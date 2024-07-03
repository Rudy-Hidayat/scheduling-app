<?php

namespace App\Services;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use DB;
use Carbon\Carbon;

class ScheduleService
{
    public function createSchedule(Request $request)
    {
        $data = $request->validate([
            'name'              => 'required|string|max:255',
            'npm'               => 'required|string|max:255',
            'asal_instansi'     => 'required|string|max:255',
            'nomor_whatsapp'    => 'required|string|max:255',
            'purpose'           => 'required|string|max:255',
            'date'              => 'required|date',
            'time'              => 'required|date_format:H:i',
            'end_time'          => 'required|date_format:H:i'
        ]);

        // Ubah waktu akhir menjadi satu menit lebih awal
        $endTime = Carbon::createFromFormat('H:i', $data['end_time'])->subMinute();
        $data['end_time'] = $endTime->format('H:i');

        // Check if there is any accepted schedule that conflicts with the new schedule
        $conflictingSchedule = Schedule::where('date', $data['date'])
                                        ->where('status', 'accepted')
                                        ->where(function($query) use ($data) {
                                            $query->whereBetween('time', [$data['time'], $data['end_time']])
                                                  ->orWhereBetween('end_time', [$data['time'], $data['end_time']])
                                                  ->orWhere(function($query) use ($data) {
                                                      $query->where('time', '<=', $data['time'])
                                                            ->where('end_time', '>=', $data['end_time']);
                                                  });
                                        })
                                        ->first();

        if ($conflictingSchedule) {
            throw ValidationException::withMessages([
                'time' => ['There is already an accepted schedule within this time range. Please choose another time.']
            ]);
        }

        $data['status'] = 'pending';

        return Schedule::create($data);
    }

    public function getAllSchedules()
    {
        return Schedule::all();
    }

    public function getPendingSchedules()
    {
        return Schedule::where('status', 'pending')->get();
    }

    public function getAcceptedSchedules()
    {
        return Schedule::where('status', 'accepted')->get();
    }

    public function acceptSchedule($id, $place, $notes = '')
    {
        $acceptedSchedule = DB::transaction(function () use ($id, $place, $notes) {
            $schedule = Schedule::findOrFail($id);

            // Automatically reject the currently accepted schedule at the same date and time, if any
            Schedule::where('date', $schedule->date)
                    ->where(function($query) use ($schedule) {
                        $query->whereBetween('time', [$schedule->time, $schedule->end_time])
                              ->orWhereBetween('end_time', [$schedule->time, $schedule->end_time])
                              ->orWhere(function($query) use ($schedule) {
                                  $query->where('time', '<=', $schedule->time)
                                        ->where('end_time', '>=', $schedule->end_time);
                              });
                    })
                    ->where('status', 'accepted')
                    ->update([
                        'status' => 'rejected',
                        'notes' => 'Automatically rejected due to another schedule being accepted at the same time.'
                    ]);

            // Accept the new schedule
            $schedule->status = 'accepted';
            $schedule->notes = $notes;
            $schedule->place = $place;
            $schedule->save();

            // Automatically reject other pending schedules at the same date and time
            Schedule::where('date', $schedule->date)
                    ->where(function($query) use ($schedule) {
                        $query->whereBetween('time', [$schedule->time, $schedule->end_time])
                              ->orWhereBetween('end_time', [$schedule->time, $schedule->end_time])
                              ->orWhere(function($query) use ($schedule) {
                                  $query->where('time', '<=', $schedule->time)
                                        ->where('end_time', '>=', $schedule->end_time);
                              });
                    })
                    ->where('status', 'pending')
                    ->where('id', '!=', $schedule->id)
                    ->update([
                        'status' => 'rejected',
                        'notes' => 'Automatically rejected due to another schedule being accepted at the same time.'
                    ]);

            return $schedule;
        });

        return $acceptedSchedule;
    }

    public function rejectSchedule($id, $place, $notes = '')
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->status = 'rejected';
        $schedule->place = $place;
        $schedule->notes = $notes;
        $schedule->save();

        return $schedule;
    }
}

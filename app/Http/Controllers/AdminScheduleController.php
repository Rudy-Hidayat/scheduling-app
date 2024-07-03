<?php

namespace App\Http\Controllers;

use App\Services\ScheduleService;
use Illuminate\Http\Request;

class AdminScheduleController extends Controller
{
    protected $scheduleService;

    public function __construct(ScheduleService $scheduleService)
    {
        $this->scheduleService = $scheduleService;
    }

    public function index()
    {
        $schedules = $this->scheduleService->getAllSchedules();

        return response()->json($schedules);
    }

    public function accept($id, Request $request)
    {
        $place = $request->input('place', '');
        $notes = $request->input('notes', '');
        $schedule = $this->scheduleService->acceptSchedule($id, $place, $notes);

        return response()->json($schedule);
    }

    public function reject($id, Request $request)
    {
        $place = $request->input('place', '');
        $notes = $request->input('notes', '');
        $schedule = $this->scheduleService->rejectSchedule($id, $place, $notes);

        return response()->json($schedule);
    }
}

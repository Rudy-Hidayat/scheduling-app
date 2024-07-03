<?php

namespace App\Http\Controllers;

use App\Services\ScheduleService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ScheduleController extends Controller
{
    protected $scheduleService;

    public function __construct(ScheduleService $scheduleService)
    {
        $this->scheduleService = $scheduleService;
    }

    public function store(Request $request)
    {
        try {
            $schedule = $this->scheduleService->createSchedule($request);
            return response()->json($schedule, 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function index()
    {
        $schedules = $this->scheduleService->getAllSchedules();

        return response()->json($schedules);
    }

    public function getAcceptedSchedules()
    {
        $schedules = $this->scheduleService->getAcceptedSchedules();
        return response()->json($schedules);
    }

    // public function index()
    // {
    //     $schedules = $this->scheduleService->getPendingSchedules();

    //     return response()->json($schedules);
    // }
}

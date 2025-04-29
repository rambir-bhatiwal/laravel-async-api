<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Jobs\ProcessTask;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Validator;

class TaskController extends Controller
{
    /**
     * Handle the submit request.
     */
    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'input' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 422);
        }

        $task = Task::create([
            'status' => 'pending',
            'task_id' => Str::uuid(),
            'input' => $request->input,
        ]);

        // Dispatch the job to the queue
        ProcessTask::dispatch($task);

        return response()->json([
            'status' => 'pending',
            'task_id' => $task->task_id,
        ]);
    }

    /**
     * Handle the status request.
     */
    public function status($task_id)
    {
        $task = Task::where('task_id', $task_id)->first();

        if (!$task) {
            return response()->json([
                'message' => 'Task not found'
            ], 404);
        }

        return response()->json([
            'task_id' => $task->task_id,
            'status' => $task->status
        ]);
    }

    /**
     * Handle the result request.
     */
    public function result($task_id = null)
    {

        $task = Task::where('task_id', $task_id)->first();

        if (!$task) {
            return response()->json([
                'message' => 'Task not found'
            ], 404);
        }

        if ($task->status === 'completed') {
            return response()->json([
                'task_id' => $task->task_id,
                'result' => $task->output,
            ]);
        }

        if ($task->status === 'failed') {
            return response()->json([
                'message' => 'Task processing failed'
            ], 500);
        }

        return response()->json([
            'message' => 'Task not finished yet',
            'status' => $task->status
        ], 202);
    }
}

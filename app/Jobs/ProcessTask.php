<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Task;
class ProcessTask implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public Task $task)
    {
        // $this->task = $task;//
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {   
        $this->task->update([
            'status' => 'processing',
        ]);
        try {
            // Simulate task processing
            sleep(60); // Simulate a long-running task
            $result = strrev($this->task->input);
            $this->task->update([
                'status' => 'completed',
                // 'output' => 'Task completed successfully.',
                'output' => $result,
            ]);
        } catch (\Exception $e) {
            $this->task->update([
                'status' => 'failed',
                'output' => $e->getMessage(),
            ]);
        }
        // Here you can add the logic to process the task
        // $this->task = Task::where('status', 'pending')->first();
        // if ($this->task) {
        //     $this->task->status = 'processing';
        //     $this->task->save();

        //     // Process the task
        //     $this->processTask($this->task);

        //     // Mark the task as completed
        //     $this->task->status = 'completed';
        //     $this->task->save();
        // }
    }
}

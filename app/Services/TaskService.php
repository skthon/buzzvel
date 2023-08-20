<?php

namespace App\Services;

use App\Api\V1\Requests\CreateTaskRequest;
use App\Api\V1\Requests\UpdateTaskRequest;
use App\Models\Task;

class TaskService
{
    public function __construct(private TaskAttachmentService $taskAttachmentService){}

    public function store(CreateTaskRequest $request): Task
    {
        $task = new Task();
        $task->id = Task::generateUuid();
        $task->title = $request->get('title');
        $task->description = $request->get('description');
        $task->user_id = $request->user()?->id;
        $task->save();

        if ($request->hasFile('attachments')) {
            collect($request->file('attachments'))->each(
                fn($attachment) => $this->taskAttachmentService->create($task, $attachment)
            );
        }

        return $task->refresh();
    }

    public function update(Task $task, UpdateTaskRequest $request): Task
    {
        $task->title = $request->get('title', $task->title);
        $task->description = $request->get('description', $task->description);
        $task->is_completed = $request->boolean('is_completed', $task->is_completed);
        $task->completed_at = $task->is_completed ? now() : null;

        if ($request->hasFile('attachments')) {
            collect($request->file('attachments'))->each(
                fn($attachment) => $this->taskAttachmentService->create($task, $attachment)
            );
        }

        if ($request->has('delete_attachments')) {
            $this->taskAttachmentService->delete($request->get('delete_attachments', []));
        }

        $task->save();

        return $task->refresh();
    }
}

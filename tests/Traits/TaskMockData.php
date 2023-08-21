<?php

namespace Tests\Traits;

use App\Models\Task;
use App\Models\TaskAttachment;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait TaskMockData
{
    public function createTaskInformation(User $user, bool $isCompleted = true): array
    {
        Storage::fake('public');

        /** @var Task $task */
        $task = Task::factory()->create([
            'is_completed' => $isCompleted,
            'completed_at' => $isCompleted ? now() : null,
            'user_id'      => $user->id,
        ]);
        $uuid1 = (string) Str::orderedUuid(36);
        $uuid2 = (string) Str::orderedUuid(36);
        $taskAttachment1 = TaskAttachment::factory()->create([
            'id'      => $uuid1,
            'task_id' => $task->id,
            'path'    => "tasks/{$task->id}/{$uuid1}.pdf",
        ]);
        $taskAttachment2 = TaskAttachment::factory()->create([
            'id'      => $uuid2,
            'task_id' => $task->id,
            'path'    => "tasks/{$task->id}/{$uuid2}.pdf",
        ]);

        return [
            'id'           => $task->id,
            'title'        => $task->title,
            'description'  => $task->description,
            'is_completed' => $task->is_completed,
            'completed_at' => $task->completed_at?->toISOString(),
            'deleted_at'   => $task->deleted_at,
            'updated_at'   => $task->updated_at->toISOString(),
            'created_at'   => $task->created_at->toISOString(),
            'attachments'  => [
                [
                    'id'         => $taskAttachment1->id,
                    'filename'   => $taskAttachment1->filename,
                    'url'        => '/storage/' . $taskAttachment1->path,
                    'created_at' => $taskAttachment1->created_at->toISOString(),
                ],
                [
                    'id'         => $taskAttachment2->id,
                    'filename'   => $taskAttachment2->filename,
                    'url'        => '/storage/' . $taskAttachment2->path,
                    'created_at' => $taskAttachment2->created_at->toISOString(),
                ],
            ],
        ];
    }
}

<?php

namespace App\Services;

use App\Models\Task;
use App\Models\TaskAttachment;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class TaskAttachmentService
{
    public function create(Task $task, UploadedFile $attachment): TaskAttachment
    {
        $taskAttachment = new TaskAttachment();
        $taskAttachment->id = TaskAttachment::generateUuid();
        $taskAttachment->disk = TaskAttachment::STORAGE_DISK;
        $taskAttachment->task_id = $task->id;
        $taskAttachment->filename = $attachment->getClientOriginalName();
        $taskAttachment->mime_type = $attachment->getMimeType();
        $extension = $attachment->getClientOriginalExtension();
        $taskAttachment->path = "tasks/{$task->id}/{$taskAttachment->id}.{$extension}";

        Storage::disk(TaskAttachment::STORAGE_DISK)->putFileAs(
            "tasks/{$task->id}",
            $attachment,
            "{$taskAttachment->id}.{$extension}"
        );

        $taskAttachment->save();

        return $taskAttachment;
    }

    public function delete(array $attachmentIds): void
    {
        foreach ($attachmentIds as $attachmentId) {
            $taskAttachment = TaskAttachment::find($attachmentId);

            Storage::disk(TaskAttachment::STORAGE_DISK)->delete($taskAttachment->path);

            $taskAttachment->forceDelete();
        }
    }
}

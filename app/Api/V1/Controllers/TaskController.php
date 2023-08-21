<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Requests\CreateTaskRequest;
use App\Api\V1\Requests\UpdateTaskRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Services\TaskService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    public function __construct(private TaskService $taskService){}

    public function index(): ResourceCollection
    {
        return TaskResource::collection(Task::all())->additional([
            'code' => 200
        ]);
    }

    public function show(Task $task): TaskResource
    {
        return (new TaskResource($task))->additional(['code' => 200]);
    }

    public function store(CreateTaskRequest $request): JsonResponse|TaskResource
    {
        try {
            return (new TaskResource($this->taskService->store($request)))
                ->additional(['code' => 201]);
        } catch (Exception $ex) {
            Log::error("[task] Failed to save task information " . __CLASS__ . '::' . __METHOD__ . ' ' . $ex->getMessage());
            return response()->json(['code' => 500, 'message' => 'Server error'], 500);
        }
    }

    public function update(Task $task, UpdateTaskRequest $request): JsonResponse|TaskResource
    {
        try {
            return new TaskResource($this->taskService->update($task, $request));
        } catch (Exception $ex) {
            Log::error("[task] Failed to update task information " . __CLASS__ . '::' . __METHOD__ . ' ' . $ex->getMessage());
            return response()->json(['code' => 500, 'message' => 'Server error'], 500);
        }
    }

    public function destroy(Task $task): JsonResponse
    {
        try {
            $task->attachments()->forceDelete();
            $task->forceDelete();

            return response()->json(['code' => 200, 'message' => 'Deleted successfully']);
        } catch (Exception $ex) {
            Log::error("[task] Failed to delete information " . __CLASS__ . '::' . __METHOD__ . ' ' . $ex->getMessage());
            return response()->json(['code' => 500, 'message' => 'Server error'], 500);
        }
    }
}

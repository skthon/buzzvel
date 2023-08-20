<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use Tests\Traits\TaskMockData;

class TaskControllerCreateAndUpdateTest extends TestCase
{
    use RefreshDatabase, TaskMockData;

    public function test_api_returns_invalid_credentials_error()
    {
        $response = $this->get('/api/tasks');
        $response->assertStatus(401);
        $response->assertJson([
            'code'    => 401,
            'message' => 'Not authenticated'
        ]);
    }

    public function test_api_returns_invalid_route_error()
    {
        Sanctum::actingAs(User::factory()->create(), ['*']);
        $response = $this->get('/api/task');
        $response->assertStatus(404);
        $response->assertJson([
            'code'    => 404,
            'message' => 'Route not found, please check the api documentation'
        ]);
    }

    public function test_api_returns_method_not_allowed_error()
    {
        Sanctum::actingAs(User::factory()->create(), ['*']);
        $response = $this->patch('/api/tasks');
        $response->assertStatus(405);
        $response->assertJson([
            'code'    => 405,
            'message' => 'Method not allowed, please check the api documentation',
        ]);
    }

    public function test_api_shows_details_of_all_tasks()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        /** @var Task $task */
        $task = $this->createTaskInformation($user);

        $response = $this->get("/api/tasks");
        $response->assertStatus(200);

        $response->assertJson([
            'code' => 200,
            'data' => [$task],
        ]);
    }

    public function test_api_viewing_a_non_existing_task_returns_record_not_found()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $response = $this->get("/api/tasks/invalid-id");
        $response->assertStatus(404);

        $response->assertJson([
            'code'    => 404,
            'message' => 'Record not found',
        ]);
    }

    public function test_api_viewing_details_of_specific_task_is_successful()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        /** @var Task $task */
        $task = $this->createTaskInformation($user);

        $response = $this->get("/api/tasks/{$task['id']}");
        $response->assertStatus(200);

        $response->assertJson([
            'code' => 200,
            'data' => $task,
        ]);
    }

    public function test_api_creating_a_new_task_returns_validation_errors()
    {
        Storage::fake('public');

        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $response = $this->post("/api/tasks", [
            'attachments' => [
                UploadedFile::fake()->create('hacker.html'),
            ]
        ]);
        $response->assertStatus(422);

        $response->assertJson([
            'code'    => 422,
            'message' => 'Invalid input',
            'errors'  => [
                'description' => ['The description field is required.'],
                'title'       => ['The title field is required.'],
                'attachments.0' => [
                    "The attachments.0 must be a file of type: pdf, jpg, png, gif, jpeg."
                ]
            ],
        ]);
    }

    public function test_api_creating_a_new_task_is_successful()
    {
        Storage::fake('public');

        /** @var User $user */
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $response = $this->post("/api/tasks", [
            'title'       => 'Learn Laravel',
            'description' => 'Learn Laravel fundamentals in 30 days by finishing a course in laracasts',
            'attachments' => [
                UploadedFile::fake()->image('test1.jpg'),
                UploadedFile::fake()->create('document.pdf', 100),
            ],
        ]);
        $response->assertStatus(201);
        $this->assertDatabaseHas('tasks', [
            'title'        => 'Learn Laravel',
            'description'  => 'Learn Laravel fundamentals in 30 days by finishing a course in laracasts',
            'is_completed' => false,
            'completed_at' => null,
            'user_id'      => $user->id,
            'deleted_at'   => null,
        ]);
        $this->assertDatabaseHas('task_attachments', [
            'filename' => 'test1.jpg',
        ]);
        $this->assertDatabaseHas('task_attachments', [
            'filename' => 'document.pdf',
        ]);

        $response = $response->json();
        $taskId = $response['data']['id'];
        $attachmentId1 = $response['data']['attachments'][0]['id'];
        $attachmentId2 = $response['data']['attachments'][1]['id'];
        Storage::disk('public')->assertExists("tasks/$taskId/$attachmentId1.jpg");
        Storage::disk('public')->assertExists("tasks/$taskId/$attachmentId2.pdf");
    }

    public function test_api_updating_an_existing_task_returns_validation_errors()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $task = $this->createTaskInformation($user);

        $response = $this->put("/api/tasks/{$task['id']}", [
            'title'              => 't',
            'description'        => 'test',
            'delete_attachments' => ['invalid_id'],
            'attachments'        => [
                UploadedFile::fake()->create('hacker.html'),
            ]
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'code'    => 422,
            'message' => 'Invalid input',
            'errors'  => [
                'description' => ['The description must be between 10 and 300 characters.'],
                'title'       => ['The title must be between 3 and 100 characters.'],
                'attachments.0' => [
                    'The attachments.0 must be a file of type: pdf, jpg, png, gif, jpeg.',
                ],
                'delete_attachments.0' => [
                    'The selected delete_attachments.0 is invalid.',
                ],
            ],
        ]);
    }

    public function test_api_updating_an_existing_task_is_successful()
    {
        Storage::fake('public');

        /** @var User $user */
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $task = $this->createTaskInformation(user: $user, isCompleted: false);

        $response = $this->put("/api/tasks/{$task['id']}", [
            'title'        => 'Learn Laravel Updated',
            'description'  => 'Learn Laravel fundamentals in 30 days by finishing a course in laracasts updated',
            'is_completed' => true,
            'attachments' => [
                UploadedFile::fake()->image('test1.jpg'),
            ],
            'delete_attachments' => [
                $task['attachments'][0]['id'],
                $task['attachments'][1]['id'],
            ],
        ]);
        $response->assertStatus(200);
        $response = $response->json();

        $this->assertDatabaseHas('tasks', [
            'title'        => 'Learn Laravel Updated',
            'description'  => 'Learn Laravel fundamentals in 30 days by finishing a course in laracasts updated',
            'is_completed' => true,
            'user_id'      => $user->id,
        ]);
        $this->assertDatabaseCount('task_attachments', 1);
        $this->assertCount(1, $response['data']['attachments']);

        Storage::disk('public')->assertMissing("tasks/{$task['id']}/{$task['attachments'][0]['id']}.png");
        Storage::disk('public')->assertMissing("tasks/{$task['id']}/{$task['attachments'][1]['id']}.png");
        Storage::disk('public')->assertExists("tasks/{$task['id']}/{$response['data']['attachments'][0]['id']}.jpg");
    }

    public function test_api_deleting_a_non_existing_task_returns_record_not_found()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $response = $this->delete("/api/tasks/invalid-id");
        $response->assertStatus(404);

        $response->assertJson([
            'code'    => 404,
            'message' => 'Record not found',
        ]);
    }

    public function test_api_deleting_an_existing_task_is_successful()
    {
        /** @var User $user */
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $task = $this->createTaskInformation($user, true);

        $response = $this->delete("/api/tasks/{$task['id']}");
        $response->assertStatus(200);
        $response->assertJson([
            'code'    => 200,
            'message' => 'Deleted successfully',
        ]);
        $this->assertDatabaseCount('tasks', 0);
    }
}

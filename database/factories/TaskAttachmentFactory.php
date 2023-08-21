<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TaskAttachment>
 */
class TaskAttachmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id'         => (string) Str::orderedUuid(36),
            'filename'   => fake()->name() . '.png',
            'disk'       => 'public',
            'mime_type'  => 'image/png',
            'path'       => 'tasks/task_id/attachment_id.png'
        ];
    }
}

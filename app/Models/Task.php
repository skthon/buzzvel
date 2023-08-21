<?php

namespace App\Models;

use App\Traits\HasUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

/**
 * @property string id
 * @property string title
 * @property string description
 * @property string user_id
 * @property bool   is_completed
 * @property Carbon completed_at
 */
class Task extends Model
{
    use HasFactory, HasUUID, SoftDeletes;

    /**
     * @var mixed|null
     */

    protected $fillable = [
        'title',
        'description',
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'completed_at' => 'datetime',
        'deleted_at'   => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function(Task $task) {
            Storage::disk(TaskAttachment::STORAGE_DISK)->deleteDirectory("tasks/{$task->id}");
        });
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(TaskAttachment::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

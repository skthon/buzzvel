<?php

namespace App\Models;

use App\Traits\HasUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string id
 * @property string filename
 * @property string disk
 * @property string path
 * @property string mime_type
 * @property string task_id
 */
class TaskAttachment extends Model
{
    use HasFactory, HasUUID, SoftDeletes;

    const STORAGE_DISK = 'public';

    protected $fillable = [
        'filename',
        'disk',
        'path',
        'mime_type',
    ];

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class TaskAttachmentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'filename'   => $this->filename,
            'url'        => Storage::disk($this->disk)->url($this->path),
            'created_at' => $this->created_at,
        ];
    }
}

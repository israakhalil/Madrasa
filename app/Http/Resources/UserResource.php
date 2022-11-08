<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

    public function toArray($request): array
    {
        return [
            'id' => $this['id'],
            'name' => $this['name'],
            'id_number' => $this['id_number'],
            'email' => $this['email'],
            // 'permissions' => $this->getAllPermissions(),
            'username' => $this['username'],
            'school_id' => $this['school_id'],
            'role_id'=> $this['role_id'],
            'created_at' => isset($this['created_at']) ? Carbon::parse($this['created_at'])->toDateTimeString() : null,
        ];

    }
}
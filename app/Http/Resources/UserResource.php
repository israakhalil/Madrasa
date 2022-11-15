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
            'classesIds'=>$this->classes()->get(),
            'classes' => ClassResource::collection($this->classes()->get())->map->toArray($request),
            'email' => $this['email'],
            'permissionIds'=>$this->permissions()->get(),
            // '_permissions' => PermissionResource::collection($this->permissions()->get())->map->toArray($request),
//                 'permissions' => $this->permissions()->get()->pluck('code'),
            'role_id'=> $this['role_id'],
            'permissions' => $this->getAllPermissions()->toArray($request),
            'school_id' => $this['school_id'],
            'school_name'=>@$this->school->name,

            'created_at' => isset($this['created_at']) ? Carbon::parse($this['created_at'])->toDateTimeString() : null,
        ];

    }
}

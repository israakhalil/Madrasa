<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SchoolResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'=> $this['id'],
            'name'=> $this['name'],
            'logo'=>$this['logo'],
            'is_active' => $this['is_active']
            ];
    }
}
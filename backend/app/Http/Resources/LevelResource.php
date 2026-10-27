<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LevelResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'=> $this['id'],
            'name'=> $this['name'],
            'school_id'=>$this['school_id'],
            'school_name'=>$this->school->name,
            // 'classes'=> $this->classes,
            ];
    }
    public function groupClasses($request)
    {
        return [
            'id'=> $this['id'],
            'name'=> $this['name'],
            'classes'=> $this->classes,
        ];
    }
}

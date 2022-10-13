<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class classResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'=> $this['id'],
            'name'=> $this['name'],
            'level_id'=>$this['level_id'],
            'level_name'=>$this->level->name,
            'attached_file'=>$this['attached_file'],
            'user_id'=>$this['user_id'],
            ];
    }
}
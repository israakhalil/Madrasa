<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'=> $this['id'],
            'received_date'=> $this['received_date'],
            'book_name'=> $this['book_name'],
            'is_delivered'=> $this['is_delivered'],
            'student_signature'=> $this['student_signature'],
            'student_id'=> $this['student_id'],
            'student_name'=>@$this->student->name,
            ];
    }
}
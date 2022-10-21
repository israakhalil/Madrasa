<?php

namespace App\Models\Procedures;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    use  HasFactory;

    protected $table="books";
    const FILLABLE = ['received_date','book_name','is_delivered',
    'student_signature','student_id'];
    protected $fillable = self::FILLABLE;
    protected $casts = 
    [
        'id'=>'integer',
        'student_id'=>'integer',
    ];


}
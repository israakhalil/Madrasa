<?php

namespace App\Models\Procedures;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absences extends Model
{
    use  HasFactory;


    protected $table="absences";
    const FILLABLE = ['student_id','absence_date','absence_reason','teacher_signature','absence_type_id'];
    protected $fillable = self::FILLABLE;
    protected $casts = 
    [
        'id'=>'integer',
    'student_id'=>'integer',
    'absence_type_id'=>'integer'
];


}
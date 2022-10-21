<?php

namespace App\Models\Procedures;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leaves extends Model
{
    use  HasFactory;


    protected $table="leaves";
    const FILLABLE = ['student_id','leave_date','leave_time',
    'student_signature','leave_reason'];
    protected $fillable = self::FILLABLE;
    protected $casts =
     ['id'=>'integer',
    'student_id'=>'integer'];


}
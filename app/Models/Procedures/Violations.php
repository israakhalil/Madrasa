<?php

namespace App\Models\Procedures;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Violations extends Model
{
    use  HasFactory;

    protected $table="violations";
    const FILLABLE = ['violation_date','action_performed',
    'violation_procedure_id','violation_degree_id','student_id',
    'suprvisore_signature','student_signature'];

    protected $fillable = self::FILLABLE;
    protected $casts = [
       'id'=>'integer', 
       'student_id'=>'integer',
       'violation_procedure_id'=>'integer',
       'violation_degree_id'=>'integer'
    ];


}
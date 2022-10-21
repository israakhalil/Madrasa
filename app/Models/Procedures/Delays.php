<?php

namespace App\Models\Procedures;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delays extends Model
{
    use  HasFactory;         
    
    protected $table="delays";
    const FILLABLE = ['student_id','delay_date','delay_reason',
    'delay_amount','student_signature'];
    protected $fillable = self::FILLABLE;
    protected $casts = ['id'=>'integer','student_id'=>'integer'];


}
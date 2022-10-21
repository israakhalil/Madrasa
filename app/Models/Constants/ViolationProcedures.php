<?php

namespace App\Models\Constants;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViolationProcedures extends Model
{
    use  HasFactory;

    protected $table="violation_procedures";
    protected $fillable = ['name'];
    protected $casts = ['id'=>'integer'];


}
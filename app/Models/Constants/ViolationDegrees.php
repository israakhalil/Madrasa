<?php

namespace App\Models\Constants;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViolationDegrees extends Model
{
    use  HasFactory;

    protected $table="violation_degrees";
    protected $fillable = ['name'];
    protected $casts = ['id'=>'integer'];


}
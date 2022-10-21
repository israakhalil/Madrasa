<?php

namespace App\Models\Constants;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsenceTypes extends Model
{
    use  HasFactory;

    protected $table="absence_types";
    protected $fillable = ['name'];
    protected $casts = ['id'=>'integer'];


}
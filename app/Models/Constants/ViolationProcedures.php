<?php

namespace App\Models\Constants;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViolationProcedures extends Model
{
    use  HasFactory;

    protected $table="violation_procedures";
    protected $primaryKey = 'id';
    const FILLABLE = ['name'];
    protected $fillable = self::FILLABLE;
    protected $casts = ['id'=>'integer'];


}
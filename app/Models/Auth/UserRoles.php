<?php

namespace App\Models\Auth;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class UserRoles extends Model
{
    use HasFactory;

    protected $table = "user_roles";


    const FILLABLE = ['user_id','role_id'];

    protected $fillable = self::FILLABLE;

}
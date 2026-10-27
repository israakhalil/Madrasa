<?php

namespace App\Models\Auth;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class RolePermission extends Model
{
    use HasFactory;

    protected $table = "role_permissions";


    const FILLABLE = ['role_id','permission_id'];

    protected $fillable = self::FILLABLE;

}

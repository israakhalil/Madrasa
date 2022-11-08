<?php

namespace App\Models\School;

use App\Models\Core\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Permission extends BaseModel
{
    // use HasFactory;

    // protected $table = "permissions";

    // const FILLABLE = [
    //     'name', 'group_id', 'created_by', 'updated_at',
    // ];

    // protected $fillable = self::FILLABLE;

    // public function users(): BelongsToMany
    // {
    //     // return $this->belongsToMany(User::class, 'permissions', 'permission_id', 'user_id');
    // }

}
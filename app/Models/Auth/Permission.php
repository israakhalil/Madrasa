<?php

namespace App\Models\School;

use App\Models\Core\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Permission extends BaseModel
{
    use HasFactory;

    protected $table = "access_control_permission";

    const FILLABLE = [
        'name', 'group_id', 'created_by', 'updated_at',
    ];

    protected $fillable = self::FILLABLE;

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'access_control_user_permission', 'permission_id', 'user_id');
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'access_control_role_permission', 'permission_id', 'role_id');
    }
//    public function getUsers($id)
//    {
//        $result = $this->executeProcedureWithCursor(($this->sp_package_name . '.' . $this->sp_get_users), [
//            'P_PERMISSION_ID' => ['value' => $id, 'type' => \PDO::PARAM_STR],
//        ] , ':O_PERMISSION');
//
//        return collect((new User())->hydrate(
//            $result
//        ))->all();
//    }

}
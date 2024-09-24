<?php

namespace Modules\Agent\Entities;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notification;
use Illuminate\Auth\MustVerifyEmail;
use Spatie\Permission\Models\Permission;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Agent extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use SoftDeletes;
    use MustVerifyEmail;

    protected $guard = 'agent';

    protected $table = "agents";

    protected $fillable = [
        'agent_key', 'user_name', 'password', 'profile', 'gender', 'agent_code', 'parent_id', 'status', 'agent_form', 'agent_to',
        'agent_buy', 'agent_sell', 'first_name', 'last_name', 'mobile_number', 'email','sap_code','mudra_code' ,'euronet_id','email_verified_at',
        'agent_otp', 'agent_change_pass', 'remember_token', 'create_date', 'created_by', 'updated_by', 'deleted_at', 'agent_type'
    ];

    public static function getUserDetail($id)
    {
        return Agent::where('id', $id)->first();
    }

    // Find role where in role_has_permission table
    public static function checkPermission($id)
    {
        return Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();
    }

    // notification
    public static function EmployeeNotification($id)
    {
        return Notification::where(['to_user' => $id, 'is_read' => '0'])->latest()->get();
    }

    public function parent()
    {
        return $this->hasOne('Modules\Agent\Entities\Agent', 'id', 'parent_id');
    }

    public function createdBy()
    {
        return $this->hasOne('App\User', 'id', 'created_by');
    }

    public function updatedBy()
    {
        return $this->hasOne('App\User', 'id', 'updated_by');
    }
}

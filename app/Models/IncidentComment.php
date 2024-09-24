<?php

namespace App\Models;
use App\User;
Use DB;
use Illuminate\Database\Eloquent\Model;

class IncidentComment extends Model
{
    Protected $tableName ="incident_comment";
    protected $fillable = ['incident_no','tc_user_id','comment'];
    public function tcuser()
    {
        return $this->hasOne(User::class,'id','tc_user_id')->role('Tc user');
    }
}

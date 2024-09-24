<?php

namespace App\Models;
use App\Models\IncidentComment;
Use DB;


use Illuminate\Database\Eloquent\Model;

class Incidents extends Model
{
    Protected $tableName ="incidents";

    public function buy_incident()
    {
        return $this->hasOne(IncidentBuyDocuments::class,'incident_number','inci_number')->orderBy('id', 'desc');
    }

    public function sell_incident()
    {
        return $this->hasOne(IncidentSellDocuments::class,'incident_number','inci_number')->orderBy('id', 'desc');
    }

    public function agentDetail(){
        return $this->hasOne(Agents::class,'id','agent_id');
    }

    public function comments()
    {
        return $this->hasMany(IncidentComment::class,'incident_no','inci_number')->with('tcuser')->orderBy('id','DESC');
    }

}    

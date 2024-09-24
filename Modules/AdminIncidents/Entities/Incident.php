<?php

namespace Modules\AdminIncidents\Entities;

use Illuminate\Database\Eloquent\Model;


class Incident extends Model
{
    protected $table = "incidents";

    protected $fillable = [
        'inci_key', 'inci_number', 'inci_agent_code', 'inci_agent_key', 'inci_type', 'transaction_type', 'inci_forex_card_no',
        'inci_name', 'inci_recived_date', 'inci_recived_time', 'inci_currency_type', 'inci_frgn_curr_amount',
        'inci_buy_sell_req', 'inci_agent_margin', 'inci_inr_amount', 'inci_agent_type', 'inci_create_time',
        'inci_departure_date', 'inci_passport_number', 'inci_currency_rate', 'inci_assign_status', 'inci_assignto',
        'inci_status', 'inci_status_message', 'inci_show_hide_status', 'expiry_date','completed_at', 'created_at', 'updated_at'
    ];

    public function incidentUpdate()
    {
        return $this->hasOne('Modules\AdminIncidents\Entities\IncidentUpdate', 'inci_up_inc_key', 'inci_key');
    }

    public function incidentCurrency()
    {
        return $this->hasMany('Modules\AdminIncidents\Entities\IncidentCurrency', 'incident_id', 'inci_number');
    }

    public function incidentAssign()
    {
        return $this->hasOne('App\User', 'id', 'inci_assignto');
    }

    public function agent()
    {
        return $this->hasOne('Modules\Agent\Entities\Agent', 'id', 'agent_id');
    }

    public function buyDocuments()
    {
        return $this->hasMany('Modules\AdminIncidents\Entities\IncidentBuyDocuments', 'incident_number', 'inci_number');
    }

    public function sellDocuments()
    {
        return $this->hasMany('Modules\AdminIncidents\Entities\IncidentSellDocuments', 'incident_number', 'inci_number');
    }
}

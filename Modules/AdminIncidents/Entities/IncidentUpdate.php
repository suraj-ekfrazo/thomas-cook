<?php

namespace Modules\AdminIncidents\Entities;

use Illuminate\Database\Eloquent\Model;


class IncidentUpdate extends Model
{
    protected $table = "incident_update";

    protected $fillable = [
        'inci_up_key', 'inci_up_fax_number', 'inci_up_agent_code_details', 'inci_up_agent_code', 'inci_up_inc_key',
        'inci_up_date', 'inci_up_time', 'inci_up_pass', 'inci_up_visa', 'inci_up_ticket', 'inci_up_pan', 'inci_up_apply',
        'inci_up_annex', 'inci_up_bank_transfer', 'inci_up_business', 'inci_up_document', 'inci_up_refound', 'inci_up_sof',
        'inci_up_other', 'inci_up_name', 'inci_up_travel_date', 'inci_up_agent_type', 'inci_up_comment', 'inci_up_bordx_no',
        'inci_up_received_date', 'inci_up_received_time', 'inci_up_assign_to', 'inci_up_accept_status', 'inci_up_assign_status',
        'created_at', 'updated_at'
    ];

    public function incident()
    {
        return $this->hasOne('Modules\AdminIncidents\Entities\Incident', 'inci_key', 'inci_up_inc_key');
    }

}

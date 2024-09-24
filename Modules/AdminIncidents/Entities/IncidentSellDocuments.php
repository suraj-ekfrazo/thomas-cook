<?php

namespace Modules\AdminIncidents\Entities;

use Illuminate\Database\Eloquent\Model;


class IncidentSellDocuments extends Model
{
    protected $table = "incident_sell_documents";

    protected $fillable = [
        'incident_number', 'passport', 'visa', 'ticket', 'pan_card', 'apply', 'annex', 'bank_transfer', 'business',
        'sof', 'other', 'passport_status', 'visa_status', 'ticket_status', 'pan_card_status', 'apply_status', 'annex_status',
        'bank_transfer_status', 'business_status', 'sof_status', 'other_status', 'created_at', 'updated_at',
    ];

    public function incident()
    {
        return $this->hasOne('Modules\AdminIncidents\Entities\Incident', 'inci_number', 'incident_number');
    }

}

<?php

namespace Modules\AdminIncidents\Entities;

use Illuminate\Database\Eloquent\Model;


class IncidentBuyDocuments extends Model
{
    protected $table = "incident_buy_documents";

    protected $fillable = [
        'incident_number', 'passport', 'refound', 'annex', 'other', 'passport_status',
        'refound_status', 'annex_status', 'other_status', 'created_at', 'updated_at',
    ];

    public function incident()
    {
        return $this->hasOne('Modules\AdminIncidents\Entities\Incident', 'inci_number', 'incident_number');
    }

}

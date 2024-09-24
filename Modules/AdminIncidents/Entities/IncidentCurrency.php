<?php

namespace Modules\AdminIncidents\Entities;

use Illuminate\Database\Eloquent\Model;


class IncidentCurrency extends Model
{
    protected $table = "incident_currency";

    protected $fillable = [
        'incident_id', 'currency_type', 'frn_curr_amount', 'inr_amount', 'currency_rate',
    ];

    public function incident()
    {
        return $this->hasOne('Modules\AdminIncidents\Entities\Incident', 'incident_id', 'inci_number');
    }

}

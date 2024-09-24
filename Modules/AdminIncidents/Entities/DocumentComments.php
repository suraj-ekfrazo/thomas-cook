<?php

namespace Modules\AdminIncidents\Entities;

use Illuminate\Database\Eloquent\Model;


class DocumentComments extends Model
{
    protected $table = "document_comments";

    protected $fillable = [
        'incident_number', 'tc_key', 'comment', 'created_at',
    ];

    public function incident()
    {
        return $this->hasOne('Modules\AdminIncidents\Entities\Incident', 'incident_id', 'incident_number');
    }

}

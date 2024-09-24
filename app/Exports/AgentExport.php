<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Modules\Agent\Entities\Agent;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AgentExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Agent::all()->map(function($user) {
            return [
                'id' => $user->id,
               'first_name' => $user->first_name,
               'last_name' => $user->last_name,
               'mobile_number' => $user->mobile_number,
               'email '=> $user->email,
               'gender'=> $user->gender,
               'agent_code '=>$user->agent_code,
               'create_date'=>$user->create_date
            ];
        });
      
    }
    public function headings(): array
    {
        return [
            'ID',
            'FIRSTNAME',
            'LASTNAME',
            'MOBILE NUMBER',
            'EMAIL ID',
            'GENDER',
            'AGENT CODE',
            'CREATE_AT'
        ];
    }
}

<?php

namespace App\Imports;

use App\Models\Agents;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\Agent\Entities\Agent;
use Illuminate\Support\Facades\Hash;

class ImportAgents implements ToModel, WithHeadingRow 
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
   public function model(array $row)
    {   

        return new Agent([
                'agent_type' => $row['agent_type'],
                'user_name' => $row['user_name'],
                'password' => Hash::make($row['password']),
                'agent_code' => $row['agent_code'],
                //'agent_series' => $row['agent_series'],
                'euronet_id' => $row['euronet_id'],
                'mudra_code' => $row['mudra_code'],
                'sap_code' => $row['sap_code'],
                'gender' => $row['gender'],
                'first_name' => $row['first_name'],
                'last_name' => $row['last_name'],
                'mobile_number' => $row['mobile_number'],
                'email' => $row['email'],
                'parent_id' => $row['parent_id'],
                'agent_form' => $row['agent_form'],
                'agent_to' => $row['agent_to'],
                'agent_buy' => $row['agent_buy'],
                'agent_sell' => $row['agent_sell'],
                'status' => $row['status'],
                'agent_key' => $row['agent_key'],
                'created_by' => $row['created_by'],
            
        ]);
    }
}

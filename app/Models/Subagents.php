<?php 
namespace App\Models;
Use DB;

use Illuminate\Database\Eloquent\Model;

class Subagents extends Model
{
    Protected $tableName ="agents";
    
    public static function getAgentEmailByCode($code){
    	$email = ''; 
        $query = DB::table('agents')->where('agent_code',$code)->first();
        if( $query) {
            $email = $query->email;
        }
    	return $email;
    }
}

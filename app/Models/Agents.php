<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Agents extends Model
{
     Protected $tableName ="agents"; 


    public function incidents(){
    	return $this->belonsTo('App\Models\Incidents','agent_code');
    }

    public static function getAgentEmailByCode($code){
        $email = '';
        $query = DB::table('agents')->where('agent_code',$code)->first();
        if( $query) {
            $email = $query->email;
        }
    	return $email;
    }
}

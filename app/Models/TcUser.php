<?php

namespace App\Models;
Use DB;
use App\User;
use Illuminate\Database\Eloquent\Model;

class TcUser extends Model
{
    Protected $tableName ="users";


    public static function getSellLoginUserIds($tcType){
    	//return DB::table('tc_user')->where('tc_login_date','!=','Logout')->where('tc_type','=',1)->pluck('tc_id')->toArray();

    	return DB::table('users')->orderBy('created_at','ASC')->pluck('id')->toArray();
    }

    public static function getLastUserIds(){
    	$data = DB::table('assign_requests')->orderBy('id','DESC')->get();
    	$result = array();
    	if(count($data )) {
    		$result = $data->first();	
    	}
    	return $result;
    }
    public static function getTcUser($tcId){
    	$data = DB::table('users')->where('id',$tcId)->get();
    	$result = array();
    	if(count($data )) {
    		$result = $data->first();	
    	}
    	return $result;
    }

    public static function getLoginTcUserList(){
        $data = User::with('roles')->role('Tc user')->where('id', '!=', env('TC_USER_ID'))->where('login_status','=','1')->where('status','=','1')->whereRaw("find_in_set('1',tc_type)")->pluck('id');
        return $data;
    }
}    

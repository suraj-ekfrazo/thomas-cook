<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Modules\Agent\Entities\Agent;
use Helper;

class ForgotPasswordTCuserController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    /**
       * Write code on Method
       *
       * @return response()
       */
      public function showForgetPasswordtcForm()
      {
       
         return view('tcuser.passwords.email');
      }
  
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function submitForgetPasswordtcForm(Request $request)
      {

          $request->validate([
              'email' => 'required|email|exists:users',
          ]);
  
          $token = Str::random(64);
  
          DB::table('password_resets')->insert([
              'email' => $request->email, 
              'token' => $token, 
              'created_at' => Carbon::now()
            ]);

	    $subject ="Reset Password";
            $mailId=$request->email;
            //$message='Dear TC-User, <br>You can reset password from bellow link: <span style="color: #16589b;font-size: 1.25em;"><a href='.route('reset.password.tc.get', $token).' >Reset Password</a></span>';
            //Helper::sendMailCreateIncident($subject,$message,$mailId);
	    $message='';
            $data=['token' => $token];
	  Helper::sendMailCreateIncident($subject,$message,$mailId,$data,'email.forgotpasstcuser');


          /*Mail::send('email.forgotpasstcuser', ['token' => $token], function($message) use($request){
           
              $message->to($request->email);
              $message->subject('Reset Password');
          });*/
  
          //return back()->with('message', 'We have e-mailed your password reset link!');
	  return back()->with('message', 'PLEASE CONTACT THOMAS COOK ADMIN!');

      }
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function showResetPasswordtcForm($token) { 

         return view('tcuser.passwords.reset', ['token'=>$token]);
      }
  
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function submitResetPasswordtcForm(Request $request)
      {
        // $all = $request->all();
        // print_r($all);
        // exit;
        // print_r($request->email);
        // exit;
          $request->validate([
              'email' => 'required|email|exists:users',
              'password' => 'required|string|min:6|confirmed',
              'password_confirmation' => 'required'
          ]);
        // echo $request->token;
          $updatePassword = DB::table('password_resets')->where(['email' => $request->email, 'token' => $request->token])->get();
        //   echo "hii"; exit;
          if(!$updatePassword){
          
           
              return back()->withInput()->with('error', 'Invalid token!');
          }
          else{
            // print($updatePassword);
            // exit;
            $user = User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);
                 
            DB::table('password_resets')->where(['email'=> $request->email])->delete();
          }
          // return back()->with('message', 'Your password has been changed!');
          return redirect('/tcuser/login')->with('message', 'Your password has been changed!');
      }


      
}


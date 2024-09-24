<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Models\Agents;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Modules\Agent\Entities\Agent;
use Helper;


class ForgotPasswordController extends Controller
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
      public function showForgetPasswordForm()
      {
         return view('agent.passwords.email');
      }
  
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function submitForgetPasswordForm(Request $request)
      {
       
          $request->validate([
              'email' => 'required|email|exists:agents',
          ]);
  
          $token = Str::random(64);
  
          DB::table('password_resets')->insert([
              'email' => $request->email, 
              'token' => $token, 
              'created_at' => Carbon::now()
            ]);
	    $subject ="Reset Password";
            $mailId=$request->email;
            //$message='Dear Customer, <br>You can reset password from bellow link: <span style="color: #16589b;font-size: 1.25em;"><a href='.route('reset.password.get', $token).' >Reset Password</a></span>';

	    $message='';
            $data=['token' => $token];
	  Helper::sendMailCreateIncident($subject,$message,$mailId,$data,'email.forgotpassword');
          /*Mail::send('email.forgotpassword', ['token' => $token], function($message) use($request){
           
              $message->to($request->email);
              $message->subject('Reset Password');
          });*/
  
          return back()->with('message', 'We have e-mailed your password reset link!');
      }
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function showResetPasswordForm($token) { 

         return view('agent.passwords.reset', ['token'=>$token]);
      }
  
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function submitResetPasswordForm(Request $request)
      {
          $request->validate([
              'email' => 'required|email|exists:agents',
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
            $user = Agent::where('email', $request->email)->update(['password' => Hash::make($request->password)]);
                 
            DB::table('password_resets')->where(['email'=> $request->email])->delete();
          }
          // return back()->with('message', 'Your password has been changed!');
          return redirect('/agent/login')->with('message', 'Your password has been changed!');
      }		


}

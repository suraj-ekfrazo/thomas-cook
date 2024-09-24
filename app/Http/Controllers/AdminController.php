<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Hash;
use Modules\AdminIncidents\Entities\Incident;
use Modules\Agent\Entities\Agent;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function index()
    {
	
        // $Agent = Agent::get()->count();
        // $AgentDeleted = Agent::onlyTrashed()->get()->count();
        // $User = User::role('TC User')->get()->count();
        // $UserDeleted = User::onlyTrashed()->get()->count();
        // $Incident = Incident::get()->count();
        // $IncidentPending = Incident::where('inci_assign_status', 0)->get()->count();
        // $IncidentDeclined = Incident::where('inci_status', 2)->get()->count();
        // $IncidentAccepted = Incident::where('inci_status', 1)->get()->count();
      
        return view('welcome');
    }

    public function login()
    {
        return redirect()->route('login');
    }

    public function updateProfile(Request $request)
    {
        $this->validate($request, [
            'name' => 'max:20',
            'new_password' => 'same:confirm_password',
            'user_profile' => 'file|mimes:jpg,png,jpeg|max:2048'
        ], [
            'name.max' => 'The name may not be greater than 20 characters.',
            'new_password.same' => 'The password and confirm password must match.',
        ]);

        if (!empty($request->email)) {
            $this->validate($request, [
                'email' => 'email',
            ], [
                'email.email' => 'The email must be a valid email address.',
            ]);
        }

        $input = $request->all();
        $User = User::find(Auth::id());
        if ($request->user_profile != '') {
            $input['user_profile'] = time() . '.' . $request->user_profile->extension();
            $request->user_profile->move(public_path('users/admin/profile/'), $input['user_profile']);
        } else {
            $input['user_profile'] = $User->user_profile;
        }

        if (!empty($input['new_password'])) {
            $input['new_password'] = Hash::make($input['new_password']);
        } else {
            $input['new_password'] = $User->password;
        }

        $input['user_profile'] = $input['user_profile'];
        $input['password'] = $input['new_password'];
        $input['email'] = $input['email'];
        $input['name'] = $input['name'];

        $User->update($input);

        return response()->json([
            'success' => 'Profile updated successfully.'
        ], 200);
    }

    // public function adminList()
    // {
    //     return view('admin.index');
    // }

    // public function create()
    // {
    //     return view('admin.create');
    // }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect("/login");
    }
}

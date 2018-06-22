<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;      
use Session;

class LoginController extends AdminBaseController
{
    // index function definition...
    public function index() {
		//dd(request()->all());
        return view('admin.admin-login');
    }
    
    public function authenticate_AJAX(Request $request)
    {
		//dd(request()->all());
		// validation
		$this->validate(request(), [
			'email' => 'required|email',
			'password' => 'required',
		]);
		
		$login_data['email']	= $request->input( 'email');
        $login_data['password'] = $request->input( 'password');
            
		$users_model = new User();
		$loggedin = $users_model->authenticate($login_data);
		
		// redirect to another page
		return redirect('/admin/dashboard');
		
	}

    // function to logout from admin-section...
    public function logout() {
      
        \Session::flush();
        return redirect('/admin/');
    }
}

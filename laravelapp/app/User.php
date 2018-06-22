<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Helpers\Utility;    // use Helper
use DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];   
    
    public function authenticate($login_data) {
		
		try{
			//echo $login_data['password'].'<br>';
			//echo Utility::get_salted_password($login_data['password']);
			$ret_		= array();
			$user_info	= DB::table('users')
						->select('users.*')
						->where([ 
								['users.email', $login_data['email']], 
								['users.password', Utility::get_salted_password($login_data['password'])] 
							])
						->get();
			
			
			
			
			//if( is_array($user_info) ) ///new
			if( !empty($user_info) ) ///new
			{
				foreach($user_info as $row)
				{
					$ret_["id"] = $row->id;
					$ret_["email"] = $row->email;
					$ret_["name"] = $row->name;
					
					\Session::put('loggedin', true);
					\Session::put('admin_user_id', $ret_["id"]);
					\Session::put('name', $ret_["name"]);					
					\Session::put('email', $ret_["email"]);					
					
                    \Session::save();
				}
			} else{
				echo '222';
			}
			
			return $ret_;
					
		}
		catch(Exception $err_obj){
			show_error($err_obj->getMessage());
		}
	}
    
}

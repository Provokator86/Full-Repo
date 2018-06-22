<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;

class DashboardController extends AdminBaseController
{
    // constructor definition...
    public function __construct() {

        parent::__construct();
    }

    // index function definition...
    public function index() {

        // show view part...
        $data = array();
        return view('admin.dashboard', $data);
        //return view('admin.dashboard')->with('data',$data);
    }
}

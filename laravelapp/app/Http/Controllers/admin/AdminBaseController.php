<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminBaseController extends Controller
{
    protected $data = array();

    // parent constructor
    public function __construct() {

        // load default data

    }
}

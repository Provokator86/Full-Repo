<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
 // WHEN ALL WRITTEN IN routes/web.php as below
use App\Task;

Route::get('/task-list', function () {
	
	//$tasks = DB::table('tasks')->get();
	//return $tasks;  // json data
	
	// after model created we can write as below
	#$tasks = App\Task::all();
	$tasks = Task::all(); // when namespace used above
    return view('tasks.index', compact('tasks'));
});


Route::get('/tasks/{task}', function ($id) {
	
	//$task = DB::table('tasks')->find($id);
	//return $tasks;  // json data
	// after model created we can write as below
	#$task = App\Task::find($id);
	$task = Task::find($id);// when namespace used above
    return view('tasks.details', compact('task'));
});
*/

// how to use with controllers
Route::get('/task-list', 'TasksController@showList');
Route::get('/tasks/{task}', 'TasksController@showDetails');
Route::get('/task/create', 'TasksController@create');
Route::post('/task', 'TasksController@store');
Route::get('/task/edit/{task}', 'TasksController@edit');
Route::post('/task/update/{id}', 'TasksController@update');
Route::get('/task/delete/{id}', 'TasksController@delete');



Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
	$name = 'Laravel';
    //return view('about', ['name' => 'Mrinmoy']);
    //return view('about', ['name' => $name]);
   // return view('about', compact('name'));
   
    $names = ['Jajabor Samanta', 'Mrinmoy Mondal', 'Nabarun S. Sarkar'];
    return view('about', compact('names', 'name'));
});

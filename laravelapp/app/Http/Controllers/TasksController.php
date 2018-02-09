<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Task;
use Session;

class TasksController extends Controller
{
    // list function starts
    public function showList(Request $request)
    {		
		//$tasks = Task::all(); // when namespace used above
		
		$query = $request->get('srch_task');
		//$query = '';
        if ($query){
            $tasks = Task::where('title', 'LIKE', "%$query%")->orderBy('created_at', 'DESC')->paginate(2);
        }
        else
			$tasks=Task::orderBy('created_at', 'DESC')->paginate(2);
		
		
		return view('tasks.index',compact('tasks'))->with('i', ($request->input('page', 1) - 1) * 2);
		
		//$tasks = DB::table('tasks')->paginate(5);
		//return view('tasks.index', compact('tasks'));
	}
	
    // details function starts
    public function showDetails($id)
    {		
		$tasks = Task::find($id);// when namespace used above
		return view('tasks.details', compact('tasks'));
	}
	
    // create function starts
    public function create()
    {		
		$tasks = Task::all();
		return view('tasks.create');
	}
	
	public function store()
	{
		//dd(request()->all());
		#$task = new Task;
		
		#$task->title = request('formGroupTitle');
		#$task->body = request('formGroupDescription');
		// save in database
		#$task->save();
		
		// validation
		$this->validate(request(), [
			'formGroupTitle' => 'required',
			'formGroupDescription' => 'required',
		]);
		
		// another approach
		Task::create([
			'title' => request('formGroupTitle'),
			'body' => request('formGroupDescription')
		]);
		
		// redirect to another page
		return redirect('/task-list');
		
	}
	
	// edit task
	public function edit($id)
	{
		$task = Task::findOrFail($id);
		return view('tasks.edit')->withTask($task);
	}
	
	// edit task
	 public function update($id, Request $request){
		 
		 //dd($request);
        //validate post data
        $this->validate($request, [
            'formGroupTitle' => 'required',
            'formGroupDescription' => 'required'
        ]);
        
        //get post data
        
        $postData = array(
			'title'=>request('formGroupTitle'),
			'body'=>request('formGroupDescription')
        );
        
        //update post data
        Task::find($id)->update($postData);
        
        //store status message
        Session::flash('flash_message', 'Task updated successfully!');

        return redirect('/task-list');
    }
    
    public function delete($id){
        //update post data
        Task::find($id)->delete();
        
        //store status message
        Session::flash('flash_message', 'Task deleted successfully!');

        return redirect('/task-list');
    }
    
}

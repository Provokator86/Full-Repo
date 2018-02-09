@extends('layouts.master')

@section('content')
    
      <div class="container">
		  <h1 class="jumbotron-heading">Create Task</h1> 
        
		<form name="" action="/laravelapp/public/task" method="POST">
			{{ csrf_field() }}
			<div class="col-md-4">
				<div class="form-group row">
					<label for="formGroupTitle">Title</label>
					<input type="text" class="form-control" id="formGroupTitle" name="formGroupTitle" placeholder="Title">
				</div>
				
				<div class="form-group row">
					<label for="formGroupDescription">Description</label>
					<!--<input type="text" class="form-control" id="formGroupDescription" placeholder="Description">-->
					<textarea class="form-control" id="formGroupDescription" name="formGroupDescription" placeholder="Description"></textarea>
				</div>
				
				<div class="form-group row">
					
					<button type="submit" class="btn btn-primary">Submit</button>
					&nbsp;<a class="btn btn-success" href="http://192.168.1.38/laravelapp/public/task-list" role="button">Back To List</a>&nbsp;
					
				</div>
				
				@include('layouts.errors')
					
			</div>
		</form>		
		
		<div class="clear"></div>
       
      </div>  
      

@endsection

@extends('layouts.master')

@section('content')
 <!--<section class="jumbotron text-center">
      <div class="container">
        <h1 class="jumbotron-heading">Tasks</h1>       
      </div>
    </section>-->
    
    
      <div class="container">
		  
        
		<h1 class="jumbotron-heading">Tasks</h1> 
		 @if(Session::has('flash_message'))
            <div class="alert alert-success">
                {{ Session::get('flash_message') }}
            </div>
			@endif
        
        <div class="container">
		
			<div class="row">
				
				<div class="col-md-8">
					<form action="" method="get" role="search">
						{{ csrf_field() }}
						<div class="input-group">
							
							<input type="text" class="form-control" name="srch_task" value="{{ app('request')->input('srch_task') }}" 
								placeholder="Search tasks"> <span class="input-group-btn">
								<button type="submit" class="btn btn-default">
									<span class="glyphicon glyphicon-search"></span>
								</button>
							</span>
						</div>
					</form>			
				</div>
				
				<div class="col-md-4 ">
					<a class="btn btn-primary btn-sm pull-right" href="{{ url('task/create') }}" role="button">Add</a>				
				</div>
				
			</div>
			
		</div>
        <div class="clearfix" style="height:20px;"></div>
		
		
        <div class="row">
			
		  
			
			<table class="table table-bordered">
			  <thead>
				<tr>
				  <th width="10%">#</th>
				  <th width="25%">Title</th>
				  <th width="50%">Description</th>
				  <th width="15%">Action</th>
				</tr>
			  </thead>
			  <tbody>
				  @foreach($tasks as $key=>$task)
				<tr>
				  <th scope="row">{{$task->id}}</th>
				  <td>{{$task->title}}</td>
				  <td>{{$task->body}}</td>
				  <td>
					  <a class="btn btn-success btn-sm" href="{{ url('task/edit') }}/{{$task->id}}" role="button">Edit</a>&nbsp;
					  <a class="btn btn-danger btn-sm" href="{{ url('task/delete') }}/{{$task->id}}" role="button">Delete</a>
				  </td>
				</tr>
				@endforeach
				
			  </tbody>
			</table>
			
			
			
			{!! $tasks->appends(request()->query())->links('layouts.pager') !!}
			
			<!--<ul>
				<?php foreach($tasks as $task) { ?>
				<li><a href="/laravelapp/public/tasks/{{$task->id}}"><?php echo $task->title; ?></a> : <span><?php echo $task->body; ?></span></li>
				<?php } ?>
			</ul>-->				
		
        </div>
      </div>  
      

@endsection

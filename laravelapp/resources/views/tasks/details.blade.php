@extends('layouts.master')

@section('content')
 <!--<section class="jumbotron text-center">
      <div class="container">
        <h1 class="jumbotron-heading">Tasks</h1>       
      </div>
    </section>-->
    
    <h1 class="jumbotron-heading">Task Details</h1> 
    <div class="album text-muted">
      <div class="container">
        <div class="row">
			<div class="col-md-4">
				<ul>
					<li>{{$task->title}}</li>  
				</ul>
            </div>
            
            <div class="col-md-8">	            		
				<p>{{$task->body}}</p>
            </div>
		
        </div>
      </div>  
    </div>   

@endsection

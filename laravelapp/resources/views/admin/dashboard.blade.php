@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Admin Loggedin</div>
                 <div class="col-xs-12 connectedSortable">
					 @if( \Session::get('loggedin') )
                    <h3>Hello <span class="text-green">Super Admin</span>, welcome to Laravelapp</h3>
                    <div class="pull-right">
                      <a href="{{ url('') }}/admin/logout" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                    @endif
                </div>
                
            </div>
        </div>
    </div>
</div>

@endsection

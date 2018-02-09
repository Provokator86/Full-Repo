<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
   

    <title>Laravel Application</title>

    <!-- Bootstrap core CSS -->
    <link href="http://192.168.1.38/laravelapp/public/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="http://192.168.1.38/laravelapp/public/css/album.css" rel="stylesheet">
    <link href="http://192.168.1.38/laravelapp/public/css/app.css" rel="stylesheet">
  </head>

  <body>

     <!-- Header-->
    @include('layouts.header')
    <!-- Header-->
    
    <!-- Navigation Menu-->
    
    <!-- Navigation Menu-->
    
    <!-- Content -->
    @yield('content')
    
	<!-- Footer -->
	@include('layouts.footer')
     
  </body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel</title>
    <link type="text/css" rel="stylesheet" href="{{asset('contents/admin')}}/css/font-awesome.min.css"/>
    <link type="text/css" href="{{asset('contents/admin/')}}/css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="{{asset('contents/admin')}}/css/style.css"/>
</head>
<body>
<div class="container-fluid header_full">
    <div class="container header">
        <div class="row">

        </div><!--row end-->
    </div><!--container end-->
</div><!--container-fluid end-->
<div class="container-fluid content_full">
    <div class="row">
        <div class="col-md-2 sidebar pd0">
            <div class="side_user">
                <img class="img-responsive" src="{{asset('contents/admin')}}/images/avatar.png"/>
                @auth
                    <h4>{{auth()->user()->name}}</h4>
                @endauth

            </div>
            <h2>MAIN NAVIGATION</h2>
            <ul>
                <li><a href="{{ route('user.view', ['id' => $user->id]) }}"><i class="fa fa-user-circle"></i> User Info </a></li>
{{--                <li><a href="#"><i class="fa fa-image"></i> Gallery</a></li>--}}
                <li><a href="{{route('logout')}}"><i class="fa fa-sign-out"></i> Logout</a></li>
            </ul>
        </div><!--sidebar end-->
        <div class="col-md-10 admin-part pd0">
            <ol class="breadcrumb">
                {{ Breadcrumbs::render()}}
            </ol>
            @yield('useronly-content')
        </div><!--admin-part end-->
    </div><!--row end-->
</div><!--container-fluid end-->
<div class="container-fluid footer_full">
    <div class="container footer">
        <div class="row">
        </div><!--row end-->
    </div><!--container end-->
</div><!--container-fluid end-->
<script type="text/javascript" src="{{asset('contents/admin')}}/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="{{asset('contents/admin/')}}/js/bootstrap.min.js"></script>
<script type="text/javascript" src="{{asset('contents/admin/')}}/js/custom.js"></script>
</body>
</html>

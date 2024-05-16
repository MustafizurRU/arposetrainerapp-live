@extends('layouts.onlyuser')

@section('useronly-content')
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="col-md-9 heading_title">
                    User Information
                </div>
                <div class="col-md-3 text-right">
                    <a href="{{ route('user.edit', ['id' => $user->id]) }}" class="btn btn-sm btn btn-primary"><i class="fa fa-info-circle"></i> Edit Info</a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                <div class="col-md-1"></div>
                <div class="col-md-9">
                    <table class="table table-hover table-striped table-responsive view_table_cus">
                        <tr>
                            <td>Name</td>
                            <td>:</td>
                            <td>{{$user->name}}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>:</td>
                            <td>{{$user->email}}</td>
                        </tr>
                        <tr>
                            <td>Total Score</td>
                            <td>:</td>
                            <td>{{ $user->total_score }}</td>
                        </tr>
                        <tr>
                            <td>Current Level</td>
                            <td>:</td>
                            <td>{{ $user->current_level }}</td>
                        </tr>
                        <tr>
                            <td>Overall Performance</td>
                            <td>:</td>
                            <td>{{ $user->overall_performance }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-2"></div>
            </div>
        </div>
        @foreach($user->items as $item)
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="col-md-9 heading_title">
                        @switch($item->level_name)
                            @case('level1') Level 1 : Details @break
                            @case('level2') Level 2 : Details @break
                            @case('level3') Level 3 : Details @break
                            @case('level4') Level 4 : Details @break
                            @case('level5') Level 5 : Details @break
                            @default
                                @break
                        @endswitch
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                    <div class="col-md-1"></div>
                    <div class="col-md-9">
                        <table class="table table-hover table-striped table-responsive view_table_cus">
                            <tr>
                                <td>Level Name</td>
                                <td>:</td>
                                <td>{{$item->level_name}}</td>
                            </tr>
                            <tr>
                                <td>Level Score</td>
                                <td>:</td>
                                <td>{{$item->level_wise_score}}</td>
                            </tr>
                            <tr>
                                <td>Performance</td>
                                <td>:</td>
                                <td>{{$item->level_performance}}</td>
                            </tr>
{{--                            <tr>--}}
{{--                                <td>Pose Image</td>--}}
{{--                                <td>:</td>--}}
{{--                                <td><img src="{{$item->pose_image_url}}" style="width: 600px; height: auto;" alt="PoseImage"></td>--}}
{{--                            </tr>--}}
                        </table>
                    </div>
                    <div class="col-md-2"></div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

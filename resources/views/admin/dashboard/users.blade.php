@extends('layouts.admin')

@section('admin_content')
    <div class="col-md-12">
        <!-- Filters -->
        <div class="well text-center filter-form">
            <form class="form form-inline" action="{{route('search')}}">
                <label for="input_search">Search</label>
                <input type="text" class="form-control" id="input_search" name="search_string" value="{{isset($search) ? $search:''}}">
                <input type="submit" value="Go" class="btn btn-primary">
            </form>
        </div>
        <!-- //Filters -->
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="col-md-9 heading_title">
                    All Information View
                </div>
{{--                <div class="col-md-3 text-right">--}}
{{--                    <a href="form.html" class="btn btn-sm btn btn-primary"><i class="fa fa-plus-circle"></i> Add New Patient</a>--}}
{{--                </div>--}}
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                <table class="table table-responsive table-striped table-hover table_cus">
                    <thead class="table_head">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Total Score</th>
                        <th class="hidden-xs">Current Level</th>
                        <th class="hidden-xs">Overall Performance</th>
                        <th>Manage</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users_data as $user)
                        <tr>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{ $user->total_score }}</td>
                            <td class="hidden-xs">{{ $user->current_level }}</td>
                            <td class="hidden-xs">{{ $user->overall_performance }}</td>
                            <td>
                                <a href="{{ route('user.view', ['id' => $user->id]) }}"><i class="fa fa-plus-square fa-lg"></i></a>
                                <a href="{{ route('user.edit', ['id' => $user->id]) }}"><i class="fa fa-pencil-square fa-lg"></i></a>
                                <a href="{{route('users')}}" onclick="deleteUser({{ $user->id }})"><i class="fa fa-trash fa-lg"></i></a>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
                {{$users_data->links()}}
            </div>
        </div>
    </div><!--col-md-12 end-->
@endsection
<script>
    function deleteUser(userId) {
        if (confirm('Are you sure you want to delete this user?')) {
            fetch(`{{ route('user.destroy', ['id' => ':userId']) }}`.replace(':userId', userId), {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
            }).then(response => {
                if (response.ok) {
                    window.location.reload();
                }
            });
        }
    }
</script>




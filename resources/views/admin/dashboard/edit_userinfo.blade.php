@extends('layouts.admin')

@section('admin_content')
    <form class="form-horizontal" action="{{ route('user.update', ['id' => $user->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="col-md-9 heading_title">
                    Update Information
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="name" class="col-sm-3 control-label">Name</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-3 control-label">Email</label>
                    <div class="col-sm-8">
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}">
                        @error('email')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="panel-footer text-center">
                <button type="submit" class="btn btn-sm btn-primary">UPDATE</button>
            </div>
        </div>
    </form>
@endsection

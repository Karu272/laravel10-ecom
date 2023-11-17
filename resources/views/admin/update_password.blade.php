@extends('admin.layout.layout')
@section('content')
    <h1>Update Admin Password</h1>
    <form method="POST" action="{{ route('admin.update_password') }}" enctype="multipart/form-data">@csrf
        <div class="card-body">
            <div class="form-group">
                <label for="admin_email">Logged in User</label>
                <strong> || {{Auth::guard('admin')->user()->email}}</strong>
            </div>
            <div class="form-group">
                <label for="current_pwd">Current Password</label>
                <input class="form-control @error('current_pwd') is-invalid @enderror" type="password" name="current_pwd" id="current_pwd"
                    placeholder="Enter Current Password"><span id="chkCurrentPwd"></span>
                    @error('current_pwd')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
            </div>
            <div class="form-group">
                <label for="new_pwd">New Password</label>
                <input class="form-control @error('new_pwd') is-invalid @enderror" type="password" name="new_pwd" id="new_pwd"
                    placeholder="Enter New Password">
                    @error('new_pwd')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
            </div>
            <div class="form-group">
                <label for="confirm_pwd">Confirm Password</label>
                <input class="form-control" type="password" name="confirm_pwd" id="confirm_pwd"
                    placeholder="Enter Confirm Password">
            </div>
            <button type="submit" class="btn btn-primary me-2">Save</button>
        </div>
    </form>
@endsection

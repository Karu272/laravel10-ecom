@extends('admin.layout.layout')
@section('content')
    <div class="col-sm-4">
        <div class="card">
            <div class="card-body">
        <h3>Update Admin Password</h3>
        <form method="POST" action="{{ route('admin.update_password') }}" enctype="multipart/form-data">@csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="admin_email">Logged in User</label>
                    <strong> || {{ Auth::guard('admin')->user()->email }}</strong>
                </div>
                <div class="form-group">
                    @if (Session::has('error_message'))
                        <div class="redDanger alert alert-danger" role="alert">
                            {{ Session::get('error_message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if (Session::has('success_message'))
                        <div class="greenDanger alert alert-danger" role="alert">
                            {{ Session::get('success_message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <label for="current_pwd">Current Password</label>
                    <input class="form-control @error('current_pwd') is-invalid @enderror" type="password"
                        name="current_pwd" id="current_pwd" placeholder="Enter Current Password"><span
                        id="chkCurrentPwd"></span>
                    @error('current_pwd')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="new_pwd">New Password</label>
                    <input class="form-control @error('new_pwd') is-invalid @enderror" type="password" name="new_pwd"
                        id="new_pwd" placeholder="Enter New Password">
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
    </div>
        </div>
    </div>
@endsection

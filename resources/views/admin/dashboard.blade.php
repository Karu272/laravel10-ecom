@extends('admin.layout.layout')
@section('content')
    <div class="col-sm-8">
        <div class="card">
            <div class="card-body">
                @if (Session::has('error_message'))
                    <div class="redDanger alert alert-danger" role="alert">
                        {{ Session::get('error_message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <h1>Dashboard</h1>
            </div>
        </div>
    </div>
@endsection

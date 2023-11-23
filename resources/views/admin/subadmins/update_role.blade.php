@extends('admin.layout.layout')
@section('content')
    <div class="col-sm-4">
        <h3>{{ $title }}</h3>
        @if (Session::has('success_message'))
            <div class="greenDanger alert alert-danger" role="alert">
                {{ Session::get('success_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <form name="SubAdminForm" id="SubAdminForm" action="{{ route('admin.subadmins.update_role', ['id' => $id]) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="subadmin_id" value="{{ $id }}">
            <div class="card-body">
                @if (!empty($subadminRoles))
                    @foreach($subadminRoles as $role)
                    @if ($role['module'] == 'cms_pages')
                        @if ($role['view_access'] == 1)
                            @php $viewCMSPages = "checked" @endphp
                        @else
                            @php $viewCMSPages = "" @endphp
                        @endif
                        @if ($role['edit_access'] == 1)
                            @php $editCMSPages = "checked" @endphp
                        @else
                            @php $editCMSPages = "" @endphp
                        @endif
                        @if ($role['full_access'] == 1)
                            @php $fullCMSPages = "checked" @endphp
                        @else
                            @php $fullCMSPages = "" @endphp
                        @endif
                    @endif
                @endforeach
                @endif
                <div class="form-group">
                    <label style="margin-left: 10%;" for="cms_pages">
                        <h4>CMS Pages</h4>
                    </label>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="cms_pages[view]" value="1"
                            @if (isset($viewCMSPages)) {{ $viewCMSPages }} @endif>
                        <label class="form-check-label">View Access</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="cms_pages[edit]" value="1"
                            @if (isset($editCMSPages)) {{ $editCMSPages }} @endif>
                        <label class="form-check-label">View/Edit Access</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="cms_pages[full]" value="1"
                            @if (isset($fullCMSPages)) {{ $fullCMSPages }} @endif>
                        <label class="form-check-label">Full access</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary me-2">Update</button>
            </div>
        </form>
    </div>
@endsection

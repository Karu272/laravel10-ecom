@extends('admin.layout.layout')
@section('content')
    <div class="col-sm-8">
        <div class="card">
            <div class="card-body">
        <div class="container-settings">
            @if (Session::has('success_message'))
                <div class="greenDanger alert alert-danger" role="alert">
                    {{ Session::get('success_message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="tablecontainer">
                <h3 style="margin-top: 10px">Subadmins
                    @if ($pagesModule['edit_access'] == 1 || $pagesModule['full_access'] == 1)
                        <a href="{{ URL('admin/subadmins/add-edit-subadmin') }}" class="btn btn-block btn-success tblBtn">
                            Add / Edit</a>
                    @endif
                </h3>
                <div class="innerCon">
                    <table class="table" id="example">
                        <thead>
                            <tr>
                                <th class="table__heading">ID</th>
                                <th class="table__heading">Name</th>
                                <th class="table__heading">Mobile</th>
                                <th class="table__heading">Email</th>
                                <th class="table__heading">Type</th>
                                <th class="table__heading">Created</th>
                                <th class="table__heading">Status</th>
                                <th class="table__heading">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subadminDbData as $subadmin)
                                <tr class="table__row">
                                    <td class="table__content" data-heading="ID">{{ $subadmin['id'] }}</td>
                                    <td class="table__content" data-heading="Title">{{ $subadmin['name'] }}</td>
                                    <td class="table__content" data-heading="Mobile">{{ $subadmin['mobile'] }}</td>
                                    <td class="table__content" data-heading="Email">{{ $subadmin['email'] }}</td>
                                    <td class="table__content" data-heading="Type">{{ $subadmin['type'] }}</td>
                                    <td class="table__content" data-heading="Created at">
                                        {{ date('F j, Y, g:i a', strtotime($subadmin['created_at'])) }}</td>
                                    <td class="table__content" data-heading="Status">
                                        @if ($pagesModule['full_access'] == 1)
                                            @if ($subadmin['status'] == 1)
                                                <a class="updateSubadminStatus" id="page-{{ $subadmin['id'] }}"
                                                    page_id="{{ $subadmin['id'] }}" href="javascript:void(0)"
                                                    style="color: blue;">
                                                    <i class="fas fa-toggle-on" status="Active"></i>
                                                </a>
                                            @else
                                                <a class="updateSubadminStatus" id="page-{{ $subadmin['id'] }}"
                                                    page_id="{{ $subadmin['id'] }}" href="javascript:void(0)">
                                                    <i class="fas fa-toggle-off" status="Inactive"></i>
                                                </a>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="table__content" data-heading="action">
                                        @if ($pagesModule['edit_access'] == 1 || $pagesModule['full_access'] == 1)
                                            <a href="{{ route('admin.subadmins.add_edit_subadmin', ['id' => $subadmin['id']]) }}"
                                                style="color: blue;">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endif
                                        @if ($pagesModule['full_access'] == 1)
                                            <a title="Delete CmsPage" href="javascript:void(0)" class="confirmDelete"
                                                record="subadmin" recordid="{{ $subadmin['id'] }}"><i
                                                    class="fas fa-trash"></i></a>
                                            <a href="{{ route('admin.subadmins.update_role', ['id' => $subadmin['id']]) }}"
                                                style="color: blue;">
                                                <i class="fas fa-unlock"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
        </div>
    </div>
@endsection

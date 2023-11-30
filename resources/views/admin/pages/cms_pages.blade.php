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
                <h3 style="margin-top: 10px"> CMS Page
                    @if ($pagesModule['edit_access'] == 1 || $pagesModule['full_access'] == 1)
                        <a href="{{ URL('admin/pages/add-edit-cmsPage') }}" class="btn btn-block btn-success tblBtn">
                            Add / Edit</a>
                    @endif
                </h3>
                <div class="innerCon">
                    <table class="table" id="example">
                        <thead>
                            <tr>
                                <th class="table__heading">ID</th>
                                <th class="table__heading">Title</th>
                                <th class="table__heading">Url</th>
                                <th class="table__heading">Created</th>
                                <th class="table__heading">Status</th>
                                <th class="table__heading">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($CmsPages as $Cms)
                                <tr class="table__row">
                                    <td class="table__content" data-heading="ID">{{ $Cms['id'] }}</td>
                                    <td class="table__content" data-heading="Title">{{ $Cms['title'] }}</td>
                                    <td class="table__content" data-heading="Url">{{ $Cms['url'] }}</td>
                                    <td class="table__content" data-heading="Created at">
                                        {{ date('F j, Y, g:i a', strtotime($Cms['created_at'])) }}</td>
                                    <td class="table__content" data-heading="Status">
                                        @if ($pagesModule['edit_access'] == 1 || $pagesModule['full_access'] == 1)
                                            @if ($Cms['status'] == 1)
                                                <a class="updateCmsPageStatus" id="page-{{ $Cms['id'] }}"
                                                    page_id="{{ $Cms['id'] }}" href="javascript:void(0)"
                                                    style="color: blue;">
                                                    <i class="fas fa-toggle-on" status="Active"></i>
                                                </a>
                                            @else
                                                <a class="updateCmsPageStatus" id="page-{{ $Cms['id'] }}"
                                                    page_id="{{ $Cms['id'] }}" href="javascript:void(0)">
                                                    <i class="fas fa-toggle-off" status="Inactive"></i>
                                                </a>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="table__content" data-heading="action">
                                        @if ($pagesModule['edit_access'] == 1 || $pagesModule['full_access'] == 1)
                                            <a href="{{ route('admin.pages.add_edit_cmsPage', ['id' => $Cms['id']]) }}"
                                                style="color: blue;">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endif
                                        @if ($pagesModule['full_access'] == 1)
                                            <a title="Delete CmsPage" href="javascript:void(0)" class="confirmDelete"
                                                record="cmsPage" recordid="{{ $Cms['id'] }}"><i
                                                    class="fas fa-trash"></i></a>
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

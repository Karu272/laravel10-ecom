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
                        <h3 style="margin-top: 10px"> Brands Page
                            @if ($pagesModule['edit_access'] == 1 || $pagesModule['full_access'] == 1)
                                <a href="{{ url('admin/brands/add-edit-brand') }}"
                                    class="btn btn-block btn-success tblBtn">
                                    Add</a>
                            @endif
                        </h3>
                        <div class="innerCon">
                            <table class="table" id="example">
                                <thead>
                                    <tr>
                                        <th class="table__heading">ID</th>
                                        <th class="table__heading">Name</th>
                                        <th class="table__heading">Url</th>
                                        <th class="table__heading">Created</th>
                                        <th class="table__heading">Status</th>
                                        <th class="table__heading">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($brandDBdata as $brand)
                                        <tr class="table__row">
                                            <td class="table__content" data-heading="ID">{{ $brand['id'] }}</td>
                                            <td class="table__content" data-heading="Name">{{ $brand['brand_name'] }}
                                            </td>
                                            <td class="table__content" data-heading="Url">{{ $brand['url'] }}</td>
                                            <td class="table__content" data-heading="Created at">
                                                {{ date('F j, Y, g:i a', strtotime($brand['created_at'])) }}</td>
                                            <td class="table__content" data-heading="Status">
                                                @if ($pagesModule['edit_access'] == 1 || $pagesModule['full_access'] == 1)
                                                    @if ($brand['status'] == 1)
                                                        <a class="updateBrandPageStatus" id="page-{{ $brand['id'] }}"
                                                            page_id="{{ $brand['id'] }}" href="javascript:void(0)"
                                                            style="color: blue;">
                                                            <i class="fas fa-toggle-on" status="Active"></i>
                                                        </a>
                                                    @else
                                                        <a class="updateBrandPageStatus" id="page-{{ $brand['id'] }}"
                                                            page_id="{{ $brand['id'] }}" href="javascript:void(0)">
                                                            <i class="fas fa-toggle-off" status="Inactive"></i>
                                                        </a>
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="table__content" data-heading="action">
                                                @if ($pagesModule['edit_access'] == 1 || $pagesModule['full_access'] == 1)
                                                    <a href="{{ route('admin.brands.add_edit_brand', ['id' => $brand['id']]) }}"
                                                        style="color: blue;">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endif
                                                @if ($pagesModule['full_access'] == 1)
                                                    <a title="Delete brand" href="javascript:void(0)"
                                                        class="confirmDelete" record="brand"
                                                        recordid="{{ $brand['id'] }}"><i class="fas fa-trash"></i></a>
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

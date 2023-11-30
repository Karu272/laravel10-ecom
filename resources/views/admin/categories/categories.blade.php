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
                        <h3 style="margin-top: 10px"> Categories Page
                            @if ($pagesModule['edit_access'] == 1 || $pagesModule['full_access'] == 1)
                                <a href="{{ url('admin/categories/add-edit-category') }}"
                                    class="btn btn-block btn-success tblBtn">
                                    Add / Edit</a>
                            @endif
                        </h3>
                        <div class="innerCon">
                            <table class="table" id="example">
                                <thead>
                                    <tr>
                                        <th class="table__heading">ID</th>
                                        <th class="table__heading">Name</th>
                                        <th class="table__heading">Parent</th>
                                        <th class="table__heading">Url</th>
                                        <th class="table__heading">Created</th>
                                        <th class="table__heading">Status</th>
                                        <th class="table__heading">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categoriesDBdata as $category)
                                        <tr class="table__row">
                                            <td class="table__content" data-heading="ID">{{ $category['id'] }}</td>
                                            <td class="table__content" data-heading="Name">{{ $category['category_name'] }}
                                            </td>
                                            <td class="table__content" data-heading="Parent">
                                                @if (isset($category['parentcategory']['category_name']))
                                                    {{ $category['parentcategory']['category_name'] }}
                                                @endif
                                            </td>
                                            <td class="table__content" data-heading="Url">{{ $category['url'] }}</td>
                                            <td class="table__content" data-heading="Created at">
                                                {{ date('F j, Y, g:i a', strtotime($category['created_at'])) }}</td>
                                            <td class="table__content" data-heading="Status">
                                                @if ($pagesModule['edit_access'] == 1 || $pagesModule['full_access'] == 1)
                                                    @if ($category['status'] == 1)
                                                        <a class="updatecategoryPageStatus" id="page-{{ $category['id'] }}"
                                                            page_id="{{ $category['id'] }}" href="javascript:void(0)"
                                                            style="color: blue;">
                                                            <i class="fas fa-toggle-on" status="Active"></i>
                                                        </a>
                                                    @else
                                                        <a class="updatecategoryPageStatus" id="page-{{ $category['id'] }}"
                                                            page_id="{{ $category['id'] }}" href="javascript:void(0)">
                                                            <i class="fas fa-toggle-off" status="Inactive"></i>
                                                        </a>
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="table__content" data-heading="action">
                                                @if ($pagesModule['edit_access'] == 1 || $pagesModule['full_access'] == 1)
                                                    <a href="{{ route('admin.categories.add_edit_category', ['id' => $category['id']]) }}"
                                                        style="color: blue;">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endif
                                                @if ($pagesModule['full_access'] == 1)
                                                    <a title="Delete category" href="javascript:void(0)"
                                                        class="confirmDelete" record="category"
                                                        recordid="{{ $category['id'] }}"><i class="fas fa-trash"></i></a>
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

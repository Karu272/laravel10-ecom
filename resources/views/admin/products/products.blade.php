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
                        <h3 style="margin-top: 10px"> Products Page
                            @if ($pagesModule['edit_access'] == 1 || $pagesModule['full_access'] == 1)
                                <a href="{{ url('admin/products/add-edit-product') }}"
                                    class="btn btn-block btn-success tblBtn">
                                    Add </a>
                            @endif
                        </h3>
                        <div class="innerCon">
                            <table class="table" id="example">
                                <thead>
                                    <tr>
                                        <th class="table__heading">ID</th>
                                        <th class="table__heading">Name</th>
                                        <th class="table__heading">Parent</th>
                                        <th class="table__heading">Family Color</th>
                                        <th class="table__heading">Featured</th>
                                        <th class="table__heading">Created</th>
                                        <th class="table__heading">Status</th>
                                        <th class="table__heading">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($getProductDBdata as $product)
                                        <tr class="table__row">
                                            <td class="table__content" data-heading="ID">{{ $product['id'] }}</td>
                                            <td class="table__content" data-heading="Name">{{ $product['product_name'] }}
                                            </td>
                                            <td class="table__content" data-heading="Parent">
                                                <!-- category comes from the function called in controller with same name -->
                                                @if (isset($product['category']['category_name']))
                                                    {{ $product['category']['category_name'] }}
                                                @endif
                                            </td>
                                            <td class="table__content" data-heading="Family Color">
                                                {{ $product['family_color'] }}</td>
                                            <td class="table__content" data-heading="Is Featured">
                                                {{ $product['is_featured'] }}</td>
                                            <td class="table__content" data-heading="Created at">
                                                {{ date('F j, Y, g:i a', strtotime($product['created_at'])) }}</td>
                                            <td class="table__content" data-heading="Status">
                                                @if ($pagesModule['edit_access'] == 1 || $pagesModule['full_access'] == 1)
                                                    @if ($product['status'] == 1)
                                                        <a class="updateproductPageStatus" id="page-{{ $product['id'] }}"
                                                            page_id="{{ $product['id'] }}" href="javascript:void(0)"
                                                            style="color: blue;">
                                                            <i class="fas fa-toggle-on" status="Active"></i>
                                                        </a>
                                                    @else
                                                        <a class="updateproductPageStatus" id="page-{{ $product['id'] }}"
                                                            page_id="{{ $product['id'] }}" href="javascript:void(0)">
                                                            <i class="fas fa-toggle-off" status="Inactive"></i>
                                                        </a>
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="table__content" data-heading="action">
                                                @if ($pagesModule['edit_access'] == 1 || $pagesModule['full_access'] == 1)
                                                    <a href="{{ route('admin.products.add_edit_product', ['id' => $product['id']]) }}"
                                                        style="color: blue;">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endif
                                                @if ($pagesModule['full_access'] == 1)
                                                    <a title="Delete product" href="javascript:void(0)"
                                                        class="confirmDelete" record="product"
                                                        recordid="{{ $product['id'] }}">
                                                        <i class="fas fa-trash"></i>
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

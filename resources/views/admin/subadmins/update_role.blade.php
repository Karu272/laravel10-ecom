@extends('admin.layout.layout')
@section('content')
    <div class="col-sm-4">
        <div class="card">
            <div class="card-body">
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
                    @if ($role['module'] == 'categories')
                        @if ($role['view_access'] == 1)
                            @php $viewCategories = "checked" @endphp
                        @else
                            @php $viewCategories = "" @endphp
                        @endif
                        @if ($role['edit_access'] == 1)
                            @php $editCategories = "checked" @endphp
                        @else
                            @php $editCategories = "" @endphp
                        @endif
                        @if ($role['full_access'] == 1)
                            @php $fullCategories = "checked" @endphp
                        @else
                            @php $fullCategories = "" @endphp
                        @endif
                    @endif
                    @if ($role['module'] == 'products')
                        @if ($role['view_access'] == 1)
                            @php $viewProducts = "checked" @endphp
                        @else
                            @php $viewProducts = "" @endphp
                        @endif
                        @if ($role['edit_access'] == 1)
                            @php $editProducts = "checked" @endphp
                        @else
                            @php $editProducts = "" @endphp
                        @endif
                        @if ($role['full_access'] == 1)
                            @php $fullProducts = "checked" @endphp
                        @else
                            @php $fullProducts = "" @endphp
                        @endif
                    @endif
                    @if ($role['module'] == 'brands')
                        @if ($role['view_access'] == 1)
                            @php $viewBrands = "checked" @endphp
                        @else
                            @php $viewBrands = "" @endphp
                        @endif
                        @if ($role['edit_access'] == 1)
                            @php $editBrands = "checked" @endphp
                        @else
                            @php $editBrands = "" @endphp
                        @endif
                        @if ($role['full_access'] == 1)
                            @php $fullBrands = "checked" @endphp
                        @else
                            @php $fullBrands = "" @endphp
                        @endif
                    @endif
                    @if ($role['module'] == 'coupons')
                        @if ($role['view_access'] == 1)
                            @php $viewCoupons = "checked" @endphp
                        @else
                            @php $viewCoupons = "" @endphp
                        @endif
                        @if ($role['edit_access'] == 1)
                            @php $editCoupons = "checked" @endphp
                        @else
                            @php $editCoupons = "" @endphp
                        @endif
                        @if ($role['full_access'] == 1)
                            @php $fullCoupons = "checked" @endphp
                        @else
                            @php $fullCoupons = "" @endphp
                        @endif
                    @endif
                @endforeach
                @endif
                <div style="margin-left: 10%;" class="form-group">
                    <label for="cms_pages">
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
                    <br>
                </div>
                <div style="margin-left: 10%;" class="form-group">
                    <label for="categories">
                        <h4>Categories</h4>
                    </label>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="categories[view]" value="1"
                            @if (isset($viewCategories)) {{ $viewCategories }} @endif>
                        <label class="form-check-label">View Access</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="categories[edit]" value="1"
                            @if (isset($editCategories)) {{ $editCategories }} @endif>
                        <label class="form-check-label">View/Edit Access</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="categories[full]" value="1"
                            @if (isset($fullCategories)) {{ $fullCategories }} @endif>
                        <label class="form-check-label">Full access</label>
                    </div>
                    <br>
                </div>
                <div style="margin-left: 10%;" class="form-group">
                    <label for="products">
                        <h4>Products</h4>
                    </label>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="products[view]" value="1"
                            @if (isset($viewProducts)) {{ $viewProducts }} @endif>
                        <label class="form-check-label">View Access</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="Products[edit]" value="1"
                            @if (isset($editProducts)) {{ $editProducts }} @endif>
                        <label class="form-check-label">View/Edit Access</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="Products[full]" value="1"
                            @if (isset($fullProducts)) {{ $fullProducts }} @endif>
                        <label class="form-check-label">Full access</label>
                    </div>
                    <br>
                </div>
                <div style="margin-left: 10%;" class="form-group">
                    <label for="brands">
                        <h4>Brands</h4>
                    </label>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="brands[view]" value="1"
                            @if (isset($viewBrands)) {{ $viewBrands }} @endif>
                        <label class="form-check-label">View Access</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="brands[edit]" value="1"
                            @if (isset($editBrands)) {{ $editBrands }} @endif>
                        <label class="form-check-label">View/Edit Access</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="brands[full]" value="1"
                            @if (isset($fullBrands)) {{ $fullBrands }} @endif>
                        <label class="form-check-label">Full access</label>
                    </div>
                    <br>
                </div>
                <div style="margin-left: 10%;" class="form-group">
                    <label for="brands">
                        <h4>Brands</h4>
                    </label>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="brands[view]" value="1"
                            @if (isset($viewBrands)) {{ $viewBrands }} @endif>
                        <label class="form-check-label">View Access</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="brands[edit]" value="1"
                            @if (isset($editBrands)) {{ $editBrands }} @endif>
                        <label class="form-check-label">View/Edit Access</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="brands[full]" value="1"
                            @if (isset($fullBrands)) {{ $fullBrands }} @endif>
                        <label class="form-check-label">Full access</label>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary me-2">Update</button>
                </div>
            </div>
        </form>
    </div>
        </div>
    </div>
@endsection

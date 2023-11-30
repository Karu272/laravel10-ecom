@extends('admin.layout.layout')
@section('content')
    <div class="col-sm-6">
        <div class="card">
            <div class="card-body">
        <h3> {{ $title }} </h3>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
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
        <form name="productForm" id="productForm"
            @if (empty($editPro['id'])) action="{{ route('admin.products.add_edit_product') }}" @else
          action="{{ route('admin.products.add_edit_product', ['id' => $editPro['id']]) }}" @endif
            method="POST" enctype="multipart/form-data">@csrf
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="product_name">Name</label>
                    <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Type name"
                        @if (!empty($editPro['product_name'])) value="{{ $editPro['product_name'] }}" @endif>
                </div>
                <div class="form-group col-md-6">
                    <label for="category_id">Category Level</label>
                    <select name="category_id" class="form-control">
                        <option value="">Select</option>
                        <option class="oSizeT" value="0">
                            &lceil;Main Category&rceil;</option>
                        @foreach ($getCategories as $cat)
                            <option value="{{ $cat['id'] }}">&loz;
                                {{ $cat['category_name'] }} &loz;</option>
                            @if (!empty($cat['subcategories']))
                                @foreach ($cat['subcategories'] as $subcat)
                                    <option value="{{ $subcat['id'] }}">
                                        &nbsp;&nbsp;&raquo; {{ $subcat['category_name'] }}
                                    </option>
                                    @if (!empty($subcat['subcategories']))
                                        @foreach ($subcat['subcategories'] as $subsubcat)
                                            <option value="{{ $subsubcat['id'] }}">
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&rarr;
                                                {{ $subsubcat['category_name'] }}
                                            </option>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="product_code">Products Code</label>
                    <input type="text" class="form-control" id="product_code" name="product_code" placeholder="Type Code"
                        @if (!empty($editPro['product_code'])) value="{{ $editPro['product_code'] }}" @endif>
                </div>
                <div class="form-group col-md-3">
                    <label for="product_color">Product Color</label>
                    <input type="text" class="form-control" id="product_color" name="product_color"
                        placeholder="Type color"
                        @if (!empty($editPro['product_color'])) value="{{ $editPro['product_color'] }}" @endif>
                </div>
                <div class="form-group col-md-3">
                    <label for="family_color">Family Color</label>
                    <select name="family_color" class="form-control" id="family_color">
                        <option value="">Select</option>
                        <option value="Red">Red</option>
                        <option value="Green">Green</option>
                        <option value="Yellow">Yellow</option>
                        <option value="Black">Black</option>
                        <option value="White">White</option>
                        <option value="Blue">Blue</option>
                        <option value="Orange">Orange</option>
                        <option value="Grey">Grey</option>
                        <option value="Silver">Silver</option>
                        <option value="Golden">Golden</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="product_weight">weight</label>
                    <input type="text" class="form-control" id="product_weight" name="product_weight"
                        placeholder="Type weight"
                        @if (!empty($editPro['product_weight'])) value="{{ $editPro['product_weight'] }}" @endif>
                </div>
                <div class="form-group col-md-3">
                    <label for="group_code">Group Code</label>
                    <input type="text" class="form-control" id="group_code" name="group_code"
                        placeholder="Type Group Code"
                        @if (!empty($editPro['group_code'])) value="{{ $editPro['group_code'] }}" @endif>
                </div>
                <div class="form-group col-md-3">
                    <label for="product_price">Price</label>
                    <input type="text" class="form-control" id="product_price" name="product_price"
                        placeholder="Type price"
                        @if (!empty($editPro['product_price'])) value="{{ $editPro['product_price'] }}" @endif>
                </div>
                <div class="form-group col-md-3">
                    <label for="product_discount">Discount %</label>
                    <input type="text" class="form-control" id="product_discount" name="product_discount"
                        placeholder="Type Discount"
                        @if (!empty($editPro['product_discount'])) value="{{ $editPro['product_discount'] }}" @endif>
                </div>
                <div class="form-group col-md-3">
                    <label for="final_price">Final Price</label>
                    <input type="text" class="form-control" id="final_price" name="final_price"
                        placeholder="Type Final Price"
                        @if (!empty($editPro['final_price'])) value="{{ $editPro['final_price'] }}" @endif>
                </div>
                <div class="form-group col-md-6">
                    <label for="description">Description</label>
                    <textarea type="text" class="form-control" id="description" name="description" rows="3"
                        placeholder="Type Description">{{ !empty($editPro['description']) ? $editPro['description'] : '' }}</textarea>
                </div>
                <div class="form-group col-md-6">
                    <label for="wash_care">Wash Care</label>
                    <textarea type="text" class="form-control" id="wash_care" name="wash_care" rows="3"
                        placeholder="Type wash_care">{{ !empty($editPro['wash_care']) ? $editPro['wash_care'] : '' }}</textarea>
                </div>
                <div class="form-group col-md-6">
                    <label for="meta_description">Meta Description</label>
                    <input type="text" class="form-control" id="meta_description" name="meta_description"
                        placeholder="Type Meta Description"
                        @if (!empty($editPro['meta_description'])) value="{{ $editPro['meta_description'] }}" @endif>
                </div>
                <div class="form-group col-md-3">
                    <label for="keywords">Search Keywords</label>
                    <input type="text" class="form-control" id="keywords" name="keywords"
                        placeholder="Type keywords"
                        @if (!empty($editPro['keywords'])) value="{{ $editPro['keywords'] }}" @endif>
                </div>
                <div class="form-group col-md-3">
                    <label for="meta_title">Meta Title</label>
                    <input type="text" class="form-control" id="meta_title" name="meta_title"
                        placeholder="Type Meta Title"
                        @if (!empty($editPro['meta_title'])) value="{{ $editPro['meta_title'] }}" @endif>
                </div>
                <div class="form-group col-md-3">
                    <label for="meta_keywords">Meta Keywords</label>
                    <input type="text" class="form-control" id="meta_keywords" name="meta_keywords"
                        placeholder="Type Meta Keywords"
                        @if (!empty($editPro['meta_keywords'])) value="{{ $editPro['meta_keywords'] }}" @endif>
                </div>
                <div class="form-group col-md-3">
                    <label for="is_featured">Is Featured</label>
                    <select class="form-control" id="is_featured" name="is_featured">
                        <option value="YES" @if (!empty($editPro['is_featured']) && $editPro['is_featured'] == 'YES') selected @endif>YES</option>
                        <option value="NO" @if (!empty($editPro['is_featured']) && $editPro['is_featured'] == 'NO') selected @endif>NO</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="product_video">Video</label>
                    <input type="file" class="form-control" id="product_video" name="product_video">
                    @if (!empty($editPro['product_video']))
                        <small class="text-muted">Current Video: {{ $editPro['product_video'] }}</small>
                    @endif
                </div>
                <div class="form-group col-md-2">
                    <label for="fabric">Fabric</label>
                    <select name="fabric" class="form-control">
                        <option value="">Select</option>
                        @foreach ($productsFilters['fabricArray'] as $fabric)
                            <option value="{{ $fabric }}">{{ $fabric }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="sleeve">Sleeve</label>
                    <select name="sleeve" class="form-control">
                        <option value="">Select</option>
                        @foreach ($productsFilters['sleeveArray'] as $sleeve)
                            <option value="{{ $sleeve }}">{{ $sleeve }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label for="pattern">Pattern</label>
                    <select name="pattern" class="form-control">
                        <option value="">Select</option>
                        @foreach ($productsFilters['petternArray'] as $pattern)
                            <option value="{{ $pattern }}">{{ $pattern }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="fit">Fit</label>
                    <select name="fit" class="form-control">
                        <option value="">Select</option>
                        @foreach ( $productsFilters['fitArray'] as $fit)
                            <option value="{{ $fit }}">{{ $fit }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label for="occasion">Occasion</label>
                    <select name="occasion" class="form-control">
                        <option value="">Select</option>
                        @foreach ( $productsFilters['occasionArray'] as $occasion)
                            <option value="{{ $occasion }}">{{ $occasion }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
        </div>
    </div>
@endsection

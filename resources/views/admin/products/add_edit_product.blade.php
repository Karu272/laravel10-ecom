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
                            <input type="text" class="form-control" id="product_name" name="product_name"
                                placeholder="Type name"
                                @if (!empty($editPro['product_name'])) value="{{ $editPro['product_name'] }}" @endif>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="category_id">Select Category</label>
                            <select name="category_id" class="form-control">
                                <option value="">Select</option>
                                @foreach ($getCategories as $cat)
                                    <option @if (isset($editPro['category_id']) && $editPro['category_id'] == $cat['id']) selected @endif value="{{ $cat['id'] }}">
                                        &loz; {{ $cat['category_name'] }} &loz;
                                    </option>
                                    @if (!empty($cat['subcategories']))
                                        @foreach ($cat['subcategories'] as $subcat)
                                            <option @if (isset($editPro['category_id']) && $editPro['category_id'] == $subcat['id']) selected @endif
                                                value="{{ $subcat['id'] }}">
                                                &nbsp;&nbsp;&raquo; {{ $subcat['category_name'] }}
                                            </option>
                                            @if (!empty($subcat['subcategories']))
                                                @foreach ($subcat['subcategories'] as $subsubcat)
                                                    <option @if (isset($editPro['category_id']) && $editPro['category_id'] == $subsubcat['id']) selected @endif
                                                        value="{{ $subsubcat['id'] }}">
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
                            <input type="text" class="form-control" id="product_code" name="product_code"
                                placeholder="Type Code"
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
                                <option value="Red" @if ($editPro['family_color'] == 'Red') selected @endif>Red</option>
                                <option value="Green" @if ($editPro['family_color'] == 'Green') selected @endif>Green</option>
                                <option value="Yellow" @if ($editPro['family_color'] == 'Yellow') selected @endif>Yellow</option>
                                <option value="Black" @if ($editPro['family_color'] == 'Black') selected @endif>Black</option>
                                <option value="White" @if ($editPro['family_color'] == 'White') selected @endif>White</option>
                                <option value="Blue" @if ($editPro['family_color'] == 'Blue') selected @endif>Blue</option>
                                <option value="Orange" @if ($editPro['family_color'] == 'Orange') selected @endif>Orange</option>
                                <option value="Grey" @if ($editPro['family_color'] == 'Grey') selected @endif>Grey</option>
                                <option value="Silver" @if ($editPro['family_color'] == 'Silver') selected @endif>Silver</option>
                                <option value="Golden" @if ($editPro['family_color'] == 'Golden') selected @endif>Golden</option>
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
                            <label for="product_discount">Discount (%)</label>
                            <input type="text" class="form-control" id="product_discount" name="product_discount"
                                placeholder="Type Discount"
                                @if (!empty($editPro['product_discount'])) value="{{ $editPro['product_discount'] }}" @endif>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="final_price">Final Price</label>
                            <input type="text" class="form-control" id="final_price" name="final_price"
                                placeholder="Type Final Price"
                                @if (!empty($editPro['final_price'])) value="{{ $editPro['final_price'] }}" @endif readonly>
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
                                <option value="YES" @if ($editPro['is_featured'] == 'YES') selected @endif>YES</option>
                                <option value="NO" @if ($editPro['is_featured'] == 'NO') selected @endif>NO</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="product_video">Video</label>
                            <input type="file" class="form-control" id="product_video" name="product_video">
                            @if (!empty($editPro['product_video']))
                                <small class="text-muted">Current Video: {{ $editPro['product_video'] }}</small>
                            @endif
                            <a title="Delete product video" href="javascript:void(0)" class="confirmDelete"
                                record="product-video" recordid="{{ $editPro['id'] }}">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="fabric">Fabric</label>
                            <select name="fabric" class="form-control">
                                <option value="">Select</option>
                                @foreach ($productsFilters['fabricArray'] as $fabricOption)
                                    <option value="{{ $fabricOption }}"
                                        @if ($editPro['fabric'] == $fabricOption) selected @endif>
                                        {{ $fabricOption }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="sleeve">Sleeve</label>
                            <select name="sleeve" class="form-control">
                                <option value="">Select</option>
                                @foreach ($productsFilters['sleeveArray'] as $sleeve)
                                    <option value="{{ $sleeve }}"
                                        @if ($editPro['sleeve'] == $sleeve) selected @endif>
                                        {{ $sleeve }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="pattern">Pattern</label>
                            <select name="pattern" class="form-control">
                                <option value="">Select</option>
                                @foreach ($productsFilters['petternArray'] as $pattern)
                                    <option value="{{ $pattern }}"
                                        @if ($editPro['pattern'] == $pattern) selected @endif>
                                        {{ $pattern }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="fit">Fit</label>
                            <select name="fit" class="form-control">
                                <option value="">Select</option>
                                @foreach ($productsFilters['fitArray'] as $fit)
                                    <option value="{{ $fit }}"
                                        @if ($editPro['fit'] == $fit) selected @endif>
                                        {{ $fit }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="occassion">Occassion</label>
                            <select name="occassion" class="form-control">
                                <option value="">Select</option>
                                @foreach ($productsFilters['occassionArray'] as $occassion)
                                    <option value="{{ $occassion }}"
                                        @if ($editPro['occassion'] == $occassion) selected @endif>
                                        {{ $occassion }}
                                    </option>
                                @endforeach
                            </select>
                            <br>
                            <br>
                        </div>
                    </div>
                    <div class="form-row">
                        <br>
                        <div style="background: #52585e;" class="formgroup col-md-12">
                            <br>
                            <label for="attribute">Attributes</label>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Size</th>
                                        <th scope="col">SKU</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Stock</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($editPro['attributes'] as $atr)
                                        <input type="hidden" name="attributeId[]" value="{{ $atr['id'] }}">
                                        <tr>
                                            <td scope="row">{{ $atr['id'] }}</td>
                                            <td>{{ $atr['size'] }}</td>
                                            <td>{{ $atr['sku'] }}</td>
                                            <td>
                                                <input style="width: 100px; color:black;" type="number" name="price[]"
                                                    value="{{ $atr['price'] }}">
                                            </td>
                                            <td>
                                                <input style="width: 100px; color:black;" type="number" name="stock[]"
                                                    value="{{ $atr['stock'] }}">
                                            </td>
                                            <td>
                                                @if ($atr['status'] == 1)
                                                    <a class="updateAttributeStatus" id="page-{{ $atr['id'] }}"
                                                        page_id="{{ $atr['id'] }}" href="javascript:void(0)"
                                                        style="color: rgb(41, 214, 113);">
                                                        <i class="fas fa-toggle-on" status="Active"></i>
                                                    </a>
                                                @else
                                                    <a class="updateAttributeStatus" id="page-{{ $atr['id'] }}"
                                                        page_id="{{ $atr['id'] }}" href="javascript:void(0)">
                                                        <i class="fas fa-toggle-off" status="Inactive"></i>
                                                    </a>
                                                @endif
                                                &nbsp;&nbsp;
                                                <a title="Delete attribute" href="javascript:void(0)" class="confirmDelete"
                                                    record="attribute" recordid="{{ $atr['id'] }}">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="formgroup col-md-12">
                            <br>
                            <label for="attribute">Add attribute</label>
                            <div class="field_wrapper">
                                <input type="text" name="size[]" id="size" placeholder="size"
                                    style="color: black; width: 23.5%" />
                                <input type="text" name="sku[]" id="sku" placeholder="sku"
                                    style="color: black; width: 23.5%" />
                                <input type="text" name="price[]" id="price" placeholder="price"
                                    style="color: black; width: 23.5%" />
                                <input type="text" name="stock[]" id="stock" placeholder="stock"
                                    style="color: black; width: 23.5%" />
                                <a href="javascript:void(0);" class="add_button" title="Add field"><i
                                        style="display: inline-block;" class="fas fa-plus"></i></a>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <br>
                            <br>
                            <label for="image">Upload Image</label>
                            <input type="file" name="image[]" multiple id="image">
                            @error('image')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <br>
                            <div class="tablecontainer">
                                <div class="innerCon">
                                    <table class="table" id="example">
                                        <thead>
                                            <tr>
                                                <th class="table__heading">Sort Number</th>
                                                <th class="table__heading">Image</th>
                                                <th class="table__heading">Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($editPro['images'] as $img)
                                                <input class="form-control" type="hidden" name="image[]"
                                                    value="{{ $img['image'] }}">
                                                <tr class="table__row">
                                                    <td style="width: 15%;" class="table__content text-center"
                                                        data-heading="sort">
                                                        <input style="display: inline-block;" class="form-control"
                                                            type="text" name="image_sort[]"
                                                            value="{{ $img['image_sort'] }}">
                                                    </td>
                                                    <td class="table__content text-center" data-heading="image">
                                                        <img style="width: 100px; display: inline-block;"
                                                            src="{{ asset('admin/img/products/small/' . $img['image']) }}"
                                                            alt="Product Image">
                                                    </td>
                                                    <td class="table__content text-center" data-heading="delete">
                                                        <a title="Delete product" href="javascript:void(0)"
                                                            class="confirmDelete" record="productimg"
                                                            recordid="{{ $img['id'] }}">
                                                            <i style="display: inline-block;" class="fas fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="form-group col-md-12">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

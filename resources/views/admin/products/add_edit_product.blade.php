@extends('admin.layout.layout')
@section('content')
    <div class="col-sm-6">
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
                    <label for="#">Category Level</label>
                    <select name="parent_id" class="form-control">
                        <option value="">Select</option>
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
                    <input type="text" class="form-control" id="family_color" name="family_color"
                        placeholder="Type Family Color"
                        @if (!empty($editPro['family_color'])) value="{{ $editPro['family_color'] }}" @endif>
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
                    <label for="product_discount">Discount</label>
                    <input type="text" class="form-control" id="product_discount" name="product_discount"
                        placeholder="Type Discount"
                        @if (!empty($editPro['product_discount'])) value="{{ $editPro['product_discount'] }}" @endif>
                </div>
                <div class="form-group col-md-3">
                    <label for="discount_type">Discount Type</label>
                    <input type="text" class="form-control" id="discount_type" name="discount_type"
                        placeholder="Type type"
                        @if (!empty($editPro['discount_type'])) value="{{ $editPro['discount_type'] }}" @endif>
                </div>
                <div class="form-group col-md-3">
                    <label for="final_price">Final Price</label>
                    <input type="text" class="form-control" id="final_price" name="final_price"
                        placeholder="Type Final Price"
                        @if (!empty($editPro['final_price'])) value="{{ $editPro['final_price'] }}" @endif>
                </div>
                <div class="form-group col-md-5">
                    <label for="product_video">Video</label>
                    <input type="file" class="form-control" id="product_video" name="product_video">
                    @if (!empty($editPro['product_video']))
                        <small class="text-muted">Current Video: {{ $editPro['product_video'] }}</small>
                    @endif
                </div>
                <!-- Existing image display -->
                <div class="form-group col-md-2">
                    @if (!empty($editPro['image']))
                        <img id="existingImage" src="{{ asset('admin/img/products/' . $editPro['image']) }}"
                            alt="Current Image">
                        <a class="confirmDelete" title="Delete Image" href="javascript:void(0)" record="categoryimg"
                            recordid="{{ $editPro['id'] }}"><i class="fas fa-trash"></i></a>
                    @endif
                    <label for="image">Image</label>
                    <input type="file" name="image" id="image" accept="image/*">
                    @error('image')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <!-- Cropper container -->
                    <div id="cropperContainer"></div>
                    <!-- Cropped image data (hidden input) -->
                    <input type="hidden" name="cropped_image_data" id="croppedImageData">
                    <script>
                        $(document).ready(function() {
                            var cropper;

                            $('#image').on('change', function(e) {
                                var input = e.target;
                                var reader = new FileReader();

                                reader.onload = function(e) {
                                    $('#cropperContainer').html('<img id="cropperImage" src="' + e.target.result +
                                        '">');

                                    // Initialize Cropper
                                    cropper = new Cropper(document.getElementById('cropperImage'), {
                                        aspectRatio: 1, // You can adjust this ratio as needed
                                        viewMode: 3,
                                        crop: function(event) {
                                            var croppedCanvas = cropper.getCroppedCanvas();
                                            $('#croppedImageData').val(croppedCanvas.toDataURL(
                                                'image/jpeg'));
                                        }
                                    });
                                };

                                reader.readAsDataURL(input.files[0]);
                            });
                        });
                    </script>
                </div>
                <div class="form-group col-md-12">
                    <label for="description">Description</label>
                    <textarea type="text" class="form-control" id="description" name="description" rows="3"
                        placeholder="Type Description">{{ !empty($editPro['description']) ? $editPro['description'] : '' }}</textarea>
                </div>
                <div class="form-group col-md-3">
                    <label for="keywords">Keywords</label>
                    <input type="text" class="form-control" id="keywords" name="keywords"
                        placeholder="Type keywords"
                        @if (!empty($editPro['keywords'])) value="{{ $editPro['keywords'] }}" @endif>
                </div>
                <div class="form-group col-md-3">
                    <label for="fabric">Fabric</label>
                    <input type="text" class="form-control" id="fabric" name="fabric" placeholder="Type color"
                        @if (!empty($editPro['fabric'])) value="{{ $editPro['fabric'] }}" @endif>
                </div>
                <div class="form-group col-md-3">
                    <label for="sleeve">Sleeve</label>
                    <input type="text" class="form-control" id="sleeve" name="sleeve"
                        placeholder="Type sleeve type"
                        @if (!empty($editPro['sleeve'])) value="{{ $editPro['sleeve'] }}" @endif>
                </div>
                <div class="form-group col-md-3">
                    <label for="fit">Fit</label>
                    <input type="text" class="form-control" id="fit" name="fit" placeholder="Type fit"
                        @if (!empty($editPro['fit'])) value="{{ $editPro['fit'] }}" @endif>
                </div>
                <div class="form-group col-md-3">
                    <label for="occassion">Occassion</label>
                    <input type="text" class="form-control" id="occassion" name="occassion"
                        placeholder="Type Family Color"
                        @if (!empty($editPro['occassion'])) value="{{ $editPro['occassion'] }}" @endif>
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
                <div class="form-group col-md-12">
                    <label for="meta_description">Meta Description</label>
                    <input type="text" class="form-control" id="meta_description" name="meta_description"
                        placeholder="Type Meta Description"
                        @if (!empty($editPro['meta_description'])) value="{{ $editPro['meta_description'] }}" @endif>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
@endsection

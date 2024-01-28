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
                <form name="brandForm" id="brandForm"
                    @if (empty($editBrand['id'])) action="{{ route('admin.brands.add_edit_brand') }}" @else
          action="{{ route('admin.brands.add_edit_brand', ['id' => $editBrand['id']]) }}" @endif
                    method="POST" enctype="multipart/form-data">@csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="brand_name">Name</label>
                            <input type="text" class="form-control" id="brand_name" name="brand_name"
                                placeholder="Type name"
                                @if (!empty($editBrand['brand_name'])) value="{{ $editBrand['brand_name'] }}" @endif>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="brand_discount">Discount</label>
                            <input type="text" class="form-control" id="brand_discount" name="brand_discount"
                                placeholder="Type discount"
                                @if (!empty($editBrand['brand_discount'])) value="{{ $editBrand['brand_discount'] }}" @endif>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea type="text" class="form-control" id="description" name="description" rows="3"
                            placeholder="Type Description">{{ !empty($editBrand['description']) ? $editBrand['description'] : '' }}</textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="url">URL</label>
                            <input type="text" class="form-control" id="url" name="url" placeholder="Type URL"
                                @if (!empty($editBrand['url'])) value="{{ $editBrand['url'] }}" @endif>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="meta_title">Meta Title</label>
                            <input type="text" class="form-control" id="meta_title" name="meta_title"
                                placeholder="Type Meta Title"
                                @if (!empty($editBrand['meta_title'])) value="{{ $editBrand['meta_title'] }}" @endif>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="meta_keywords">Meta Keywords</label>
                        <input type="text" class="form-control" id="meta_keywords" name="meta_keywords"
                            placeholder="Type Meta Keywords"
                            @if (!empty($editBrand['meta_keywords'])) value="{{ $editBrand['meta_keywords'] }}" @endif>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="meta_description">Meta Description</label>
                        <input type="text" class="form-control" id="meta_description" name="meta_description"
                            placeholder="Type Meta Description"
                            @if (!empty($editBrand['meta_description'])) value="{{ $editBrand['meta_description'] }}" @endif>
                    </div>
                    <div class="form-group">
                        <!-- Existing image display -->
                        <div class="form-group">
                            @if (!empty($editBrand['image']))
                                <img id="existingImage" src="{{ asset('admin/img/brands/' . $editBrand['image']) }}"
                                    alt="Current Image">
                                <a class="confirmDelete" title="Delete Image" href="javascript:void(0)" record="brandimg"
                                    recordid="{{ $editBrand['id'] }}"><i class="fas fa-trash" style="color: blue;"></i></a>
                            @endif
                        </div>
                        <!-- Brand Image -->
                        <label for="image">Upload New Image</label>
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
                                            aspectRatio: NaN, // Set to NaN to allow freeform aspect ratio
                                            viewMode: 2,
                                            crop: function(event) {
                                                var croppedCanvas = cropper.getCroppedCanvas();
                                                $('#croppedImageData').val(croppedCanvas.toDataURL(
                                                    'image/jpeg'));
                                            }
                                        });

                                        // Allow user to specify both width and height for cropping
                                        $('#setCropDimensions').on('click', function() {
                                            var width = parseFloat($('#cropWidth').val());
                                            var height = parseFloat($('#cropHeight').val());

                                            if (!isNaN(width) && !isNaN(height)) {
                                                // Set the custom aspect ratio
                                                cropper.setAspectRatio(width / height);
                                            } else {
                                                // Reset to freeform aspect ratio if invalid dimensions
                                                cropper.setAspectRatio(NaN);
                                            }
                                        });
                                    };

                                    reader.readAsDataURL(input.files[0]);
                                });
                            });
                        </script>

                    </div>
                    <!-- // Brand Image -->
                    <!-- BRAND LOGO -->
                    <div class="form-group">
                        <!-- Existing image display -->
                        <div class="form-group">
                            @if (!empty($editBrand['brand_logo']))
                                <img id="existingImage"
                                    src="{{ asset('admin/img/brands/logos/' . $editBrand['brand_logo']) }}"
                                    alt="Current Image">
                                <a class="confirmDelete" title="Delete Image" href="javascript:void(0)" record="brand-logo"
                                    recordid="{{ $editBrand['id'] }}" style="color: blue;"><i
                                        class="fas fa-trash"></i></a>
                            @endif
                        </div>
                        <label for="brand_logo">Upload New Logo</label>
                        <input type="file" name="brand_logo" id="brand_logo" accept="image/*">
                        @error('brand_logo')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <!-- Cropper container -->
                        <div id="cropperContainerLogo"></div>
                        <!-- Cropped image data (hidden input) -->
                        <input type="hidden" name="cropped_logo_data" id="croppedLogoData">
                        <script>
                            $(document).ready(function() {
                                var cropper;

                                $('#brand_logo').on('change', function(e) {
                                    var input = e.target;
                                    var reader = new FileReader();

                                    reader.onload = function(e) {
                                        $('#cropperContainerLogo').html('<img id="cropperLogo" src="' + e.target.result +
                                            '">');

                                        // Initialize Cropper
                                        cropper = new Cropper(document.getElementById('cropperLogo'), {
                                            aspectRatio: NaN, // Set to NaN to allow freeform aspect ratio
                                            viewMode: 2,
                                            crop: function(event) {
                                                var croppedCanvas = cropper.getCroppedCanvas();
                                                $('#croppedLogoData').val(croppedCanvas.toDataURL(
                                                    'brand_logo/png'));
                                            }
                                        });

                                        // Allow user to specify both width and height for cropping
                                        $('#setLogoCropDimensions').on('click', function() {
                                            var width = parseFloat($('#logoCropWidth').val());
                                            var height = parseFloat($('#logoCropHeight').val());

                                            if (!isNaN(width) && !isNaN(height)) {
                                                // Set the custom aspect ratio
                                                cropper.setAspectRatio(width / height);
                                            } else {
                                                // Reset to freeform aspect ratio if invalid dimensions
                                                cropper.setAspectRatio(NaN);
                                            }
                                        });
                                    };

                                    reader.readAsDataURL(input.files[0]);
                                });
                            });
                        </script>

                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
@endsection

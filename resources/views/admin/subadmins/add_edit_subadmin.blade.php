@extends('admin.layout.layout')
@section('content')
    <div class="col-sm-4">
        <div class="card">
            <div class="card-body">
        <h3>{{ $title }}</h3>
        @if (Session::has('error_message'))
            <div class="redDanger alert alert-danger" role="alert">
                {{ Session::get('error_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <form name="SubAdminForm" id="SubAdminForm"
            @if (empty($subadmin['id'])) action="{{ route('admin.subadmins.add_edit_subadmin') }}"
      @else
          action="{{ route('admin.subadmins.add_edit_subadmin', ['id' => $subadmin['id']]) }}" @endif
            method="POST" enctype="multipart/form-data">@csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input class="form-control" type="text" name="name" id="name" placeholder="Enter Name"
                        @if (!empty($subadmin['name'])) value="{{ $subadmin['name'] }}" @else value="{{ old('name') }}" @endif>
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="mobile">Mobile</label>
                    <input class="form-control" type="text" name="mobile" id="mobile" placeholder="Enter Mobile"
                        @if (!empty($subadmin['mobile'])) value="{{ $subadmin['mobile'] }}" @else value="{{ old('mobile') }}" @endif>
                    @error('mobile')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input
                        @if ($subadmin['id'] != '') disabled="" style="background-color: rgb(0, 0, 0)" @else required="" @endif
                        class="form-control" type="email" name="email" id="email" placeholder="Enter email"
                        @if (!empty($subadmin['email'])) value="{{ $subadmin['email'] }}" @else value="{{ old('email') }}" @endif>
                    @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input class="form-control" type="password" name="password" id="password" placeholder="Enter password"
                        @if (!empty($subadmin['password'])) value="{{ $subadmin['password'] }}" @else value="{{ old('password') }}" @endif>
                    @error('password')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>


                <div class="form-group">
                <!-- Existing image display -->
                @if (!empty($subadmin['image']))
                    <img id="existingImage" src="{{ asset('admin/img/' . $subadmin['image']) }}" alt="Current Image">
                @endif
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
                <button type="submit" class="btn btn-primary me-2">Update</button>
            </div>
        </form>
    </div>
        </div>
    </div>
@endsection

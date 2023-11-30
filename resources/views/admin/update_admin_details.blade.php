@extends('admin.layout.layout')
@section('content')
    <div class="col-sm-4">
        <div class="card">
            <div class="card-body">
        <h3>Update Admin Details</h3>
        <form method="POST" action="{{ route('admin.update_admin_details') }}" enctype="multipart/form-data">@csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="admin_email">Logged in User</label>
                    <strong> || {{ Auth::guard('admin')->user()->email }}</strong>
                </div>
                <div class="form-group">
                    @if (Session::has('success_message'))
                        <div class="greenDanger alert alert-danger" role="alert">
                            {{ Session::get('success_message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <label for="admin_name">Name</label>
                    <input class="form-control" type="text" name="admin_name" id="admin_name"
                        placeholder="Enter New Name" value="{{ Auth::guard('admin')->user()->name }}">
                    @error('admin_name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="admin_mobile">Mobile number</label>
                    <input class="form-control" type="text" name="admin_mobile" id="admin_mobile"
                        placeholder="Enter New Mobile Number" value="{{ Auth::guard('admin')->user()->mobile }}">
                    @error('admin_mobile')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Existing image display -->
                @if (!empty(Auth::guard('admin')->user()->image))
                    <img id="existingImage" src="{{ asset('admin/img/' . Auth::guard('admin')->user()->image) }}"
                        alt="Current Image">
                @endif
                <div class="form-group">
                    <label for="admin_image">Upload New Image</label>
                    <input type="file" name="admin_image" id="admin_image" accept="image/*">
                    @error('admin_image')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <!-- Cropper container -->
                    <div id="cropperContainer"></div>
                    <!-- Cropped image data (hidden input) -->
                    <input type="hidden" name="cropped_image_data" id="croppedImageData">
                    <script>
                        $(document).ready(function() {
                            var cropper;

                            $('#admin_image').on('change', function(e) {
                                var input = e.target;
                                var reader = new FileReader();

                                reader.onload = function(e) {
                                    $('#cropperContainer').html('<img id="cropperImage" src="' + e.target.result +
                                        '">');

                                    // Initialize Cropper
                                    cropper = new Cropper(document.getElementById('cropperImage'), {
                                        aspectRatio: 1, // You can adjust this ratio as needed
                                        viewMode: 2,
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
                <button type="submit" class="btn btn-primary me-2">Update</button>
            </div>
        </form>
    </div>
        </div>
    </div>
@endsection

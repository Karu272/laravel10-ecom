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
                <form name="bannerForm" id="bannerForm"
                    @if (empty($bannerData['id'])) action="{{ route('admin.banners.add_edit_banner') }}" @else
          action="{{ route('admin.banners.add_edit_banner', ['id' => $bannerData['id']]) }}" @endif
                    method="POST" enctype="multipart/form-data">@csrf
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="type">Type</label>
                            <input type="text" class="form-control" id="type" name="type" placeholder="Type type"
                                @if (!empty($bannerData['type'])) value="{{ $bannerData['type'] }}" @endif>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="link">Link</label>
                            <input type="text" class="form-control" id="link" name="link" placeholder="Type Link"
                                @if (!empty($bannerData['link'])) value="{{ $bannerData['link'] }}" @endif>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title"
                                placeholder="Type title"
                                @if (!empty($bannerData['title'])) value="{{ $bannerData['title'] }}" @endif>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="alt">Alt text</label>
                            <input type="text" class="form-control" id="alt" name="alt"
                                placeholder="Type Meta Title"
                                @if (!empty($bannerData['alt'])) value="{{ $bannerData['alt'] }}" @endif>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="sort">Sort</label>
                            <input type="text" class="form-control" id="sort" name="sort"
                                placeholder="Type Meta Keywords"
                                @if (!empty($bannerData['sort'])) value="{{ $bannerData['sort'] }}" @endif>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="image">Upload Image</label>
                            <input type="file" name="image" id="image">
                            @error('image')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <br>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
@endsection

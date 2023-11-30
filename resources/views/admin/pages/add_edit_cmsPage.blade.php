@extends('admin.layout.layout')
@section('content')
    <div class="col-sm-4">
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
        <form name="cmsForm" id="cmsForm"
            @if (empty($cmspage['id'])) action="{{ route('admin.pages.add_edit_cmsPage') }}"
      @else
          action="{{ route('admin.pages.add_edit_cmsPage', ['id' => $cmspage['id']]) }}" @endif
            method="POST" enctype="multipart/form-data">@csrf
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Type Title"
                        @if (!empty($cmspage['title'])) value="{{ $cmspage['title'] }}" @endif>
                </div>
                <div class="form-group col-md-6">
                    <label for="url">URL</label>
                    <input type="text" class="form-control" id="url" name="url" placeholder="Type URL"
                        @if (!empty($cmspage['url'])) value="{{ $cmspage['url'] }}" @endif>
                </div>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea type="text" class="form-control" id="description" name="description" rows="3"
                    placeholder="Type Description" @if (!empty($cmspage['description'])) value="{{ $cmspage['description'] }}" @endif></textarea>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="meta_title">Meta Title</label>
                    <input type="text" class="form-control" id="meta_title" name="meta_title"
                        placeholder="Type Meta Title"
                        @if (!empty($cmspage['meta_title'])) value="{{ $cmspage['meta_title'] }}" @endif>
                </div>
            </div>
            <div class="form-group">
                <div class="form-group col-md-6">
                    <label for="meta_keywords">Meta Keywords</label>
                    <input type="text" class="form-control" id="meta_keywords" name="meta_keywords"
                        placeholder="Type Meta Keywords"
                        @if (!empty($cmspage['meta_keywords'])) value="{{ $cmspage['meta_keywords'] }}" @endif>
                </div>
            </div>
            <div class="form-group">
                <label for="meta_description">Meta Description</label>
                <input type="text" class="form-control" id="meta_description" name="meta_description"
                    placeholder="Type Meta Description"
                    @if (!empty($cmspage['meta_description'])) value="{{ $cmspage['meta_description'] }}" @endif>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
        </div>
    </div>
@endsection

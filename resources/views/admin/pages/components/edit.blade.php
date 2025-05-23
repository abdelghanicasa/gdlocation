@extends('admin.app')

@section('content')
<div class="iq-card">
        <div class="iq-card-header">
            <h4 class="card-title">Modifier un contenu</h4>
        </div>
        <div class="iq-card-body">
            <form action="{{ route('pages.update', $page) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ $page->title }}" required>
                </div>
                <div class="form-group">
                    <label for="content">Content</label>
                    <textarea name="content" id="content" class="form-control" rows="5">{{ $page->content }}</textarea>
                </div>
                <div class="form-group">
                    <label for="images">Images..</label>
                    <input type="file" name="images[]" id="images" class="form-control" multiple>
                </div>
                @php
                $images = json_decode($page->images, true);
    $firstImage = !empty($images) ? $images[0] : null;
@endphp
                @if($page->images)
                            <div class="form-group">
                                <img src="{{ asset('storage/' . $firstImage) }}" alt="Image actuelle" 
                                class="img-thumbnail" width="200">
                                <p class="text-muted">Image actuelle</p>
                            </div>
                @endif
                <button type="submit" class="btn btn-success">Update</button>
            </form>
        </div>
    </div>
</div>
@endsection

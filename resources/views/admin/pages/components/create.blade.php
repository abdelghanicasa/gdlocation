@extends('admin.app')

@section('content')
<div class="iq-card">
        <div class="iq-card-header">
            <h4 class="card-title">Créer un page</h4>
        </div>
        <div class="iq-card-body">
            <form action="{{ route('pages.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="title">Titre</label>
                    <input type="text" name="title" id="title" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="text" name="slug" id="slug" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="content">Description</label>
                    <textarea name="content" id="content" class="form-control" rows="5" required></textarea>
                </div>
                <div class="form-group">
                    <label for="images">Images</label>
                    <input type="file" name="images[]" id="images" class="form-control" multiple>
                </div>
                <button type="submit" class="btn btn-success">Save</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const titleInput = document.getElementById('title');
        const slugInput = document.getElementById('slug');

        titleInput.addEventListener('input', function () {
            if (!slugInput.dataset.edited) {
                slugInput.value = titleInput.value
                    .toLowerCase()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/^-+|-+$/g, '');
            }
        });

        slugInput.addEventListener('input', function () {
            slugInput.dataset.edited = true;
        });
    });
</script>
@endsection

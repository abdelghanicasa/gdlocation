@extends('admin.app')

@section('content')

    <div class="iq-card">
        <div class="iq-card-header">
            <h4 class="card-title">Modifier un contenu</h4>
        </div>
        <div class="iq-card-body">
            <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="page_id">Sélectionner une page *</label>
                            <select class="form-control" name="page_id" id="page_id" required>
                                @foreach($pages as $page)
                                    <option value="{{ $page->id }}" {{ $post->page_id == $page->id ? 'selected' : '' }}>
                                        {{ $page->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="title">Titre de l'article *</label>
                            <input type="text" class="form-control" name="title" id="title" value="{{ old('title', $post->title) }}" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="text">Texte *</label>
                            <textarea class="form-control" name="text" id="text" rows="5" required>{{ old('text', $post->text) }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" class="form-control" name="image" id="image" style="">
                            <small class="text-muted">Formats acceptés : JPEG, PNG, JPG (max 2MB)</small>
                        </div>
                        @if($post->image)
                            <div class="form-group">
                                <img src="{{ asset('storage/' . $post->image) }}" alt="Image actuelle" class="img-thumbnail" width="200">
                                <p class="text-muted">Image actuelle</p>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-12 bg-gray-100 p-3">
                        <h5>Blocs supplémentaires</h5>
                        <div id="blocks-container">
                            @foreach($post->blocks as $index => $block)
                                <div class="block-item" style="margin-bottom: 20px;">
                                    <input type="hidden" name="blocks[{{ $index }}][id]" value="{{ $block->id }}">
                                    <div class="form-group">
                                        <label for="blocks[{{ $index }}][title]">Titre du bloc</label>
                                        <input type="text" class="form-control" name="blocks[{{ $index }}][title]" value="{{ $block->title }}" placeholder="Titre du bloc">
                                    </div>
                                    <div class="form-group">
                                        <label for="blocks[{{ $index }}][content]">Contenu du bloc</label>
                                        <textarea class="form-control" name="blocks[{{ $index }}][content]" rows="3" placeholder="Contenu du bloc">{{ $block->content }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="blocks[{{ $index }}][image]">Image (optionnelle)</label>
                                        <input type="file" class="form-control" name="blocks[{{ $index }}][image]">
                                        @if($block->image)
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/' . $block->image) }}" alt="Image actuelle" class="img-thumbnail" width="200">
                                                <p class="text-muted">Image actuelle</p>
                                            </div>
                                        @endif
                                    </div>
                                    <button type="button" class="btn btn-danger remove-block">Supprimer ce bloc</button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Enregistrer
                    </button>
                    <button type="button" id="add-block" class="btn btn-secondary">Ajouter un bloc</button>
                </div>

            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let blockIndex = {{ $post->blocks->count() }};

            document.getElementById('add-block').addEventListener('click', function () {
                const container = document.getElementById('blocks-container');
                const blockHtml = `
                    <div class="block-item">
                        <div class="form-group">
                            <label for="blocks[${blockIndex}][title]">Titre du bloc</label>
                            <input type="text" class="form-control" name="blocks[${blockIndex}][title]" placeholder="Titre du bloc">
                        </div>
                        <div class="form-group">
                            <label for="blocks[${blockIndex}][content]">Contenu du bloc</label>
                            <textarea class="form-control" name="blocks[${blockIndex}][content]" rows="3" placeholder="Contenu du bloc"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="blocks[${blockIndex}][image]">Image (optionnelle)</label>
                            <input type="file" class="form-control" name="blocks[${blockIndex}][image]">
                        </div>
                        <button type="button" class="btn btn-danger remove-block">Supprimer ce bloc</button>
                    </div>
                `;
                container.insertAdjacentHTML('beforeend', blockHtml);
                blockIndex++;
            });

            document.getElementById('blocks-container').addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-block')) {
                    e.target.closest('.block-item').remove();
                }
            });
        });
    </script>

@endsection

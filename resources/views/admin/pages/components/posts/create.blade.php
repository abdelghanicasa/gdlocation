@extends('admin.app')

@section('content')

        <div class="iq-card">
            <div class="iq-card-header">
                <h4 class="card-title">Créer un contenu</h4>
            </div>
            <div class="iq-card-body">
                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="page_id">Sélectionner une page *</label>
                                <select class="form-control" name="page_id" id="page_id" required>
                                    @foreach($pages as $page)
                                        <option value="{{ $page->id }}" {{ isset($selectedPageId) && $selectedPageId == $page->id ? 'selected' : '' }}>
                                            {{ $page->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="title">Titre de l'article *</label>
                                <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="text">Texte *</label>
                                <textarea class="form-control" name="text" id="text" rows="5" required>{{ old('text') }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="image">Image</label>
                                <input type="file" class="form-control" name="image" id="image">
                                <small class="text-muted">Formats acceptés : JPEG, PNG, JPG (max 2MB)</small>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <h5>Blocs supplémentaires</h5>
                            <div id="blocks-container">
                                <div class="block-item">
                                    <div class="form-group">
                                        <label for="blocks[0][title]">Titre du bloc</label>
                                        <input type="text" class="form-control" name="blocks[0][title]" placeholder="Titre du bloc">
                                    </div>
                                    <div class="form-group">
                                        <label for="blocks[0][content]">Contenu du bloc</label>
                                        <textarea class="form-control" name="blocks[0][content]" rows="3" placeholder="Contenu du bloc"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="blocks[0][image]">Image (optionnelle)</label>
                                        <input type="file" class="form-control" name="blocks[0][image]">
                                    </div>
                                    <button type="button" class="btn btn-danger remove-block">Supprimer ce bloc</button>
                                </div>
                            </div>
                            <button type="button" id="add-block" class="btn btn-secondary mt-3">Ajouter un bloc</button>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Enregistrer
                    </button>
                    
                </form>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                let blockIndex = 1;

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

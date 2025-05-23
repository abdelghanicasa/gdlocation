@extends('admin.app')

@section('content')

<div class="iq-card pt-3">
    <div class="iq-card-header">
        <h4 class="card-title">Créer un contenu</h4>
    </div>
    <div class="iq-card-body">
        <a href="{{ route('pages.create') }}" class="btn btn-primary">Créer une nouvelle page</a>
        <a href="{{ route('posts.create') }}" class="btn btn-secondary">Créer un nouvel article</a>
        <a href="{{ route('posts.index') }}" class="btn btn-info">Voir tous les articles</a>
        <div class="table-responsive">
            <table class="table table-borderless">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pages as $page)
                    <tr>
                        <td>{{ $page->title }}</td>
                        <td>
                            <a href="{{ route('pages.edit', $page) }}" class="btn btn-warning">Modifier</a>
                            <a href="{{ route('posts.create', ['page_id' => $page->id]) }}" class="btn btn-success">Créer un article</a>
                            <form action="{{ route('pages.destroy', $page) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</div
    @endsection
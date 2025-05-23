@extends('admin.app')

@section('content')

    <div class="iq-card">
        <div class="iq-card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">Liste des articles</h4>
            <a href="{{ route('posts.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Créer un article
            </a>
        </div>
        <div class="iq-card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Titre</th>
                        <th>Page</th>
                        <th>Date de création</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->page->title }}</td>
                            <td>{{ $post->created_at->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fa fa-edit"></i> Modifier
                                </a>
                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr ?')">
                                        <i class="fa fa-trash"></i> Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

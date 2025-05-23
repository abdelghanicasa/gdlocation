@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $post->title }}</h1>
    <p>{{ $post->text }}</p>

    @foreach($post->blocks as $block)
        <div class="post-block">
            <h2>{{ $block->title }}</h2>
            <p>{{ $block->content }}</p>
        </div>
    @endforeach
</div>
@endsection

@extends('frontend.layouts.app')

@section('content')
<section>
    <div class="container">
        <div class="cs_radius_10 cs_about cs_style_1 gradient-div" style="padding: 3%;">
            <div class="cs_section_heading cs_style_1 text-left">
                <h2 class="cs_fs_38">À Propos de Nous</h2>
                @if($companyInfo->isNotEmpty())
                    @foreach($companyInfo as $post)
                        <h3 class="cs_fs_28">{{ $post->title }}</h3>
                        <p class="cs_section_subtitle cs_mb_lg_15">
                            {!! nl2br(e($post->text)) !!}
                        </p>
                        @if($post->blocks->isNotEmpty())
                            @foreach($post->blocks as $block)
                                <div class="cs_feature_box cs_style_4">
                                    <h4>{{ $block->title }}</h4>
                                    <p>{!! nl2br(e($block->content)) !!}</p>
                                    @if($block->image)
                                        <img src="{{ asset('storage/' . $block->image) }}" alt="{{ $block->title }}" class="img-fluid">
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    @endforeach
                @else
                    <p>Aucune information disponible pour le moment.</p>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
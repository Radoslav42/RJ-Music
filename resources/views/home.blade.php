
@extends('layouts.layout')
@section('content')

<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" >
            <h1><img src="@if($hasSelectedAuthor)  {{url('storage/Files/'."Author" . $author->id. "Image") }} @else{{ asset('images/RJ_Music_500x500.png') }} @endif" alt="" width="70" height="70" class="d-inline-block align-text-top">   @if(!$hasSelectedAuthor)RJ-Music @else {{$author->firstname}}  {{$author->lastname}}  @endif</h1>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            @if ($hasSelectedAuthor)
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/home" >Domov</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"  href="{{url('about', ['authorId' => $author->id])}}">O mne</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{url('beforeSelectAlbum', ['authorId' => $author->id])}}" >Albumy</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/beforeSelectAuthor" >Interpreti</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/beforeLogin">Prihlásenie</a>
                    </li>
                </ul>
            @else
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/home" >Domov</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/beforeSelectAuthor" >Interpreti</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/beforeLogin">Prihlásenie</a>
                    </li>
                </ul>
            @endif
        </div>
    </div>
</nav>
<div id="carouselWithCaptions" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
            @if(!$hasSelectedAuthor)
                @for ($i = 0; $i < $authors->count(); $i++)
                    @if ($i == 0)
                        <button type="button" data-bs-target="#carouselWithCaptions" class="active" aria-current="true"  data-bs-slide-to="{{$i}}" aria-label="Slide {{$i+1}}"></button>
                     @else
                        <button type="button" data-bs-target="#carouselWithCaptions" data-bs-slide-to="{{$i}}" aria-label="Slide {{$i+1}}"></button>
                    @endif
                @endfor
            @else
                @for ($i = 0; $i < $albums->count(); $i++)
                    @if ($i == 0)
                        <button type="button" data-bs-target="#carouselWithCaptions" class="active" aria-current="true" data-bs-slide-to="{{$i}}" aria-label="Slide {{$i+1}}"></button>
                    @else
                        <button type="button" data-bs-target="#carouselWithCaptions" data-bs-slide-to="{{$i}}" aria-label="Slide {{$i+1}}"></button>
                    @endif
                @endfor
            @endif
    </div>
    <div class="carousel-inner">
        @if(!$hasSelectedAuthor)
            @for ($i = 0; $i < $authors->count(); $i++)
            @if ($i == 0)
                <div class="carousel-item active ">
                    <img src="{{ url('storage/Files/'. 'Author' . $authors[$i]->id . 'Image')}}" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                    <p></p>
                    </div>
                </div>
            @else
                <div class="carousel-item">
                    <img src="{{ url('storage/Files/'. 'Author' . $authors[$i]->id . 'Image')}}" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <p></p>
                    </div>
                </div>
            @endif
            @endfor
        @else
            @for ($i = 0; $i < $albums->count(); $i++)
                @if ($i == 0)
                    <div class="carousel-item active ">
                        <img src="{{ url('storage/Files/'. "Album" . $albums[$i]->id . "Image")}}" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <p></p>
                        </div>
                    </div>
                @else
                    <div class="carousel-item ">
                        <img src="{{ url('storage/Files/'. "Album" . $albums[$i]->id . "Image")}}" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <p></p>
                        </div>
                    </div>
                @endif
            @endfor
        @endif
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselWithCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselWithCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
<div class=" panelForSmallAlbumImagesOrText">
    @if(!$hasSelectedAuthor)
        @foreach ($authors as $author)
            <a href="{{url('/home', ['authorId' => $author->id])}}"><img src="{{ url('storage/Files/'. 'Author' . $author->id . 'Image')}}" alt="" class="smallAlbumImage"></a>
        @endforeach
    @else
        @foreach ($albums as $album)
            <a href="{{url('beforeSelectSong', ['albumId' => $album->id, 'authorId' => $author->id])}}"><img src="{{ url('storage/Files/'. "Album" . $album->id . "Image")}}" alt="" class="smallAlbumImage"></a>
        @endforeach
    @endif
</div>
<div class=" panelForSmallAlbumImagesOrText">
    @if (!$hasSelectedAuthor)
        <p>Najdi si svojho interpreta, precitaj si o jeho tvorbe, vypocuj si skladby jeho albumov.</p>
    @else
        <?php
        echo $shortDescriptionText;
        ?>
    @endif
</div>
@endsection

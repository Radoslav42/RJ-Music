@extends('layouts.layout')
@section('content')
<nav class="navbar navbar-dark bg-dark ">
    <div class="container-fluid">
            <h1><img src="{{url('storage/Files/'."Author" . $author->id. "Image") }} " alt="" width="70" height="70" class="d-inline-block align-text-top">   {{$author->firstname}}  {{$author->lastname}} </h1>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/home">Domov</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/about">O mne</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{url('beforeSelectAlbum', ['authorId' => $author->id])}}" >Albumy</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/beforeSelectAuthor">Interpreti</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/beforeLogin">Prihlásenie</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-12 col-md-4">
                    <img src="{{url('storage/Files/'."Author" . $author->id. "Image")}}" class="img-fluid" alt="...">
                </div>
                <div class="col-12 col-md-8">
                    <?php
                    echo $descriptionText;
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

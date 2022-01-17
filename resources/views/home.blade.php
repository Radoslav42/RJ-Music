
@extends('layouts.layout')
@section('content')

<div id="carouselWithCaptions" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselWithCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselWithCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselWithCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active ">
            <img src="images/RJ_Music_500x500.png" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h5>Music Forever!</h5>
                <p></p>
            </div>
        </div>
        <div class="carousel-item ">
            <img src="images/Conflict.jpg" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h5>Music Forever!</h5>
                <p></p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="images/CakewalkUI.png" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h5>Create music in Cakewalk Sonar!</h5>
                <p>One of the best DAW software on the world!</p>
            </div>
        </div>
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
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <h1><img src="images/RJ_Music_500x500.png" alt="" width="70" height="70" class="d-inline-block align-text-top">   RJ-Music</h1>
        </a>
        <a class="navbar-brand" href="#"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/home" >Domov</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"  href="/about">O mne</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/beforeLogin">Prihlásenie</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
@endsection

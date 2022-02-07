@extends('layouts.layout')
@section('content')
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand">
                <h1><img src="images/RJ_Music_500x500.png" alt="" width="70" height="70" class="d-inline-block align-text-top">   RJ-Music</h1>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/home" >Domov</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/beforeSelectAuthor">Interpreti</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/beforeLogin">Prihlásenie</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


@endsection

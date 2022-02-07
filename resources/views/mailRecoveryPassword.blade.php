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
                        <a class="nav-link" href="/beforeSelectAuthor">Interpreti</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/beforeLogin">Prihlásenie</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container " style="max-width: 550px"  id="loginContainer">
        <div class="row">
            <p id="serverMessage">{{$sessionMessage}}</p>
            <p>Zadaj emailovú adresu, kde ti bude zaslaný mail pre obnovenie hesla:</p>
            <form method="post" enctype="application/x-www-form-urlencoded" action="/sendMailForRecoveryPassword">
                @csrf
                <div class="mt-2 ">
                    <label for="mailForm" class="form-label">Email:</label>
                    <input type="email" id="mailForm" class="form-control" name="email" value required="required" minlength="3" maxlength="50">
                </div>
                <button type="submit" class="btn btn-primary buttonForm" id="buttonForm">Poslať</button>
            </form>
        </div>
    </div>
@endsection

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
                    <a class="nav-link" aria-current="page" href="/home">Domov</a>
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
<div class="container col-xl-5 col-md-8 col-sm-10" style="max-width: 500px"  id="registrationContainer">
    <div class="row">
        <p id="serverMessage">{{$sessionMessage}}</p>
        <h2>Registrácia</h2>
        <form method="post" action="/register" enctype="application/x-www-form-urlencoded">
            <!--treba nastavit csrf, ked sa jedna o metodu post-->
            @csrf
            <div class="mt-2 ">
                <label for="usernameForm" class="form-label">Používateľské meno:</label>
                <input type="text" id="usernameForm" class="form-control" name="user_name" value required="required" minlength="3" maxlength="50">
            </div>
            <div class="mt-2">
                <label for="usernameForm" class="form-label">Email:</label>
                <input type="email" id="EmailForm" class="form-control" name="email" value required="required" minlength="3" maxlength="50">
            </div>
            <div class="mt-2">
                <label for="passForm" class="form-label">Heslo:</label>
                <input type="password" id="passForm" class="form-control" name="password" value required="required" minlength="3" maxlength="50">
            </div>
            <button type="submit" class="btn btn-primary buttonForm" id="buttonForm">Registrovať</button>
        </form>
    </div>
    <div class="row" id="registration">
        <a href="/beforeLogin" class="blacklink">Prihlásenie</a>
    </div>
</div>
@endsection

@extends('layouts.layout')
@section('content')
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
            <h1 ><img src="{{ url('storage/Files/'.$imageFilename) }}" alt="" width="70" height="70" class="d-inline-block align-text-top">  {{$firstname}}  {{$lastname}}</h1>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/beforeUpdateUser" >Používateľské údaje</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="/beforeActionWithAuthor" >Môj interpret</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="/beforeSelectAuthor" >Interpreti</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/logout">Odhlasiť sa</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container col-xl-5 col-md-8 col-sm-10" style="max-width: 550px"  id="userContainer">
    <div class="row" >
        <h2>Používateľské údaje</h2>
        <p id="serverMessage">{{$sessionMessage}}</p>
        <form method="post" action="/updateUser" enctype="application/x-www-form-urlencoded">
            @csrf
            <div class="mt-2  ">
                <label for="usernameForm" class="form-label">Používateľské meno:</label>
                <input type="text"  id="usernameForm" class="form-control " name="username" value="{{$username}}" required="required" minlength="3" maxlength="50">
            </div>
            <div class="mt-2">
                <label for="usernameForm" class="form-label">Email:</label>
                <input type="email" id="EmailForm" class="form-control" name="email" value="{{$email}}" required="required" minlength="3" maxlength="50">
            </div>
            <button type="submit" class="btn btn-primary buttonForm" name="updateUserButton" id="buttonForm">Aktualizovať údaje</button>
        </form>
        <div class="row" id="changePasswordDrow">
            <a href="/beforeChangePassword" class="blacklink">Zmeniť heslo</a>
        </div>
    </div>
</div>
@endsection

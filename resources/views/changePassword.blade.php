@extends('layouts.layout')
@section('content')
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            @if($token == null)
                <h1 ><img src="{{ url('storage/Files/'.$imageFilename) }}" alt="" width="70" height="70" class="d-inline-block align-text-top">  {{$firstname}}  {{$lastname}}</h1>
            @else
                <a class="navbar-brand">
                    <h1><img src="images/RJ_Music_500x500.png" alt="" width="70" height="70" class="d-inline-block align-text-top">   RJ-Music</h1>
                </a>
            @endif
            @if($token == null)
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
            @endif
        </div>
    </nav>
    <div class="container col-xl-5 col-md-8 col-sm-10" style="max-width: 500px"  id="registrationContainer">
        <div class="row">
            <p id="serverMessage">{{$sessionMessage}}</p>
            <h2>Zmena hesla:</h2>
            <form method="post" action="/changePassword" enctype="application/x-www-form-urlencoded">
                @csrf
                @if($token == null)
                    <div class="mt-2 ">
                        <label for="oldPasswordForm" class="form-label">Zadaj pôvodné heslo:</label>
                        <input type="password" id="oldPasswordForm" class="form-control" name="oldPassword" value="" required="required" minlength="3" maxlength="50">
                    </div>
                @endif
                    <div class="mt-2">
                        <label for="newPasswordForm" class="form-label">Zadaj nové heslo:</label>
                        <input type="password" id="newPasswordForm" class="form-control" name="newPassword" value="" required="required" minlength="3" maxlength="50">
                    </div>
                    <div class="mt-2">
                        <label for="retypeNewPasswordForm" class="form-label">Zadaj znova nové heslo:</label>
                        <input type="password" id="retypeNewPasswordForm" class="form-control" name="retypeNewPassword" value="" required="required" minlength="3" maxlength="50">
                        <input type="text" id="tokenForm" class="form-control" hidden name="token" value="{{$token != null ? $token : ""}}" minlength="3" maxlength="50">
                    </div>
                <button type="submit" class="btn btn-primary buttonForm" id="buttonForm">Zmeniť heslo</button>
            </form>
        </div>
    </div>
@endsection

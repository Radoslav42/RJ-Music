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
                        <a class="nav-link" aria-current="page" href="/beforeUpdateUser" >Používateľ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/beforeActionWithAuthor" >Údaje interpreta</a>
                    </li>
                    @if ($existAuthor)
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/beforeActionWithAlbums" >Albumy interpreta</a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="/beforeSelectAuthor">Interpreti</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/logout">Odhlasiť sa</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container" id="userContainer">
        <div class="row">
            <h2>Údaje interpreta</h2>
            <p id="serverMessage">{{$sessionMessage}}</p>
            <form method="post"  action="/updateAuthor" enctype="multipart/form-data">
                @csrf
                <div class="mt-2 ">
                    <label for="firstnameForm" class="form-label">Meno:</label>
                    <input type="text" id="firstnameForm" class="form-control" name="firstname" required value="{{$firstname}}" minlength="3" maxlength="30">
                </div>
                <div class="mt-2">
                    <label for="lastnameForm" class="form-label">Priezvisko:</label>
                    <input type="text" id="lastnameForm" class="form-control" name="lastname" required value="{{$lastname}}" minlength="3" maxlength="30">
                </div>
                <div class="mt-2">
                    <label for="imageFilenameForm" class="form-label">Obrázok interpreta:</label>
                    <input type="file" id="imageFilenameForm"  class="form-control" accept=".gif,.jpg,.jpeg,.png"  name="imageFilename" >
                </div>
                <div class="mt-2">
                    <label for="descriptionTextarea" class="form-label">Popis interpreta:</label>
                    <textarea  name="descriptionText" id="descriptionTextarea" >{{$descriptionText}}</textarea>
                </div>
                <button type="submit"  name="updateAuthorButton" class="btn btn-primary buttonForm" id="buttonForm">@if($firstname != "" && $lastname != "") Aktualizovať údaje interpreta @else Vytvor interpreta @endif </button>
            </form>


            <form method="post" action="/deleteAuthor"  enctype="application/x-www-form-urlencoded">
                @csrf
                @if($firstname != "" && $lastname != "")
                    <button type="submit" name="deleteAuthorButton"  class="btn btn-primary buttonForm" id="buttonFormD">Zmazat interpreta</button>
                @endif
            </form>
            <p></p>
        </div>
    </div>
@endsection

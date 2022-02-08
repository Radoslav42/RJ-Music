@extends('layouts.layout')
<link href="css/bootstrap.min.css" rel="stylesheet">
@section('content')
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">

            <h1 ><img src="@if($hasManageAlbum){{ url('storage/Files/'.$imageFilename) }}@else {{url('storage/Files/'."Author" . $authorId. "Image")}} @endif" alt="" width="70" height="70" class="d-inline-block align-text-top">  {{$firstname}}  {{$lastname}}</h1>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    @if($hasManageAlbum)
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/beforeUpdateUser" >Používateľ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/beforeActionWithAuthor" >Údaje interpreta</a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/beforeActionWithAlbums" >Albumy interpreta</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/beforeSelectAuthor">Interpreti</a>
                    </li>
                    @if (!$hasManageAlbum)
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="/home" >Domov</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"  href="{{url('about', ['authorId' => $authorId])}}">O mne</a>
                        </li>
                    @endif
                    @if($hasManageAlbum)
                    <li class="nav-item">
                        <a class="nav-link" href="/logout">Odhlasiť sa</a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-2">
        @if(!$editExist)
            <form method="post" enctype="multipart/form-data" action="/createAlbum">
        @else
            <form method="post" enctype="multipart/form-data" action="{{url('/updateAlbum', ['albumId' => $album->id])}}">
        @endif
            @csrf
        <div class="mt-2 ">
            <div class="col-md-12 card-header text-center font-weight-bold">
                <h2>Značenie albumu</h2>
                <h1><img id="imageAlbum" src="{{ url('storage/Files/'.$albumImageFilename) }}" alt="" width="150" height="150" class="d-inline-block align-text-top"></h1>
            </div>
            <label for="albumNameForm" class="form-label">Názov albumu:</label>
            @if($hasManageAlbum)
                 <input type="text" id="albumNameForm" class="form-control" name="albumName" required value="@if($editExist){{$album->getAttribute('name')}} @endif" minlength="3" maxlength="50">
            @else
                <input type="text" id="albumNameForm" class="form-control" readonly name="albumName" required value="@if($editExist){{$album->getAttribute('name')}} @endif" minlength="3" maxlength="50">
            @endif
        </div>
            @if($hasManageAlbum)
                <div class="mt-2">
                    <label for="imageFilenameForm" class="form-label">Obrázok albumu:</label>
                    <input type="file" id="imageFilenameForm"  class="form-control" accept=".gif,.jpg,.jpeg,.png"  name="imageFilename" >
                </div>
            @endif
            @if ($hasManageAlbum)
                <button type="submit" class="btn btn-primary buttonForm" id="buttonForm">@if ($editExist) Uložiť zmeny @else Vytvor album @endif</button>
            @endif
        </form>
            @if($editExist)

            <div class="row">
            <div class="col-md-12 card-header text-center font-weight-bold">
                <h2>Skladby albumu</h2>
            </div>
                @if ($hasManageAlbum)
                <div class="col-md-12 mt-1 mb-2"><button type="button" id="addNewSong" class="btn btn-success">Pridaj skladbu</button></div>
                @endif
                    <div class="col-md-12">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col"><p>Názov skladby</p></th>
                        <th scope="col"><p>Žáner</p></th>
                        <th scope="col"><p>Dĺžka trvania</p></th>
                        <th scope="col"><p>Veľkosť</p></th>
                        @if($hasManageAlbum)
                            <th scope="col"><p>Správa skladby</p></th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @if ($songs != null)
                        @foreach ($songs as $song)
                            <tr>
                                <td><p>{{ $song->name }}</p></td>
                                <td><p>{{ $song->genre }}</p></td>
                                <td><p>{{ $song->length }}</p></td>
                                <td><p>{{ $song->size/1000000 }} MB</p></td>
                                @if($hasManageAlbum)
                                <td>
                                    <a href="{{url('/deleteSong', ['songId' => $song->id])}}" class="btn btn-primary buttonEditDeleteInTable buttonEditDeleteInTable buttonFormD"data-id="{{ $song->id }}">Zmazať</a>
                                </td>
                                @endif
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
            </div>
            @endif
    </div>
    <div class="modal fade " id="ajax-new-song-model" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content modelModalHeader ">
                <div class="modal-header modelModalHeader" >
                    <h4 class="modal-title" id="ajaxNewSongModel"></h4>
                </div>
                <div class="modal-body modelModalBody">
                    <form action="/addSong" id="addEditSongForm" enctype="multipart/form-data" name="addEditSongForm" class="form-horizontal" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name" class=" control-label">Názov skladby</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Napíš názov skladby" value="" maxlength="50" required="">
                            </div>
                            <label for="name" class=" control-label">Názov žánru</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="genre" name="genre" placeholder="Napíš názov žánru skladby" value="" maxlength="50" required="">
                            </div>
                            <div class="mt-2">
                                <label for="songFilenameForm" class="form-label">Súbor skladby</label>
                                <input type="file" id="songFilenameForm"  class="form-control" accept=".mp3,.wav," name="songFilename" >
                                <button type="submit" class="btn btn-primary buttonForm" id="btn-save" value="addNewSong">Pridaj
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.4/datatables.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function($){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#addNewSong').click(function () {
                $('#addSongForm').trigger("reset");
                $('#ajaxNewSongModel').html("Pridaj skladbu");
                $('#ajax-new-song-model').modal('show');
            });
        });
    </script>

@stop

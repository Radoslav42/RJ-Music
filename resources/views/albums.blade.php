@extends('layouts.layout')
@section('content')

    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
                <h1 ><img src="@if($hasManageAlbums){{ url('storage/Files/'.$imageFilename) }} @else  @endif" alt="" width="70" height="70" class="d-inline-block align-text-top">  {{$firstname}}  {{$lastname}}</h1>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/beforeUpdateUser" >Používateľ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/beforeActionWithAuthor" >Údaje interpreta</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/beforeActionWithAlbums" >Albumy interpreta</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/logout">Odhlasiť sa</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-2">
        <div class="row">
            <div class="col-md-12 card-header text-center font-weight-bold">
                <h2>Albumy môjho interpreta</h2>
            </div>
            <div class="col-md-12 mt-1 mb-2">
                <a href="{{url('/beforeCreateAlbum')}}" class="btn btn-primary buttonEditDeleteInTable ">Pridaj album</a>

            </div>
            <div class="col-md-12">
                <table class="table" id="datatable-ajax-crud" >
                    <thead>
                    <tr>
                        <th scope="col"><p>Názov albumu</p></th>
                        <th scope="col"><p>Mená interpretov</p></th>
                        <th scope="col"><p>Počet skladieb</p></th>
                        <th scope="col"><p>Žáner</p></th>
                        <th scope="col"><p>Dátum vytvorenia</p></th>
                        <th scope="col"><p>Dĺžka trvania</p></th>
                        <th scope="col"><p>Veľkosť</p></th>
                        <th scope="col"><p>Správa albumu</p></th>
                    </tr>
                    </thead>
                    <tbody>
                    @if ($albums != null)
                    @foreach ($albums as $album)
                        <tr>
                            <td><p>{{ $album->name }}</p></td>
                            <td><p>{{ $album->getAuthorNames() }}</p></td>
                            <td><p>{{ $album->getNumberSongs() }}</p></td>
                            <td><p>{{ $album->getGenre() }}</p></td>
                            <td><p>{{ $album->createdAt }}</p></td>
                            <td><p>{{ $album->getLength() }}</p></td>
                            <td><p>{{ $album->getSize()}}</p></td>
                            <td>


                                <a href="{{url('/beforeUpdateAlbum', ['albumId' => $album->id])}}" class="btn btn-primary buttonEditDeleteInTable ">Upraviť</a>
                                <a href="{{url('/deleteAlbum', ['albumId' => $album->id])}}" class="btn btn-primary buttonEditDeleteInTable delete">Zmazať</a>

                            </td>
                        </tr>
                    @endforeach
                    @endif
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <div class="modal fade " id="ajax-album-model" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content modelModalHeader ">
                <div class="modal-header modelModalHeader" >
                    <h4 class="modal-title" id="ajaxAlbumModel"></h4>
                </div>
                <div class="modal-body modelModalBody">
                    <form action="javascript:void(0)" id="addEditAlbumForm" name="addEditAlbumForm" class="form-horizontal" method="post">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <div class="mt-2">
                                <label for="name" class="form-label">Názov albumu:</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Napíš názov albumu" value="" maxlength="50" required="">
                            </div>
                            <div class="mt-2">
                                <label for="imageFilenameForm" class="form-label">Obrázok albumu:</label>
                                <input type="file" id="imageFilenameForm" name="imageFilename" value required class="form-control" accept=".gif,.jpg,.jpeg,.png" >
                            </div>
                            <button type="submit" class="buttonForm btn " id="btn-save" value="addNewAlbum">Uložiť
                            </button>
                        </div>
                        <div class="col-sm-offset-2 col-sm-10">

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.4/datatables.min.css"/>



@endsection

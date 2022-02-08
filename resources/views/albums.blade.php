@extends('layouts.layout')
@section('content')

    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
                <h1 ><img src="@if($hasManageAlbums){{ url('storage/Files/'.$imageFilename) }} @else {{url('storage/Files/'."Author" . $authorId. "Image")}}   @endif" alt="" width="70" height="70" class="d-inline-block align-text-top">  {{$firstname}}  {{$lastname}}</h1>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    @if ($hasManageAlbums)
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/beforeUpdateUser" >Používateľ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/beforeActionWithAuthor" >Údaje interpreta</a>
                    </li>
                    @endif
                    @if (!$hasManageAlbums)
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/home" >Domov</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"  href="{{url('about', ['authorId' => $authorId])}}">O mne</a>
                    </li>
                    @endif
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/beforeActionWithAlbums" >Albumy interpreta</a>
                        </li>
                    @if ($hasManageAlbums)
                    <li class="nav-item">
                        <a class="nav-link" href="/logout">Odhlasiť sa</a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-2">
        <div class="row">
            <div class="col-md-12 card-header text-center font-weight-bold">
                @if ($hasManageAlbums)
                    <h2>Albumy môjho interpreta</h2>
                @else
                    <h2>Albumy interpreta</h2>
                @endif
            </div>
            @if ($hasManageAlbums)
            <div class="col-md-12 mt-1 mb-2">
                <a href="{{url('/beforeCreateAlbum')}}" class="btn btn-primary buttonEditDeleteInTable ">Pridaj album</a>
            </div>
            @endif
            <div class="col-md-12">
                <table class="table" id="datatable-ajax-crud" >
                    <thead>
                    <tr>
                        <th scope="col"><p>Obrázok albumu</p></th>
                        <th scope="col"><p>Názov albumu</p></th>
                        <th scope="col"><p>Mená interpretov</p></th>
                        <th scope="col"><p>Počet skladieb</p></th>
                        <th scope="col"><p>Žáner</p></th>
                        <th scope="col"><p>Dátum vytvorenia</p></th>
                        <th scope="col"><p>Dĺžka trvania</p></th>
                        <th scope="col"><p>Veľkosť</p></th>
                        @if ($hasManageAlbums)
                        <th scope="col"><p>Správa albumu</p></th>
                        @endif
                        @if (!$hasManageAlbums)
                        <th scope="col"><p>Možnosti</p></th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @if ($albums != null)
                    @foreach ($albums as $album)
                        <tr>
                            <td><img src="{{ url('storage/Files/'. $album->getImageFilename()) }}" alt="" width="100" height="100" class="d-inline-block align-text-top"></img></td>
                            <td><p>{{ $album->name }}</p></td>
                            <td><p>{{ $album->getAuthorNames() }}</p></td>
                            <td><p>{{ $album->getNumberSongs() }}</p></td>
                            <td><p>{{ $album->getGenre() }}</p></td>
                            <td><p>{{ $album->createdAt }}</p></td>
                            <td><p>{{ $album->getLength() }}</p></td>
                            <td><p>{{ $album->getSize()}} MB</p></td>
                            @if ($hasManageAlbums)
                                <td>
                                    <a href="{{url('/beforeUpdateAlbum', ['albumId' => $album->id])}}" class="btn btn-primary buttonEditDeleteInTable ">Upraviť</a>
                                    <a href="{{url('/deleteAlbum', ['albumId' => $album->id])}}" class="btn btn-primary buttonEditDeleteInTable delete buttonFormD">Zmazať</a>
                                </td>
                            @endif
                            @if(!$hasManageAlbums)
                                <td>
                                    <a class="btn btn-primary buttonEditDeleteInTable delete buttonForm" href="{{url('beforeSelectSong', ['albumId' => $album->id, 'authorId' => $authorId])}}">Zobrazit album</a>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

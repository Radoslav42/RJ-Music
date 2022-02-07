@extends('layouts.layout')
<link href="css/bootstrap.min.css" rel="stylesheet">
@section('content')
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">

            <h1 ><img src="@if($hasManageAlbum){{ url('storage/Files/'.$imageFilename) }}@else @endif" alt="" width="70" height="70" class="d-inline-block align-text-top">  {{$firstname}}  {{$lastname}}</h1>

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
                        <a class="nav-link" href="/beforeSelectAuthor">Interpreti</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/logout">Odhlasiť sa</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-2">
        <form method="post" enctype="application/x-www-form-urlencoded" action="/createAlbum">
        <div class="mt-2 ">
            <div class="col-md-12 card-header text-center font-weight-bold">
                <h2>Značenie albumu</h2>
                <h1><img id="imageAlbum" src="{{ url('storage/Files/'.$albumImageFilename) }}" alt="" width="150" height="150" class="d-inline-block align-text-top"></h1>
            </div>
            <label for="albumNameForm" class="form-label">Názov albumu:</label>
            @if($hasManageAlbum)
                 <input type="text" id="albumNameForm" class="form-control" name="albumName" required value minlength="3" maxlength="50">
            @else
                <input type="text" id="albumNameForm" class="form-control" readonly name="albumName" required value minlength="3" maxlength="50">
            @endif
        </div>
            @if($hasManageAlbum)
            <div class="mt-2">
                <label for="imageFilenameForm" class="form-label">Obrázok albumu:</label>
                <input type="file" id="imageFilenameForm" class="form-control" accept=".gif,.jpg,.jpeg,.png" required name="imageFilename" >
            </div>
            @endif
            @if ($hasManageAlbum)
                <button type="submit" class="btn btn-primary buttonForm" id="buttonForm">@if ($editExist) Uložiť zmeny @else Vytvor album @endif</button>
            @endif
            @if($editExist)
            <div class="row">
            <div class="col-md-12 card-header text-center font-weight-bold">
                <h2>Skladby albumu</h2>
            </div>
            <div class="col-md-12 mt-1 mb-2"><button type="button" id="addNewSong" class="btn btn-success">Pridaj skladbu</button></div>
            <div class="col-md-12">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col"><p>Názov skladby</p></th>
                        <th scope="col"><p>Žáner</p></th>
                        <th scope="col"><p>Dĺžka trvania</p></th>
                        <th scope="col"><p>Veľkosť</p></th>
                        <th scope="col"><p>Správa skladby</p></th>
                    </tr>
                    </thead>
                    <tbody>
                    @if ($songs != null)
                        @foreach ($songs as $song)
                            <tr>
                                <td>{{ $song->name }}</td>
                                <td>{{ $song->genre }}</td>
                                <td>{{ $song->length }}</td>
                                <td>{{ $song->size }}</td>
                                @if($hasManageAlbum)
                                <td>
                                    <a href="javascript:void(0)" class="btn btn-primary edit" data-id="{{ $song->id }}">Edit</a>
                                    <a href="javascript:void(0)" class="btn btn-primary delete" data-id="{{ $song->id }}">Delete</a>
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
            @csrf
        </form>
    </div>
    <div class="modal fade " id="ajax-song-model" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content modelModalHeader ">
                <div class="modal-header modelModalHeader" >
                    <h4 class="modal-title" id="ajaxSongModel"></h4>
                </div>
                <div class="modal-body modelModalBody">
                    <form action="javascript:void(0)" id="addEditSongForm" name="addEditSongForm" class="form-horizontal" method="post">
                        <input type="hidden" name="id" id="id">
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
                                <input type="file" id="songFilenameForm"  class="form-control" accept=".mp3,.wav,"  name="songFilename" >
                            </div>
                        </div>
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary buttonForm" id="btn-save" value="addNewSong">Pridaj
                            </button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function($){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#addNewSong').click(function () {
                $('#addEditSongForm').trigger("reset");
                $('#ajaxSongModel').html("Pridaj skladbu");
                $('#ajax-song-model').modal('show');
            });
            $('body').on('click', '.edit', function () {
                var id = $(this).data('id');

                // ajax
                $.ajax({
                    type:"post",
                    url: "{{ url('editSong') }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){
                        $('#ajaxSongModel').html("Edit Song");
                        $('#ajax-song-model').modal('show');
                        $('#id').val(res.id);
                        $('#name').val(res.name);
                        $('#genre').val(res.genre);
                        $('#filename').val(res.filename);
                    }
                });
            });
            $('body').on('click', '.delete', function () {
                if (confirm("Zmazať skladbu?") == true) {
                    var id = $(this).data('id');

                    // ajax
                    $.ajax({
                        type:"post",
                        url: "{{ url('deleteSong') }}",
                        data: { id: id },
                        dataType: 'json',
                        success: function(res){
                            window.location.reload();
                        }
                    });
                }
            });
            $('body').on('click', '#btn-save', function (event) {
                var id = $("#id").val();
                var name = $("#name").val();
                $("#btn-save").html('Please Wait...');
                $("#btn-save"). attr("disabled", true);

                // ajax
                $.ajax({
                    type:"post",
                    url: "{{ url('addUpdateSong') }}",
                    data: {
                        id:id,
                        name:name,

                    },
                    dataType: 'json',
                    success: function(res){
                        window.location.reload();
                        $("#btn-save").html('Submit');
                        $("#btn-save"). attr("disabled", false);
                    }
                });
            });
        });
    </script>

@stop

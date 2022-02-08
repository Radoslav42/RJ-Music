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

    <div class="container mt-2">
        <div class="row">
            <div class="col-md-12 card-header text-center font-weight-bold">
                <h2>Interpreti</h2>
            </div>
            <div class="col-md-12">
                <table class="table" id="datatable-ajax-crud" >
                    <thead>
                    <tr>
                        <th scope="col"><p>Obrázok Interpreta</p></th>
                        <th scope="col"><p>Meno</p></th>
                        <th scope="col"><p>Priezvisko</p></th>
                        <th scope="col"><p>Možnosti</p></th>
                    </tr>
                    </thead>
                    <tbody>
                    @if ($authors != null)
                        @foreach ($authors as $author)
                            <tr>
                                <td><img src="{{ url('storage/Files/'. "Author" . $author->id . "Image") }}" alt="" width="100" height="100" class="d-inline-block align-text-top"></img></td>
                                <td><p>{{ $author->firstname }}</p></td>
                                <td><p>{{ $author->lastname }}</p></td>
                                <td>

                                    <a href="{{url('/home', ['authorId' => $author->id])}}" class="btn btn-primary buttonEditDeleteInTable ">Domov</a>
                                    <a href="{{url('/about', ['authorId' => $author->id])}}" class="btn btn-primary buttonEditDeleteInTable ">O mne</a>
                                    <a href="{{url('/beforeSelectAlbum', ['authorId' => $author->id])}}" class="btn btn-primary buttonEditDeleteInTable">Albumy</a>

                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script >


        function TextChange(inputText){
            count = 0;
            for (i = 0; i < authors.length; i++)
            {
                if (authors[i].firstname.includes(inputText) || authors[i].lastname.includes(inputText))
                    count++;
            }
            $countFindings = document.getElementById("countFindings");
            $countFindings.value = count;
        }
    </script>
@endsection

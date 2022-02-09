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
            <div class="col-md-12" id="tableDiv">
                <p>Hľadaj:</p>
                <input type="text" id="FindInput" width="500"  oninput="TextChange(this.value)">
                <table class="table" id="datatable" >
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
                <script type="text/javascript">
                    let arrHead = new Array();
                    arrHead = ['<p>Obrázok Interpreta</p>', '<p>Meno</p>', '<p>Priezvisko</p>', '<p>Možnosti</p>']; // table headers.
                    authors = JSON.parse('<?= json_encode($authors); ?>');

                    function TextChange(inputText){
                        removeTable();
                        createTable();

                        for (let i = 0; i < authors.length; i++)
                        {
                            fullname = authors[i].firstname + " " + authors[i].lastname;
                            if (fullname.includes(inputText))
                            addRow(authors[i]);
                        }
                    }
                    function removeTable() {
                        let removeTab = document.getElementById('datatable');
                        let parentEl = removeTab.parentElement;
                        parentEl.removeChild(removeTab);
                    }
                    function createTable() {
                        var table = document.createElement('table');
                        table.setAttribute('id', 'datatable');
                        table.setAttribute('class', 'col-md-12');
                        var thead = document.createElement('thead');
                        table.appendChild(thead);
                        let tr = thead.insertRow(0);
                        thead.appendChild(tr);
                        for (let h = 0; h < arrHead.length; h++) {
                            let th = document.createElement('th');
                            th.innerHTML = arrHead[h];
                            tr.appendChild(th);
                        }

                        let div = document.getElementById('tableDiv');
                        div.appendChild(table);
                    }
                    async function axiosImageAuthor(authorId) {
                        const response = await axios.get("/getAuthorImgUrl/" + authorId);
                        return response.data;
                    }
                    async function addRow(author) {
                        let table = document.getElementById('datatable');
                        let authorId = author.id;
                        let rowCnt = table.rows.length;
                        let tr = table.insertRow(rowCnt);
                        tr = table.insertRow(rowCnt);

                        for (let c = 0; c < arrHead.length; c++) {
                            let td = document.createElement('td');          // TABLE DEFINITION.
                            td = tr.insertCell(c);

                            if (c == 0) {
                                let img = document.createElement('img');

                                let url = "";
                                url = await axiosImageAuthor(authorId);//axios.get("/getAuthorImgUrl/" + authorId).then(response => response.data);
                                img.setAttribute('src', url);
                                img.setAttribute('alt', '');
                                img.setAttribute('width', '100');
                                img.setAttribute('width', '100');
                                img.setAttribute('class', 'd-inline-block align-text-top');

                                td.appendChild(img);
                            }
                            else if (c == 1) {
                                let p = document.createElement('p');
                                p.innerHTML = author.firstname ;
                                td.appendChild(p);
                            }
                            else if (c == 2) {
                                let p = document.createElement('p');
                                p.innerHTML = author.lastname ;
                                td.appendChild(p);
                            }
                            else {
                                // the 2nd, 3rd and 4th column, will have textbox.
                                let a = document.createElement('a');
                                a.setAttribute('href', '{{url('/home', ['authorId' => $author->id])}}');
                                a.setAttribute('class', 'btn btn-primary buttonEditDeleteInTable');
                                a.innerHTML = 'Domov';
                                td.appendChild(a);
                                a = document.createElement('a');
                                a.setAttribute('href', '{{url('/about', ['authorId' => $author->id])}}');
                                a.setAttribute('class', 'btn btn-primary buttonEditDeleteInTable');
                                a.innerHTML = 'O mne';
                                td.appendChild(a);
                                a = document.createElement('a');
                                a.setAttribute('href', '{{url('/beforeSelectAlbum', ['authorId' => $author->id])}}');
                                a.setAttribute('class', 'btn btn-primary buttonEditDeleteInTable');
                                a.innerHTML = 'Albumy';
                                td.appendChild(a);
                            }
                        }
                    }
                </script>

            </div>
        </div>
    </div>
@endsection

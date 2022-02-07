@extends('layouts.layout')
@section('content')
<nav class="navbar navbar-dark bg-dark ">
    <div class="container-fluid">
            <h1><img src="images/RJ_Music_500x500.png" alt="" width="70" height="70" class="d-inline-block align-text-top">   Radoslav Joob</h1>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/home">Domov</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/about">O mne</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/authors">Interpreti</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/beforeLogin">Prihlásenie</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2>O mne</h2>
            <p>
                Lorem Ipsum je demonstrativní výplňový text používaný v tiskařském a knihařském průmyslu. Lorem Ipsum je považováno za standard v této oblasti už od začátku 16. století, kdy dnes neznámý tiskař vzal kusy textu a na jejich základě vytvořil speciální vzorovou knihu. Jeho odkaz nevydržel pouze pět století, on přežil i nástup elektronické sazby v podstatě beze změny. Nejvíce popularizováno bylo Lorem Ipsum v šedesátých letech 20. století, kdy byly vydávány speciální vzorníky s jeho pasážemi a později pak díky počítačovým DTP programům jako Aldus PageMaker.
            </p>
        </div>
        <div class="col-12">
            <div class="row">
                <div class="col-12 col-md-4">
                    <img src="images/RJ_Music_500x500.png" class="img-fluid" alt="...">
                </div>
                <div class="col-12 col-md-8">
                    <p>
                        Proč ho používáme?
                        Je obecně známou věcí, že člověk bývá při zkoumání grafického návrhu rozptylován okolním textem, pokud mu dává nějaký smysl. Úkolem Lorem Ipsum je pak nahradit klasický smysluplný text vhodnou bezvýznamovou alternativou s relativně běžným rozložením slov. To jej dělá narozdíl od opakujícího se "Tady bude text. Tady bude text..." mnohem více čitelnějším. V dnešní době je Lorem Ipsum používáno spoustou DTP balíků a webových editorů coby výchozí model výplňového textu. Ostatně si zkuste zadat frázi "lorem ipsum" do vyhledavače a sami uvidíte. Během let se objevily různé varianty a odvozeniny od klasického Lorem Ipsum, někdy náhodou, někdy účelně (např. pro pobavení čtenáře).
                        Odkud pochází?
                        Navzdory všeobecnému přesvědčení Lorem Ipsum není náhodný text. Jeho původ má kořeny v klasické latinské literatuře z roku 45 před Kristem, což znamená, že je více jak 2000 let staré. Richard McClintock, profesor latiny na univerzitě Hampden-Sydney stát Virginia, který se zabýval téměř neznámými latinskými slovy, odhalil prapůvod slova consectetur z pasáže Lorem Ipsum. Nejstarším dílem, v němž se pasáže Lorem Ipsum používají, je Cicerova kniha z roku 45 před Kristem s názvem "De Finibus Bonurum et Malorum" (O koncích dobra a zla), konkrétně jde pak o kapitoly 1.10.32 a 1.10.33. Tato kniha byla nejvíce známá v době renesance, jelikož pojednávala o etice. Úvodní řádky Lorem Ipsum, "Lorem ipsum dolor sit amet...", pocházejí z kapitoly 1.10.32 z uvedené knihy.

                        Klasické pasáže Lorem Ipsum z 16. století jsou reprodukovány níže. Kapitoly 1.10.32 a 1.10.33 z "De Finibus Bonorum et Malorum" od Cicera najdete v původní podobě doplněné o anglický překlad z roku 1914 od H. Rackhama.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-8">
                    <p>
                        Proč ho používáme?
                        Je obecně známou věcí, že člověk bývá při zkoumání grafického návrhu rozptylován okolním textem, pokud mu dává nějaký smysl. Úkolem Lorem Ipsum je pak nahradit klasický smysluplný text vhodnou bezvýznamovou alternativou s relativně běžným rozložením slov. To jej dělá narozdíl od opakujícího se "Tady bude text. Tady bude text..." mnohem více čitelnějším. V dnešní době je Lorem Ipsum používáno spoustou DTP balíků a webových editorů coby výchozí model výplňového textu. Ostatně si zkuste zadat frázi "lorem ipsum" do vyhledavače a sami uvidíte. Během let se objevily různé varianty a odvozeniny od klasického Lorem Ipsum, někdy náhodou, někdy účelně (např. pro pobavení čtenáře).
                        Odkud pochází?
                        Navzdory všeobecnému přesvědčení Lorem Ipsum není náhodný text. Jeho původ má kořeny v klasické latinské literatuře z roku 45 před Kristem, což znamená, že je více jak 2000 let staré. Richard McClintock, profesor latiny na univerzitě Hampden-Sydney stát Virginia, který se zabýval téměř neznámými latinskými slovy, odhalil prapůvod slova consectetur z pasáže Lorem Ipsum. Nejstarším dílem, v němž se pasáže Lorem Ipsum používají, je Cicerova kniha z roku 45 před Kristem s názvem "De Finibus Bonurum et Malorum" (O koncích dobra a zla), konkrétně jde pak o kapitoly 1.10.32 a 1.10.33. Tato kniha byla nejvíce známá v době renesance, jelikož pojednávala o etice. Úvodní řádky Lorem Ipsum, "Lorem ipsum dolor sit amet...", pocházejí z kapitoly 1.10.32 z uvedené knihy.

                        Klasické pasáže Lorem Ipsum z 16. století jsou reprodukovány níže. Kapitoly 1.10.32 a 1.10.33 z "De Finibus Bonorum et Malorum" od Cicera najdete v původní podobě doplněné o anglický překlad z roku 1914 od H. Rackhama.
                    </p>
                </div>
                <div class="col-12 col-md-4">
                    <img src="images/CakewalkUI.png" class="img-fluid" alt="...">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

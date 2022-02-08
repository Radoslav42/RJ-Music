<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index()
    {
        $authorId = request('authorId');
        if ($authorId != null) {
            $author = AuthorController::getAuthorById($authorId);
            $albums = $author->albums()->get()->take(5);
            return view('home', ['titleText' => "Domov", 'shortDescriptionText' => Storage::get("public\\Files\\" . "Author" . $authorId . "Description"), 'hasSelectedAuthor' => true ,'author' => $author, 'albums' => $albums]);
        }
        else {
            return view('home', ['titleText' => "Domov", 'hasSelectedAuthor' => false ,'authors' => Author::all()->take(10)]);
        }
    }
}

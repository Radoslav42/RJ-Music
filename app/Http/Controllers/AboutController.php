<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    public function index()
    {
        $authorId = request('authorId');
        if ($authorId != null) {
            $author = AuthorController::getAuthorById($authorId);
            $albums = $author->albums()->get()->take(5);
            return view('about', ['titleText' => "O mne", 'descriptionText' => Storage::get("public\\Files\\" . "Author" . $authorId . "Description"),'author' => $author]);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\UserController;
use App\Models\User;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AuthorController extends Controller
{

    public static function getAuthorById(int $id) : Author
    {
        if (Author::all()->where('id', '=', $id)->count() > 0) {
            return Author::all()->where('id', '=', $id)->first();
        }
        throw new Exception("Author with id={$id} does not exist!");
    }
    private function validateStringLengthFrom3To30Characters(string $str) : bool
    {
        if (strlen($str) >= 3 && strlen($str) <= 30)
            return true;
        else {
            session()->put('sessionMessage', "Wrong string length!");
            return false;
        }
    }
    public function beforeActionWithAuthor()
    {
        if (UserController::isLoggedUser()) {
            $user = session()->get('loggedUser', [User::class]);
            $authorId = $user->getAttribute('authorId');
            if ($authorId != null)
            {
                $author = AuthorController::getAuthorById($authorId);
                $view = view('author', ['titleText' => "Môj interpret",
                    'sessionMessage' => session()->has("sessionMessage") ? session()->get("sessionMessage") : "",
                    'firstname' => $author->getAttribute('firstname'), 'lastname' => $author->getAttribute('lastname'),
                    'imageFilename' => "Author" . $authorId. "Image", 'descriptionText' => Storage::get("public\\Files\\" . "Author" . $authorId . "Description" )]);
                session()->put('sessionMessage', "");
                return $view;
            }
            else
            {
                $view = view('author', ['titleText' => "Môj interpret",
                    'sessionMessage' => session()->has("sessionMessage") ? session()->get("sessionMessage") : "",
                    'firstname' => "", 'lastname' => "",
                    'imageFilename' => "", 'descriptionText' => ""]);
                session()->put('sessionMessage', "");
                return $view;
            }
        }
        else
        {
            return redirect('beforeLogin');
        }
    }
    public function updateAuthor()
    {
        if (UserController::isLoggedUser()) {
            $user = session()->get('loggedUser', [User::class]);
            $authorId = $user->getAttribute('authorId');
            $firstname = request('firstname');
            $lastname = request('lastname');
            $descriptionText = request('descriptionText');
            $isSelectedImageFile = true;
            if ($_FILES["imageFilename"]["error"] == UPLOAD_ERR_OK)
            {
                $imageFile = request('imageFilename');
            }
            else
            {
                $isSelectedImageFile = false;
            }
            if ($authorId == null)
            {
                $author = new Author();
            }
            else
            {
                $author = AuthorController::getAuthorById($authorId);
            }

            if ($this->validateStringLengthFrom3To30Characters($firstname) && $this->validateStringLengthFrom3To30Characters($lastname))
            {
                $author->setAttribute('firstname', $firstname);
                $author->setAttribute('lastname', $lastname);
            }
            else
            {
                session()->put('sessionMessage', "Wrong input!");
                return redirect('beforeActionWithAuthor');
            }
            $author->save();
            $authorId = $author->getAttribute('id');
            $relativePath = "public\\Files\\";
            if ($isSelectedImageFile)
            {
                $filename = $_FILES['imageFilename']['name'];
                Storage::disk('local')->put($relativePath . "Author" . $authorId . "Image", $imageFile->getContent());
            }
            Storage::disk('local')->put($relativePath . "Author" . $authorId . "Description", $descriptionText);

            if ($user->getAttribute('authorId') == null)
            {
                $user->setAttribute('authorId', $authorId);
                $user->save();
            }
            return redirect('beforeUpdateAlbum', ['']);
        }
        else
        {
            return redirect('beforeLogin');
        }
    }
    public function deleteAuthor()
    {
        if (UserController::isLoggedUser())
        {
            $user = session()->get('loggedUser', [User::class]);
            $authorId = $user->getAttribute('authorId');
            $author = AuthorController::getAuthorById($authorId);
            $author->delete();
            $user->refresh();
            $authorId = $user->getAttribute('authorId');
            return redirect('beforeActionWithAuthor');
        }
        else
        {
            return redirect('beforeLogin');
        }
    }
    public function beforeSelectAuthor()
    {
        $view = view('authors', ['titleText' => "Interpreti",
            'sessionMessage' => session()->has("sessionMessage") ? session()->get("sessionMessage") : "",
            'authors' => Author::all()]);
        session()->put('sessionMessage', "");
        return $view;
    }
}

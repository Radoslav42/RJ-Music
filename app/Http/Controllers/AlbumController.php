<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AuthorController;
use App\Models\Album;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AlbumController extends Controller
{
    public function beforeActionWithAlbums()
    {
        if (UserController::isLoggedUser()) {

            $user = session()->get('loggedUser', [User::class]);
            $author = AuthorController::getAuthorById($user->getAttribute('authorId'));
            $albums = null;
            if (DB::table('authorables')->where('author_id', '=', $author->getAttribute('id'))->count() > 0)
            {
                $albums = $author->albums();
                //test
                /*foreach ($albums->get() as $album)
                {
                    $name = $album->getAttribute('name');
                    $authorNames =  $album->getAuthorNames();
                }*/
            }


            $view = view('albums', ['titleText' => "Správa albumov", 'hasManageAlbums' => true, 'albums' => $albums != null ? $albums->get() : null,
                'firstname' => $author->getAttribute('firstname'), 'lastname' => $author->getAttribute('lastname'),
                'imageFilename' => "Author" . $author->getAttribute('id'). "Image",
                'sessionMessage' => session()->has("sessionMessage") ? session()->get("sessionMessage") : ""]);
            session()->put('sessionMessage', "");
            return $view;
        }
        else
        {
            return redirect('beforeLogin');
        }
    }
    public function editAlbum() : Response
    {
        $id = request('id');
        $album  = Album::all()->where($id)->first();

        return response()->json($album);
    }
    public function deleteAlbum()
    {
        $albumId = request('albumId');
        $album = Album::all()->where('id', '=', $albumId)->first();
        $album->delete();
        return redirect('/beforeActionWithAlbums');
    }
    public function createUpdateAlbum() : \Illuminate\Http\JsonResponse
    {
        if (UserController::isLoggedUser()) {
            $user = session()->get('loggedUser', [User::class]);
            $author = AuthorController::getAuthorById($user->getAttribute('authorId'));
            $id = request('id');
            if (Album::all()->where('id', '=', $id)->count() > 0) {
                $album = Album::all()->where('id', '=', $id)->first();
                $album->setAttribute('name', request('name'));
                $album->save();
            } else {
                $album = new Album();
                $album->setAttribute('name', request('name'));
                $album->setAttribute('createdAt', Carbon::now());
                $album->save();
                $album->authors()->save($author);

            }

            return response()->json(['success' => true]);
        }
        else
        {
            return redirect('beforeLogin');
        }
    }
    public function addUpdateSong(): \Illuminate\Http\JsonResponse
    {
        if (UserController::isLoggedUser()) {
            $user = session()->get('loggedUser', [User::class]);
            $author = AuthorController::getAuthorById($user->getAttribute('authorId'));
            $id = request('id');
            if (Album::all()->where('id', '=', $id)->count() > 0) {
                $album = Album::all()->where('id', '=', $id)->first();
                $album->setAttribute('name', request('name'));
                $album->save();
            } else {
                $album = new Album();
                $album->setAttribute('name', request('name'));
                $album->setAttribute('createdAt', Carbon::now());
                $album->save();
                DB::table('authors_albums')->insert([
                    'authorId' => $user->getAttribute('authorId'),
                    'albumId' => $id != null ? $id : $album->getAttribute('id')
                ]);
            }

            return response()->json(['success' => true]);
        }
        else
        {
            return redirect('beforeLogin');
        }
    }
    public function createAlbum()
    {
        $albumName = request('albumName');
        $imageFilename = request('imageFilename');
    }
    public function beforeCreateAlbum()
    {
        if (UserController::isLoggedUser()) {
            $user = session()->get('loggedUser', [User::class]);
            $author = AuthorController::getAuthorById($user->getAttribute('authorId'));
            $view = view('album', ['titleText' => "Správa albumu", 'hasManageAlbum' => true, 'songs' => null,
                'firstname' => $author->getAttribute('firstname'), 'lastname' => $author->getAttribute('lastname'),
                'imageFilename' => "Author" . $author->getAttribute('id') . "Image", 'albumImageFilename' => "",
                'sessionMessage' => session()->has("sessionMessage") ? session()->get("sessionMessage") : "",
                'editExist' => false]);
            session()->put('sessionMessage', "");
            return $view;
        }
        else
        {
            return redirect('beforeLogin');
        }
    }
    public function beforeUpdateAlbum()
    {
        if (UserController::isLoggedUser()) {
            $albumId = request('albumId');
            $user = session()->get('loggedUser', [User::class]);
            $author = AuthorController::getAuthorById($user->getAttribute('authorId'));
            $album = Album::all()->where('id', '='. $albumId)->first();
            $view = view('album', ['titleText' => "Správa albumu", 'hasManageAlbum' => true, 'songs' => null,
                'firstname' => $author->getAttribute('firstname'), 'lastname' => $author->getAttribute('lastname'),
                'imageFilename' => "Author" . $author->getAttribute('id') . "Image", 'album' => $album,
                'sessionMessage' => session()->has("sessionMessage") ? session()->get("sessionMessage") : ""]);
            session()->put('sessionMessage', "");
            return $view;
        }
        else
        {
            return redirect('beforeLogin');
        }
    }
}

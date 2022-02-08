<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AuthorController;
use App\Models\Album;
use App\Models\Song;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use MP3File;

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
            if (session()->has('albumId'))
            session()->remove('albumId');
            return redirect('beforeLogin');
        }
    }
    public function updateAlbum()
    {
        $id = request('albumId');
        $album  = Album::all()->where('id', '=', $id)->first();
        $albumName = request('albumName');
        $album->setAttribute('name', $albumName);
        $album->save();
        $isSelectedImageFile = true;
        if ($_FILES["imageFilename"]["error"] == UPLOAD_ERR_OK)
        {
            $imageFile = request('imageFilename');
        }
        else
        {
            $isSelectedImageFile = false;
        }
        $relativePath = "public\\Files\\";
        if ($isSelectedImageFile)
        {
            $filename = $_FILES['imageFilename']['name'];
            Storage::disk('local')->put($relativePath . "Album" . $album->getAttribute('id') . "Image", $imageFile->getContent());
        }
        return redirect(route('beforeUpdateAlbum', ['albumId' =>  $album->getAttribute('id')]));
    }
    public function deleteAlbum()
    {
        $albumId = request('albumId');
        $album = Album::all()->where('id', '=', $albumId)->first();
        $album->delete();
        return redirect('/beforeActionWithAlbums');
    }
    public function addSong()
    {
        $name = request('name');
        $genre = request('genre');
        $isSelectedImageFile = true;
        $song = new Song();
        $song->setAttribute('name', $name);
        $song->setAttribute('genre', $genre);
        if ($_FILES["songFilename"]["error"] == UPLOAD_ERR_OK)
        {
            $songFile = request('songFilename');
        }
        else
        {
            $isSelectedImageFile = false;
        }
        $relativePath = "public\\Files\\";
        $song->setAttribute('length', Song::getDuration($songFile));
        $song->setAttribute('size',filesize($songFile));
        $song->save();
        $albumId = session()->get('albumId');
        $song->albums()->save(Album::all()->where('id', '=',$albumId)->first());
        if ($isSelectedImageFile)
        {
            $filename = $_FILES['songFilename']['name'];
            Storage::disk('local')->put($relativePath . "Song" . $song->getAttribute('id'), $songFile->getContent());
        }

        return redirect(route('beforeUpdateAlbum', ['albumId' =>  $albumId]));
    }
    public function deleteSong()
    {
        $songId = request('songId');
        $albumId = session()->get('albumId');
        $song = Song::all()->where('id', '=', $songId)->first();
        $song->delete();
        return redirect(route('beforeUpdateAlbum', ['albumId' =>  $albumId]));
    }
    public function beforeUpdateAlbum()
    {
        if (UserController::isLoggedUser()) {
            $albumId = request('albumId');
            $user = session()->get('loggedUser', [User::class]);
            $author = AuthorController::getAuthorById($user->getAttribute('authorId'));
            $album = Album::all()->where('id', '=', $albumId)->first();
            $albumImageFilename = "Album" . $album->getAttribute('id') . "Image";
            $view = view('album', ['titleText' => "Správa albumu", 'hasManageAlbum' => true, 'songs' => null,
                'firstname' => $author->getAttribute('firstname'), 'lastname' => $author->getAttribute('lastname'),
                'imageFilename' => "Author" . $author->getAttribute('id') . "Image", 'album' => $album, 'albumImageFilename' => $albumImageFilename,
                'editExist' => true, 'songs' => $album->songs()->get(),
                'sessionMessage' => session()->has("sessionMessage") ? session()->get("sessionMessage") : ""]);
            session()->put('sessionMessage', "");
            session()->put('albumId', $albumId);
            return $view;
        }
        else
        {
            if (session()->has('albumId'))
                session()->remove('albumId');
            return redirect('beforeLogin');
        }
    }
    public function createAlbum()
    {
        $albumName = request('albumName');
        $imageFilename = request('imageFilename');
        $album = new Album();
        $album->setAttribute('name', $albumName);
        $album->setAttribute('createdAt', Carbon::now());
        $album->save();
        $user = session()->get('loggedUser', [User::class]);
        $author = AuthorController::getAuthorById($user->getAttribute('authorId'));
        $album->authors()->save($author);
        $isSelectedImageFile = true;
        if ($_FILES["imageFilename"]["error"] == UPLOAD_ERR_OK)
        {
            $imageFile = request('imageFilename');
        }
        else
        {
            $isSelectedImageFile = false;
        }
        $relativePath = "public\\Files\\";
        if ($isSelectedImageFile)
        {
            $filename = $_FILES['imageFilename']['name'];
            Storage::disk('local')->put($relativePath . "Album" . $album->getAttribute('id') . "Image", $imageFile->getContent());
        }
        return redirect(route('beforeUpdateAlbum', ['albumId' =>  $album->getAttribute('id')]));
    }
    public function beforeSelectAlbum()
    {
        $authorId = request('authorId');
        $author = AuthorController::getAuthorById($authorId);
        $albums = $author->albums()->get();
        $view = view('albums', ['titleText' => "Správa albumov", 'hasManageAlbums' => false, 'albums' => $albums,
            'firstname' => $author->getAttribute('firstname'), 'lastname' => $author->getAttribute('lastname'),
            'imageFilename' => "Author" . $author->getAttribute('id') . "Image", 'authorId' => $authorId,
            'sessionMessage' => session()->has("sessionMessage") ? session()->get("sessionMessage") : ""]);
        session()->put('sessionMessage', "");
        return $view;
    }
    public function beforeSelectSong()
    {
        $albumId = request('albumId');
        $authorId = request('authorId');
        $author = AuthorController::getAuthorById($authorId);
        $album = Album::all()->where('id', '=', $albumId)->first();
        $albumImageFilename = "Album" . $album->getAttribute('id') . "Image";
        $view = view('album', ['titleText' => "Správa albumu", 'hasManageAlbum' => false, 'songs' => null,
            'firstname' => $author->getAttribute('firstname'), 'lastname' => $author->getAttribute('lastname'),
            'imageFilename' => "Author" . $author->getAttribute('id') . "Image", 'album' => $album, 'albumImageFilename' => $albumImageFilename,
            'editExist' => true, 'songs' => $album->songs()->get(), 'authorId' => $authorId,
            'sessionMessage' => session()->has("sessionMessage") ? session()->get("sessionMessage") : ""]);
        session()->put('sessionMessage', "");
        session()->put('albumId', $albumId);
        return $view;
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

}

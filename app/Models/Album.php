<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $appends = ['authorNames', 'imageFilename', 'numberSongs', 'genre', 'length', 'size'];
    public function __construct(array $attributes = [])
    {
        $this->timestamps = false;
        parent::__construct($attributes);
    }
    public function authors(): \Illuminate\Database\Eloquent\Relations\MorphToMany
    {
        return $this->morphToMany(Author::class, 'authorable');
    }
    public function songs(): \Illuminate\Database\Eloquent\Relations\MorphToMany
    {
        return $this->morphedByMany( Song::class, 'albumable');
    }
    public function getAuthorNames() : string
    {
        $authorNames = "";
        $start = true;
        foreach ($this->authors()->get() as $author)
        {
            if ($start)
            {
                $start= false;
            }
            else
            {
                $authorNames .= ', ';
            }
            $authorNames .= $author->getAttribute('firstname') . ' ' . $author->getAttribute('lastname');
        }
        return $authorNames;
    }
    public function getImageFilename(): string
    {
        return "Album" . $this->getAttribute('id') . "Image";
    }
    public function getNumberSongs() : int
    {
        return $this->songs()->get()->count();
    }
    public function getGenre(): string
    {
        $genres = "";
        $start = true;
        foreach ($this->songs()->get() as $song)
        {
            if ($start)
            {
                $start= false;
            }
            else
            {
                $genres .= ', ';
            }
            $genres .= $song->getAttribute('genre');
        }
        return $genres;
    }
    public function getLength()
    {
        $time = new Carbon();
        $time->setSeconds(0);
        $time->minutes(0);
        $time->setHours(0);
        $sumSeconds = 0;

        $hours = floor($sumSeconds/3600);
        $minutes = floor(($sumSeconds % 3600)/60);
        $seconds = (($sumSeconds%3600)%60);


        foreach ($this->songs()->get() as $song)
        {
            $explodedTime = explode(':', $song->getAttribute('length'));
            $seconds = $explodedTime[0]*3600+$explodedTime[1]*60+$explodedTime[2];
            $time->addSecond($seconds);
        }
        return $time->format('H:i:s');
    }
    public function getSize() : int
    {
        $size = 0;
        foreach ($this->songs()->get() as $song)
        {
            $size += $song->getAttribute('size');
        }
        return $size / 1000000;
    }
    use HasFactory;
}

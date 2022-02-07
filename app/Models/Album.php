<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $appends = ['authorNames', 'numberSongs', 'genre', 'length', 'size'];
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
        $length = 0;
        foreach ($this->songs()->get() as $song)
        {
            $length += $song->getAttribute('length');
        }
        return $length;
    }
    public function getSize() : int
    {
        $size = 0;
        foreach ($this->songs()->get() as $song)
        {
            $size += $song->getAttribute('size');
        }
        return $size;
    }
    use HasFactory;
}

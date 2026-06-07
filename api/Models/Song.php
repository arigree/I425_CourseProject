<?php
/**
 * Author: Benjamin Egger-Torke
 * Date: 6/1/26
 * File: Song.php
 * Description:
 **/
//also mostly working from practice
namespace MusicAPI\Models;
use Illuminate\Database\Eloquent\Model;

class Song extends Model{
    //table associated with model
    protected $table = 'song';
    //table's primary key
    protected $primaryKey = 'songID';
    //if release date and add date don't match
    public $timestamps = false;
    //pk is int, still specify
    protected $keyType = 'int';
    //table is numeric, does increment
    public $incrementing = true;

    public static function getSong() {
        return self::all();

    }
    //View a specific song by id
    public static function getSongById(int $id) {
        return self::findOrFail($id);
    }

    //create a song
    public static function createSong($request) {
        $params = $request ->getParsedBody();
        $song = new Song();

        foreach ($params as $field => $value) {
            $song->$field = $value;

        }
        $song -> save();
        return $song;
    }

    //Update an Song
    public static function updateSong($request) {
        $params = $request->getParsedBody();
        $id = $request->getAttribute('id');
        $song = self::findOrFail($id);
        if(!$song) {
            return false;
        }

        foreach($params as $field => $value) {
            $song->$field = $value;
        }

        $song->save();
        return $song;
    }

    public function artists(){
        return $this->belongsToMany(Artist::class, 'artist_song', 'songID', 'artistID');
    }
}
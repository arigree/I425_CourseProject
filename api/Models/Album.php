<?php
/**
 * Author: Benjamin Egger-Torke
 * Date: 6/1/26
 * File: Album.php
 * Description:
 **/
namespace MusicAPI\Models;
use Illuminate\Database\Eloquent\Model;

class Album extends Model{
    //table associated with model
    protected $table = 'album';
    //table's primary key
    protected $primaryKey = 'albumID';
    //if release date and add date don't match
    public $timestamps = false;
    //pk is int, still specify
    protected $keyType = 'int';
    //table is numeric, does increment
    public $incrementing = true;

    public static function getAlbum() {
        return self::all();

    }
    //View a specific album by id
    public static function getAlbumById(int $id) {
        return self::findOrFail($id); //?

    }

    public static function createAlbum($request) {
        $params = $request ->getParsedBody();
        $album = new Album();

        foreach ($params as $field => $value) {
            $album->$field = $value;

        }
        $album -> save();
        return $album;
    }

    //Update an album
    public static function updateAlbum($request) {
        $params = $request->getParsedBody();
        $id = $request->getAttribute('id');
        $album = self::findOrFail($id);
        if(!$album) {
            return false;
        }

        foreach($params as $field => $value) {
            $album->$field = $value;
        }

        $album->save();
        return $album;
    }

    public function artist(){
        return $this->belongsTo(Artist::class, 'artistID', 'artistID');
    }
}
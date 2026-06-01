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
    protected $table = 'song';
    //table's primary key
    protected $primaryKey = 'id';
    //if release date and add date don't match
    public $timestamps = false;
    //pk is int, still specify
    protected $keyType = 'int';
    //table is numeric, does increment
    public $incrementing = true;

    public static function getAlbum() {
        $song = self::all();
        return $song;
    }
    //View a specific professor by id
    public static function getAlbumById(int $id) {
        $song = self::findOrFail($id); //?
        return $song;
    }
}
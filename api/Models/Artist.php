<?php
/**
 * Author: Jonathan Nguyen
 * Date: 5/31/2026
 * File: Artist.php
 * Description:
 */

//mostly copied from practice, just changed names and made sure the primary key was numbers
namespace MusicAPI\Models;
use Illuminate\Database\Eloquent\Model;
class Artist extends Model{

//The table associated with this model
    protected $table = 'artist';
//The primary key of the table
    protected $primaryKey = 'artistID';
//The PK is numeric
    public $incrementing = true;

    protected $keyType = 'int';
//If the created_at and updated_at columns are not used
    public $timestamps = false;


    //Retrieve all artists
    public static function getArtist() {
        $artist = self::all();
        return $artist;
    }

    //View a specific artist by id
    public static function getArtistById(int $id) {
        $artist = self::findOrFail($id); //?
        return $artist;
    }

    //create a new student
    public static function createArtist($request) {
        $params = $request ->getParsedBody();
        $artist = new Artist();

        foreach ($params as $field => $value) {
            $artist->$field = $value;

        }
        $artist -> save();
        return $artist;
    }

    //delete an artist
    public static function deleteArtist($request) {
        $id = $request ->getAttribute('id');            //attribute vs parsedbody?
        $artist = self::findOrFail($id);
        return($artist ? $artist->delete() : $artist);
    }

    //Update an artist
    public static function updateArtist($request) {
        $params = $request->getParsedBody();
        $id = $request->getAttribute('id');
        $artist = self::findOrFail($id);
        if(!$artist) {
            return false;
        }

        foreach($params as $field => $value) {
            $artist->$field = $value;
        }

        $artist->save();
        return $artist;
    }













    //relationship functions
    public function songs(){
        return $this->belongsToMany(Song::class, 'artist-song', 'artistID', 'songID');
    }

    //add the one to many function
    public function albums(){
        return $this->hasMany(Album::class, 'artistID', 'artistID',);
    }
}
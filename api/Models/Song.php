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

    public static function getSong($request) {
        //return self::all();
        //get the total number of row count
        $count = self::count();

        //Get querystring variables from url
        $params = $request->getQueryParams();

        //do limit and offset exist?
        $limit = array_key_exists('limit', $params) ? (int)$params['limit'] : 10;   //items per page
        $offset = array_key_exists('offset', $params) ? (int)$params['offset'] : 0;  //offset of the first item

        //pagination
        $links = self::getLinks($request, $limit, $offset);

        //build query
        $query = self::with('artist');  //build the query to get all courses
        $query = $query->skip($offset)->take($limit);  //limit the rows

        //code for sorting
        $sort_key_array = self::getSortKeys($request);
        //soft the output by one or more columns
        foreach ($sort_key_array as $column => $direction) {
            $query->orderBy($column, $direction);
        }

        //retrieve the courses
        $song = $query->get();  //Finally, run the query and get the results

        //construct the data for response
        $results = [
            'totalCount' => $count,
            'limit' => $limit,
            'offset' => $offset,
            'links' => $links,
            'sort' => $sort_key_array,
            'data' => $song
        ];

        return $results;

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

    // Delete a song
    public static function deleteSong($request) {
        $id = $request->getAttribute('id');
        $song = self::findOrFail($id);
        return ($song ? $song->delete() : $song);
    }

    // Search for songs
    public static function searchSongs($term) {
        if (is_numeric($term)) {
            $query = self::where('songID', '=', $term)
                ->orWhere('plays', '>=', $term)
                ->orWhere('genreID', '=', $term)
                ->orWhere('albumID', '=', $term);
        } else {
            $query = self::where('songID', 'like', "%$term%")
                ->orWhere('songTitle', 'like', "%$term%")
                ->orWhere('duration', 'like', "%$term%")
                ->orWhere('releaseDate', 'like', "%$term%")
                ->orWhere('plays', 'like', "%$term%")
                ->orWhere('genreID', 'like', "%$term%")
                ->orWhere('albumID', 'like', "%$term%");
        }

        return $query->with('artist')->get();
    }

    public function artist(){
        return $this->belongsToMany(Artist::class, 'artist_song', 'songID', 'artistID');
    }
    // Return an array of links for pagination. The array includes links for the current, first, next, and last pages.
    private static function getLinks($request, $limit, $offset) {
        $count = self::count();

        // Get request uri and parts
        $uri = $request->getUri();
        if($port = $uri->getPort()) {
            $port = ':' . $port;
        }
        $base_url = $uri->getScheme() . "://" . $uri->getHost() . $port . $uri->getPath();

        // Construct links for pagination
        $links = [];
        $links[] = ['rel' => 'self', 'href' => "$base_url?limit=$limit&offset=$offset"];
        $links[] = ['rel' => 'first', 'href' => "$base_url?limit=$limit&offset=0"];
        if ($offset - $limit >= 0) {
            $links[] = ['rel' => 'prev', 'href' => "$base_url?limit=$limit&offset=" . $offset - $limit];
        }
        if ($offset + $limit < $count) {
            $links[] = ['rel' => 'next', 'href' => "$base_url?limit=$limit&offset=" . $offset + $limit];
        }
        $links[] = ['rel' => 'last', 'href' => "$base_url?limit=$limit&offset=" . $limit * (ceil($count / $limit) - 1)];

        return $links;
    }
    /*
     * Sort keys are optionally enclosed in [ ], separated with commas;
     * Sort directions can be optionally appended to each sort key, separated by :.
     * Sort directions can be 'asc' or 'desc' and defaults to 'asc'.
     * Examples: sort=[number:asc,title:desc], sort=[number, title:desc]
     * This function retrieves sorting keys from uri and returns an array.
    */
    private static function getSortKeys($request) {
        $sort_key_array = [];

        // Get querystring variables from url
        $params = $request->getQueryParams();

        if (array_key_exists('sort', $params)) {
            $sort = preg_replace('/^\[|]$|\s+/', '', $params['sort']);  // remove white spaces, [, and ]
            $sort_keys = explode(',', $sort); //get all the key:direction pairs
            foreach ($sort_keys as $sort_key) {
                $direction = 'asc';
                $column = $sort_key;
                if (strpos($sort_key, ':')) {
                    list($column, $direction) = explode(':', $sort_key);
                }
                $sort_key_array[$column] = $direction;
            }
        }

        return $sort_key_array;
    }
}
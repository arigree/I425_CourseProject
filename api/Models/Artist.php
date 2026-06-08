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
    public static function getArtist($request) {
        //$artist = self::all();
        //return $artist;
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
        $query = self::with('song', 'album');  //build the query to get all courses
        $query = $query->skip($offset)->take($limit);  //limit the rows

        //code for sorting
        $sort_key_array = self::getSortKeys($request);
        //soft the output by one or more columns
        foreach ($sort_key_array as $column => $direction) {
            $query->orderBy($column, $direction);
        }

        //retrieve the courses
        $artist = $query->get();  //Finally, run the query and get the results

        //construct the data for response
        $results = [
            'totalCount' => $count,
            'limit' => $limit,
            'offset' => $offset,
            'links' => $links,
            'sort' => $sort_key_array,
            'data' => $artist
        ];

        return $results;
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
    public function song(){
        return $this->belongsToMany(Song::class, 'artist-song', 'artistID', 'songID');
    }

    //add the one to many function
    public function album(){
        return $this->hasMany(Album::class, 'artistID', 'artistID',);
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
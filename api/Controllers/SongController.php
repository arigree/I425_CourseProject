<?php
/**
 * Author: Benjamin Egger-Torke
 * Date: 6/1/26
 * File: SongController.php
 * Description:
 **/
namespace MusicAPI\Controllers;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use MusicAPI\Models\Song;
use MusicAPI\Controllers\ControllerHelper as Helper;
use MusicAPI\Validation\Validator;

class SongController {
    //get all artists
    public function index(Request $request, Response $response, array $args) : Response {
        $params = $request->getQueryParams();
        $term = array_key_exists('q', $params) ? $params['q'] : "";

        $results = ($term) ? Song::searchSongs($term) : Song::getSong($request);

        return Helper::withJson($response, $results, 200);
    }
    //view a specific artist
    public function view(Request $request, Response $response, array $args) : Response {
        $id = $args['id'];
        $results = Song::getSongById($id);
        return Helper::withJson($response, $results, 200);
    }

    //adding relationship method
    public function artist(Request $request, Response $response, array $args) : Response {
        $song = Song::findOrFail($args['id']);
        return Helper::withJson($response, ['data' => $song->artist], 200);
    }

    public function create(Request $request, Response $response, array $args) : Response {
        $validation = Validator::validateSong($request);
        if(!$validation) {
            $results = [
                'status' => "Validation failed",
                'errors' => Validator::getErrors()
            ];
            return Helper::withJson($response, $results, 500);
        }

        $song = Song::createSong($request);
        if (!$song) {
            $results['status'] = 'Song cannot be created.';
            return Helper::withJson($response, $results, 500);
        }
        $results = [
            'status' => 'success',
            'data' => $song
        ];
        return Helper::withJson($response, $results, 200);
    }

    //update a song
    public function update(Request $request, Response $response, array $args) : Response
    {
        $validation = Validator::validateSong($request);
        if (!$validation) {
            $results = [
                'status' => "Validation failed",
                'errors' => Validator::getErrors()
            ];
            return Helper::withJson($response, $results, 500);
        }
        $song = Song::updateSong($request);
        if (!$song) {
            $results['status'] = "song cannot been updated.";
            return Helper::withJson($response, $results, 500);
        }
        $results = [
            'status' => "Song has been updated.",
            'data' => $song
        ];
        return Helper::withJson($response, $results, 200);
    }

}
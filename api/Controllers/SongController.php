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

class SongController {
    //get all artists
    public function index(Request $request, Response $response, array $args) : Response {
        $results = Song::getSong($request);
        return Helper::withJson($response, $results, 200);
    }
    //view a specific artist
    public function view(Request $request, Response $response, array $args) : Response {
        $id = $args['id'];
        $results = Song::getSongById($id);
        return Helper::withJson($response, $results, 200);
    }
}
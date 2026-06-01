<?php
/**
 * Author: Jonathan Nguyen
 * Date: 5/31/2026
 * File: ArtistController.php
 * Description:
 */

namespace MusicAPI\Controllers;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use MusicAPI\Models\Artist;
use MusicAPI\Controllers\ControllerHelper as Helper;


//can copy this for listing and finding songs, genres, labels, and albums? im prettu sure this is enough to turn in lmao
class ArtistController {
    //list all artists
    public function index(Request $request, Response $response, array $args) : Response {
        $results = Artist::getArtist();
        return Helper::withJson($response, $results, 200);
    }

    //view a specific artist
    public function view(Request $request, Response $response, array $args) : Response {
        $id = $args['id'];
        $results = Artist::getArtistById($id);
        return Helper::withJson($response, $results, 200);
    }

}
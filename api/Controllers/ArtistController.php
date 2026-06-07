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
use MusicAPI\Validation\Validator;

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

    //create an artist
    public function create(Request $request, Response $response, array $args) : Response {
        $validation = Validator::validateArtist($request);
        if(!$validation) {
            $results = [
                'status' => "Validation failed",
                'errors' => Validator::getErrors()
            ];
            return Helper::withJson($response, $results, 500);
        }

        $artist = Artist::createArtist($request);
        if (!$artist) {
            $results['status'] = 'Artist cannot be created.';
            return Helper::withJson($response, $results, 500);
        }
        $results = [
            'status' => 'success',
            'data' => $artist
        ];
        return Helper::withJson($response, $results, 200);
    }

    //Delte an artist
    public function delete(Request $request, Response $response, array $args) : Response {
        $artist = Artist::deleteArtist($request);
        if (!$artist) {
            $results['status'] = 'Artist cannot be deleted.';
            return Helper::withJson($response, $results, 500);
        }
        $results['status'] = 'Artist has been deleted';
        return Helper::withJson($response, $results, 200);
    }

    //update an artist
    public function update(Request $request, Response $response, array $args) : Response
    {
        $validation = Validator::validateArtist($request);
        if (!$validation) {
            $results = [
                'status' => "Validation failed",
                'errors' => Validator::getErrors()
            ];
            return Helper::withJson($response, $results, 500);
        }
        $artist = Artist::updateArtist($request);
        if (!$artist) {
            $results['status'] = "artist cannot been updated.";
            return Helper::withJson($response, $results, 500);
        }
        $results = [
            'status' => "Artist has been updated.",
            'data' => $artist
        ];
        return Helper::withJson($response, $results, 200);
    }


    //adding relationship method
    public function albums(Request $request, Response $response, array $args) : Response {
        $artist = Artist::findOrFail($args['id']);
        return Helper::withJson($response, ['data' => $artist->albums], 200);
    }

    public function songs(Request $request, Response $response, array $args) : Response{
        $artist = Artist::findOrFail($args['id']);
        return Helper::withJson($response, ['data' => $artist->songs], 200);
    }
}
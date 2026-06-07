<?php
/**
 * Author: Benjamin Egger-Torke
 * Date: 6/1/26
 * File: AlbumController.php
 * Description:
 **/
namespace MusicAPI\Controllers;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use MusicAPI\Models\Album;
use MusicAPI\Controllers\ControllerHelper as Helper;
use MusicAPI\Validation\Validator;

class AlbumController {
    //get all artists
    public function index(Request $request, Response $response, array $args) : Response {
        $results = Album::getAlbum();
        return Helper::withJson($response, $results, 200);
    }
    //view a specific artist
    public function view(Request $request, Response $response, array $args) : Response {
        $id = $args['id'];
        $results = Album::getAlbumById($id);
        return Helper::withJson($response, $results, 200);
    }

    public function create(Request $request, Response $response, array $args) : Response {
        $validation = Validator::validateAlbum($request);
        if(!$validation) {
            $results = [
                'status' => "Validation failed",
                'errors' => Validator::getErrors()
            ];
            return Helper::withJson($response, $results, 500);
        }

        $album = Album::createAlbum($request);
        if (!$album) {
            $results['status'] = 'A;bum cannot be created.';
            return Helper::withJson($response, $results, 500);
        }
        $results = [
            'status' => 'success',
            'data' => $album
        ];
        return Helper::withJson($response, $results, 200);
    }

    //update an albyum
    public function update(Request $request, Response $response, array $args) : Response
    {
        $validation = Validator::validateAlbum($request);
        if (!$validation) {
            $results = [
                'status' => "Validation failed",
                'errors' => Validator::getErrors()
            ];
            return Helper::withJson($response, $results, 500);
        }
        $album = Album::updateAlbum($request);
        if (!$album) {
            $results['status'] = "album cannot been updated.";
            return Helper::withJson($response, $results, 500);
        }
        $results = [
            'status' => "Album has been updated.",
            'data' => $album
        ];
        return Helper::withJson($response, $results, 200);
    }


}
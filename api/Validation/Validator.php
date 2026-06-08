<?php
/**
 * Author: Jonathan Nguyen
 * Date: 6/7/2026
 * File: Validator.php
 * Description:
 */

namespace MusicAPI\Validation;
use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;

class Validator {
    private static array $errors = [];
//Return the errors in an array
    public static function getErrors() : array {
        return self::$errors;
    }

    // A generic validation method. it returns true on success or false on failed validation.
    public static function validate($request, array $rules) : bool {
        foreach ($rules as $field => $rule) {
            //Retrieve parameters from URL or the request body
            $param = $request->getAttribute($field) ?? $request->getParsedBody()[$field];
            try{
                $rule->setName($field)->assert($param);
            } catch (NestedValidationException $ex) {
                self::$errors[$field] = $ex->getFullMessage();
            }
        }
        // Return true or false; "false" means a failed validation.
        return empty(self::$errors);
    }

    //Validate data
    public static function validateArtist($request) : bool {
        //Define all the validation rules
        $rules = [
        //'artistID' => v::notEmpty()->intType(),                     Autoincrement
            'artistName' => v::stringType()->notEmpty(),
            'artistDescription' => v::stringType()->notEmpty(),
            'joinDate' => v::date('Y-m-d'),
        ];

        return self::validate($request, $rules);
    }
    public static function validateAlbum($request) : bool {
        //Define all the validation rules
        $rules = [
            //'artistID' => v::notEmpty()->intType(),
            'albumTitle' => v::stringType()->notEmpty(),
            'releaseDate' => v::date('Y-m-d'),
            'artistID' => v::intType()->notEmpty(),
            'labelID' => v::intType()->notEmpty(),
        ];

        return self::validate($request, $rules);
    }
    public static function validateSong($request) : bool {
        //Define all the validation rules
        $rules = [
            //'artistID' => v::notEmpty()->intType(),
            'songTitle' => v::stringType()->notEmpty(),
            'duration' => v::time('H:i:s'),
            'releaseDate' => v::date('Y-m-d'),
            'plays' => v::intVal()->notEmpty(),
            'genreID' => v::intVal()->notEmpty(),
            //'albumID' => v::intVal()->notEmpty(),                       I don't think we need this
        ];

        return self::validate($request, $rules);
    }






}
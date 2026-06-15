<?php
/**
 * Author: Jonathan Nguyen
 * Date: 6/15/2026
 * File: User.php
 * Description:
 */


namespace MusicAPI\Models;
use Illuminate\Database\Eloquent\Model;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
class User extends Model {
    // JWT settings
    const JWT_KEY = '6f4b9d3c2a1e8f7b6c5d4e3f2a1b0c9d6f4b9d3c2a1e8f7b6c5d4e3f2a1b0c9d';
    const JWT_EXPIRE = 3600;
//The table associated with this model. "users" is the default name.
    protected $table = 'users';
//The primary key of the table. "id" is the default name.
    protected $primaryKey = 'id';
//Is the PK an incrementing integer value? "True" is the default value.
    public $incrementing = true;
//The data type of the PK. "int" is the default value.
    protected $keyType = 'int';
//Do the created_at and updated_at columns exist in the table? "True" is the default value.
    public $timestamps = true;
//List all users
    public static function getUsers() {
        $users = self::all();
        return $users;
    }


    // View a specific user by id
    public static function getUserById(string $id)
    {
        $user = self::findOrFail($id);
        return $user;
    }

    // Create a new user
    public static function createUser($request)
    {
        // Retrieve parameters from request body
        $params = $request->getParsedBody();

        // Create a new User instance
        $user = new User();

        // Set the user's attributes
        foreach ($params as $field => $value) {
            $user->$field = ($field == "password") ? password_hash($value, PASSWORD_DEFAULT) : $value;
        }

        // Insert the user into the database
        $user->save();
        return $user;
    }

    // Update a user
    public static function updateUser($request)
    {
        // Retrieve parameters from request body
        $params = $request->getParsedBody();

        //Retrieve the user's id from url
        $id = $request->getAttribute('id');
        $user = self::findOrFail($id);

        if(!$user) {
            return false;
        }

        //update attributes of the user
        foreach($params as $field => $value) {
            $user->$field =  ($field == "password") ? password_hash($value, PASSWORD_DEFAULT) : $value;
        }

        // Update the user
        $user->save();
        return $user;
    }

    // Delete a user
    public static function deleteUser($request)
    {
        $user = self::findOrFail($request->getAttribute('id'));
        return ($user ? $user->delete() : $user);
    }

    //Authenticate usre
    public static function authenticateUser($username, $password) {
        $user =self::where('username', $username)->first();
        if(!$user) {
            return false;
        }
        return password_verify($password, $user->password) ? $user : false;
    }

    public static function generateJWT($id)
    {
        $user = self::findOrFail($id);
        $payload = [
            'iat' => time(),
            'exp' => time() + self::JWT_EXPIRE,
            'data' =>[
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'role' => $user->role
                ]
            ];
            return JWT::encode($payload, self::JWT_KEY, 'HS256');
        }
        public static function validateJWT($jwt)
        {
            try{
                return JWT::decode($jwt, new Key(self::JWT_KEY, 'HS256'));

            } catch (\Exception $e){
                return false;
            }
        }
}
<?php
/**
 * Author: Jonathan Nguyen
 * Date: 5/31/2026
 * File: dependencies.php
 * Description:
 */
use DI\Container;
use MusicAPI\Controllers\ArtistController;
use MusicAPI\Controllers\SongController;
use MusicAPI\Controllers\AlbumController;

return function(Container $container) {
// Make artist dependency
        $container->set('Artist', function() {
            return new ArtistController();
        });
        $container->set('Song', function() {
            return new SongController();
        });
        $container->set('Album', function() {
            return new AlbumController();
        });
        $container->set('ArtistController', function() {
            return new ArtistController();
        });
        $container->set('SongController', function() {
            return new SongController();
        });
        $container->set('AlbumController', function() {
            return new AlbumController();
        });
    };
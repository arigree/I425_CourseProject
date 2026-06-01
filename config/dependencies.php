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

return function(Container $container) {
// Make artist dependency
        $container->set('Artist', function() {
            return new ArtistController();
        });
        $container->set('Song', function() {
            return new SongController();
        });
        $container->set('ArtistController', function() {
            return new ArtistController();
        });
    };
<?php
/**
 * Author: Jonathan Nguyen
 * Date: 5/31/2026
 * File: dependencies.php
 * Description:
 */
use DI\Container;
use MusicAPI\Controllers\ArtistController;
    return function(Container $container) {
// Make artist dependency
        $container->set('Artist', function() {
            return new ArtistController();
        });
    };
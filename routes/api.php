<?php

Flight::route('/api/hello/@name', function($name) {
    echo 'hello ' . $name;
});	

Flight::route('/api/hello/*', function() {
    echo 'hello all';
});	

Flight::route('POST /api/post', function() {
    $data = Flight::request()->query['name'];
    Flight::json($data);
});	

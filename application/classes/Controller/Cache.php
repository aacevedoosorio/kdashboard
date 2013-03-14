<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cache extends Kohana_Controller {

    public function index()
    {
        echo("In Cache Controller");
    }

    public function clear(){
        Cache::instance('default')->delete_all();
        echo("Cache cleared");
    }
} // End Cache

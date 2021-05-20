<?php

if(!function_exists('test_path')) {
    function test_path($path = '') : string
    {
        return app()->basePath() . DIRECTORY_SEPARATOR . 'tests' . DIRECTORY_SEPARATOR . $path;
    }
}

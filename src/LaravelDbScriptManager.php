<?php

namespace Karlerss\LaravelDbScriptManager;

class LaravelDbScriptManager
{
    public static function getScriptsPath()
    {
        return app()->databasePath() . DIRECTORY_SEPARATOR . 'scripts';
    }
}
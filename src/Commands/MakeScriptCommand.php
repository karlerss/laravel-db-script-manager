<?php

namespace Karlerss\LaravelDbScriptManager\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Composer;
use Illuminate\Database\Migrations\MigrationCreator;

class MakeScriptCommand extends Command
{
    protected $signature = 'make:db-script {name}';

    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $fs;

    public function __construct(\Illuminate\Filesystem\Filesystem $fs)
    {
        $this->fs = $fs;
        parent::__construct();
    }

    public function handle()
    {
        $dir = $this->laravel->databasePath() . DIRECTORY_SEPARATOR . 'scripts';
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        (new MigrationCreator($this->fs, $this->laravel->basePath('stubs')))
            ->create($this->argument('name'), $dir);
    }
}

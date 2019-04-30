<?php


namespace Karlerss\LaravelDbScriptManager\Commands;


use Illuminate\Console\Command;
use Illuminate\Database\Migrations\MigrationCreator;
use Illuminate\Support\Composer;

class MakeScriptCommand extends Command
{
    protected $signature = 'make:db-script {name}';

    /**
     * @var MigrationCreator
     */
    protected $creator;

    /**
     * @var Composer
     */
    protected $composer;

    public function __construct(MigrationCreator $creator, Composer $composer)
    {
        $this->creator = $creator;
        $this->composer = $composer;
        parent::__construct();
    }

    public function handle()
    {
        $dir = $this->laravel->databasePath() . DIRECTORY_SEPARATOR . 'scripts';
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        $this->creator->create($this->argument('name'), $dir);
    }
}
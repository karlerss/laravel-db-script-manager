<?php


namespace Karlerss\LaravelDbScriptManager\Commands;


use Illuminate\Database\Console\Migrations\MigrateCommand as BaseMigrateCommand;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Migrations\Migrator;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Karlerss\LaravelDbScriptManager\LaravelDbScriptManager;

class MigrateCommand extends BaseMigrateCommand
{
    /**
     * @var Filesystem
     */
    protected $files;

    public function __construct(Migrator $migrator)
    {
        $this->files = app(Filesystem::class);

        $this->description = $this->description . '. Also migrates scripts.';
        parent::__construct($migrator);
    }

    public function handle()
    {
        $this->scriptsDown();

        parent::handle();

        $this->scriptsUp();
    }

    /**
     * Runs up() for all scripts
     */
    protected function scriptsUp(): void
    {
        $this->getScriptInstances()
            ->map(function (Migration $migration, $name) {
                $migration->up();
                $this->line("Script up: $name");
            });
    }

    /**
     * Runs down() for all scripts
     */
    protected function scriptsDown(): void
    {
        $this->getScriptInstances()
            ->reverse()
            ->map(function (Migration $migration, $name) {
                $migration->down();
                $this->line("Script down: $name");
            });
    }

    /**
     * Gets all db script instances
     *
     * @return Collection
     */
    protected function getScriptInstances(): Collection
    {
        return collect($this->migrator->getMigrationFiles([LaravelDbScriptManager::getScriptsPath()]))
            ->each(function (string $file) {
                $this->files->requireOnce($file);
            })->mapWithKeys(function (string $file, string $name) {
                return [$name => $this->migrator->resolve($name)];
            });
    }
}
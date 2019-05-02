<?php

namespace Karlerss\LaravelDbScriptManager\Tests;

use Illuminate\Filesystem\Filesystem;
use Karlerss\LaravelDbScriptManager\LaravelDbScriptManagerServiceProvider;
use \Orchestra\Testbench\TestCase;

class DbScriptManagerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
//        $classes = get_declared_classes();
//        sort($classes);
//        dd($classes);
        /** @var Filesystem $fs */
        $fs = app(Filesystem::class);
        try {
            $files = $fs->files($this->getScriptsDir());
        } catch (\Exception $e) {
            return;
        }
        foreach ($files as $file) {
            $fs->delete($file->getRealPath());
        }
    }

    /**
     * @test
     */
    public function it_can_create_scripts()
    {
        /** @var Filesystem $fs */
        $fs = app(Filesystem::class);

        $scriptsDir = $this->getScriptsDir();

        $this->artisan('make:db-script quick_test');
        $splFileInfos = $fs->files($scriptsDir);
        $this->assertCount(1, $splFileInfos);
        $this->assertContains('QuickTest', $splFileInfos[0]->getContents());
    }

    /**
     * @test
     */
    public function it_takes_scripts_down_and_recreates()
    {
        $this->loadLaravelMigrations();
        /** @var Filesystem $fs */
        $fs = app(Filesystem::class);
        $fs->copy(
            __DIR__ . '/scripts/2019_01_01_123456_create_active_users_view.stub',
            $this->getScriptsDir() . DIRECTORY_SEPARATOR . '2019_01_01_123456_create_active_users_view.php'
        );

        $res = $this->artisan('migrate', ['--path' => 'migrations'])->execute();
        \DB::table('users')->insert([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('pass'),
        ]);

        $this->assertCount(1, \DB::table('users')->get());
        $this->assertEquals('Test Usertest@example.com', \DB::table('active_users')->get()[0]->calculated_name);
    }

    protected function getPackageProviders($app)
    {
        return [LaravelDbScriptManagerServiceProvider::class];
    }

    /**
     * @return string
     */
    private function getScriptsDir(): string
    {
        return app()->databasePath() . DIRECTORY_SEPARATOR . 'scripts';
    }
}
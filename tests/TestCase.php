<?php

namespace SanSanLabs\MicrosoftGraph\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use SanSanLabs\MicrosoftGraph\MicrosoftGraphServiceProvider;

class TestCase extends Orchestra {
  protected function setUp(): void {
    parent::setUp();

    Factory::guessFactoryNamesUsing(
      fn(string $modelName) => "SanSanLabs\\MicrosoftGraph\\Database\\Factories\\" . class_basename($modelName) . "Factory",
    );
  }

  protected function getPackageProviders($app) {
    return [MicrosoftGraphServiceProvider::class];
  }

  public function getEnvironmentSetUp($app) {
    config()->set("database.default", "testing");

    /*
             foreach (\Illuminate\Support\Facades\File::allFiles(__DIR__ . '/database/migrations') as $migration) {
                (include $migration->getRealPath())->up();
             }
             */
  }
}

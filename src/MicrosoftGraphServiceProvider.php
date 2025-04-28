<?php

namespace SanSanLabs\MicrosoftGraph;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class MicrosoftGraphServiceProvider extends PackageServiceProvider {
  public function configurePackage(Package $package): void {
    /*
     * This class is a Package Service Provider
     *
     * More info: https://github.com/spatie/laravel-package-tools
     */
    $package->name("laravel-microsoft-graph")->hasConfigFile("microsoft-graph");
  }
}

<?php

namespace App\ADR\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class ADRProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $commandClasses = [];

        foreach (File::allFiles(__DIR__ . '/../Commands') as $file) {
            $class = 'App\\ADR\\Commands\\' . $file->getFilenameWithoutExtension();
            if (class_exists($class)) {
                $commandClasses[] = $class;
            }
        }

        $this->commands($commandClasses);
    }
}

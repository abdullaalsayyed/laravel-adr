<?php

namespace App\Console\Commands;

namespace App\ADR\Commands;

use ReflectionClass;
use Illuminate\Console\Command;
use App\ADR\Contracts\ADRAction;
use Illuminate\Support\Facades\File;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Put;
use Spatie\RouteAttributes\Attributes\Delete;

class ValidateActionRoutes extends Command
{
    protected $signature = 'adr:validate:actions';
    protected $description = 'Validate that each Action has a route attribute';

    public function handle(): int
    {
        $actionFiles = File::allFiles(app_path('Modules/*/Actions/*/'));
        $missingAttributes = [];

        foreach ($actionFiles as $file) {
            $className = 'App\\Modules\\Users\\Actions\\V1\\' . str_replace('.php', '', $file->getFilename());

            if (class_exists($className) && in_array(ADRAction::class, class_implements($className))) {
                $reflection = new ReflectionClass($className);
                $attributes = $reflection->getAttributes();

                $hasRouteAttribute = collect($attributes)->contains(function ($attribute) {
                    return in_array($attribute->getName(), [
                        Get::class,
                        Post::class,
                        Put::class,
                        Delete::class,
                    ]);
                });

                if (!$hasRouteAttribute) {
                    $missingAttributes[] = $className;
                }
            }
        }

        if (empty($missingAttributes)) {
            $this->info('All actions have route attributes.');
        } else {
            $this->error('The following actions are missing route attributes:');
            foreach ($missingAttributes as $className) {
                $this->line("- {$className}");
            }

            return 1;
        }

        return 0;
    }
}

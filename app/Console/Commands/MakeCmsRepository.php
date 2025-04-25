<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
class MakeCmsRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "make:cms-repository {type} {name} {module-name}";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "To create Repository inside cms core and local modules.";

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Retrieve command arguments
        $moduleName = $this->argument("module-name");
        $name = $this->argument("name");
        $type = $this->argument("type");

        // Define the base directory for the cms folder outside of `app`
        if ($type == "local") {
            $baseCmsPath = base_path(
                "cms/{$type}/theme1/{$moduleName}/Repositories"
            );
        } else {
            $baseCmsPath = base_path("cms/{$type}/{$moduleName}/Repositories");
        }

        // Check if the repository file already exists
        if (File::exists("{$baseCmsPath}/{$name}.php")) {
            $this->error(
                "Repository {$name} already exists in module {$moduleName} and type {$type}."
            );
            return;
        }

        // Create the directories if they do not exist
        if (!File::isDirectory($baseCmsPath)) {
            File::makeDirectory($baseCmsPath, 0755, true); // Use recursive directory creation
        }

        // Define the repository class template
        $template = <<<EOT
<?php

namespace cms\\{$type}\\{$moduleName}\Repositories;

class {$name}
{
    // Repository methods go here
}
EOT;

        // Create the repository file with the template
        File::put("{$baseCmsPath}/{$name}.php", $template);

        $this->info(
            "Repository {$name} created successfully in cms/{$type}/{$moduleName}/Repositories."
        );
    }
}

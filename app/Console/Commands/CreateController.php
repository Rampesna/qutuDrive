<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateController extends Command
{
    protected $signature = 'evren:controller {namespace} {controllerName}';

    protected $description = 'Generate a controller and request objects';

    public function handle()
    {
        $namespace = $this->argument('namespace');
        $controllerName = $this->argument('controllerName');

        // Controller Oluşturma
        $controllerPath = app_path("Http/Controllers/{$namespace}/{$controllerName}Controller.php");
        $this->createDirectoryIfNotExists(dirname($controllerPath));
        $this->generateController($controllerPath, $namespace, $controllerName);

        // Request Klasörü Oluşturma
        $requestFolderPath = app_path("Http/Requests/{$namespace}/{$controllerName}");
        $this->createDirectoryIfNotExists($requestFolderPath);

        // Request Nesneleri Oluşturma
        $requestClasses = ['GetByIdRequest', 'GetAllRequest', 'CreateRequest', 'DeleteRequest', 'UpdateRequest'];
        foreach ($requestClasses as $requestClass) {
            $requestPath = "{$requestFolderPath}/{$requestClass}.php";
            $this->generateRequest($requestPath, $namespace, $controllerName, $requestClass);
        }

        $this->info('Controller and request objects generated successfully!');
    }

    private function createDirectoryIfNotExists($path)
    {
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
            $this->info("Directory created: $path");
        }
    }

    private function generateController($path, $namespace, $controllerName)
    {
        $stub = <<<EOD
<?php

namespace App\Http\Controllers\\{$namespace};

use App\Core\Controller;

class {$controllerName}Controller extends Controller
{
    // Controller işlemleri buraya gelecek
}
EOD;

        File::put($path, $stub);
        $this->info("Controller created: $path");
    }

    private function generateRequest($path, $namespace, $controllerName, $requestClass)
    {
        $stub = <<<EOD
<?php

namespace App\Http\Requests\\{$namespace}\\{$controllerName};

use Illuminate\Foundation\Http\FormRequest;

class {$requestClass} extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            // Validation kuralları buraya gelecek
        ];
    }
}
EOD;

        File::put($path, $stub);
        $this->info("Request created: $path");
    }
}

<?php

namespace Facade\CodeEditor\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Response;

class Controller
{
    protected function ensureFileExistInProject(string $filePath)
    {
        abort_unless(file_exists($filePath), 404, 'Requested file does not exist.');

        $realPath = realpath($filePath);

        $realBasePath = realpath(base_path());

        abort_unless(Str::startsWith($realPath, $realBasePath), 404, 'Requested file was not found in the project.');
    }

    protected function ensureIsPhpFile(string $file, string $contents)
    {
        abort_unless(Str::endsWith($file, '.php'), Response::HTTP_UNPROCESSABLE_ENTITY, 'Requested file is not a PHP file.');

        if (Str::endsWith($file, '.blade.php')) {
            return;
        }

        abort_unless(Str::startsWith($contents, '<?php'), Response::HTTP_UNPROCESSABLE_ENTITY, 'Requested file does not start with `<?php`.');
    }
}

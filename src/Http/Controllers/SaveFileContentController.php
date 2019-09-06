<?php

namespace Facade\CodeEditor\Http\Controllers;

use Illuminate\Http\Response;
use Facade\CodeEditor\Http\Requests\FileContentsRequest;

class SaveFileContentController extends Controller
{
    public function __invoke(FileContentsRequest $request)
    {
        $file = $request->get('file');

        abort_unless($file, Response::HTTP_UNPROCESSABLE_ENTITY);

        $filePath = base_path($file);

        $this->ensureFileExistInProject($filePath);

        file_put_contents($filePath, rtrim($request->get('value')).PHP_EOL);

        return ['saved' => true];
    }
}

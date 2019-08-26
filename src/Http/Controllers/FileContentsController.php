<?php

namespace Facade\CodeEditor\Http\Controllers;

use Illuminate\Http\Response;
use Facade\CodeEditor\Http\Requests\FileContentsRequest;

class FileContentsController extends Controller
{
    public function __invoke(FileContentsRequest $request)
    {
        $file = $request->get('file');

        abort_unless($file, Response::HTTP_UNPROCESSABLE_ENTITY);

        $filePath = base_path($file);

        $this->ensureFileExistInProject($filePath);

        $contents = file_get_contents($filePath);

        $this->ensureIsPhpFile($file, $contents);

        $contents = explode("\n", $contents);

        array_unshift($contents, 'dummy');
        unset($contents[0]);

        return [
            'code_snippet' => $contents,
        ];
    }
}

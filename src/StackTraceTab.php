<?php

namespace Facade\CodeEditor;

use Facade\Ignition\Tabs\Tab;
use Facade\CodeEditor\Http\Controllers\FileContentsController;

class StackTraceTab extends Tab
{
    public function component(): string
    {
        return 'StackTab';
    }

    public function name(): string
    {
        return 'Stack trace';
    }

    public function registerAssets()
    {
        $this->script('ignition-code-editor', __DIR__.'/../build/js/tab.js');
    }

    public function meta(): array
    {
        return [
            'fileContentsEndpoint' => action([FileContentsController::class]),
        ];
    }
}

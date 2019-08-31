<?php

namespace Facade\CodeEditor;

use Facade\Ignition\Ignition;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Facade\CodeEditor\Http\Controllers\FileContentsController;
use Facade\CodeEditor\Http\Controllers\SaveFileContentController;

class CodeEditorServiceProvider extends ServiceProvider
{
    public function register()
    {
        if ($this->shouldRegisterFileContentsRoute()) {
            Route::prefix('ignition-code-editor')->group(function () {
                Route::get('file-contents', FileContentsController::class);
                Route::put('file-contents', SaveFileContentController::class);
            });
        }
    }

    public function boot()
    {
        Ignition::tab(new StackTraceTab);
    }

    protected function shouldRegisterFileContentsRoute(): bool
    {
        if (! $this->app->environment('local')) {
            return false;
        }

        if (! config('app.debug')) {
            return false;
        }

        return true;
    }
}

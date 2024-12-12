<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;

use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof HttpException) {
            $status = $exception->getStatusCode();

            if ($status == 403) {
                return auth()->check()
                    ? redirect()->route('error-403')
                    : redirect()->route('login');
            } elseif ($status == 404) {
                return auth()->check()
                    ? redirect()->route('error-404')
                    : redirect()->route('login');
            } elseif ($status == 500) {
                return auth()->check()
                    ? redirect()->route('error-500')
                    : redirect()->route('login');
            }
        }

        return parent::render($request, $exception);
    }


}

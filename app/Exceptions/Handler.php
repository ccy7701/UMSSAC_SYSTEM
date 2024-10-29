<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $exception
     * @return \Illuminate\Http\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception) {
        // Code 403: Forbidden access
        if ($exception instanceof AccessDeniedHttpException) {
            return response()->view('errors.403', [], 403);
        }

        // Code 404: Page not found
        if ($exception instanceof NotFoundHttpException) {
            return response()->view('errors.404', [], 404);
        }

        // Code 419: Page expired / CSRF token mismatch
        if ($exception instanceof TokenMismatchException) {
            return response()->view('errors.419', [], 419);
        }

        // Code 500: Internal server error
        if ($exception instanceof HttpException && $exception->getStatusCode() === 500) {
            return response()->view('errors.500', [], 500);
        }

        // Code 503: Service unavailable / maintenance
        if ($exception instanceof HttpException && $exception->getStatusCode() === 503) {
            return response()->view('errors.503', [], 503);
        }

        return parent::render($request, $exception);
    }
}

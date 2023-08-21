<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (AuthenticationException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'code'    => 401,
                    'message' => 'Not authenticated'
                ], 401);
            }
        });
    }

    public function render($request, \Throwable $e)
    {
        $message = match (true) {
            $e instanceof ResourceNotFoundException     => 'Resource not found, please check the api documentation',
            $e instanceof ModelNotFoundException        => 'Record not found',
            $e instanceof NotFoundHttpException         => 'Route not found, please check the api documentation',
            $e instanceof MethodNotAllowedHttpException => 'Method not allowed, please check the api documentation',
            default                                     => null,
        };

        if ($message) {
            $code = $e instanceof MethodNotAllowedHttpException ? 405 : 404;
            return response()->json([
                'code'    => $code,
                'message' => $message,
            ], $code);
        }

        return parent::render($request, $e);
    }
}

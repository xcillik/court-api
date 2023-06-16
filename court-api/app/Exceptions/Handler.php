<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
    public function register(): void {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (NotFoundHttpException $e, Request $request) {
            if ($request->is("api/*")) {
                return response()->json(["error" => "404 Not Found"], Response::HTTP_NOT_FOUND);
            }
        });
    }

    public function render($request, Throwable $e) {
        if ($e instanceof MethodNotAllowedHttpException)
            return response()->json(["error" => "405 Method Not Allowed"], Response::HTTP_METHOD_NOT_ALLOWED);
        
        if ($e instanceof AuthenticationException)
            return response()->json(["error" => "401 Unauthorized"], Response::HTTP_UNAUTHORIZED);
        
        return parent::render($request, $e);
    }
}

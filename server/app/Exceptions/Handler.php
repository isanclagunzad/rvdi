<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Log as Log;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {

        if ($exception instanceof TokenMismatchException) {
            return redirect()->back()->withError("The login form has expired, please try again");
        }

        Log::error($exception->getMessage(), [ get_class($exception), $exception->getTrace() ]);

        if(($exception instanceof QueryException) && $request->expectsJson()) {
            return response()->json([
                'error' => 'An error occurred. Please try again later'
            ], 422);
        }

        if($request->wantsJson() && $exception instanceof AuthorizationException) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 403);
        }


        if($request->wantsJson() && $exception instanceof ModelNotFoundException) {
            return response()->json([
                'message' => 'An error occurred. Please try again later.'
            ], 404);
        }

        if($request->wantsJson() && !$exception instanceof ValidationException) {
            return response()->json([
                'message' => empty($exception->getMessage()) ? 'An error occurred. Please try again later.' : $exception->getMessage()
            ], 404);
        }


        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => $exception->getMessage()], 401);
        }
        return redirect()->guest('login');
    }
}

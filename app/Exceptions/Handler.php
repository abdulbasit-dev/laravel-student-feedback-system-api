<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
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
        //for not object found exception
        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->wantsJson()) {
                return response()->json([
                    'result' => false,
                    'status' => Response::HTTP_NOT_FOUND,
                    "message" => "Object not found"
                ], 404);
            }
        });

        //user has no permisission exception
        $this->renderable(function (AccessDeniedHttpException $e, $request) {
            if ($request->wantsJson()) {
                return response()->json([
                    'result' => false,
                    'status' => Response::HTTP_FORBIDDEN,
                    'message' => "This action is unauthorized.",
                ], 403);
            }
        });
    }
}

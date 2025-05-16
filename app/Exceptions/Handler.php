<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
 /**
     * A list of the exception types that should not be reported.
     *
     * @var array<int, class-string<Throwable>>
     */
 protected $dontReport = [
 AuthenticationException::class,
 AuthorizationException::class,
 HttpException::class,
 ModelNotFoundException::class,
 TokenMismatchException::class,
 ValidationException::class,
 ];

 /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     */
 public function report(Throwable $exception): void
 {
 parent::report($exception);
 }

 /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Responsephp artisan
 public function render($request, Throwable $exception)
 {
 parent::render($request, $exception);
 }

 /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
 protected function unauthenticated($request, AuthenticationException $exception)
 {
 if ($request->expectsJson()) {
 return response()->json(['error' => 'Unauthenticated.'], 401);
 }

 return redirect()->guest(route('login'));
 }
}

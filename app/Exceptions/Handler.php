<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Route;
use App\Services\NotificationViaSlack\NotificationViaSlackServices;

class Handler extends ExceptionHandler
{
    use Notifiable;

    private $exceptionName = '';


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
        return parent::report($exception);
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
        $stringException = $exception->__toString();

        if (strpos($stringException,'ErrorException') == 0 &&
                strpos($stringException,'Undefined variable') == 16){
            $this->exceptionName = 'PhpError';
        }
        elseif(strpos($stringException,'ErrorException') == 0 &&
            strpos($stringException,'Undefined variable') != 16){
            $this->exceptionName = 'ViewError';
        }

        if (strpos($stringException,'PDOException') !== false) {
            $this->exceptionName = 'PhpError';
        }

        $is_slack = env('IS_SLACK', 0);
        if($is_slack == 1){
            $this->sendNotifySlack($exception);
        }

        $is_debug = env('IS_DEV', 0);
        if($is_debug == 1){
            return parent::render($request, $exception);
        }
		die('404');
		//
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
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('login'));
    }

    public function sendNotifySlack($exception) {
        (new NotificationViaSlackServices())->SendAttachmentFields($exception, $this->exceptionName);
    }
}

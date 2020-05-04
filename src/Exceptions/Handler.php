<?php

namespace LaravelExceptionReporter\Exceptions;

use Throwable;
use Exception;
use Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Http;

class Handler extends ExceptionHandler
{

    /**
     * @var string global throttle cache key
     */
    protected $globalThrottleCacheKey = "email_exception_global";

    /**
     * @var null|string throttle cache key
     */
    protected $throttleCacheKey = null;

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param Throwable $exception
     * @throws Exception
     */
    public function report(Throwable $exception)
    {
        if ($exception instanceof \LaravelExceptionReporter\Exceptions\ExceptionReporter) {
            dd("instanceof");
            if ($exception->getMessage()) {
            }
        }
        // check if we should mail this exception
        if ($this->shouldMail($exception)) {
            // if we passed our validation lets mail the exception
            $this->reportException($exception);
        }

        // run the parent report (logs exception and all that good stuff)
        $this->callParentReport($exception);
    }

    /**
     * wrapping the parent call to isolate for testing
     *
     * @param Throwable $exception
     * @throws Exception
     */
    protected function callParentReport(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Determine if the exception should be mailed
     *
     * @param Throwable $exception
     * @return bool
     * @throws Exception
     */
    protected function shouldMail(Throwable $exception)
    {
        return true;
        // if emailing is turned off in the config
        if (config('laravelExceptionReporter.report_exception') != true ) {
            // we should not report this exception
            return false;
        }

        // we made it past all the possible reasons to not email so we should mail this exception
        return true;
    }

    /**
     * mail the exception
     *
     * @param Throwable $exception
     */
    public static function reportException( $exception)
    {

    try {
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

            // dd("instanceof",($exception instanceof Throwable));
        // if  ( $exception instanceof Throwable){

        $data = [
            'exception' => [
                'message' => $exception->getMessage(),
                'previous' => $exception->getPrevious(),
                'code' => $exception->getCode(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                // 'trace' => $exception->getTrace(),
                // 'traceasstring' => $exception->getTraceAsString(),
                'user' => \Auth::user(),
                'get_params' => $_GET,
                'post_params' => $_POST,
                'session_params' => session()->all()
            ],
            'app_url' => env('APP_URL', ''),
            'app_env' => env('APP_ENV', ''),
        ];
        // dd(json_encode($data));
        // \Log::info(json_encode($data));
        $response = Http::timeout(1)->post('http://127.0.0.1:8000/api/report',$data);
        // }
    } catch (\Exception $e) {
        // dd($e);
    }


        // Mail::send('laravelExceptionReporter::emailException', $data, function ($message) {

        //     $default = 'An Exception has been thrown on '.
        //         config('app.name', 'unknown').' ('.config('app.env', 'unknown').')';
        //     $subject = config('laravelExceptionReporter.ErrorEmail.emailSubject') ?: $default;

        //     $message->from(config('laravelExceptionReporter.ErrorEmail.fromEmailAddress'))
        //         ->to(config('laravelExceptionReporter.ErrorEmail.toEmailAddress'))
        //         ->subject($subject);
        // });
    }

}

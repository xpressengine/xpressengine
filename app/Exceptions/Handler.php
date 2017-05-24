<?php namespace App\Exceptions;

use Event;
use RuntimeException;
use XePresenter;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Xpressengine\Plugin\Exceptions\PluginFileNotFoundException;
use Xpressengine\Support\Exceptions\AccessDeniedHttpException;
use Xpressengine\Support\Exceptions\HttpXpressengineException;
use Xpressengine\Support\Exceptions\XpressengineException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        ModelNotFoundException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $e
     *
     * @return void
     */
    public function report(Exception $e)
    {
        return parent::report($e);
    }

    /**
     * exception filter
     *
     * @param \Exception $e exception
     *
     * @return \Exception
     */
    private function filter(Exception $e)
    {
        $responseException = null;

        /*
         * make responseException
        */
        // token mismatch
        if ($e instanceof TokenMismatchException) {
            $responseException = new HttpXpressengineException([], Response::HTTP_FORBIDDEN);
            $responseException->setMessage(xe_trans('xe::tokenMismatch'));
        } // not found
        elseif ($e instanceof NotFoundHttpException) {
            $responseException = new HttpXpressengineException([], Response::HTTP_NOT_FOUND);
            $responseException->setMessage(xe_trans('xe::pageNotFound'));
        } // method now allowed
        elseif ($e instanceof MethodNotAllowedHttpException) {
            $responseException = new HttpXpressengineException([], Response::HTTP_METHOD_NOT_ALLOWED);
            $responseException->setMessage(xe_trans('xe::methodNotAllowed'));
        } // access denied
        elseif ($e instanceof AccessDeniedHttpException) {
            // Redirect is not returned(redirection is not executed). only set current uri to session
            $e->setMessage(xe_trans('xe::accessDenied'));
            $responseException = $e;
        } // http exception
        elseif ($e instanceof HttpException) {
            $responseException = $e;
        } // xpressengine exception
        elseif ($e instanceof HttpXpressengineException) {
            $e->setMessage(xe_trans($e->getMessage(), $e->getArgs()));
            $responseException = $e;
        } // xpressengine exception
        elseif ($e instanceof XpressengineException) {
            // plugin cache 삭제
            if ($e instanceof PluginFileNotFoundException) {
                $cache = app('cache');
                Event::fire('cache:clearing', ['plugins']);
                $cache->store('plugins')->flush();
                Event::fire('cache:cleared', ['plugins']);
            }
            $responseException = new HttpXpressengineException([], Response::HTTP_INTERNAL_SERVER_ERROR, $e);
            $message = xe_trans($e->getMessage(), $e->getArgs());
            if ('' === $message) {
                $message = get_class($e);
            } elseif ($message == $e->getMessage()) {
                $message = $e->getMessage();
            }
        } else {
            $responseException = new HttpXpressengineException([], Response::HTTP_INTERNAL_SERVER_ERROR, $e);
            $responseException->setMessage(xe_trans('xe::systemError'));
        }

        if ($responseException->getMessage() == '') {
            $responseException->setMessage(xe_trans('xe::systemError'));
        }

        return $responseException;
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception               $e
     *
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        /** @var HttpXpressengineException|RuntimeException $responseException */
        $responseException = $this->filter($e);

        // debugging mode
        if (config('app.debug') && $e instanceof AccessDeniedHttpException === false) {
            return $this->renderDebugMode($request, $e, $responseException);
        }

        // post request
        if ($request->isMethod('post') && !$request->ajax() && !$request->wantsJson()) {
            return redirect()->back()->with(
                'alert',
                [
                    'type' => 'danger',
                    'statusCode' => $responseException->getStatusCode(),
                    'message' => $responseException->getMessage()
                ]
            )->withInput();
        }

        $view = null;

        // ajax request
        if ($request->ajax() || $request->wantsJson()) {
            $view = XePresenter::makeApi([
                'message' => $responseException->getMessage(),
            ]);
        } else {
            XePresenter::setSkinTargetId('error');
            $view = XePresenter::make(
                'error',
                ['type' => 'danger', 'exception' => $responseException, 'message' => $responseException->getMessage()]
            );
        }

        return response($view, $responseException->getStatusCode());
    }

    /**
     * renderDebugMode
     *
     * @param Request   $request
     * @param Exception $e
     * @param HttpExceptionInterface $responseException
     *
     * @return \Illuminate\Http\RedirectResponse|Response
     */
    private function renderDebugMode($request, $e, $responseException)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return response(
                [
                    'exception' => get_class($responseException),
                    'occurredException' => get_class($e),
                    'message' => $responseException->getMessage(),
                    'trace' => explode('#', $e->getTraceAsString()),
                ],
                $responseException->getStatusCode()
            );
        }
        return $this->toIlluminateResponse($this->convertExceptionToResponse($responseException), $e);
    }
}

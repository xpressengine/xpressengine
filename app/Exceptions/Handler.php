<?php
/**
 * Handler.php
 *
 * PHP version 7
 *
 * @category    Exceptions
 * @package     App\Exceptions
 * @license     https://opensource.org/licenses/MIT MIT
 * @link        https://laravel.com
 */

namespace App\Exceptions;

use Event;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Router;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use XePresenter;
use Xpressengine\Support\Exceptions\AccessDeniedHttpException;
use Xpressengine\Support\Exceptions\HttpXpressengineException;

/**
 * Class Handler
 *
 * @category    Exceptions
 * @package     App\Exceptions
 * @license     https://opensource.org/licenses/MIT MIT
 * @link        https://laravel.com
 */
class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        HttpXpressengineException::class,
        ModelNotFoundException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, \Throwable $e)
    {
        if (method_exists($e, 'render') && $response = $e->render($request)) {
            return Router::toResponse($request, $response);
        }

        if ($e instanceof Responsable) {
            return $e->toResponse($request);
        }

        Event::dispatch('exception.handler:prepare.before', [$e]);
        $e = $this->prepareException($e);
        Event::dispatch('exception.handler:prepare.after', [$e]);

        if ($e instanceof HttpResponseException) {
            return $e->getResponse();
        }

        if ($e instanceof AuthenticationException) {
            return $this->unauthenticated($request, $e);
        }

        if ($e instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($e, $request);
        }

        return $request->expectsJson()
            ? $this->prepareJsonResponse($request, $e)
            : $this->prepareResponse($request, $e);
    }

    /**
     * Prepare exception for rendering.
     *
     * @param  \Throwable  $e
     * @return \Throwable
     */
    protected function prepareException(\Throwable $e)
    {
        if ($e instanceof ModelNotFoundException) {
            $e = new NotFoundHttpException('xe::pageNotFound', $e);
//            $e = new NotFoundHttpException($e->getMessage(), $e);
        } elseif ($e instanceof NotFoundHttpException) {
            $e = new NotFoundHttpException('xe::pageNotFound', $e);
        } elseif ($e instanceof AuthorizationException) {
            $e = new AccessDeniedHttpException();
        } elseif ($e instanceof TokenMismatchException) {
            $e = new HttpException(419, 'xe::tokenMismatch');
        }

        return $this->convert($e);
    }

    /**
     * exception filter for send xpressengine message
     *
     * @param  \Throwable  $e
     * @return HttpXpressengineException|\Throwable
     */
    protected function convert(\Throwable $e)
    {
        if ($e instanceof HttpXpressengineException) {
            $e->setMessage(xe_trans($e->getMessage(), $e->getArgs()));
            return $e;
        }

        if ($e instanceof HttpException) {
            $converted = new HttpXpressengineException([], $e->getStatusCode(), $e);
            $message = xe_trans($e->getMessage()) ?: get_class($e);
            $converted->setMessage($message);

            return $converted;
        }

        if ($e->getPrevious() && $this->isHttpException($e->getPrevious())) {
            return $this->convert($e->getPrevious());
        }

        return $e;
    }

    /**
     * Determine if the given exception is an HTTP exception.
     *
     * @param  \Throwable  $e
     * @return bool
     */
    protected function isHttpException(\Throwable $e)
    {
        return $e instanceof HttpException || $this->isHttpXpressengineException($e);
    }

    /**
     * Determine if the given exception is an HTTP exception.
     *
     * @param  \Throwable|null  $e
     * @return bool
     */
    protected function isHttpXpressengineException(\Throwable $e = null)
    {
        return $e instanceof HttpXpressengineException;
    }

    /**
     * Prepare a response for the given exception.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function prepareResponse($request, \Throwable $e)
    {
        if ($this->isHttpException($e) === false && config('app.debug')) {
            return $this->toIlluminateResponse($this->convertExceptionToResponse($e), $e);
        }

        if ($this->isHttpException($e) === false) {
            $e = new HttpXpressengineException([], 500, $e);
            $e->setMessage(xe_trans('xe::systemError'));
        }

        return (new \Illuminate\Pipeline\Pipeline($this->container))
            ->send($request)
            ->through(
                !session()->isStarted() ? [
                    \App\Http\Middleware\EncryptCookies::class,
                    \Illuminate\Session\Middleware\StartSession::class,
                ] : []
            )
            ->then(function ($request) use ($e) {
                $response = $this->withTheme() === true ?
                    $this->renderWithTheme($e, $request) :
                    $this->renderWithoutXE($e);

                return $this->toIlluminateResponse($response, $e);
            });
    }

    /**
     * Render the given HttpXpressengineException.
     *
     * @param  HttpXpressengineException  $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderWithoutXE(HttpXpressengineException $e)
    {
        $status = $e->getStatusCode();
        $path = $this->getPath();
        if (view()->exists("$path.$status") === false) {
            $status = 500;
        }

        return $this->getView($path, $status, $e);
    }

    /**
     * Render the given HttpXpressengineException.
     *
     * @param  HttpXpressengineException  $e
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderWithTheme(HttpXpressengineException $e, Request $request)
    {
        $status = $e->getStatusCode();

        // return for api
        if ($request->expectsJson()) {
            $view = XePresenter::makeApi([
                'message' => $e->getMessage(),
            ]);
            return response($view, $status);
        }

        $path = $this->getPath();
        if (view()->exists("$path.$status") === false) {
            $status = 500;
        }

        try {
            if ($status === 503) {
                // maintenance mode
                $view = $this->getView($path, $status, $e);
            } else {
                $view = $this->getTheme($path, $status, $e);
            }
        } catch (\Throwable $renderError) {
            $view = $this->getView($path, $status, $e);
        }

        $view->setStatusCode($e->getStatusCode());

        return $view;
    }

    /**
     * render with xe theme(use Presenter)
     *
     * @param $path
     * @param $status
     * @param  HttpXpressengineException  $e
     * @return Response
     */
    protected function getTheme($path, $status, HttpXpressengineException $e)
    {
        XePresenter::setSkinTargetId(null);
        $view = XePresenter::make("$path.$status", [
            'exception' => $e,
            'path' => $path,
            'xe' => true,
        ]);
        return response($view);
    }

    /**
     * render without xe
     *
     * @param $path
     * @param $status
     * @param  \Xpressengine\Support\Exceptions\HttpXpressengineException  $e
     * @return Response
     */
    protected function getView($path, $status, HttpXpressengineException $e)
    {
        return response()->view("$path.$status", [
            'exception' => $e,
            'path' => $path,
            'xe' => false,
        ], $status, $e->getHeaders());
    }

    /**
     * Convert the given exception to an array.
     *
     * @param  \Throwable  $e
     * @return array
     */
    protected function convertExceptionToArray(\Throwable $e)
    {
        $arr = parent::convertExceptionToArray($e);

        if ($arr['message'] === 'Server Error') {
            $arr['message'] = xe_trans('xe::systemError');
        }

        return $arr;
    }

    /**
     * Get view path for errors
     *
     * @return string
     */
    protected function getPath()
    {
        return config('view.error.path');
    }

    /**
     * Determine if use theme with error view
     *
     * @return bool
     */
    protected function withTheme()
    {
        return config('view.error.theme', true);
    }
}

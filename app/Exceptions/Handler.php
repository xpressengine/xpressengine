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

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Event;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Routing\Router;
use Illuminate\Validation\ValidationException;
use XePresenter;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Xpressengine\Plugin\Exceptions\PluginFileNotFoundException;
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
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception               $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Exception $e)
    {
        if (method_exists($e, 'render') && $response = $e->render($request)) {
            return Router::toResponse($request, $response);
        } elseif ($e instanceof Responsable) {
            return $e->toResponse($request);
        }

        Event::fire('exception.handler:prepare.before', [$e]);
        $e = $this->prepareException($e);
        Event::fire('exception.handler:prepare.after', [$e]);

        if ($e instanceof HttpResponseException) {
            return $e->getResponse();
        } elseif ($e instanceof AuthenticationException) {
            return $this->unauthenticated($request, $e);
        } elseif ($e instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($e, $request);
        }

        return $request->expectsJson()
            ? $this->prepareJsonResponse($request, $e)
            : $this->prepareResponse($request, $e);
    }

    /**
     * Prepare exception for rendering.
     *
     * @param  \Exception  $e
     * @return \Exception
     */
    protected function prepareException(Exception $e)
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
     * @param Exception $e
     * @return HttpXpressengineException|Exception
     */
    protected function convert(Exception $e)
    {
        $converted = $e;

        if ($e instanceof HttpXpressengineException) {
            $e->setMessage(xe_trans($e->getMessage(), $e->getArgs()));
            $converted = $e;
        } elseif ($e instanceof HttpException) {
            /** @var HttpException $e */
            $converted = new HttpXpressengineException([], $e->getStatusCode(), $e);
            $message = xe_trans($e->getMessage());
            if ('' === $message) {
                $message = get_class($e);
            }
            $converted->setMessage($message);
        } elseif ($e->getPrevious() && $this->isHttpException($e->getPrevious())) {
            $converted = $this->convert($e->getPrevious());
        }

        return $converted;
    }

    /**
     * Determine if the given exception is an HTTP exception.
     *
     * @param  \Exception  $e
     * @return bool
     */
    protected function isHttpException(Exception $e)
    {
        return $e instanceof HttpException || $this->isHttpXpressengineException($e);
    }

    /**
     * Determine if the given exception is an HTTP exception.
     *
     * @param  \Exception  $e
     * @return bool
     */
    protected function isHttpXpressengineException(Exception $e = null)
    {
        return $e !== null && $e instanceof HttpXpressengineException;
    }

    /**
     * is fatal error
     *
     * @param Exception $e
     * @return bool
     */
    protected function isFatalError(Exception $e)
    {
        return $e instanceof \Symfony\Component\Debug\Exception\FatalErrorException;
    }

    /**
     * Prepare a response for the given exception.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function prepareResponse($request, Exception $e)
    {
        if (!$this->isHttpException($e) && config('app.debug')) {
            return $this->toIlluminateResponse(
                $this->convertExceptionToResponse($e), $e
            );
        }

        if (!$this->isHttpException($e)) {
            $e = new HttpXpressengineException([], 500, $e);
            $e->setMessage(xe_trans('xe::systemError'));
        }

        return (new \Illuminate\Pipeline\Pipeline($this->container))
            ->send($request)
            ->through(!session()->isStarted() ? [
                \App\Http\Middleware\EncryptCookies::class,
                \Illuminate\Session\Middleware\StartSession::class,
            ] : [])
            ->then(function ($request) use ($e) {
                return $this->toIlluminateResponse(
                    $this->isFatalError($e) || !$this->withTheme() ?
                        $this->renderWithoutXE($e) :
                        $this->renderWithTheme($e, $request),
                    $e
                );
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
        if (view()->exists("{$path}.{$status}") === false) {
            $status = 500;
        }

        return $this->getView($path, $status, $e);
    }

    /**
     * Render the given HttpXpressengineException.
     *
     * @param  HttpXpressengineException $e
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
        if (view()->exists("{$path}.{$status}") === false) {
            $status = 500;
        }

        try {
            if ($status == 503) {
                // maintenance mode
                $view = $this->getView($path, $status, $e);
            } else {
                $view = $this->getTheme($path, $status, $e);
            }
        } catch (Exception $renderError) {
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
     * @param HttpXpressengineException $e
     * @return Response
     */
    protected function getTheme($path, $status, HttpXpressengineException $e)
    {
        XePresenter::setSkinTargetId(null);
        $view = XePresenter::make("{$path}.{$status}", [
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
     * @param Exception $e
     * @return Response
     */
    protected function getView($path, $status, HttpXpressengineException $e)
    {
        $view = response()->view("{$path}.{$status}", [
            'exception' => $e,
            'path' => $path,
            'xe' => false,
        ], $status, $e->getHeaders());
        return $view;
    }

    /**
     * Convert the given exception to an array.
     *
     * @param  \Exception  $e
     * @return array
     */
    protected function convertExceptionToArray(Exception $e)
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

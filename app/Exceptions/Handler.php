<?php namespace App\Exceptions;

use Event;
use XePresenter;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpKernel\Exception\HttpException;
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
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception               $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof PluginFileNotFoundException) {
            $cache = app('cache');
            Event::fire('cache:clearing', ['plugins']);
            $cache->store('plugins')->flush();
            Event::fire('cache:cleared', ['plugins']);
        }

        if ($this->isUnauthorizedException($e)) {
            $e = new HttpException(403, $e->getMessage());
        }

        $converted = $this->converter($e);

        // 테마를 이용한 리턴은 어떻게?
        if ($this->isDebugMode($e) === true) {
            // debug mode
            return $this->toDebugModeResponse($e, $converted, $request);
        } elseif ($this->isPostRequest($request)) {
            // when post request
            return $this->toPostBackRedirect($converted);
        } elseif ($this->isFatalError($e)) {
            // system fatal error (etc, Laravel framework error)
            return $this->toIlluminateResponse($this->renderWithoutXE($converted), $converted);
        } elseif ($this->isHttpXpressengineException($converted)) {
            // xpressengine http exception, converted exceptions
            return $this->toIlluminateResponse($this->renderWithTheme($converted, $request), $converted);
        } elseif ($this->isHttpException($e)) {
            // laravel default http exception render
            return $this->toIlluminateResponse($this->renderHttpException($e), $e);
        } else {
            // laravel default exception render
            return $this->toIlluminateResponse($this->convertExceptionToResponse($e), $e);
        }
    }

    /**
     * exception filter for send xpressengine message
     *
     * @param Exception $e
     * @return HttpXpressengineException|Exception
     */
    public function converter(Exception $e)
    {
        $converted = null;
        $debug = config('app.debug');

        if ($e instanceof TokenMismatchException) {
            $converted = new HttpXpressengineException([], Response::HTTP_FORBIDDEN, $e);
            $converted->setMessage(xe_trans('xe::tokenMismatch'));
        } elseif ($e instanceof NotFoundHttpException) {
            $converted = new HttpXpressengineException([], Response::HTTP_NOT_FOUND, $e);
            $converted->setMessage(xe_trans('xe::pageNotFound'));
        } elseif ($e instanceof MethodNotAllowedHttpException) {
            $converted = new HttpXpressengineException([], Response::HTTP_METHOD_NOT_ALLOWED, $e);
            $converted->setMessage(xe_trans('xe::methodNotAllowed'));
        } elseif ($e instanceof HttpXpressengineException) {
            $e->setMessage(xe_trans($e->getMessage(), $e->getArgs()));
            $converted = $e;
        } elseif ($this->isHttpException($e)) {
            /** @var HttpException $e */
            $converted = new HttpXpressengineException([], $e->getStatusCode(), $e);
            $message = xe_trans($e->getMessage());
            if ('' === $message) {
                $message = get_class($e);
            }
            $converted->setMessage($message);
        } elseif ($e instanceof XpressengineException && $debug !== true) {
            $converted = new HttpXpressengineException([], Response::HTTP_INTERNAL_SERVER_ERROR, $e);
            $message = xe_trans($e->getMessage(), $e->getArgs());
            if ('' === $message) {
                $message = get_class($e);
            } elseif ($message == $e->getMessage()) {
                $message = $e->getMessage();
            }
            $converted->setMessage($message);
        } elseif ($e instanceof XpressengineException && $debug === true) {
            $converted = $e;
        }

        // if not debug mode them always render by view file
        if ($converted == null && $debug !== true) {
            $converted = new HttpXpressengineException([], Response::HTTP_INTERNAL_SERVER_ERROR, $e);
            $converted->setMessage(xe_trans('xe::systemErrorFramework'));
        }

        return $converted;
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
     * is post request
     *
     * @param Request $request
     * @return bool
     */
    protected function isPostRequest(Request $request)
    {
        return $request->isMethod('post') && !$request->ajax() && !$request->wantsJson();
    }

    /**
     * is debug mode
     *
     * @param Exception $e
     * @return bool
     */
    protected function isDebugMode(Exception $e)
    {
        return config('app.debug') && $e instanceof AccessDeniedHttpException === false;
    }

    /**
     * is system error
     *
     * @param Exception $e
     * @return bool
     */
    protected function isSystemError(Exception $e)
    {
        return $this->isHttpException($e) === false && $this->isHttpXpressengineException($e) === false;
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

    protected function toDebugModeResponse(Exception $e, Exception $converted = null, Request $request)
    {
        if ($converted == null) {
            $converted = $e;
        }
        $status = 500;
        if (method_exists($converted, 'getStatusCode') == true) {
            /** @var HttpException $converted */
            $status = $converted->getStatusCode();
        }

        // return for api
        if ($request->ajax() || $request->wantsJson()) {
            return response(
                [
                    'exception' => get_class($converted),
                    'occurredException' => get_class($e),
                    'message' => $converted->getMessage(),
                    'trace' => explode('#', $e->getTraceAsString()),
                ],
                $status
            );
        }

        return $this->toIlluminateResponse($this->convertExceptionToResponse($converted), $converted);
    }

    /**
     * exception back redirect
     *
     * @param Exception $e
     * @return $this
     */
    protected function toPostBackRedirect(Exception $e)
    {
        $statusCode = 500;
        if (method_exists($e, 'getStatusCode')) {
            $statusCode = $e->getStatusCode();
        }

        return redirect()->back()->with(
            'alert',
            [
                'type' => 'danger',
                'statusCode' => $statusCode,
                'message' => $e->getMessage()
            ]
        )->withInput();
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
        $path = config('view.error');
        if (view()->exists("{$path}.{$status}") === false) {
            $status = 500;
        }

        $view = $this->getView($path, $status, $e);

        if (view()->exists("{$path}.{$status}") === false) {
            return $this->convertExceptionToResponse($e);
        } else {
            return $view;
        }
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
        if ($request->ajax() || $request->wantsJson()) {
            $view = XePresenter::makeApi([
                'message' => $e->getMessage(),
            ]);
            return response($view, $status);
        }

        $path = config('view.error');
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

        if (view()->exists("{$path}.{$status}") === false) {
            return $this->convertExceptionToResponse($e);
        } else {
            return $view;
        }
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
    protected function getView($path, $status, Exception $e)
    {
        $view = response()->view("{$path}.{$status}", [
            'exception' => $e,
            'path' => $path,
            'xe' => false,
        ], $status);
        return $view;
    }

}

<?php
namespace App\Http\Middleware;

use Closure;

class ExceptAppendableVerifyCsrfToken extends VerifyCsrfToken
{
    protected static $staticExcept = [];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->except = array_merge($this->except, static::$staticExcept);

        return parent::handle($request, $next);
    }

    /**
     * csrf 검사를 하지 않을 route 를 등록 함
     *
     * laravel 업데이트에 의해 변경될 수 있음
     *
     * @param string $path route path
     * @return void
     */
    public static function setExcept($path)
    {
        static::$staticExcept[] = $path;
        static::$staticExcept = array_unique(static::$staticExcept);
    }

    /**
     * csrf 검사를 하지 않을 route 의 등록을 해제 함
     *
     * laravel 업데이트에 의해 변경될 수 있음
     *
     * @param string $path route path
     * @return void
     */
    public static function unsetExcept($path)
    {
        foreach (static::$staticExcept as $idx => $exceptPath) {
            if ($exceptPath === $path) {
                unset(static::$staticExcept[$idx]);
                break;
            }
        }
    }
}

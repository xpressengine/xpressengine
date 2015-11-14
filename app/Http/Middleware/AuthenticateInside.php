<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Routing\Middleware;

class AuthenticateInside implements Middleware
{
    protected $credentials = ['id' => 'admin', 'password' => 'xexe123123+'];

    protected $allowIps = [
        '14.52.148.62', // xewlan
        '14.52.148.56', // xehub1
        '121.134.173.59' // xehub2
    ];
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (env('APP_ENV') != 'local' && !in_array($request->ip(), $this->allowIps)) {
            if (empty($request->getUser())
                || empty($request->getPassword())
                || $request->getUser() !== $this->credentials['id']
                || $request->getPassword() !== $this->credentials['password']) {
                return $this->auth->basic();
            }
        }

        return $next($request);
    }
}

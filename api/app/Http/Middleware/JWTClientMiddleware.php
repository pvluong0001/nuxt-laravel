<?php

namespace App\Http\Middleware;

use App\Exceptions\UnauthorizedException;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use JWTAuth;

class JWTClientMiddleware extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $this->authenticate($request);
            if (Auth::guard('client')->check()) {
                return $next($request);
            }
        } catch (UnauthorizedHttpException $exception) {
            $token = JWTAuth::getToken();
            try {
                $newToken = JWTAuth::refresh($token);
                auth('client')->setToken($newToken)->user();

                $response = $next($request);

                //Check if the response is JSON
                if ($request->acceptsJson()) {
                    $currentData = (array)$response->getData();

                    return response()->json(
                        array_merge($currentData, [
                            'newToken' => $newToken
                        ])
                    );
                }

                return $response;
            } catch (\Exception $exception) {
                throw new UnauthorizedException($exception->getMessage());
            }
        } catch (\Exception $exception) {
            throw new UnauthorizedException($exception->getMessage());
        }
    }
}

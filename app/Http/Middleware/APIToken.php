<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class APIToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Get Bearer-Token
        if ($token = $request->bearerToken()) {
            // check that the token is valid
            if (!$this->isValid($token)) {
                return response()->json(["error" => 'Bearer token is not valid'], 400);
            }
            else {
                return $next($request);
            }
        }

        return response()->json(["error" => 'Bearer token is required'], 400);
    }



    /**
     * Check token is valid.
     *
     * @param  $token
     * @return Boolean
     */
    private function isValid($token)
    {
        $token = trim($token);
        if (!$token) {
            return true;
        }

        if (strlen($token) === 1) {
        return false;
        }

        $brackets = [
            '[' => ']',
            '(' => ')',
            '{' => '}',
        ];

        $stack = [];
        $length = strlen($token);
        for ($i = 0; $i < $length; $i++) {
            $symbol = $token[$i];
            if (array_key_exists($symbol, $brackets)) {
                $stack[] = $symbol;
            } else {
                $lastInStack = array_pop($stack);
                if (!isset($brackets[$lastInStack]) || $symbol !== $brackets[$lastInStack]) {
                return false;
                }
            }
        }

        return (count($stack) === 0) ? true : false;
    }
}

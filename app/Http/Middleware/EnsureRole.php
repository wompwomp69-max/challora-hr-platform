<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        if (!in_array($request->user()->role->value, $roles)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized. You do not have permission to access this page.'], 403);
            }
            return response()->view('errors.403', [
                'exception' => new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException('Unauthorized action.'),
            ], 403);
        }

        return $next($request);
    }
}

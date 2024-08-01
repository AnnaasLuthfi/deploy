<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class isOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        $userOwner = User::where('name','owner')->first();

        if ($user && $user->id === $userOwner->id) {
            return $next($request);
        }

        return response()->json([
            "message" => "Anda tidak bisa masuk ke halaman owner",
        ], 401);

        return $next($request);

    }
}

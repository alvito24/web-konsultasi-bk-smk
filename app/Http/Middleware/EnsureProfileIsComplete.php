<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureProfileIsComplete
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Jika user login TAPI profil belum lengkap
        // DAN user tidak sedang berada di halaman setup profil (biar gak loop)
        if ($user && !$user->is_profile_complete && !$request->routeIs('profile.setup', 'profile.setup.store', 'logout')) {
            return redirect()->route('profile.setup');
        }

        return $next($request);
    }
}

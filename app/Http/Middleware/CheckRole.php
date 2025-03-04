<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user()) {
            return redirect('login');
        }

        // Redirect ke halaman sesuai role
        if ($request->user()->role->nama === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        
        return $next($request);
    }
}

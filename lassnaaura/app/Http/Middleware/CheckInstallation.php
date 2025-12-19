<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\Response;

class CheckInstallation
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $installedFile = storage_path('installed');
        
        // If not installed and not on installer route, redirect to installer
        if (!File::exists($installedFile) && !$request->is('install*')) {
            return redirect()->route('installer.index');
        }
        
        // If installed and trying to access installer, redirect to home
        if (File::exists($installedFile) && $request->is('install*')) {
            return redirect('/')->with('info', 'Application is already installed.');
        }
        
        return $next($request);
    }
}

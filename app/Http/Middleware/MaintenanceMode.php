<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Configuration;

class MaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $maintenance_mode = Configuration::where("name", "maintenance-mode")->first();
        if ($maintenance_mode && $maintenance_mode->value == TRUE) {
            return redirect()->route('maintenance');
        } else {
            return $next($request);
        }
    }
}

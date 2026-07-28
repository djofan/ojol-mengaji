<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsolatePanelSession
{
    public function handle(Request $request, Closure $next): Response
    {
        // Deteksi segment URL pertama (admin, guru, atau peserta)
        $segment = $request->segment(1);

        if (in_array($segment, ['admin', 'guru', 'peserta'])) {
            // Paksa nama cookie berubah sesuai panel yang sedang dibuka
            config(['session.cookie' => 'ojolmengaji_' . $segment . '_session']);
        }

        return $next($request);
    }
}
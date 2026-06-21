<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Adds a hardened set of HTTP security headers to every response.
 *
 * The Content-Security-Policy is tuned for this app's stack: Vite-built
 * self-hosted assets, Alpine.js (which requires 'unsafe-eval' to evaluate
 * its directive expressions) and Bunny Fonts. Adjust if external origins
 * are added.
 *
 * Defense-in-depth: the Nginx vhost emits the IDENTICAL policy so that
 * statically-served assets (which never hit PHP) are covered too. If you
 * change anything here, mirror it in the Nginx config to avoid conflicting
 * duplicate headers.
 */
class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $csp = implode('; ', [
            "default-src 'self'",
            "script-src 'self' 'unsafe-eval'",
            "style-src 'self' 'unsafe-inline' https://fonts.bunny.net",
            "font-src 'self' https://fonts.bunny.net",
            "img-src 'self' data:",
            "connect-src 'self'",
            "object-src 'none'",
            "base-uri 'self'",
            "form-action 'self'",
            "frame-ancestors 'none'",
        ]);

        $headers = [
            'Content-Security-Policy' => $csp,
            'X-Frame-Options' => 'DENY',
            'X-Content-Type-Options' => 'nosniff',
            'Referrer-Policy' => 'strict-origin-when-cross-origin',
            'Permissions-Policy' => 'geolocation=(), microphone=(), camera=(), payment=(), usb=(), interest-cohort=()',
            'X-XSS-Protection' => '0',
            'Cross-Origin-Opener-Policy' => 'same-origin',
        ];

        // Only advertise HSTS over a secure connection (RFC 6797).
        if ($request->isSecure()) {
            $headers['Strict-Transport-Security'] = 'max-age=31536000; includeSubDomains; preload';
        }

        foreach ($headers as $name => $value) {
            $response->headers->set($name, $value);
        }

        // Remove fingerprinting headers where present.
        $response->headers->remove('X-Powered-By');
        $response->headers->remove('Server');

        return $response;
    }
}

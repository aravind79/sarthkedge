<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Log;
use Symfony\Component\HttpFoundation\Response;

class MustVerifyEmail
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if (Auth::user()->hasRole('School Admin')) {
            if (!$user->hasVerifiedEmail()) {
                return redirect('/email/verify');
            } else {
                $userCheck = DB::connection('mysql')->table('users')->where('email', $user->email)->first();
                if ($userCheck && is_null($userCheck->email_verified_at)) {
                    DB::connection('mysql')->table('users')->where('id', $user->id)->update(['email_verified_at' => Carbon::now()]);
                }
            }
        }
        return $next($request);
    }
}

<?php
namespace App\Http\Middleware;

use Closure;

class CorsMiddleware {

  public function handle($request, Closure $next)
  {
    $response = $next($request);

    //request yang diperbolehkan
    // $response->header('Access-Control-Allow-Methods', 'HEAD, GET, POST, PUT, PATCH, DELETE');
    $response->header('Access-Control-Allow-Methods', 'GET');
    $response->header('Access-Control-Allow-Headers', $request->header('Access-Control-Request-Headers'));

    //domain yang diizinkan
    $response->header('Access-Control-Allow-Origin', '*');
    return $response;
  }
}

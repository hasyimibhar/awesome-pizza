<?php

namespace AwesomePizza\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use Illuminate\Contracts\Support\Arrayable;

class JsonNumericCasting
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        if ($response instanceof Response) {
            $content = $response->getOriginalContent();
            if ($content instanceof Arrayable) {
                $content = json_encode($content->toArray(), JSON_NUMERIC_CHECK);
            } else {
                $content = json_encode($content, JSON_NUMERIC_CHECK);
            }

            $response->setContent($content);
        }

        return $response;
    }
}

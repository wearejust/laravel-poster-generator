<?php

namespace Just\PosterGenerator\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Contracts\Config\Repository as ConfigInterface;

class GuardRenderURI
{
    /**
     * @var ConfigInterface
     */
    private $config;

    /**
     * @param ConfigInterface $config
     */
    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * Run the request filter.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $header = $request->header('X-API-POSTER-KEY');

        if ($header === $this->config->get('poster.middleware_token')) {
            return $next($request);
        }

        return redirect('/');
    }

}
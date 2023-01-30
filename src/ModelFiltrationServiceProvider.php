<?php

namespace SamaviDev\ModelFiltration;

use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use ReflectionMethod;
use SamaviDev\ModelFiltration\Attributes\Filter;

class ModelFiltrationServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->callAfterResolving('router', function (Router $router) {
            $router->matched($this->assign(...));
        });
    }

    private function assign(RouteMatched $matched): void
    {
        $route = $matched->route;

        if (! isset($route->action['controller'])) {
            return;
        }

        $method = new ReflectionMethod(...explode('@', $route->action['uses']));

        foreach ($method->getAttributes(Filter::class) as $attribute) {
            $attribute->newInstance()->setup($matched->request);
        }

        $route->setParameter('filtered', Filter::get());
    }
}

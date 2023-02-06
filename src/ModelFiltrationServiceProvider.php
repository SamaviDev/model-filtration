<?php

namespace SamaviDev\ModelFiltration;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use ReflectionAttribute;
use ReflectionClass;
use SamaviDev\ModelFiltration\Attributes\Filter;
use SamaviDev\ModelFiltration\Contracts\Group;

class ModelFiltrationServiceProvider extends ServiceProvider
{
    public function register()
    {
        Event::listen('eloquent.booting:*', $this->listener(...));
    }

    protected function listener(string $event, array $models): void
    {
        $model = $models[0];
        [$simple, $group] = $this->getAttributes($model);

        foreach ($simple as $attribute) {
            $attribute->newInstance()->setup($model);
        }

        foreach ($group as $attribute) {
            $instance = $attribute->newInstance();

            foreach ($instance->props() as $operator => $accepted) {
                (new Filter($accepted, $operator))->setup($model);
            }
        }
    }

    protected function getAttributes($model): array
    {
        $class = new ReflectionClass($model);

        return [
            $class->getAttributes(Filter::class),
            $class->getAttributes(Group::class, ReflectionAttribute::IS_INSTANCEOF),
        ];
    }
}

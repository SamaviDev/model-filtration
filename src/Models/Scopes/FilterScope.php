<?php

namespace SamaviDev\ModelFiltration\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class FilterScope implements Scope
{
    public function __construct(private $accepted, private $operator)
    {
    }

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $param = $this->getParams();

        return match ($this->operator) {
            'and' => $builder->where($param->toArray()),
            'or' => $builder->orWhere($param->toArray()),
            'like' => $this->whereLike($builder, $param, 'and'),
            'like:or' => $this->whereLike($builder, $param, 'or'),
            'with' => $builder->with($this->accepted),
        };
    }

    /**
     * Receive input parameters from request
     *
     * @return Collection
     */
    private function getParams(): Collection
    {
        $param = collect(app(Request::class)->query)->only($this->accepted);

        foreach ((array) $this->accepted as $field => $name) {
            if (is_string($field) && $param->has($name)) {
                $param->put($field, $param->get($name))->offsetUnset($name);
            }
        }

        return $param;
    }

    private function whereLike($builder, $params, $boolean): Builder
    {
        return $builder->where(
            array_values($params->map(fn ($value, $name) => [$name, 'like', $value, $boolean])->all())
        );
    }
}

<?php

namespace SamaviDev\ModelFiltration\Attributes;

use Attribute;
use SamaviDev\ModelFiltration\Models\Scopes\FilterScope;

#[Attribute(Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
class Filter
{
    public function __construct(
        private array|string $accepted,
        private string $operator = 'and'
    ) {
    }

    public function setup($model): void
    {
        $model::addGlobalScope(
            $this->operator,
            new FilterScope($this->accepted, $this->operator)
        );
    }
}

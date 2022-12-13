<?php

namespace Esatic\Suitecrm\Services;

use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

interface RelatedItemsInterface
{
    public function execute(Request $request, string $module, string $relationName, string $id): Builder;
}

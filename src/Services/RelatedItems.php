<?php

namespace Esatic\Suitecrm\Services;

use Esatic\Suitecrm\Events\RelatedItemsEvent;
use Esatic\Suitecrm\Models\RelatedModule;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class RelatedItems implements RelatedItemsInterface
{

    public function execute(Request $request, string $module, string $relationName, string $id): Builder
    {
        /** @var RelatedModule $relation */
        $relation = RelatedModule::query()
            ->where('module', '=', $module)
            ->where('relation_name', '=', $relationName)
            ->firstOrFail();
        $query = DB::connection('suitecrm')
            ->table(sprintf('%s as tbl1', $relation->related_table))
            ->join(sprintf('%s as tbl2', $relation->primary_table), 'tbl2.id', '=', sprintf('tbl1.%s', $relation->related_field));
        if ($relation->cstm) {
            $query->join(sprintf('%s_cstm as tbl3', $relation->primary_table), 'tbl3.id_c', '=', 'tbl2.id')
                ->select('tbl2.*', 'tbl3.*');
        } else {
            $query->select('tbl2.*');
        }
        $query->where(sprintf('tbl1.%s', $relation->filter_field), '=', $id)
            ->where('tbl1.deleted', '=', 0)
            ->where('tbl2.deleted', '=', 0)
            ->orderByDesc('tbl2.date_entered');
        event(new RelatedItemsEvent($query, $request, $module, $relationName, $id));
        return $query;
    }
}

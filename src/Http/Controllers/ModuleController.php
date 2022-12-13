<?php

namespace Esatic\Suitecrm\Http\Controllers;

use App\Models\User;
use Esatic\Suitecrm\Models\RelatedModule;
use Esatic\Suitecrm\Services\RelatedItemsInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ModuleController extends BaseController
{

    protected RelatedItemsInterface $relatedItems;

    /**
     * @param RelatedItemsInterface $relatedItems
     */
    public function __construct(RelatedItemsInterface $relatedItems)
    {
        $this->relatedItems = $relatedItems;
    }

    public function index(Request $request, string $module, string $relationName): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();
        if (empty($user->account_id)) {
            return response()->json(['message' => 'User not related to account'], 400);
        }
        $result = $this->relatedItems->execute($request, $module, $relationName, $user->account_id)
            ->paginate($request->input('size', 20));
        return response()->json($result);
    }

    public function view(string $module, string $id): JsonResponse
    {
        /** @var RelatedModule $relation */
        $relation = RelatedModule::query()
            ->where('module', '=', $module)
            ->firstOrFail();
        $result = DB::connection('suitecrm')->table(sprintf('%s as tbl1', Str::lower($module)))
            ->join(sprintf('%s_cstm as tbl2', Str::lower($module)), 'tbl2.id_c', '=', 'tbl1.id')
            ->select('tbl1.*', 'tbl2.*')
            ->where('tbl1.id', '=', $id)->first();
        if ($result) {
            return response()->json($result);
        }
        return response()->json(['404 Not found'], 404);
    }

    public function relationship(Request $request, string $module, string $id, string $relationName): JsonResponse
    {
        $result = $this->relatedItems->execute($request, $module, $relationName, $id)
            ->paginate($request->input('size', 20));
        return response()->json($result);
    }

}

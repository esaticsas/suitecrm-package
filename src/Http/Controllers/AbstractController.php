<?php

namespace Esatic\Suitecrm\Http\Controllers;

use Esatic\Suitecrm\Contracts\ApiCrmInterface;
use Esatic\Suitecrm\Events\AfterGetAvailableModules;
use Esatic\Suitecrm\Events\AfterGetEntries;
use Esatic\Suitecrm\Events\AfterGetEntry;
use Esatic\Suitecrm\Events\AfterGetEntryList;
use Esatic\Suitecrm\Events\AfterGetModuleFields;
use Esatic\Suitecrm\Events\AfterGetRelationships;
use Esatic\Suitecrm\Events\AfterSetEntries;
use Esatic\Suitecrm\Events\AfterSetEntry;
use Esatic\Suitecrm\Events\AfterSetRelationship;
use Esatic\Suitecrm\Events\BeforeGetAvailableModules;
use Esatic\Suitecrm\Events\BeforeGetEntries;
use Esatic\Suitecrm\Events\BeforeGetEntry;
use Esatic\Suitecrm\Events\BeforeGetEntryList;
use Esatic\Suitecrm\Events\BeforeGetModuleFields;
use Esatic\Suitecrm\Events\BeforeGetRelationships;
use Esatic\Suitecrm\Events\BeforeSetEntries;
use Esatic\Suitecrm\Events\BeforeSetEntry;
use Esatic\Suitecrm\Events\BeforeSetRelationship;
use Esatic\Suitecrm\Services\ApiCrm;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

abstract class AbstractController extends BaseController
{


    protected ApiCrmInterface $crmApi;

    /**
     * @param ApiCrm $crmApi
     */
    public function __construct(ApiCrmInterface $crmApi)
    {
        $this->crmApi = $crmApi;
    }

    /**
     * @param string $module
     * @param Request $request
     * @return JsonResponse
     * @throws \Esatic\Suitecrm\Exceptions\AuthenticationException
     */
    public function getEntryList(string $module, Request $request): JsonResponse
    {
        $query = !is_null($request->input('query')) ? $request->input('query') : '';
        $orderBy = $request->input('order_by', 'date_entered');
        $offset = $request->input('offset', 0);
        $selectFields = explode(',', $request->input('fields'));
        $linkNameFields = $request->input('link_field_name', array());
        $maxResults = $request->input('limit', 20);
        $deleted = $request->input('deleted', 0);
        $favorites = $request->input('favorite', false);
        event(new BeforeGetEntryList($module, $query, $orderBy, $offset, $selectFields, $linkNameFields, $maxResults, $deleted, $favorites));
        $result = $this->crmApi->getEntryList($module, $query, $orderBy, $offset, $selectFields, $linkNameFields, $maxResults, $deleted, $favorites);
        event(new AfterGetEntryList($module, $result));
        return response()->json($result);
    }

    /**
     * @param string $module
     * @param string $moduleId
     * @param string $linkFieldName
     * @param Request $request
     * @return JsonResponse
     * @throws \Esatic\Suitecrm\Exceptions\AuthenticationException
     */
    public function getRelationships(string $module, string $moduleId, string $linkFieldName, Request $request): JsonResponse
    {
        $relatedFields = explode(',', $request->input('related_fields'));
        $relatedModuleQuery = !is_null($request->input('query')) ? $request->input('query') : '';
        $orderBy = $request->input('order_by', 'date_entered');
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 20);
        $items = explode(',', $request->input('related_module_link_name'));
        $relatedModuleLinkName = [];
        foreach ($items as $item) {
            $relatedModuleLinkName[] = [
                'name' => $item,
                'value' => explode(',', $request->input($item))
            ];
        }
        $deleted = $request->input('deleted', 0);
        $favorites = $request->input('favorites', false);
        $before = new BeforeGetRelationships($module, $moduleId, $linkFieldName, $relatedFields, $relatedModuleQuery, $orderBy, $offset, $limit, $relatedModuleLinkName, $deleted, $favorites);
        event($before);
        $result = $this->crmApi->getRelationships(
            $before->getModule(),
            $before->getModuleId(),
            $before->getLinkFieldName(),
            $before->getRelatedFields(),
            $before->getRelatedModuleQuery(),
            $before->getOrderBy(),
            $before->getOffset(),
            $before->getLimit(),
            $before->getRelatedModuleLinkName(),
            $before->isDeleted(),
            $before->isFavorites()
        );
        $after = new AfterGetRelationships($module, $result);
        event($after);
        return response()->json($after->getResult());
    }

    /**
     * @param string $module
     * @param string $id
     * @return JsonResponse
     * @throws \Esatic\Suitecrm\Exceptions\AuthenticationException
     */
    public function getEntry(string $module, string $id): JsonResponse
    {
        event(new BeforeGetEntry($module, $id));
        $result = $this->crmApi->getEntry($id, $module);
        $after = new AfterGetEntry($module, $result);
        event($after);
        return response()->json($after->getResult());
    }

    /**
     * @return JsonResponse
     * @throws \Esatic\Suitecrm\Exceptions\AuthenticationException
     */
    public function getAvailableModules(): JsonResponse
    {
        event(new BeforeGetAvailableModules());
        $result = $this->crmApi->getAvailableModules();
        event(new AfterGetAvailableModules($result));
        return response()->json($result);
    }

    /**
     * @param string $module
     * @return JsonResponse
     * @throws \Esatic\Suitecrm\Exceptions\AuthenticationException
     */
    public function getModuleFields(string $module): JsonResponse
    {
        event(new BeforeGetModuleFields($module));
        $result = $this->crmApi->getModuleFields($module);
        event(new AfterGetModuleFields($module, $result));
        return response()->json($result);
    }

    /**
     * @param string $module
     * @param Request $request
     * @return JsonResponse
     * @throws \Esatic\Suitecrm\Exceptions\AuthenticationException
     */
    public function setEntry(string $module, Request $request): JsonResponse
    {
        $data = $request->all();
        $before = new BeforeSetEntry($module, $data);
        event($before);
        $result = $this->crmApi->setEntry($module, $before->getNameValueList());
        $after = new AfterSetEntry($module, $result);
        event($after);
        return response()->json($after->getResult());
    }

    public function setEntries(string $module, Request $request)
    {
        $data = $request->all();
        $finalData = array();
        if ($request->exists('entry')) {
            $finalData = $data['entry'];
        }
        $before = new BeforeSetEntries($module, $finalData);
        event($before);
        $result = $this->crmApi->setEntries($before->getModule(), $before->getNameValueList());
        $after = new AfterSetEntries($module, $result);
        event($after);
        return response()->json($after->getResult());
    }

    /**
     * @param string $module
     * @param string $id
     * @param string $linkFieldName
     * @param Request $request
     * @return JsonResponse
     * @throws \Esatic\Suitecrm\Exceptions\AuthenticationException
     */
    public function setRelationship(string $module, string $id, string $linkFieldName, Request $request): JsonResponse
    {
        $ids = $request->input('ids');
        $before = new BeforeSetRelationship($module, $id, $linkFieldName, $ids);
        event($before);
        $result = $this->crmApi->setRelationship($module, $id, $linkFieldName, $ids);
        $after = new AfterSetRelationship($module, $result);
        event($after);
        return response()->json($after->getResult());
    }

    /**
     * @param string $module
     * @param Request $request
     * @return JsonResponse
     * @throws \Esatic\Suitecrm\Exceptions\AuthenticationException
     */
    public function getEntries(string $module, Request $request): JsonResponse
    {
        $ids = explode(',', $request->input('ids'));
        $fields = explode(',', $request->input('fields'));
        $link_name_to_fields_array = explode(',', $request->input('link_name_to_fields_array'));
        $track_view = $request->input('track_view', false);
        $before = new BeforeGetEntries($module, $ids, $fields, $link_name_to_fields_array, $track_view);
        event($before);
        $result = $this->crmApi->getEntries($module, $ids, $fields, $link_name_to_fields_array, $track_view);
        $after = new AfterGetEntries($module, $result);
        event($after);
        return response()->json($after->getResult());
    }
}

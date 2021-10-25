<?php

namespace Esatic\Suitecrm\Http\Controllers;

use Esatic\Suitecrm\Contracts\ApiCrmInterface;
use Esatic\Suitecrm\Events\AfterGetAvailableModules;
use Esatic\Suitecrm\Events\AfterGetEntries;
use Esatic\Suitecrm\Events\AfterGetEntry;
use Esatic\Suitecrm\Events\AfterGetEntryList;
use Esatic\Suitecrm\Events\AfterGetModuleFields;
use Esatic\Suitecrm\Events\AfterGetRelationships;
use Esatic\Suitecrm\Events\AfterSetEntry;
use Esatic\Suitecrm\Events\AfterSetRelationship;
use Esatic\Suitecrm\Events\BeforeGetAvailableModules;
use Esatic\Suitecrm\Events\BeforeGetEntries;
use Esatic\Suitecrm\Events\BeforeGetEntry;
use Esatic\Suitecrm\Events\BeforeGetEntryList;
use Esatic\Suitecrm\Events\BeforeGetModuleFields;
use Esatic\Suitecrm\Events\BeforeGetRelationships;
use Esatic\Suitecrm\Events\BeforeSetEntry;
use Esatic\Suitecrm\Events\BeforeSetRelationship;
use Esatic\Suitecrm\Services\ApiCrm;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
        event(new BeforeGetRelationships($module, $moduleId, $linkFieldName, $relatedFields, $relatedModuleQuery, $orderBy, $offset, $limit, $relatedModuleLinkName, $deleted, $favorites));
        $result = $this->crmApi->getRelationships($module, $moduleId, $linkFieldName, $relatedFields, $relatedModuleQuery, $orderBy, $offset, $limit, $relatedModuleLinkName, $deleted, $favorites);
        event(new AfterGetRelationships($module, $result));
        return response()->json($result);
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
        event(new AfterGetEntry($module, $result));
        return response()->json($result);
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
        event(new BeforeSetEntry($module, $data));
        $result = $this->crmApi->setEntry($module, $data);
        event(new AfterSetEntry($module, $result));
        return response()->json($result);
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
        event(new BeforeSetRelationship($module, $id, $linkFieldName, $ids));
        $result = $this->crmApi->setRelationship($module, $id, $linkFieldName, $ids);
        event(new AfterSetRelationship($module, $result));
        return response()->json($result);
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
        event(new BeforeGetEntries($module, $ids, $fields, $link_name_to_fields_array, $track_view));
        $result = $this->crmApi->getEntries($module, $ids, $fields, $link_name_to_fields_array, $track_view);
        event(new AfterGetEntries($module, $result));
        return response()->json($result);
    }
}

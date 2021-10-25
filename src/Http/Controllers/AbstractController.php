<?php

namespace Esatic\Suitecrm\Http\Controllers;

use Esatic\Suitecrm\Contracts\ApiCrmInterface;
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
        return response()->json($this->crmApi->getEntryList(
            $module,
            !is_null($request->input('query')) ? $request->input('query') : '',
            $request->input('order_by', 'date_entered'),
            $request->input('offset', 0),
            explode(',', $request->input('fields')),
            $request->input('link_field_name', array()),
            $request->input('limit', 20),
            $request->input('deleted', 0),
            $request->input('favorite', false)
        ));
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
        return response()->json($this->crmApi->getRelationships(
            $module,
            $moduleId,
            $linkFieldName,
            explode(',', $request->input('related_fields')),
            !is_null($request->input('query')) ? $request->input('query') : '',
            $request->input('order_by', 'date_entered'),
            $request->input('offset', 0),
            $request->input('limit', 20),
            array(),
            $request->input('deleted', 0)
        ));
    }

    /**
     * @param string $module
     * @param string $id
     * @return JsonResponse
     * @throws \Esatic\Suitecrm\Exceptions\AuthenticationException
     */
    public function getEntry(string $module, string $id): JsonResponse
    {
        return response()->json($this->crmApi->getEntry($id, $module));
    }

    /**
     * @return JsonResponse
     * @throws \Esatic\Suitecrm\Exceptions\AuthenticationException
     */
    public function getAvailableModules(): JsonResponse
    {
        return response()->json($this->crmApi->getAvailableModules());
    }

    /**
     * @param string $module
     * @return JsonResponse
     * @throws \Esatic\Suitecrm\Exceptions\AuthenticationException
     */
    public function getModuleFields(string $module): JsonResponse
    {
        return response()->json($this->crmApi->getModuleFields($module));
    }

    /**
     * @param string $module
     * @param Request $request
     * @return JsonResponse
     * @throws \Esatic\Suitecrm\Exceptions\AuthenticationException
     */
    public function setEntry(string $module, Request $request): JsonResponse
    {
        return response()->json($this->crmApi->setEntry($module, $request->all()));
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
        return response()->json($this->crmApi->setRelationship(
            $module,
            $id,
            $linkFieldName,
            $request->input('ids')
        ));
    }

    /**
     * @param string $module
     * @return JsonResponse
     * @throws \Esatic\Suitecrm\Exceptions\AuthenticationException
     */
    public function getEntries(string $module, Request $request): JsonResponse
    {
        return response()->json($this->crmApi->getEntries(
            $module,
            explode(',', $request->input('ids')),
            explode(',', $request->input('fields'))
        ));
    }
}

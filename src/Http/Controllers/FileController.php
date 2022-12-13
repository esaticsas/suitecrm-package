<?php

namespace Esatic\Suitecrm\Http\Controllers;

use Esatic\Suitecrm\Events\AfterUploadFile;
use Esatic\Suitecrm\Services\CrmUrlFilesService;
use Esatic\Suitecrm\Services\UploadFileService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FileController
{


    protected UploadFileService $uploadFileService;
    protected CrmUrlFilesService $crmUrlFilesService;

    /**
     * @param UploadFileService $uploadFileService
     * @param CrmUrlFilesService $crmUrlFilesService
     */
    public function __construct(
        UploadFileService  $uploadFileService,
        CrmUrlFilesService $crmUrlFilesService
    )
    {
        $this->uploadFileService = $uploadFileService;
        $this->crmUrlFilesService = $crmUrlFilesService;
    }

    /**
     * @param string $module
     * @param Request $request
     * @return JsonResponse
     * @throws GuzzleException
     */
    public function upload(string $module, Request $request): JsonResponse
    {
        $response = $this->uploadFileService->upload($module);
        event(new AfterUploadFile($response));
        return response()->json($response);
    }

    /**
     * @param string $module
     * @param string $id
     * @return JsonResponse
     */
    public function download(string $module, string $id): JsonResponse
    {
        $finalUrl = $this->crmUrlFilesService->getUrl();
        $apiUrl = sprintf('%s/index.php?entryPoint=getDocument&module=%s&id=%s', $finalUrl, $module, $id);
        return response()->json(['url' => $apiUrl]);
    }
}

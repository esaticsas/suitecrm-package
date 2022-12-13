<?php

namespace Esatic\Suitecrm\Services;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class UploadFileService
{
    protected Client $client;
    protected Request $request;
    protected CrmUrlFilesService $crmUrlFilesService;

    /**
     * @param Client $client
     * @param Request $request
     * @param CrmUrlFilesService $crmUrlFilesService
     */
    public function __construct(Client $client, Request $request, CrmUrlFilesService $crmUrlFilesService)
    {
        $this->client = $client;
        $this->request = $request;
        $this->crmUrlFilesService = $crmUrlFilesService;
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function upload(string $module)
    {
        $finalUrl = $this->crmUrlFilesService->getUrl();
        $apiUrl = sprintf('%s/index.php?entryPoint=uploadDocument&module=%s', $finalUrl, $module);
        $file = $this->request->file('file');
        $multipartData = [];
        foreach ($this->request->all() as $key => $item) {
            $multipartData[] = [
                'name' => $key,
                'contents' => $item
            ];
        }
        $file = $this->request->file('file');
        $multipartData[] = [
            'name' => 'file',
            'contents' => file_get_contents($file),
            'headers' => ['Content-Type' => $file->getClientMimeType()],
            'filename' => $file->getClientOriginalName()
        ];
        $response = $this->client->request('POST', $apiUrl, array(
            'multipart' => $multipartData
        ));
        return json_decode($response->getBody()->getContents(), true);
    }

}

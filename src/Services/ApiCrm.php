<?php


namespace Esatic\Suitecrm\Services;


use Esatic\Suitecrm\Contracts\ApiCrmInterface;
use Esatic\Suitecrm\Exceptions\AuthenticationException;
use Esatic\Suitecrm\Exceptions\CrmException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ApiCrm implements ApiCrmInterface
{
    private Api $api;
    private AuthApi $authApiService;
    private CrmUrlFilesService $crmUrlFilesService;
    private Client $client;

    /**
     * ApiCrm constructor.
     * @param Api $api
     * @param AuthApi $authApiService
     * @param CrmUrlFilesService $crmUrlFilesService
     * @param Client $client
     */
    public function __construct(
        Api                $api,
        AuthApi            $authApiService,
        CrmUrlFilesService $crmUrlFilesService,
        Client             $client
    )
    {
        $this->api = $api;
        $this->authApiService = $authApiService;
        $this->crmUrlFilesService = $crmUrlFilesService;
        $this->client = $client;
    }

    /**
     * @see https://docs.suitecrm.com/developer/api/api-v4.1-methods/#_get_entry_list
     *
     * @param string $module
     * @param string $query Filter query - Added to the SQL where clause,
     * @param string $orderBy
     * @param int $offset Start with the first record
     * @param array $selectFields Return the module fields
     * @param array $linkNameFields Link to the 'module' relationship and retrieve the fields
     * @param int $maxResults Show max results
     * @param int $deleted Do not show deleted
     * @param bool $favorites If only records marked as favorites should be returned.
     * @return mixed
     * @throws \Esatic\Suitecrm\Exceptions\AuthenticationException
     * @throws CrmException
     */
    public function getEntryList(
        string $module,
        string $query,
        string $orderBy = '',
        int    $offset = 0,
        array  $selectFields = array(),
        array  $linkNameFields = array(),
        int    $maxResults = 10,
        int    $deleted = 0,
        bool   $favorites = false
    ): array
    {
        $sessId = $this->authApiService->auth();
        $entryArgs = array(
            'session' => $sessId,
            'module_name' => $module,
            //Filter query - Added to the SQL where clause,
            'query' => $query,
            //Order by - unused
            'order_by' => $orderBy,
            //Start with the first record
            'offset' => $offset,
            //Return the id and name fields
            'select_fields' => $selectFields,
            //Link to the 'contacts' relationship and retrieve the
            //First and last names.
            'link_name_to_fields_array' => $linkNameFields,
            //Show max results
            'max_results' => $maxResults,
            //Do not show deleted
            'deleted' => $deleted,
            //If only records marked as favorites should be returned.
            'favorites' => $favorites,
        );
        return $this->api->sendRequest('get_entry_list', $entryArgs);
    }

    /**
     * @see https://docs.suitecrm.com/developer/api/api-v4.1-methods/#_get_relationships
     *
     * @param string $module
     * @param string $moduleId
     * @param string $linkFieldName
     * @param array $relatedFields
     * @param string $relatedModuleQuery
     * @param string $orderBy
     * @param int $offset
     * @param int $limit
     * @param array $relatedModuleLinkName
     * @param bool $deleted
     * @param bool $favorites
     * @return mixed
     * @throws \Esatic\Suitecrm\Exceptions\AuthenticationException
     * @throws CrmException
     */
    public function getRelationships(
        string $module,
        string $moduleId,
        string $linkFieldName,
        array  $relatedFields = [],
        string $relatedModuleQuery = '',
        string $orderBy = '',
        int    $offset = 0,
        int    $limit = 0,
        array  $relatedModuleLinkName = array(),
        bool   $deleted = false,
        bool   $favorites = false
    ): array
    {
        $sessId = $this->authApiService->auth();
        $get_relationships_parameters = array(
            'session' => $sessId,
            'module_name' => $module,
            'module_id' => $moduleId,
            'link_field_name' => $linkFieldName,
            'related_module_query' => $relatedModuleQuery,
            'related_fields' => $relatedFields,
            'related_module_link_name_to_fields_array' => $relatedModuleLinkName,
            'deleted' => $deleted,
            'order_by' => $orderBy,
            'offset' => $offset,
            'limit' => $limit,
            //If only records marked as favorites should be returned.
            'favorites' => $favorites,
        );
        return $this->api->sendRequest('get_relationships', $get_relationships_parameters);
    }

    /**
     * @see https://docs.suitecrm.com/developer/api/api-v4.1-methods/#_get_entry
     *
     * @param string $id the ID of the record to retrieve.
     * @param string $module the name of the module from which to retrieve records
     * @return mixed
     * @throws \Esatic\Suitecrm\Exceptions\AuthenticationException
     * @throws CrmException
     */
    public function getEntry(string $id, string $module): array
    {
        $sessId = $this->authApiService->auth();
        $get_entry_parameters = array(
            //session id
            'session' => $sessId,
            //The name of the module from which to retrieve records
            'module_name' => $module,
            //The ID of the record to retrieve.
            'id' => $id,
            //The list of fields to be returned in the results
            'select_fields' => array(),
            //A list of link names and the fields to be returned for each link name
            'link_name_to_fields_array' => array(),
        );
        return $this->api->sendRequest('get_entry', $get_entry_parameters);
    }

    /**
     * @see https://docs.suitecrm.com/developer/api/api-v4.1-methods/#_get_available_modules
     *
     * @return mixed
     * @throws \Esatic\Suitecrm\Exceptions\AuthenticationException
     * @throws CrmException
     */
    public function getAvailableModules(): array
    {
        $sessId = $this->authApiService->auth();
        $get_available_modules_parameters = array(
            //Session id
            'session' => $sessId,
            //Module filter. Possible values are 'default', 'mobile', 'all'.
            'filter' => 'all',
        );
        return $this->api->sendRequest('get_available_modules', $get_available_modules_parameters);
    }


    /**
     * @see https://docs.suitecrm.com/developer/api/api-v4.1-methods/#_get_module_fields
     *
     * @param string $module The name of the module from which to retrieve fields
     * @return mixed
     * @throws \Esatic\Suitecrm\Exceptions\AuthenticationException
     * @throws CrmException
     */
    public function getModuleFields(string $module): array
    {
        $sessId = $this->authApiService->auth();
        $get_module_fields_parameters = array(
            //Session id
            'session' => $sessId,

            //The name of the module from which to retrieve fields
            'module_name' => $module,

            //List of specific fields
            'fields' => array(),
        );
        return $this->api->sendRequest('get_module_fields', $get_module_fields_parameters);
    }

    /**
     * @see https://docs.suitecrm.com/developer/api/api-v4.1-methods/#_set_entry
     *
     * @param string $module The name of the module from which to save records.
     * @param array $nameValueList
     * @return mixed
     * @throws \Esatic\Suitecrm\Exceptions\AuthenticationException
     * @throws CrmException
     */
    public function setEntry(string $module, array $nameValueList): array
    {
        $sessId = $this->authApiService->auth();
        $set_entry_parameters = array(
            //session id
            'session' => $sessId,
            //The name of the module from which to retrieve records.
            'module_name' => $module,
            //Record attributes
            'name_value_list' => $nameValueList,
        );
        return $this->api->sendRequest('set_entry', $set_entry_parameters);
    }

    /**
     * @see https://docs.suitecrm.com/developer/api/api-v4.1-methods/#_set_entries
     *
     * @param string $module The name of the module from which to save records.
     * @param array $nameValueList
     * @return mixed
     * @throws \Esatic\Suitecrm\Exceptions\AuthenticationException
     * @throws CrmException
     */
    public function setEntries(string $module, array $nameValueList): array
    {
        $sessId = $this->authApiService->auth();
        $set_entry_parameters = array(
            //session id
            'session' => $sessId,
            //The name of the module from which to retrieve records.
            'module_name' => $module,
            //Record attributes
            'name_value_list' => $nameValueList,
        );
        return $this->api->sendRequest('set_entries', $set_entry_parameters);
    }

    /**
     * @see https://docs.suitecrm.com/developer/api/api-v4.1-methods/#_set_relationship
     *
     * @param string $module The name of the module.
     * @param string $id The ID of the specified module bean.
     * @param string $linkFieldName The relationship name of the linked field from which to relate records.
     * @param array $relatedIds The list of record ids to relate
     * @param array $nameValueList Sets the value for relationship based fields
     * @return mixed
     * @throws \Esatic\Suitecrm\Exceptions\AuthenticationException
     * @throws CrmException
     */
    public function setRelationship(string $module, string $id, string $linkFieldName, array $relatedIds, array $nameValueList = []): array
    {
        $sessId = $this->authApiService->auth();
        $set_relationship_parameters = array(
            //session id
            'session' => $sessId,
            //The name of the module.
            'module_name' => $module,
            //The ID of the specified module bean.
            'module_id' => $id,
            //The relationship name of the linked field from which to relate records.
            'link_field_name' => $linkFieldName,
            //The list of record ids to relate
            'related_ids' => $relatedIds,
            //Sets the value for relationship based fields
            'name_value_list' => $nameValueList,

            //Whether or not to delete the relationship. 0:create, 1:delete
            'delete' => 0,
        );
        return $this->api->sendRequest('set_relationship', $set_relationship_parameters);
    }

    /**
     * @see https://docs.suitecrm.com/developer/api/api-v4.1-methods/#_set_note_attachment
     *
     * @param string $noteId
     * @param string $fileName The file name of the attachment.
     * @param string $content
     * @param string $relatedModule
     * @return mixed
     * @throws \Esatic\Suitecrm\Exceptions\AuthenticationException
     * @throws CrmException
     */
    public function setNoteAttachment(string $noteId, string $fileName, string $content, string $relatedModule): array
    {
        $sessId = $this->authApiService->auth();
        $set_note_attachment_parameters = array(
            //Session id
            "session" => $sessId,

            //The attachment details
            "note" => array(
                'id' => $noteId,
                //The file name of the attachment.
                'filename' => $fileName,
                //The binary contents of the file.
                'file' => base64_encode($content),
                'related_module_name' => $relatedModule
            ),
        );
        return $this->api->sendRequest('set_note_attachment', $set_note_attachment_parameters);
    }

    /**
     * @see https://docs.suitecrm.com/developer/api/api-v4.1-methods/#_get_note_attachment
     *
     * @param string $noteId
     * @return mixed
     * @throws \Esatic\Suitecrm\Exceptions\AuthenticationException
     * @throws CrmException
     */
    public function getNoteAttachment(string $noteId): array
    {
        $sessId = $this->authApiService->auth();
        $get_note_attachment_parameters = array(
            //Session id
            "session" => $sessId,
            //The ID of the note containing the attachment.
            'id' => $noteId,
        );
        return $this->api->sendRequest('get_note_attachment', $get_note_attachment_parameters);
    }

    /**
     * @see https://docs.suitecrm.com/developer/api/api-v4.1-methods/#_get_entries
     *
     * @param string $module
     * @param array $ids
     * @param array $select_fields
     * @param array $link_name_to_fields_array
     * @param bool $track_view
     * @return mixed
     * @throws \Esatic\Suitecrm\Exceptions\AuthenticationException
     * @throws CrmException
     */
    public function getEntries(string $module, array $ids, array $select_fields = [], array $link_name_to_fields_array = [], bool $track_view = false): array
    {
        $sessId = $this->authApiService->auth();
        $getEntriesParameters = array(
            'session' => $sessId,
            'module_name' => $module,
            'ids' => $ids,
            'select_fields' => $select_fields,
            'link_name_to_fields_array' => $link_name_to_fields_array,
            'track_view' => $track_view
        );
        return $this->api->sendRequest('get_entries', $getEntriesParameters);
    }

    /**
     * @throws AuthenticationException
     * @throws CrmException
     */
    public function genericRequest(string $method, array $restData): array
    {
        $token = $this->authApiService->auth();
        $data['session'] = $token;
        $resultData = array_merge($data, $restData);
        return $this->api->sendRequest($method, $resultData);
    }

    /**
     * @throws GuzzleException
     */
    public function getEntryPoint(string $entryPoint, array $params = []): array
    {
        $response = $this->client->request('GET', $this->getUrl($entryPoint, $params));
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @throws GuzzleException
     */
    public function postEntryPoint(string $entryPoint, array $params = [], array $body = []): array
    {
        $response = $this->client->request('POST', $this->getUrl($entryPoint, $params), $body);
        return json_decode($response->getBody(), true);
    }

    protected function getUrl(string $entryPoint, array $params = []): string
    {
        $finalUrl = $this->crmUrlFilesService->getUrl();
        $params = http_build_query($params);
        return sprintf('%s/index.php?entryPoint=%s&%s', $finalUrl, $entryPoint, $params);
    }
}

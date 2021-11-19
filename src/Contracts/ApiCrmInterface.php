<?php

namespace Esatic\Suitecrm\Contracts;

interface ApiCrmInterface
{

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
     * @return array
     * @throws \Esatic\Suitecrm\Exceptions\AuthenticationException
     */
    public function getEntryList(string $module, string $query, string $orderBy = '', int $offset = 0, array $selectFields = array(), array $linkNameFields = array(), int $maxResults = 10, int $deleted = 0, bool $favorites = false): array;

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
     */
    public function getRelationships(string $module, string $moduleId, string $linkFieldName, array $relatedFields = [], string $relatedModuleQuery = '', string $orderBy = '', int $offset = 0, int $limit = 0, array $relatedModuleLinkName = array(), bool $deleted = false, bool $favorites = false): array;


    /**
     * @see https://docs.suitecrm.com/developer/api/api-v4.1-methods/#_get_entry
     *
     * @param string $id the ID of the record to retrieve.
     * @param string $module the name of the module from which to retrieve records
     * @return mixed
     * @throws \Esatic\Suitecrm\Exceptions\AuthenticationException
     */
    public function getEntry(string $id, string $module): array;


    /**
     * @see https://docs.suitecrm.com/developer/api/api-v4.1-methods/#_get_available_modules
     *
     * @return mixed
     * @throws \Esatic\Suitecrm\Exceptions\AuthenticationException
     */
    public function getAvailableModules(): array;


    /**
     * @see https://docs.suitecrm.com/developer/api/api-v4.1-methods/#_get_module_fields
     *
     * @param string $module The name of the module from which to retrieve fields
     * @return mixed
     * @throws \Esatic\Suitecrm\Exceptions\AuthenticationException
     */
    public function getModuleFields(string $module): array;

    /**
     * @see https://docs.suitecrm.com/developer/api/api-v4.1-methods/#_set_entry
     *
     * @param string $module The name of the module from which to save records.
     * @param array $nameValueList
     * @return mixed
     * @throws \Esatic\Suitecrm\Exceptions\AuthenticationException
     */
    public function setEntry(string $module, array $nameValueList): array;


    /**
     * @see https://docs.suitecrm.com/developer/api/api-v4.1-methods/#_set_entries
     *
     * @param string $module The name of the module from which to save records.
     * @param array $nameValueList
     * @return mixed
     * @throws \Esatic\Suitecrm\Exceptions\AuthenticationException
     */
    public function setEntries(string $module, array $nameValueList): array;


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
     */
    public function setRelationship(string $module, string $id, string $linkFieldName, array $relatedIds, array $nameValueList = []): array;


    /**
     * @see https://docs.suitecrm.com/developer/api/api-v4.1-methods/#_set_note_attachment
     *
     * @param string $noteId
     * @param string $fileName The file name of the attachment.
     * @param string $content
     * @param string $relatedModule
     * @return mixed
     * @throws \Esatic\Suitecrm\Exceptions\AuthenticationException
     */
    public function setNoteAttachment(string $noteId, string $fileName, string $content, string $relatedModule): array;


    /**
     * @see https://docs.suitecrm.com/developer/api/api-v4.1-methods/#_get_note_attachment
     *
     * @param string $noteId
     * @return mixed
     * @throws \Esatic\Suitecrm\Exceptions\AuthenticationException
     */
    public function getNoteAttachment(string $noteId): array;

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
     */
    public function getEntries(string $module, array $ids, array $select_fields = [], array $link_name_to_fields_array = [], bool $track_view = false): array;


}

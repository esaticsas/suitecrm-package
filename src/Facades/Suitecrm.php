<?php


namespace Esatic\Suitecrm\Facades;


use Illuminate\Support\Facades\Facade;

/**
 * Reference Class \Esatic\Suitecrm\Facades\CrmApi
 * show off @method
 * @method static mixed|array getEntryList(string $module, string $query, string $orderBy = '', int $offset = 0, array $selectFields = array(), array $linkNameFields = array(), int $maxResults = 10, int $deleted = 0, bool $favorites = false)
 * @method static mixed|array getRelationShipData(string $module, string $moduleId, string $linkFieldName, array $relatedFields = [], string $relatedModuleQuery = '', string $orderBy = '', int $offset = 0, int $limit = 0, array $relatedModuleLinkName = array())
 * @method static mixed|array getEntry(string $id, string $module)
 * @method static mixed|array getAvailableModules()
 * @method static mixed|array getModuleFields(string $module)
 * @method static mixed|array setEntry(string $module, array $nameValueList)
 * @method static mixed|array setRelationship(string $module, string $id, string $linkFieldName, array $relatedIds, array $nameValueList = [])
 * @method static mixed|array setNoteAttachment(string $noteId, string $fileName, string $content, string $relatedModule)
 * @method static mixed|array getNoteAttachment(string $noteId)
 */
class Suitecrm extends Facade
{

    const FACADE = 'suitecrm';

    protected static function getFacadeAccessor(): string
    {
        return self::FACADE;
    }

}

<?php


namespace Esatic\Suitecrm\Facades;


use Illuminate\Support\Facades\Facade;

/**
 * Reference Class \Esatic\Suitecrm\Services\ApiCrm
 * show off @method
 * @method static mixed|array getEntry(string $id, string $module)
 * @method static mixed|array getAvailableModules()
 * @method static mixed|array getModuleFields(string $module)
 * @method static mixed|array setEntry(string $module, array $nameValueList)
 * @method static mixed|array setRelationship(string $module, string $id, string $linkFieldName, array $relatedIds, array $nameValueList = [])
 * @method static mixed|array setNoteAttachment(string $noteId, string $fileName, string $content, string $relatedModule)
 * @method static mixed|array getNoteAttachment(string $noteId)
 * @method static mixed|array getEntries(string $module, array $ids, array $select_fields = [], array $link_name_to_fields_array = [], bool $track_view = false)
 * @method static mixed|array genericRequest(string $method, array $restData)
 */
class Suitecrm extends Facade
{

    const FACADE = 'suitecrm';

    protected static function getFacadeAccessor(): string
    {
        return self::FACADE;
    }

}

<?php

namespace Esatic\Suitecrm\Events;

class BeforeSetRelationship extends BaseEvent
{

    private string $module;
    private string $id;
    private string $linkFieldName;
    private array $relatedIds;
    private array $nameValueList;

    public function __construct(string $module, string $id, string $linkFieldName, array $relatedIds, array $nameValueList = [])
    {
        $this->module = $module;
        $this->id = $id;
        $this->linkFieldName = $linkFieldName;
        $this->relatedIds = $relatedIds;
        $this->nameValueList = $nameValueList;
    }

    /**
     * @return string
     */
    public function getModule(): string
    {
        return $this->module;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLinkFieldName(): string
    {
        return $this->linkFieldName;
    }

    /**
     * @return array
     */
    public function getRelatedIds(): array
    {
        return $this->relatedIds;
    }

    /**
     * @return array
     */
    public function getNameValueList(): array
    {
        return $this->nameValueList;
    }


}

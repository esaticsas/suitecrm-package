<?php

namespace Esatic\Suitecrm\Events;

class BeforeGetRelationships extends BaseEvent
{
    private array $relatedFields;
    private string $relatedModuleQuery;
    private string $orderBy;
    private int $offset;
    private int $limit;
    private array $relatedModuleLinkName;
    private bool $deleted;
    private bool $favorites;
    private string $module;
    private string $moduleId;
    private string $linkFieldName;


    /**
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
     */
    public function __construct(string $module, string $moduleId, string $linkFieldName, array $relatedFields = [], string $relatedModuleQuery = '', string $orderBy = '', int $offset = 0, int $limit = 0, array $relatedModuleLinkName = array(), bool $deleted = false, bool $favorites = false)
    {
        $this->relatedFields = $relatedFields;
        $this->relatedModuleQuery = $relatedModuleQuery;
        $this->orderBy = $orderBy;
        $this->offset = $offset;
        $this->limit = $limit;
        $this->relatedModuleLinkName = $relatedModuleLinkName;
        $this->deleted = $deleted;
        $this->favorites = $favorites;
        $this->module = $module;
        $this->moduleId = $moduleId;
        $this->linkFieldName = $linkFieldName;
    }

    /**
     * @return array
     */
    public function getRelatedFields(): array
    {
        return $this->relatedFields;
    }

    /**
     * @return string
     */
    public function getRelatedModuleQuery(): string
    {
        return $this->relatedModuleQuery;
    }

    /**
     * @return string
     */
    public function getOrderBy(): string
    {
        return $this->orderBy;
    }

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @return array
     */
    public function getRelatedModuleLinkName(): array
    {
        return $this->relatedModuleLinkName;
    }

    /**
     * @return bool
     */
    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    /**
     * @return bool
     */
    public function isFavorites(): bool
    {
        return $this->favorites;
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
    public function getModuleId(): string
    {
        return $this->moduleId;
    }

    /**
     * @return string
     */
    public function getLinkFieldName(): string
    {
        return $this->linkFieldName;
    }

    /**
     * @param array $relatedFields
     */
    public function setRelatedFields(array $relatedFields): void
    {
        $this->relatedFields = $relatedFields;
    }

    /**
     * @param string $relatedModuleQuery
     */
    public function setRelatedModuleQuery(string $relatedModuleQuery): void
    {
        $this->relatedModuleQuery = $relatedModuleQuery;
    }

    /**
     * @param string $orderBy
     */
    public function setOrderBy(string $orderBy): void
    {
        $this->orderBy = $orderBy;
    }

    /**
     * @param int $offset
     */
    public function setOffset(int $offset): void
    {
        $this->offset = $offset;
    }

    /**
     * @param int $limit
     */
    public function setLimit(int $limit): void
    {
        $this->limit = $limit;
    }

    /**
     * @param array $relatedModuleLinkName
     */
    public function setRelatedModuleLinkName(array $relatedModuleLinkName): void
    {
        $this->relatedModuleLinkName = $relatedModuleLinkName;
    }

    /**
     * @param bool $deleted
     */
    public function setDeleted(bool $deleted): void
    {
        $this->deleted = $deleted;
    }

    /**
     * @param bool $favorites
     */
    public function setFavorites(bool $favorites): void
    {
        $this->favorites = $favorites;
    }

    /**
     * @param string $module
     */
    public function setModule(string $module): void
    {
        $this->module = $module;
    }

    /**
     * @param string $moduleId
     */
    public function setModuleId(string $moduleId): void
    {
        $this->moduleId = $moduleId;
    }

    /**
     * @param string $linkFieldName
     */
    public function setLinkFieldName(string $linkFieldName): void
    {
        $this->linkFieldName = $linkFieldName;
    }


}

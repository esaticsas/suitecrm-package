<?php

namespace Esatic\Suitecrm\Events;

class BeforeGetEntryList extends BaseEvent
{
    private string $module;
    private string $query;
    private string $orderBy;
    private int $offset;
    private array $selectFields;
    private array $linkNameFields;
    private int $maxResults;
    private int $deleted;
    private bool $favorites;

    public function __construct(string $module, string $query, string $orderBy = '', int $offset = 0, array $selectFields = array(), array $linkNameFields = array(), int $maxResults = 10, int $deleted = 0, bool $favorites = false)
    {
        $this->module = $module;
        $this->query = $query;
        $this->orderBy = $orderBy;
        $this->offset = $offset;
        $this->selectFields = $selectFields;
        $this->linkNameFields = $linkNameFields;
        $this->maxResults = $maxResults;
        $this->deleted = $deleted;
        $this->favorites = $favorites;
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
    public function getQuery(): string
    {
        return $this->query;
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
     * @return array
     */
    public function getSelectFields(): array
    {
        return $this->selectFields;
    }

    /**
     * @return array
     */
    public function getLinkNameFields(): array
    {
        return $this->linkNameFields;
    }

    /**
     * @return int
     */
    public function getMaxResults(): int
    {
        return $this->maxResults;
    }

    /**
     * @return int
     */
    public function getDeleted(): int
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


}

<?php

namespace Esatic\Suitecrm\Events;

class BeforeGetEntries extends BaseEvent
{

    private string $module;
    private array $ids;
    private array $select_fields;
    private array $link_name_to_fields_array;
    private bool $track_view;

    public function __construct(string $module, array $ids, array $select_fields = [], array $link_name_to_fields_array = [], bool $track_view = false)
    {
        $this->module = $module;
        $this->ids = $ids;
        $this->select_fields = $select_fields;
        $this->link_name_to_fields_array = $link_name_to_fields_array;
        $this->track_view = $track_view;
    }

    /**
     * @return string
     */
    public function getModule(): string
    {
        return $this->module;
    }

    /**
     * @return array
     */
    public function getIds(): array
    {
        return $this->ids;
    }

    /**
     * @return array
     */
    public function getSelectFields(): array
    {
        return $this->select_fields;
    }

    /**
     * @return array
     */
    public function getLinkNameToFieldsArray(): array
    {
        return $this->link_name_to_fields_array;
    }

    /**
     * @return bool
     */
    public function isTrackView(): bool
    {
        return $this->track_view;
    }


}

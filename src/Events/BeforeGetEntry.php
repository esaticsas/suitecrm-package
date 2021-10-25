<?php

namespace Esatic\Suitecrm\Events;

class BeforeGetEntry extends BaseEvent
{


    private string $module;
    private string $id;

    public function __construct(string $module, string $id)
    {
        $this->module = $module;
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getModule(): string
    {
        return $this->module;
    }

    /**
     * @param string $module
     */
    public function setModule(string $module): void
    {
        $this->module = $module;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }


}

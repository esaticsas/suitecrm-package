<?php

namespace Esatic\Suitecrm\Events;

class BeforeSetEntry extends BaseEvent
{

    private string $module;
    private array $nameValueList;

    public function __construct(string $module, array $nameValueList)
    {
        $this->module = $module;
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
     * @param string $module
     */
    public function setModule(string $module): void
    {
        $this->module = $module;
    }

    /**
     * @return array
     */
    public function getNameValueList(): array
    {
        return $this->nameValueList;
    }

    /**
     * @param array $nameValueList
     */
    public function setNameValueList(array $nameValueList): void
    {
        $this->nameValueList = $nameValueList;
    }


}

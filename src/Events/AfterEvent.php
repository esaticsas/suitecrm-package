<?php

namespace Esatic\Suitecrm\Events;

class AfterEvent extends BaseEvent
{
    private string $module;
    private array $result;

    /**
     * @param string $module
     * @param array $result
     */
    public function __construct(string $module, array $result)
    {
        $this->module = $module;
        $this->result = $result;
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
    public function getResult(): array
    {
        return $this->result;
    }


}

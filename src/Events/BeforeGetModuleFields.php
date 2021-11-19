<?php

namespace Esatic\Suitecrm\Events;

class BeforeGetModuleFields extends BaseEvent
{

    private string $module;

    public function __construct(string $module)
    {
        $this->module = $module;
    }

    /**
     * @return string
     */
    public function getModule(): string
    {
        return $this->module;
    }


}

<?php

namespace Esatic\Suitecrm\Events;

class AfterGetAvailableModules extends BaseEvent
{


    private array $result;

    public function __construct(array $result = [])
    {
        $this->result = $result;
    }

    /**
     * @return array
     */
    public function getResult(): array
    {
        return $this->result;
    }


}

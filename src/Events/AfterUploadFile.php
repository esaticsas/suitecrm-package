<?php

namespace Esatic\Suitecrm\Events;

class AfterUploadFile extends BaseEvent
{
    private array $result;

    /**
     * @param array $result
     */
    public function __construct(array &$result)
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

    /**
     * @param array $result
     */
    public function setResult(array $result): void
    {
        $this->result = $result;
    }
}

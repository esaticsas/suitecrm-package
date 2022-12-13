<?php

namespace Esatic\Suitecrm\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;

class RelatedItemsEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected Builder $query;
    protected Request $request;
    protected string $module;
    protected string $relationName;
    protected string $id;

    /**
     * @param Builder $query
     * @param Request $request
     * @param string $module
     * @param string $relationName
     * @param string $id
     */
    public function __construct(Builder $query, Request $request, string $module, string $relationName, string $id)
    {
        $this->query = $query;
        $this->request = $request;
        $this->module = $module;
        $this->relationName = $relationName;
        $this->id = $id;
    }

    /**
     * @return Builder
     */
    public function getQuery(): Builder
    {
        return $this->query;
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
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
    public function getRelationName(): string
    {
        return $this->relationName;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }


    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}

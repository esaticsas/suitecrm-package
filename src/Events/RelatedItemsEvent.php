<?php

namespace Esatic\Suitecrm\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;
use Esatic\Suitecrm\Models\RelatedModule;

class RelatedItemsEvent {

    use Dispatchable,
        InteractsWithSockets,
        SerializesModels;

    protected Builder $query;
    protected Request $request;
    protected string $module;
    protected string $relationName;
    protected string $id;
    protected RelatedModule $relateModule;

    /**
     * @param Builder $query
     * @param Request $request
     * @param string $module
     * @param string $relationName
     * @param string $id
     */
    public function __construct(Builder $query, Request $request, string $module, string $relationName, string $id, RelatedModule $relateModule) {
        $this->query = $query;
        $this->request = $request;
        $this->module = $module;
        $this->relationName = $relationName;
        $this->id = $id;
        $this->relateModule = $relateModule;
    }

    /**
     * @return Builder
     */
    public function getQuery(): Builder {
        return $this->query;
    }

    /**
     * @return Request
     */
    public function getRequest(): Request {
        return $this->request;
    }

    /**
     * @return string
     */
    public function getModule(): string {
        return $this->module;
    }

    /**
     * @return string
     */
    public function getRelationName(): string {
        return $this->relationName;
    }

    /**
     * @return string
     */
    public function getId(): string {
        return $this->id;
    }

    /**
     * @return RelatedModule
     */
    public function getRelateModule(): RelatedModule {
        return $this->relateModule;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn() {
        return new PrivateChannel('channel-name');
    }

}

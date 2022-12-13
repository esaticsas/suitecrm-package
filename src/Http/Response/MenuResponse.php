<?php

namespace Esatic\Suitecrm\Http\Response;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;

class MenuResponse implements Responsable
{
    protected array $compactItems;

    /**
     * @param array $compactItems
     */
    public function __construct(array $compactItems)
    {
        $this->compactItems = $compactItems;
    }


    public function toResponse($request): JsonResponse
    {
        $home = [
            'name' => 'home',
            'label' => 'Inicio',
            'title' => 'Inicio',
            'position' => -10,
            'icon' => 'heroicons_outline:home',
            'link' => '/home',
            'type' => 'basic'
        ];
        array_unshift($this->compactItems, $home);
        foreach ($this->compactItems as $compactItem) {
            $compactItem['title'] = $compactItem['label'];
        }
        $items = array(
            'compact' => $this->compactItems,
            'horizontal' => [],
            'default' => [],
            'futuristic' => []
        );
        return response()->json($items);
    }
}

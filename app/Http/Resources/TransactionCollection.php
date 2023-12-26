<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TransactionCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public $collects='App\Http\Resources\TransactionResource';

    public function toArray(Request $request): array
    {
        return [
            'results' => $this->collection,
            'next' => $this->nextPageUrl(),
            'previous'=>$this->previousPageUrl(),
        ];
    }
}

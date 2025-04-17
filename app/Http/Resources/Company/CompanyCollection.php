<?php

namespace App\Http\Resources\Company;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CompanyCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'meta' => [
                'total' => $this->total(),
                'limit' => $this->perPage(),
                'total_pages' => ceil($this->total() / $this->perPage()),
                'current_page' => $this->currentPage(),
                'last_page' => $this->lastPage(),
            ],
            'data' => CompanyResource::collection($this->collection),
        ];
    }
}

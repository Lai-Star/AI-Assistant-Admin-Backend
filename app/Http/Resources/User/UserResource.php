<?php

namespace App\Http\Resources\User;

use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'company_id' => Company::find($this->company_id)->name ?? '',
            // 'user_group_id' => $this->user_group_id,
            'updated_at' => $this->updated_at,
        ];
    }
}

<?php

namespace App\Http\Resources\UserGroup;

use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Resources\Json\JsonResource;

class UserGroupResource extends JsonResource
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
            'company_name' => Company::find($this->company_id)->name ?? '',
            'member_cnt' => $this->member_cnt,
            'created_at' => $this->created_at,
        ];
    }
}

<?php

namespace App\Http\Resources\Company;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
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
            'leader_user' => User::find($this->leader_user_id),
            'member_cnt' => $this->member_cnt,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClassesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        $arrayData = [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'seats' => $this->seats,
            'enrolled' => !!count($this->children),
        ];

        return $arrayData;
    }
}

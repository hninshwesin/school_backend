<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChildResource extends JsonResource
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
            'age' => $this->age,
            'enrolled' => new ClassesResourceCollection($this->classes),
        ];

        return $arrayData;
    }
}

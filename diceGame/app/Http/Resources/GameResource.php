<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            "id" => $this->id,
            "player_id" => $this->player_id,
            "dice_1" => $this->dice_1,
            "dice_2" => $this->dice_2,
            "result" => $this->result,


        ];
    }
}

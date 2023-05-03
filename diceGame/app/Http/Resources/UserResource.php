<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class UserResource extends JsonResource
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
            "username" => $this->username,
            "email" => $this->email,
            "total_games" => $this->total_games,
            "total_wins" => $this->total_wins,
            "winning_percentage" => $this->winning_percentage

        ];
    }
}

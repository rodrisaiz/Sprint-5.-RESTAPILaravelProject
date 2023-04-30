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
            "totalGames" => $this->total_games,
            "totalWins" => $this->total_wins,
            "winningPercentage" => $this->winning_percentage

        ];
    }
}

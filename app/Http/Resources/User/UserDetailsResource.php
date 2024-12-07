<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'mobile' => $this->mobile,
            'website' => $this->website,
            'facebook' => $this->facebook,
            'whatsapp' => $this->whatsapp,
            'linkedin' => $this->linkedin,
            'gender' => $this->gender,
            'date_of_birth' => Carbon::parse($this->date_of_birth)->format('d M Y'), 
            'nick_name' => $this->nick_name,
            'current_city' => $this->current_city,
            'primary_lang' => $this->primary_lang,
            'secondary_lang' => $this->secondary_lang,
            'favorite_quote' => $this->favorite_quote,
        ];
    }
}

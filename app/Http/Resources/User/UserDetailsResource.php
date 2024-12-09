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
            'mobile' => $this->whenHas('mobile'),
            'website' => $this->whenHas('website'),
            'facebook' => $this->whenHas('facebook'),
            'whatsapp' => $this->whenHas('whatsapp'),
            'linkedin' => $this->whenHas('linkedin'),
            'gender' => $this->whenHas('gender'),
            'date_of_birth' => Carbon::parse($this->whenHas('date_of_birth'))->format('d M Y'), 
            'nick_name' => $this->whenHas('nick_name'),
            'current_city' => $this->whenHas('current_city'),
            'primary_lang' => $this->whenHas('primary_lang'),
            'secondary_lang' => $this->whenHas('secondary_lang'),
            'favorite_quote' => $this->whenHas('favorite_quote'),
        ];
    }
}

<?php

namespace App\Http\Resources\Messenger;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResourceForMessengerSidebar extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'body' => $this->body(),
            'created_at' => $this->created_at->diffForHumans(),
            'read_at' => ($this->read_at) ? $this->read_at->diffForHumans() : null
        ];
    }

    // Prefixing message body
    public function body(){
        if($this->sender_id == auth()->id()){
            return "You: {$this->body}";
        }
        return $this->body;
    }
}

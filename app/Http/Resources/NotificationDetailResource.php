<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title'=>$this->data['title'],
            'message'=>$this->data['message'],
            'date'=>Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'web_link'=>$this->data['web_link'],
            
        ];
    }
}

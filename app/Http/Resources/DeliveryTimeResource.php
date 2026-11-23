<?php

namespace App\Http\Resources;

use App\Traits\Translatable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryTimeResource extends JsonResource
{
    use Translatable;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $start = Carbon::parse($this->start_time)->format('h:i A');
        $end   = Carbon::parse($this->end_time)->format('h:i A');
        $day   = ucfirst($this->day_of_week);
        $branchName = $this->translate($this->branch->name);

        return [
            'id'          => $this->id,
            'day_of_week' => $day,
            'start_time'  => $start ,
            'end_time'    => $end ,
            'branch_name' => $branchName,
            'label'       => "{$day}, {$start} - {$end} ({$branchName})",
        ];
    }
}

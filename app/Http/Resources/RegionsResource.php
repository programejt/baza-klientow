<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RegionsResource extends JsonResource
{
  public function __construct()
  {}

  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
   */
  public function toArray($request)
  {
      return parent::toArray($request);
  }

  public function json() {
    header('Content-Type: application/json');
    echo file_get_contents(base_path().'/resources/regions/regions.json');
    exit;
  }
}

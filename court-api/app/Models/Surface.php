<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surface extends Model {
    use HasFactory;

    protected $table = "surfaces";
    protected $primaryKey = "surface_id";
    protected $fillable = ["rent_cost", "name"];

    public function courts() {
        return $this->hasMany(Court::class, "court_id", null);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Court extends Model {
    use HasFactory;

    protected $table = "courts";
    protected $primaryKey = "court_id";
    protected $fillable = ["name", "surface_id"];

    public function surface() {
        return $this->hasOne(Surface::class, "surface_id", "surface_id");
    }

    public function reservations() {
        return $this->hasMany(Reservation::class, "reservation_id", null);
    }

    public function getRentCost(): float {
        // Per hour
        return $this->surface->rent_cost;
    }
}

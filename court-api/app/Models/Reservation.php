<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model {
    use HasFactory;

    protected $table = "reservations";
    protected $primaryKey = "reservation_id";
    protected $fillable = ["court_id", "user_id", "doubles", "phone_number", "start_ts", "end_ts"];

    public function court() {
        return $this->hasOne(Court::class, "court_id", "court_id");
    }

    public function user() {
        return $this->belongsTo(User::class, "user_id", "user_id");
    }

    public function calculateRentCost(): float {
        $duration = strtotime($this->end_ts) - strtotime($this->start_ts);
        $total_price = ($duration / (60*60)) * ($this->doubles === "1" ? $this->court->getRentCost() * 1.5 : $this->court->getRentCost());

        return $total_price;
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Court;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CourtsController extends Controller {
    public function index() {
        $courts = \App\Models\Court::join("surfaces", "courts.surface_id", "=", "surfaces.surface_id")
            ->select("courts.name as court_name", "surfaces.name as surface", "rent_cost")
            ->paginate(20);

        return response()->json($courts->items())
            ->header("X-Total", $courts->total())
            ->header("X-Prev-Page", $courts->previousPageUrl())
            ->header("X-Next-Page", $courts->nextPageUrl());
    }

    public function show(string $court_id) {
        $court = \App\Models\Court::join("surfaces", "courts.surface_id", "=", "surfaces.surface_id")
            ->select("court_id", "courts.name as court_name", "surfaces.name as surface", "rent_cost")
            ->firstWhere("court_id", $court_id);
        
        if ($court === null)
            return response()->json(["error" => "404 Not Found"], Response::HTTP_NOT_FOUND);
        
        return response()->json($court);
    }
}

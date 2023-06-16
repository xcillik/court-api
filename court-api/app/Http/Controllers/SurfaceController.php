<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SurfaceController extends Controller {
    public function index() {
        $courts = \App\Models\Surface::select("surface_id", "rent_cost", "name")
            ->paginate(20);

        return response()->json($courts->items())
            ->header("X-Total", $courts->total())
            ->header("X-Prev-Page", $courts->previousPageUrl())
            ->header("X-Next-Page", $courts->nextPageUrl());
    }

    public function show(string $court_id) {
        $court = \App\Models\Surface::select("surface_id", "rent_cost", "name")
            ->firstWhere("surface_id", $court_id);
        
        if ($court === null)
            return response()->json(["error" => "404 Not Found"], Response::HTTP_NOT_FOUND);
        
        return response()->json($court);
    }
}

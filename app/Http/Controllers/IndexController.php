<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class IndexController extends Controller
{
    //
    public function index(Request $request)
    {
        // Load the JSON file
        $jsonFilePath = storage_path('/app/social_media_data.json');
        $mediaData = [];

        if (file_exists($jsonFilePath)) {
            $mediaData = json_decode(file_get_contents($jsonFilePath), true);
        }
        $collection = collect($mediaData);
        $currentPage = $request->input('page', 1);

        $perPage = 20;

        $currentItems = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();

        // Create a LengthAwarePaginator instance
        $paginatedData = new LengthAwarePaginator(
            $currentItems, // Items for this page
            $collection->count(), // Total items
            $perPage, // Items per page
            $currentPage, // Current page
            ['path' => $request->url(), 'query' => $request->query()] // Preserve URL parameters
        );

        // Pass the JSON data to the Inertia page

//        return response()->json($paginatedData);
        return Inertia::render('Index', [
            'mediaData' => $paginatedData,
        ]);
    }
}

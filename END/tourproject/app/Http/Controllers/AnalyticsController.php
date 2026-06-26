<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnalyticsController extends Controller
{
    private $filePath = 'analytics.json';

    /**
     * Store a page visit or action event.
     * POST /api/analytics/visit
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'page_name'   => 'required|string|max:500',
            'user_agent'  => 'nullable|string|max:1000',
            'device_type' => 'nullable|string|max:50',
            'timestamp'   => 'nullable|string|max:50',
        ]);

        $data = [];
        if (Storage::exists($this->filePath)) {
            $data = json_decode(Storage::get($this->filePath), true) ?? [];
        }

        $validated['timestamp']  = $validated['timestamp'] ?? now()->toIso8601String();
        $validated['ip']         = $request->ip();
        $data[]                  = $validated;

        // Keep only last 10,000 entries to prevent file bloat
        if (count($data) > 10000) {
            $data = array_slice($data, -10000);
        }

        Storage::put($this->filePath, json_encode($data));

        return response()->json(['message' => 'Logged successfully']);
    }

    /**
     * Full analytics for admin dashboard.
     * GET /api/admin/analytics
     */
    public function index()
    {
        return response()->json($this->buildSummary());
    }

    /**
     * Build the analytics summary object from stored data.
     */
    private function buildSummary(): array
    {
        $data = [];
        if (Storage::exists($this->filePath)) {
            $data = json_decode(Storage::get($this->filePath), true) ?? [];
        }

        $totalViews   = 0;
        $pages        = [];
        $devices      = [];
        $whatsapp     = 0;
        $contactForm  = 0;

        foreach ($data as $visit) {
            $page   = $visit['page_name'] ?? 'unknown';
            $device = $visit['device_type'] ?? 'Unknown';

            if (str_starts_with($page, 'action:whatsapp_click')) {
                $whatsapp++;
            } elseif (str_starts_with($page, 'action:contact_form')) {
                $contactForm++;
            } else {
                // Regular page view
                $pages[$page] = ($pages[$page] ?? 0) + 1;
                $totalViews++;
            }

            // Device counts for all records
            $devices[$device] = ($devices[$device] ?? 0) + 1;
        }

        arsort($pages);
        arsort($devices);

        return [
            'total_views'                => $totalViews,
            'total_events'               => count($data),
            'most_visited_pages'         => $pages,
            'device_types'               => $devices,
            'whatsapp_clicks'            => $whatsapp,
            'contact_form_submissions'   => $contactForm,
            'raw_data'                   => array_slice(array_reverse($data), 0, 100),
        ];
    }
}

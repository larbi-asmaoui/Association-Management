<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Request;

class ChartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $chartData = [
            'options' => [
                'chart' => [
                    'id' => 'basic-line',
                ],
                'xaxis' => [
                    'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                ],
            ],
            'series' => [
                [
                    'name' => 'series-1',
                    'data' => [30, 40, 25, 50, 49, 21, 70, 51, 42, 36, 45, 56],
                ],
            ],
        ];

        return Inertia::render('Chart', [
            'chartData' => $chartData,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Services\CategorySpendService;
use Illuminate\Http\Request;
use App\Services\GainService;
use App\Services\SpendService;

class HomeController extends Controller
{
    protected $serviceGain;
    protected $serviceSpend;

    public function __construct(GainService $serviceGain, SpendService $serviceSpend)
    {
        $this->middleware('auth');
        $this->serviceGain = $serviceGain;
        $this->serviceSpend = $serviceSpend;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $gains = $this->serviceGain->sumAmountsMonth();
        $spends = $this->serviceSpend->sumAmountsMonth();

        $categoriesData = $this->serviceSpend->totalSpentByCategory();
        $categoriesData = $categoriesData->sortByDesc('total');

        $max = $categoriesData->max('total');
        $min = $categoriesData->min('total');

        $categoriesChart = [['Categoria', 'Total']];
        $colors = [];

        foreach ($categoriesData->values() as $item) {
            $value = (float) $item->total;
            $percentage = $max == $min ? 0 : ($value - $min) / ($max - $min);
            $color = $this->interpolateColor($percentage);
            $categoriesChart[] = [$item->name, $value];
            $colors[] = $color;
        }

        return view('home', compact('gains', 'spends', 'categoriesChart', 'colors'));
    }

    private function interpolateColor($percentage)
    {
        $green = [76, 175, 80];   
        $red = [183, 28, 28]; 

        $r = (int) ($green[0] + ($red[0] - $green[0]) * $percentage);
        $g = (int) ($green[1] + ($red[1] - $green[1]) * $percentage);
        $b = (int) ($green[2] + ($red[2] - $green[2]) * $percentage);

        return sprintf("#%02X%02X%02X", $r, $g, $b);
    }
}

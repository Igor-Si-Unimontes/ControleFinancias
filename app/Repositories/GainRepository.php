<?php
namespace App\Repositories;
use App\Models\Gain;
use Carbon\Carbon;

class GainRepository
{
    public function create(array $data)
    {
        return Gain::create($data);
    }

    public function update(int $id, array $data)
    {
        return Gain::where('id', $id)->update($data);
    }

    public function delete(int $id)
    {
        return Gain::destroy($id);
    }

    public function findById($id)
    {
        return Gain::find($id);
    }
    public function all()
    {
        return Gain::all()->where('user_id', auth()->id());
    }
    public function sumAmountsMonth()
    {
        return Gain::whereMonth('date', now()->month)->where('user_id', auth()->id())->sum('amount');
    }
     public function filtersForDateRange($start, $end)
    {
        return Gain::whereBetween('date', [$start, $end])
            ->where('user_id', auth()->id())
            ->orderBy('date')
            ->get()
            ->map(function ($gain) {
                return [
                    'name' => $gain->name,
                    'description' => $gain->description,
                    'amount' => $gain->amount,
                    'date' => Carbon::parse($gain->date)->format('d/m/Y'),
                    'category_gain_id' => $gain->category_gain_id
                ];
            });
    }
}
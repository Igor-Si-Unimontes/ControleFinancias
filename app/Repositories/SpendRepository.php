<?php
namespace App\Repositories;
use App\Models\Spend;
use Illuminate\Support\Facades\DB;

class SpendRepository
{
    public function create(array $data)
    {
        return Spend::create($data);
    }

    public function update(int $id, array $data)
    {
        return Spend::where('id', $id)->update($data);
    }

    public function delete(int $id)
    {
        return Spend::destroy($id);
    }

    public function findById($id)
    {
        return Spend::find($id);
    }
    public function all()
    {
        return Spend::all()->where('user_id', auth()->id());
    }
    public function sumAmountsMonth()
    {
        return Spend::whereMonth('date', now()->month)->where('user_id', auth()->id())->sum('amount');
    }
    public function totalSpentByCategory()
    {
        return DB::table('spends')
            ->join('category_spends', 'spends.category_spend_id', '=', 'category_spends.id')
            ->select('category_spends.name', DB::raw('SUM(spends.amount) as total'))
            ->where('spends.user_id', auth()->id())
            ->groupBy('category_spends.name')
            ->get();
    }
    public function filtersForDateRange($startDate, $endDate)
    {
        return Spend::whereBetween('date', [$startDate, $endDate])
            ->where('user_id', auth()->id())
            ->get();
    }
}
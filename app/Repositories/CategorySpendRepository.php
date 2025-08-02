<?php
namespace App\Repositories;
use App\Models\CategorySpend;

class CategorySpendRepository
{
    public function create(array $data)
    {
        return CategorySpend::create($data);
    }

    public function update(int $id, array $data)
    {
        return CategorySpend::where('id', $id)->update($data);
    }

    public function delete(int $id)
    {
        return CategorySpend::destroy($id);
    }

    public function findById($id)
    {
        return CategorySpend::find($id);
    }
    public function all()
    {
        return CategorySpend::all();
    }
}
<?php
namespace App\Repositories;
use App\Models\Spend;

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
        return Spend::all();
    }
}
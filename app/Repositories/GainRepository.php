<?php
namespace App\Repositories;
use App\Models\Gain;

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
        return Gain::all();
    }
}
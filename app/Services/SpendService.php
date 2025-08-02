<?php
namespace App\Services;
use App\Repositories\SpendRepository;
class SpendService
{
    protected $repository;

    public function __construct(SpendRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createSpend(array $data)
    {
        return $this->repository->create($data);
    }

    public function updateSpend(int $id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function deleteSpend(int $id)
    {
        return $this->repository->delete($id);
    }

    public function findSpendById(int $id)
    {
        return $this->repository->findById($id);
    }

    public function getAllSpends()
    {
        return $this->repository->all();
    }
}
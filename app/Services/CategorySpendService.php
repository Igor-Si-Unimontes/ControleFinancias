<?php
namespace App\Services;
use App\Repositories\CategorySpendRepository;
class CategorySpendService
{
    protected $repository;

    public function __construct(CategorySpendRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createCategorySpend(array $data)
    {
        return $this->repository->create($data);
    }

    public function updateCategorySpend(int $id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function deleteCategorySpend(int $id)
    {
        return $this->repository->delete($id);
    }

    public function findCategorySpendById(int $id)
    {
        return $this->repository->findById($id);
    }

    public function getAllCategorySpends()
    {
        return $this->repository->all();
    }
}
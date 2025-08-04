<?php
namespace App\Services;
use App\Repositories\GainRepository;
class GainService
{
    protected $repository;

    public function __construct(GainRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createGain(array $data)
    {
        return $this->repository->create($data);
    }

    public function updateGain(int $id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function deleteGain(int $id)
    {
        return $this->repository->delete($id);
    }

    public function findGainById(int $id)
    {
        return $this->repository->findById($id);
    }

    public function getAllGains()
    {
        return $this->repository->all();
    }
    public function sumAmountsMonth()
    {
        return $this->repository->sumAmountsMonth();
    }
}
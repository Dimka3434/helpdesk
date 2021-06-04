<?php

namespace App\Services;

use App\Models\Problem;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProblemService
 *
 * @package App\Services
 */
class ProblemService
{
    private Problem $model;

    /**
     * ProblemService constructor.
     */
    public function __construct()
    {
        $this->model = new Problem;
    }

    /**
     * @param array $data
     *
     * @return Builder|Model
     */
    public function storeProblem(int $userId, array $data)
    {
        $data['status'] = Problem::STATUS_OPENED;
        $data['user_id'] = $userId;

        return $this->model->newQuery()->create(
            $data
        );
    }

    /**
     * @param int $id
     *
     * @return bool|mixed|null
     */
    public function deleteProblem(int $id)
    {
        $status = $this->model->newQuery()->find($id)->delete();

        return $status;
    }

    /**
     * @param int $id
     * @param int $performerId
     */
    public function assignToPerformer(int $id, int $performerId)
    {
        $problem = $this->model->newQuery()
            ->where('id', $id)
            ->update([
                'performer_id' => $performerId,
                'status' => Problem::STATUS_ASSIGNED_PERFORMER,
            ]);
    }

    /**
     * @param int $id
     */
    public function makeProblemDone(int $id)
    {
        $problem = $this->model->newQuery()
            ->where('id', $id)
            ->update([
                'status' => Problem::STATUS_CHECKING,
            ]);
    }

    /**
     * @param int $id
     */
    public function closeProblem(int $id)
    {
        $problem = $this->model->newQuery()
            ->where('id', $id)
            ->update([
                'status' => Problem::STATUS_CLOSED,
            ]);
    }

    public function getById(int $id)
    {
        return $this->model->newQuery()->find($id);
    }

    public function getAll()
    {
        return $this->model->newQuery()
            ->get();
    }

    public function getProblemsByUserId(?int $userId)
    {
        return $this->model->newQuery()
            ->where('user_id', $userId)
            ->get();
    }
}

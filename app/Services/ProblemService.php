<?php

namespace App\Services;

use App\Models\Problem;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProblemService
 *
 * @package App\Services
 */
class ProblemService
{
    /**
     * @var Problem
     */
    private Problem $model;

    /**
     * ProblemService constructor.
     */
    public function __construct()
    {
        $this->model = new Problem;
    }

    /**
     * @param int $userId
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
     * @param int $priority
     *
     */
    public function assignToPerformer(int $id, int $performerId, int $priority = Problem::LOW_PRIORITY)
    {
        $problem = $this->model->newQuery()
            ->where('id', $id)
            ->update([
                'performer_id' => $performerId,
                'priority' => $priority,
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
     *
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function getById(int $id)
    {
        return $this->model->newQuery()->find($id);
    }

    /**
     * @return Builder[]|Collection
     */
    public function getAll()
    {
        return $this->model->newQuery()
            ->get();
    }

    /**
     * @param int|null $userId
     *
     * @return Builder[]|Collection
     */
    public function getProblemsByUserId(?int $userId)
    {
        return $this->model->newQuery()
            ->where('user_id', $userId)
            ->get();
    }

    /**
     * @return int
     */
    public function getOpenedProblemsCount(): int
    {
        return $this->model->newQuery()
            ->where('status', Problem::STATUS_OPENED)
            ->count();
    }

    /**
     * @param int $performerId
     *
     * @return int
     */
    public function getAssignedProblemsCountByPerformerId(int $performerId): int
    {
        return $this->model->newQuery()
            ->where('performer_id', $performerId)
            ->where('status', Problem::STATUS_ASSIGNED_PERFORMER)
            ->count();
    }

    /**
     * @param int $id
     * @param string $commentary
     *
     * @return int
     */
    public function closeProblem(int $id, string $commentary=''): int
    {
        return $this->model->newQuery()
            ->where('id', $id)
            ->update([
                'status' => Problem::STATUS_CLOSED,
                'commentary' => $commentary
            ]);
    }
}

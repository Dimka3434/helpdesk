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
    public function makeProblemUnderway(int $id)
    {
        $problem = $this->model->newQuery()
            ->where('id', $id)
            ->update([
                'status' => Problem::STATUS_UNDERWAY,
                'work_started_at' => now(),
            ]);
    }

    /**
     * @param int $id
     * @param string $commentary
     */
    public function makeProblemDone(int $id, string $commentary)
    {
        $problem = $this->model->newQuery()
            ->where('id', $id)
            ->update([
                'status' => Problem::STATUS_CHECKING,
                'work_ended_at' => now(),
                'commentary' => $commentary,
            ]);
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
        $problems = $this->model->newQuery()
            ->get();

        foreach ($problems as $problem) {
            if (
                ($problem->status === Problem::STATUS_CLOSED || $problem->status === Problem::STATUS_CHECKING)
                && ($problem->work_started_at || $problem->work_ended_at)
            ) {
                $problem->time_spent = $problem->work_started_at->diffInHours($problem->work_ended_at);
            }
        }

        return $problems;
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
     *
     * @return Builder[]|Collection
     */
    public function getAssignedProblemsByPerformerId(int $id)
    {
        return $this->model->newQuery()
            ->where('id', $id)
            ->get();
    }
}

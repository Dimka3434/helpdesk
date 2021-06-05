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
     * Создать проблему
     *
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
     * Удалить проблему
     *
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
     * Перевести проблему в статус "Ждет подтверждения" и закрепляем за исполнителем
     *
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
     * Перевести проблему в статус "В работе"
     *
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
     * Перевести проблему в статус "На проверке"
     *
     * @param int $id
     * @param string $commentary
     */
    public function makeProblemDone(int $id, string $commentary='')
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
     * Перевести проблему в статус "Закрыто"
     *
     * @param int $id
     * @param string $commentary
     *
     * @return int
     */
    public function closeProblem(int $id, string $commentary = ''): int
    {
        return $this->model->newQuery()
            ->where('id', $id)
            ->update([
                'status' => Problem::STATUS_CLOSED,
                'commentary' => $commentary,
            ]);
    }

    /**
     * Получить заявку по айди
     *
     * @param int $id
     *
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function getById(int $id)
    {
        return $this->model->newQuery()->find($id);
    }

    /**
     * Получить все заявки (либо завершенные, либо на проверке)
     *
     * @return Builder[]|Collection
     */
    public function getAll($type = 'checking')
    {
        $problems = $this->model->newQuery()
            ->when($type === 'checking', function ($query) {
                return $query->where('status', Problem::STATUS_OPENED)->orWhere('status', Problem::STATUS_CHECKING);
            })
            ->when($type === 'done', function ($query) {
                return $query->where('status', Problem::STATUS_CLOSED);
            })
            ->orderByDesc('created_at')
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
     * Получить список проблем пользователя
     *
     * @param int|null $userId
     *
     * @return Builder[]|Collection
     */
    public function getProblemsByUserId(?int $userId)
    {
        return $this->model->newQuery()
            ->where('user_id', $userId)
            ->orderByDesc('created_at')
            ->get();
    }

    /**
     * Получить количество открытых заявок (для сайдбара)
     *
     * @return int
     */
    public function getOpenedProblemsCount(): int
    {
        return $this->model->newQuery()
            ->where('status', Problem::STATUS_OPENED)
            ->count();
    }

    /**
     * Получить количество заявок в работе для исполнителя (для сайдбара)
     *
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
     * Получить заявки в работе закрепленных за исполнителем
     *
     * @param int $performerId
     *
     * @return Builder[]|Collection
     */
    public function getAssignedProblemsByPerformerId(int $performerId)
    {
        return $this->model->newQuery()
            ->where('performer_id', $performerId)
            ->where('status', Problem::STATUS_ASSIGNED_PERFORMER)
            ->orWhere('status', Problem::STATUS_UNDERWAY)
            ->orderByDesc('created_at')
            ->get();
    }
}

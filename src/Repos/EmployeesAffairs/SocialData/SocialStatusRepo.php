<?php

namespace SM\Repos\EmployeesAffairs\SocialData;

use Simple\Core\DataAccess\IDataAccess;
use Simple\Core\DataAccess\Query;
use Simple\Helpers\Log;
use SM\Entities\EmployeesAffairs\SocialStatus;

class SocialStatusRepo implements ISocialStatusRepo
{
    private IDataAccess $dataAccess;

    private string $view = 'social_status_view';

    private string $table = 'social_status';

    private array $columns = [
        'employee_id',
        'martial_status',
        'martial_status_id ',
        'children_count',
        'update_date'
    ];

    public function __construct(IDataAccess $dataAccess)
    {
        $this->dataAccess = $dataAccess;
    }

    public function getByEmployeeId($id): array
    {
        $query = new Query();
        $query->select($this->columns)
            ->from($this->view)
            ->where('employee_id', '=', $id)
            ->orderBy(['update_date' => 'DESC']);
        $data = $this->dataAccess->getAll($query);
        $allStatuses = array_map(function ($status) {
            return new SocialStatus(
                $status['employee_id'],
                $status['martial_status'],
                $status['martial_status_id'],
                $status['children_count'],
                $status['update_date']
            );
        }, $data);
        return $allStatuses;
    }

    public function createOrUpdate(SocialStatus $socialStatus)
    {
        if ($this->isRecordExists($socialStatus)) {
            $this->update($socialStatus);
        } else {
            $this->create($socialStatus);
        }
    }

    public function create(SocialStatus $socialStatus)
    {
        $query = new Query();
        $query->insertInto($this->table)
            ->values([
                'id' => null,
                'employee_id' => $socialStatus->getEmployeeId(),
                'martial_status_id' => $socialStatus->getMartialStatusId(),
                'children_count' => $socialStatus->getChildrenCount(),
                'update_date' => $socialStatus->getUpdateDate()
            ]);
        return $this->dataAccess->run($query);
    }

    public function update(SocialStatus $socialStatus)
    {
        Log::dump('update');
    }

    public function isRecordExists(SocialStatus $socialStatus)
    {
        $childrenCount = $socialStatus->getChildrenCount();
        $childrenCount = empty($childrenCount) ? 0 : $childrenCount;
        $query = new Query();
        $query->select($this->columns)
            ->from($this->table)
            ->where('employee_id', '=', $socialStatus->getEmployeeId())
            ->andWhere('martial_status_id', '=', $socialStatus->getMartialStatusId())
            ->andWhere('children_count', '=', $childrenCount);

        $result = $this->dataAccess->get($query);
        return $result !== false;
    }
}

<?php

namespace SM\Repos\EmployeesAffairs\SocialData;

use Exception;
use Simple\Core\DataAccess\Query;
use Simple\Core\DataAccess\IDataAccess;
use SM\Entities\EmployeesAffairs\SocialStatus;

class LastSocialStatusRepo implements ILastSocialStatusRepo
{
    private IDataAccess $dataAccess;

    private string $table = 'last_social_status';

    public function __construct(IDataAccess $dataAccess)
    {
        $this->dataAccess = $dataAccess;
    }

    public function update(SocialStatus $socialStatus)
    {
        $query = new Query();
        $query->update($this->table)
            ->set([
                $this->table . '.martial_status_id' => $socialStatus->getMartialStatusId(),
                $this->table . '.children_count' => $socialStatus->getChildrenCount(),
                $this->table . '.update_date' => $socialStatus->getUpdateDate()
            ])
            ->where($this->table . '.employee_id', '=', $socialStatus->getEmployeeId());
        return $this->dataAccess->run($query);
    }

    public function create(SocialStatus $socialStatus)
    {
        throw new Exception('method not implemented yet');
    }
}

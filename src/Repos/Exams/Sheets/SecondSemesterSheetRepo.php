<?php

namespace SM\Repos\Exams\Sheets;

use SM\Repos\IReadRepo;
use SM\Entities\Entity;
use Simple\Core\DataAccess\IDataAccess;
use Simple\Core\DataAccess\Query;

class SecondSemesterSheetRepo implements IReadRepo
{
  protected IDataAccess $dataAccess;
  protected string $dbTable;
  protected int $gradeNumber;

  public function __construct(string $semester, int $gradeNumber, IDataAccess $dataAccess)
  {
    $this->dataAccess = $dataAccess;
    $this->gradeNumber = $gradeNumber;
    $this->dbTable = $semester . '_sheet_view';
  }

  public function getAll()
  {
  }

  public function getById($id)
  {
  }
}

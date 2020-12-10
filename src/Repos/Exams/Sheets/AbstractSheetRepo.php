<?php

namespace SM\Repos\Exams\Sheets;

use SM\Repos\IReadRepo;
use SM\Entities\Entity;
use Simple\Core\DataAccess\Query;
use Simple\Core\DataAccess\IDataAccess;

abstract class AbstractSheetRepo implements IReadRepo
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

  /**
   * Get All Data from the data source
   */
  abstract public function getAll();

  /**
   * Get one data item from data source
   */
  abstract public function getById($id);
}

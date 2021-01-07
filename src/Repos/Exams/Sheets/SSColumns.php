<?php

$columns = [
    $this->dbTable . '.sittingNumber',
    $this->dbTable . '.studentId',
    $this->dbTable . '.studentName',
    $this->dbTable . '.classNumber',
    $this->dbTable . '.grade',
    $this->dbTable . '.enrollmentStatus',
    $this->dbTable . '.sex',
    $this->dbTable . '.religion',
    $this->dbTable . '.pirthDate',
    $this->dbTable . '.day',
    $this->dbTable . '.month',
    $this->dbTable . '.year',
    $this->dbTable . '.fs_secrets',
    $this->dbTable . '.ss_secrets',

    $this->dbTable . '.fse_arabic',
    $this->dbTable . '.fsw_arabic',
    $this->dbTable . '.sse_arabic',
    $this->dbTable . '.ssw_arabic',

    $this->dbTable . '.fse_english',
    $this->dbTable . '.fsw_english',
    $this->dbTable . '.sse_engligh',
    $this->dbTable . '.ssw_english',

    $this->dbTable . '.fse_socials',
    $this->dbTable . '.fsw_socials',
    $this->dbTable . '.sse_socials',
    $this->dbTable . '.ssw_socials',

    $this->dbTable . '.fse_math',
    $this->dbTable . '.fsw_aljebra',
    $this->dbTable . '.fsw_geometry',
    $this->dbTable . '.sse_math',
    $this->dbTable . '.ssw_aljebra',
    $this->dbTable . '.ssw_geometry',

    $this->dbTable . '.fse_sciences',
    $this->dbTable . '.fsp_sciences',
    $this->dbTable . '.fsw_sciences',
    $this->dbTable . '.sse_sciences',
    $this->dbTable . '.ssp_sciences',
    $this->dbTable . '.ss_sciences',

    $this->dbTable . '.fse_activity_1',
    $this->dbTable . '.sse_activity_1',

    $this->dbTable . '.fse_activity_2',
    $this->dbTable . '.sse_activity_2',

    $this->dbTable . '.fse_religion',
    $this->dbTable . '.fsw_religion',
    $this->dbTable . '.sse_religion',
    $this->dbTable . '.ssw_religion',

    $this->dbTable . '.fse_computer',
    $this->dbTable . '.fsp_computer',
    $this->dbTable . '.fsw_computer',
    $this->dbTable . '.sse_computer',
    $this->dbTable . '.ssp_computer',
    $this->dbTable . '.ss_computer',

    $this->dbTable . '.fse_draw',
    $this->dbTable . '.fsw_draw',
    $this->dbTable . '.sse_draw',
    $this->dbTable . '.ssw_draw',

    $this->dbTable . '.fse_sports',
    $this->dbTable . '.sse_sports',
];
return $columns;

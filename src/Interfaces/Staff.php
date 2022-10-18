<?php

/**
 * Created by PhpStorm.
 * Filename: Staff.php
 * User: Nguyễn Văn Ước
 * Date: 28/09/2022
 * Time: 13:28
 */

namespace Uocnv\OopTrainese\Interfaces;

require __DIR__ . '/../../vendor/autoload.php';

interface Staff
{
    public function getSalary(): int;
}

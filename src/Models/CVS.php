<?php

/**
 * Created by PhpStorm.
 * Filename: CVS.php
 * User: Nguyễn Văn Ước
 * Date: 28/09/2022
 * Time: 13:28
 */

namespace Uocnv\OopTrainese\Models;

use Uocnv\OopTrainese\Interfaces\Staff;
use Uocnv\OopTrainese\Models\Model;

class CVS extends Model implements Staff
{
    protected $table      = 'cvs';
    protected $attributes = [
        'id',
        'name',
        'birthday',
        'salary',
        'kpi',
        'created_at',
        'updated_at',
    ];

    const KPI = 100;

    /**
     * Get salary of CVS
     *
     * @return int
     */
    public function getSalary(): int
    {
        $kpi = $this->kpi ?: 0;
        if ($kpi < 80) {
            $bonus = 15000;
        } else if ($kpi < self::KPI) {
            $bonus = 10000;
        } else if ($kpi == self::KPI) {
            $bonus = 0;
        } else {
            $bonus = 15000;
        }
        $bonusSalary = $bonus * ($kpi - self::KPI);
        return ($this->salary ?: 0) + ($bonusSalary ?: 0);
    }
}

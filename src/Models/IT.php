<?php

/**
 * Created by PhpStorm.
 * Filename: IT.php
 * User: Nguyễn Văn Ước
 * Date: 28/09/2022
 * Time: 10:10
 */

namespace Uocnv\OopTrainese\Models;

use Uocnv\OopTrainese\Interfaces\Staff;
use Uocnv\OopTrainese\Models\Model;

class IT extends Model implements Staff
{
    protected $table      = 'it';
    protected $attributes = [
        'id',
        'name',
        'birthday',
        'salary',
        'bonus',
        'created_at',
        'updated_at',
    ];

    /**
     * Get salary of IT
     *
     * @return int
     */
    public function getSalary(): int
    {
        return ($this->salary ?: 0) + ($this->bonus ?: 0);
    }
}

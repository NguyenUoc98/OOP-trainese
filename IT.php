<?php

/**
 * Created by PhpStorm.
 * Filename: IT.php
 * User: Nguyễn Văn Ước
 * Date: 28/09/2022
 * Time: 10:10
 */

require_once 'Model.php';
require_once 'Staff.php';

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

<?php
/**
 * Created by PhpStorm.
 * Filename: index.php
 * User: Nguyễn Văn Ước
 * Date: 28/09/2022
 * Time: 11:45
 */

require_once __DIR__ . '/vendor/autoload.php';

use Uocnv\OopTrainese\Models\IT;
use Uocnv\OopTrainese\Models\CVS;

$its = IT::query()->where('bonus', '>', 0)->orderBy('bonus', 'desc')->getFirst();
$cvss = CVS::query()->select('name', 'salary', 'kpi')->where('kpi', '>', 100)->orderBy('kpi', 'desc')->getFirst();

var_dump($cvss->getSalary());
die();

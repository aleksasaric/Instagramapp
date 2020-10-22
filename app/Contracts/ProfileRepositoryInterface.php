<?php
/**
 * Created by PhpStorm.
 * User: Aleksa
 * Date: 2020-04-28
 * Time: 00:11
 */
namespace App\Contracts;


interface ProfileRepositoryInterface
{
    public function getById($id);
    public function getByUsername($username);
    public function insertOrUpdate($data, $id = null);
}

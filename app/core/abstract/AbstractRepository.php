<?php
namespace App\Core;

use \PDO;

abstract class AbstractRepository extends Database{

    protected PDO $pdo;

    public function __construct(){
        $this->pdo = parent::getInstance()->getConnection();
    }

    abstract public function selectAll();
    abstract public function insert();
    abstract public function update();
    abstract public function delete();
    abstract public function selectById();
    abstract public function selectBy(array $filter);


}
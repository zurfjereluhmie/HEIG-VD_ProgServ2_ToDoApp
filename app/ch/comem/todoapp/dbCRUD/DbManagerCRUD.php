<?php

namespace ch\comem\todoapp\dbCRUD;

use ch\comem\todoapp\dbCRUD\I_APICRUD;
use PDO;
use Exception;

/**
 * This abstract class represents a CRUD manager for a database.
 * It implements the I_APICRUD interface.
 * 
 * @package ch\comem\todoapp\dbCRUD
 */
abstract class DbManagerCRUD implements I_APICRUD
{
    private $db = null;

    public function __construct()
    {
        $config = parse_ini_file('../../config/db.ini', true);
        $this->db = new PDO($config['dsn']);
        if (!$this->db) throw new Exception('Could not connect to database');
        $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    public function getDb(): PDO
    {
        return $this->db;
    }

    abstract public function create(object $object): int;
    abstract public function read(int $id): ?object;
    abstract public function update(int $id, object $object): bool;
    abstract public function delete(int $id): bool;
}

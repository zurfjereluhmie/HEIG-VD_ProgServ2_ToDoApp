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
        $config_file = '|var|config|db.ini';

        $config = parse_ini_file(str_replace("|", DIRECTORY_SEPARATOR, $config_file), true);
        if (!$config) throw new Exception('Could not read database configuration file');

        if (!isset($config['dsn'])) throw new Exception('Database configuration file does not contain DSN information');
        if (!isset($config['username'])) throw new Exception('Database configuration file does not contain username information');
        if (!isset($config['password'])) throw new Exception('Database configuration file does not contain password information');

        $adaptedDSN = str_replace("|", DIRECTORY_SEPARATOR, $config['dsn']);
        $this->db = new PDO($adaptedDSN, $config['username'], $config['password']);

        if (!$this->db) throw new Exception('Could not connect to database');
        $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    public function getDb(): PDO
    {
        return $this->db;
    }

    abstract public function create(object $object): int;
    abstract public function read(int $id): ?object;
    abstract public function update(int $id, object $object): ?object;
    abstract public function delete(int $id): bool;
}

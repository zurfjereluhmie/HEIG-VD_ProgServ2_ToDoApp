<?php

namespace ch\comem\todoapp\dbCRUD;

use ch\comem\todoapp\task\Task;
use ch\comem\todoapp\task\TaskBuilder;
use DateTime;
use Exception;

class DbManagerCRUD_Task extends DbManagerCRUD 
{
    private static ?DbManagerCRUD_Task $instance = null;

    private function __construct()
    {
        parent::__construct();
    }

    public static function getInstance(): DbManagerCRUD_Task
    {
        if (self::$instance == null) self::$instance = new DbManagerCRUD_Task();
        return self::$instance;
    }

    public function create(object $object): int
    {
        $userId = $this->getUserId();
        if (!isset($userId)) throw new Exception("User not logged in");
        if (!$object instanceof Task) throw new Exception("Object is not a Task");

        $sql = "INSERT INTO Task (title, description, isDone, isFav, dueDate, category_id, user_id) VALUES (:title, :description, :isDone, :isFav, :dueDate, :category_id, :user_id)";
        $stmt = $this->getDb()->prepare($sql);
        $res = $stmt->execute([
            "title" => $object->getTitle(),
            "description" => $object->getDescription(),
            "isDone" => $object->isDone(),
            "isFav" => $object->isFav(),
            "dueDate" => $object->getDueDate()->format("Y-m-d H:i:s"),
            "category_id" => $object->getCategory()->getId(),
            "user_id" => $userId
        ]);
        if (!$res) throw new Exception("Error while creating task");
        return $this->getDb()->lastInsertId();
    }

    public function read(int $id): ?object
    {
        if (!isset($id)) throw new Exception("Id cannot be null");
        $userId = $this->getUserId();
        if (!isset($userId)) throw new Exception("User not logged in");

        $sql = "SELECT * FROM Task WHERE id = :id AND user_id = :user_id";
        $stmt = $this->getDb()->prepare($sql);
        $stmt->execute(["id" => $id, "user_id" => $userId]);
        $task = $stmt->fetch();

        if (!$task) return null;

        return (new TaskBuilder($task["title"], new DateTime($task["dueDate"]), $task["category_id"]))
            ->setId($task["id"])
            ->setDescription($task["description"])
            ->setIsDone($task["isDone"])
            ->setIsFav($task["isFav"])
            ->build();
    }

    public function readAll(): array
    {
        $userId = $this->getUserId();
        if (!isset($userId)) throw new Exception("User not logged in");

        $sql = "SELECT * FROM Task WHERE user_id = :user_id";
        $stmt = $this->getDb()->prepare($sql);
        $stmt->execute(["user_id" => $userId]);
        $tasks = $stmt->fetchAll();

        $taskObjects = [];
        foreach ($tasks as $task) {
            $taskObjects[] = (new TaskBuilder($task["title"], new DateTime($task["dueDate"]), $task["category_id"]))
                ->setId($task["id"])
                ->setDescription($task["description"])
                ->setIsDone($task["isDone"])
                ->setIsFav($task["isFav"])
                ->build();
        }

        return $taskObjects;
    }

    public function update(int $id, object $object): ?object
    {
        if (!$object instanceof Task) throw new Exception("Object is not a Task");
        if (!$id == $object->getId()) throw new Exception("Id and object id do not match");

        $sql = "UPDATE Task SET title = :title, description = :description, isDone = :isDone, isFav = :isFav, dueDate = :dueDate, category_id = :category_id WHERE id = :id";
        $stmt = $this->getDb()->prepare($sql);
        $res = $stmt->execute([
            "title" => $object->getTitle(),
            "description" => $object->getDescription(),
            "isDone" => $object->isDone(),
            "isFav" => $object->isFav(),
            "dueDate" => $object->getDueDate()->format("Y-m-d H:i:s"),
            "category_id" => $object->getCategory()->getId(),
            "id" => $id
        ]);
        if (!$res) throw new Exception("Error while updating task");
        return $this->read($id);
    }

    public function delete(int $id): bool
    {
        if (!isset($id)) throw new Exception("Id cannot be null");
        $userId = $this->getUserId();
        if (!isset($userId)) throw new Exception("User not logged in");

        $sql = "DELETE FROM Task WHERE id = :id AND user_id = :user_id";
        $stmt = $this->getDb()->prepare($sql);
        $res = $stmt->execute(["id" => $id, "user_id" => $userId]);
        if (!$res) throw new Exception("Error while deleting task");
        return true;
    }

    private function getUserId(): ?int
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION["user"])) throw new Exception("User not logged in");

        return $_SESSION["user"]["id"];
    }
}
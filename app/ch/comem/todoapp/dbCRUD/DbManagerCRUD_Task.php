<?php

namespace ch\comem\todoapp\dbCRUD;

use ch\comem\todoapp\task\Task;
use ch\comem\todoapp\task\TaskBuilder;
use DateTime;
use Exception;

/**
 * This class extends the DbManagerCRUD class and is responsible for handling CRUD operations for tasks in the database.
 * It is a singleton class.
 * 
 * @package ch\comem\todoapp\dbCRUD
 */
class DbManagerCRUD_Task extends DbManagerCRUD
{
    private static ?DbManagerCRUD_Task $instance = null;

    private function __construct()
    {
        parent::__construct();
    }

    /**
     * Returns an instance of the DbManagerCRUD_Task class.
     *
     * @return DbManagerCRUD_Task An instance of the DbManagerCRUD_Task class.
     */
    public static function getInstance(): DbManagerCRUD_Task
    {
        if (self::$instance == null) self::$instance = new DbManagerCRUD_Task();
        return self::$instance;
    }

    /**
     * Creates a new record in the database for the given object.
     *
     * @param object $object The object to be created in the database.
     * @return int The ID of the newly created record.
     */
    public function create(object $object): int
    {
        $userId = $this->getUserId();
        if (!isset($userId)) throw new Exception("User not logged in");
        if (!$object instanceof Task) throw new Exception("Object is not a Task");

        $sql = "INSERT INTO Task (title, description, is_done, is_fav, due_date, user_id, category_id) VALUES (:title, :description, :is_done, :is_fav, :due_date, :user_id, :category_id)";
        $stmt = $this->getDb()->prepare($sql);
        $res = $stmt->execute([
            "title" => $object->getTitle(),
            "description" => $object->getDescription(),
            "is_done" => (int) $object->isDone(),
            "is_fav" => (int) $object->isFav(),
            "due_date" => $object->getDueDate()->format("Y-m-d H:i:s"),
            "user_id" => $userId,
            "category_id" => $object->getCategoryId()
        ]);
        if (!$res) throw new Exception("Error while creating task");
        return $this->getDb()->lastInsertId();
    }

    /**
     * Reads a task from the database based on its ID.
     *
     * @param int $id The ID of the task to read.
     * @return object|null The task object if found, null otherwise.
     */
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

        return (new TaskBuilder($task["title"], new DateTime($task["due_date"]), $task["category_id"]))
            ->setId($task["id"])
            ->setDescription($task["description"])
            ->setIsDone($task["is_done"])
            ->setIsFav($task["is_fav"])
            ->build();
    }

    /**
     * Reads all tasks from the database.
     *
     * @return array An array of tasks.
     */
    public function readAll(): array
    {
        $userId = $this->getUserId();
        if (!isset($userId)) throw new Exception("User not logged in");

        $sql = "SELECT * FROM Task WHERE user_id = :user_id ORDER BY due_date ASC";
        $stmt = $this->getDb()->prepare($sql);
        $stmt->execute(["user_id" => $userId]);
        $tasks = $stmt->fetchAll();

        $taskObjects = [];
        foreach ($tasks as $task) {
            $taskObjects[] = (new TaskBuilder($task["title"], new DateTime($task["due_date"]), $task["category_id"]))
                ->setId($task["id"])
                ->setDescription($task["description"])
                ->setIsDone($task["is_done"])
                ->setIsFav($task["is_fav"])
                ->build();
        }

        return $taskObjects;
    }

    /**
     * Updates a task in the database.
     *
     * @param int $id The ID of the task to update.
     * @param object $object The updated task object.
     * @return object|null The updated task object if successful, null otherwise.
     */
    public function update(int $id, object $object): ?object
    {
        if (!$object instanceof Task) throw new Exception("Object is not a Task");
        if (!$id == $object->getId()) throw new Exception("Id and object id do not match");

        $sql = "UPDATE Task SET title = :title, description = :description, is_done = :isDone, is_fav = :isFav, due_date = :dueDate, category_id = :category_id WHERE id = :id";
        $stmt = $this->getDb()->prepare($sql);
        $res = $stmt->execute([
            "title" => $object->getTitle(),
            "description" => $object->getDescription(),
            "isDone" => (int) $object->isDone(),
            "isFav" => (int) $object->isFav(),
            "dueDate" => $object->getDueDate()->format("Y-m-d H:i:s"),
            "category_id" => $object->getCategoryId(),
            "id" => $id
        ]);
        if (!$res) throw new Exception("Error while updating task");
        return $this->read($id);
    }

    /**
     * Deletes a task from the database.
     *
     * @param int $id The ID of the task to delete.
     * @return bool Returns true if the task was successfully deleted, false otherwise.
     */
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

    /**
     * Returns the user ID associated with the current task.
     *
     * @return int|null The user ID or null if not found.
     */
    private function getUserId(): ?int
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION["user"])) throw new Exception("User not logged in");

        return $_SESSION["user"]["id"];
    }
}

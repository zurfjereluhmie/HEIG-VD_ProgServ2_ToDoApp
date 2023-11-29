<html>

<head>
</head>

<body>
    <?php
    require_once '../app/autoload.php';

    use ch\comem\todoapp\category\CategoryManager;
    use ch\comem\todoapp\task\TaskManager;
    use ch\comem\todoapp\task\TaskBuilder;


    $categoryManager = CategoryManager::getInstance();
    $catgories = $categoryManager->getCategories();

    $taskManager = TaskManager::getInstance();

    $task1 = new TaskBuilder("Task 1", new DateTime("2023-11-29"), 1);
    $task2 = new TaskBuilder("Task 2", new DateTime("2023-11-29"), 1);
    $task3 = new TaskBuilder("Task 3", new DateTime("2023-11-29"), 2);
    $task4 = new TaskBuilder("Task 4", new DateTime("2023-11-29"), 2);
    $task5 = new TaskBuilder("Task 5", new DateTime("2023-11-29"), 2);
    $task6 = new TaskBuilder("Task 6", new DateTime("2023-11-29"), 3);
    $task7 = new TaskBuilder("Task 7", new DateTime("2023-11-30"), 3);
    $task8 = new TaskBuilder("Task 8", new DateTime("2023-11-30"), 3);
    $task9 = new TaskBuilder("Task 9", new DateTime("2023-11-30"), 3);
    $task10 = new TaskBuilder("Task 10", new DateTime("2023-12-02"), 3);
    $task11 = new TaskBuilder("Task 11", new DateTime("2023-12-02"), 3);
    $task12 = new TaskBuilder("Task 12", new DateTime("2023-12-02"), 3);
    $task13 = new TaskBuilder("Task 13", new DateTime("2023-12-02"), 3);
    $task14 = new TaskBuilder("Task 14", new DateTime("2023-12-02"), 3);
    $task15 = new TaskBuilder("Task 15", new DateTime("2023-12-02"), 3);

    // TODO : ADD - Tasks To Add for better testing Tasks Display
    // $taskManager->addTask($task1);
    // $taskManager->addTask($task2);
    // $taskManager->addTask($task3);
    // $taskManager->addTask($task4);
    // $taskManager->addTask($task5);
    // $taskManager->addTask($task6);
    // $taskManager->addTask($task7);
    // $taskManager->addTask($task8);
    // $taskManager->addTask($task9);
    // $taskManager->addTask($task10);
    // $taskManager->addTask($task11);
    // $taskManager->addTask($task12);
    // $taskManager->addTask($task13);
    // $taskManager->addTask($task14);
    // $taskManager->addTask($task15);
    $tasks = $taskManager->getTasks();
    
    // $tasks[0]->setDueDate(new DateTime("2023-11-29"));
    // $tasks[1]->setDueDate(new DateTime("2023-11-29"));

    // $tasks[1]->setCategory(2);

    $taskManager->updateTask($tasks[0]);
    $taskManager->updateTask($tasks[1]);

    echo "<pre>";
    print_r($tasks);
    echo "</pre>";
    ?>
</body>

</html>
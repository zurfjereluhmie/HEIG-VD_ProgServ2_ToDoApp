<?php

require_once "../app/autoload.php";
require_once "locale/locale-conf.php";

use ch\comem\todoapp\category\CategoryManager;

$categoryManager = CategoryManager::getInstance();
$categories = $categoryManager->getCategories();
?>

<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-white sidebar collapse">
    <div class="sidebar-sticky pt-3">
        <!-- Sidebar menu -->
        <ul class="nav flex-column sidebarUl">
            <li class="nav-item navItemAddTask">
                <a class="nav-link navLinkAddTask" href="/task-create.php">
                    <img class="navImg" src="assets/icons/addtask.svg" alt="Add a task icon">
                    <?= TEXT['add-a-task']; ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link navItem <?php echo (basename($_SERVER['PHP_SELF']) === 'dashboard.php') ? 'navItemActive' : ''; ?>" href="/dashboard.php">
                    <img class="navImg" src="assets/icons/dashboard.svg" alt="Dashboard icon">
                    <?= TEXT['dashboard']; ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link navItem <?php echo (basename($_SERVER['PHP_SELF']) === 'categories.php') ? 'navItemActive' : ''; ?>" href="/categories.php">
                    <img class="navImg" src="assets/icons/lists.svg" alt="Lists icon">
                    <?= TEXT['categories']; ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link navItem <?php echo (basename($_SERVER['PHP_SELF']) === 'favourites.php') ? 'navItemActive' : ''; ?>" href="/favourites.php">
                    <img class="navImg" src="assets/icons/favourite.svg" alt="Favourites icon">
                    <?= TEXT['favourites']; ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link navItem <?php echo (basename($_SERVER['PHP_SELF']) === 'calendar.php') ? 'navItemActive' : ''; ?>" href="/calendar.php">
                    <img class="navImg" src="assets/icons/calendar.svg" alt="Calendar icon">
                    <?= TEXT['calendar']; ?>
                </a>
            </li>
        </ul>
        <hr>
        <!-- Sidebar menu end -->
        <!-- My ToDo Categories -->
        <h6 class="d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            <span class="navItem navToDoCategoryTitle"><?= TEXT['my-todo-categories'] ?></span>
        </h6>
        <ul class="nav flex-column mb-2 navToDoCategory">
            <?php if (!empty($categories)) : ?>
                <?php foreach ($categories as $cat) : ?>
                    <li class="nav-item">
                        <a class="nav-link navToDoItem d-flex" href="./category.php?id=<?= $cat->getId() ?>">
                            <div class="colorTag" style="background: <?= $cat->getColor() ?>;"></div>
                            <span><?= $cat->getTitle() ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            <?php else : ?>
                <li class="nav-item">
                    <a class="nav-link navToDoItem d-flex" href="/categories.php">
                        <span><?= TEXT['my-todo-categories-empty']; ?></span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
        <hr>
        <!-- My ToDo Categories end -->
        <!-- Settings -->
        <ul class="nav flex-column mb-2 sidebarUl bottomUl">
            <li class="nav-item">
                <a class="nav-link navItem" href="/user-update.php" id="settings">
                    <img class="navImg" src="assets/icons/settings.svg" alt="">
                    <?= TEXT['settings']; ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link navItem" href="/logout.php">
                    <img class="navImg" src="assets/icons/logout.svg" alt="">
                    <?= TEXT['logout']; ?>
                </a>
            </li>
        </ul>
        <!-- Settings end -->
    </div>
</nav>
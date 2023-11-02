<?php

require_once "../app/autoload.php";

use ch\comem\todoapp\category\CategoryManager;

$categoryManager = CategoryManager::getInstance();
$categories = $categoryManager->getCategories();
?>

<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-white sidebar collapse">
    <div class="sidebar-sticky pt-3">
        <!-- Sidebar menu -->
        <ul class="nav flex-column sidebarUl">
            <li class="nav-item navItemAddTask">
                <a class="nav-link navLinkAddTask" href="#">
                    <img class="navImg" src="assets/icons/addtask.svg" alt="Add a task icon">
                    Add a task
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link navItem <?php echo (basename($_SERVER['PHP_SELF']) === 'dashboard.php') ? 'navItemActive' : ''; ?>" href="/dashboard.php">
                    <img class="navImg" src="assets/icons/dashboard.svg" alt="Dashboard icon">
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link navItem <?php echo (basename($_SERVER['PHP_SELF']) === 'categories.php') ? 'navItemActive' : ''; ?>" href="/categories.php">
                    <img class="navImg" src="assets/icons/lists.svg" alt="Lists icon">
                    Categories
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link navItem <?php echo (basename($_SERVER['PHP_SELF']) === 'favourites.php') ? 'navItemActive' : ''; ?>" href="/favourites.php">
                    <img class="navImg" src="assets/icons/favourite.svg" alt="Favourites icon">
                    Favourites
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link navItem <?php echo (basename($_SERVER['PHP_SELF']) === 'calendar.php') ? 'navItemActive' : ''; ?>" href="/calendar.php">
                    <img class="navImg" src="assets/icons/calendar.svg" alt="Calendar icon">
                    Calendar
                </a>
            </li>
        </ul>
        <hr>
        <!-- Sidebar menu end -->
        <!-- My ToDo Categories -->
        <h6 class="d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            <span class="navItem navToDoCategoryTitle">My ToDo Categories :</span>
        </h6>
        <ul class="nav flex-column mb-2 navToDoCategory">
            <?php if (!empty($categories)) : ?>
                <?php foreach ($categories as $category) : ?>
                    <li class="nav-item">
                        <a class="nav-link navToDoItem d-flex" href="./category?id=<?= $category->getId() ?>">
                            <div class="colorTag" style="background: <?= $category->getColor() ?>;"></div>
                            <span><?= $category->getTitle() ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            <?php else : ?>
                <li class="nav-item">
                    <a class="nav-link navToDoItem d-flex" href="/categories.php">
                        <span>No categories yet</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
        <hr>
        <!-- My ToDo Categories end -->
        <!-- Settings -->
        <ul class="nav flex-column mb-2 sidebarUl bottomUl">
            <li class="nav-item">
                <a class="nav-link navItem" href="#" id="settings">
                    <img class="navImg" src="assets/icons/settings.svg" alt="">
                    Settings
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link navItem" href="/logout.php">
                    <img class="navImg" src="assets/icons/logout.svg" alt="">
                    Log out
                </a>
            </li>
        </ul>
        <!-- Settings end -->
    </div>
</nav>
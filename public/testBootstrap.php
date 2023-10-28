<!DOCTYPE html>
<html lang="fr" data-lt-installed="true">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>ToDoApp - Dasboard</title>

    <!-- CSS Lib -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- CSS Custom -->
    <link href="styles/main.css" rel="stylesheet">
    <link href="styles/navBar.css" rel="stylesheet">
    <link href="styles/dashboard.css" rel="stylesheet">
    <link href="styles/task.css" rel="stylesheet">
    <link href="styles/list.css" rel="stylesheet">
    <link href="styles/taskCheckboxColor.css" rel="stylesheet">
    <!-- <link href="css/modal.css" rel="stylesheet"> -->

    <!-- icon -->
    <link rel="icon" href="assets/icons/logo.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous">


</head>

<body>
    <nav class="navbar navbar-dark sticky-top bg-white flex-md-nowrap p-0">
        <a class="col-md-3 col-lg-2 mr-0 px-3" href="/">
            <img class="" src="assets/icons/logo.svg" alt="Logo">
        </a>
        <button id="displayMenu" class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div id="searchContent">
            <input class="mx-auto searchBar" type="search" placeholder="Search" aria-label="Search">
            <!-- Result of the search -->
            <div id="livesearch">
                <ul>
                    <li>
                        Resultat #1
                    </li>
                    <li>
                        Resultat #2
                    </li>
                    <li>
                        Resultat #3
                    </li>
                </ul>
            </div>
        </div>
        <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
                <div class="d-flex flex-row justify-content-end align-items-center">
                    <img class="navUserDisplayPP" src="assets/profilePictures/default.jpg" alt="Profile pictures" width="50">
                    <p class="navUserDisplayName">Jérémie Zurflüh</p>
                </div>
            </li>
        </ul>
    </nav>

    <div class="container-fluid">
        <div class="row">
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
                            <a class="nav-link navItem navItemActive" href="/">
                                <img class="navImg" src="assets/icons/dashboard.svg" alt="Dashboard icon">
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link navItem" href="/lists.html">
                                <img class="navImg" src="assets/icons/lists.svg" alt="Lists icon">
                                Lists
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link navItem" href="favourites.html">
                                <img class="navImg" src="assets/icons/favourite.svg" alt="Favourites icon">
                                Favourites
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link navItem" href="calendar.html">
                                <img class="navImg" src="assets/icons/calendar.svg" alt="Calendar icon">
                                Calendar
                            </a>
                        </li>
                    </ul>
                    <hr>

                    <!-- Sidebar menu end -->

                    <!-- My ToDo Lists -->
                    <h6 class="d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span class="navItem navToDoListTitle">My ToDo Lists :</span>
                    </h6>
                    <ul class="nav flex-column mb-2 navToDoList">
                        <li class="nav-item">
                            <a class="nav-link navToDoItem d-flex" href="./list.html">
                                <div class=" colorTag BlueTag"></div>
                                <span>Course</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link navToDoItem d-flex" href="#">
                                <div class=" colorTag RedTag"></div>
                                <span>Devoirs</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link navToDoItem d-flex" href="#">
                                <div class=" colorTag GreenTag"></div>
                                <span>Vacances</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link navToDoItem d-flex" href="#">
                                <div class=" colorTag YellowTag"></div>
                                <span>Projet vidéo</span>
                            </a>
                        </li>
                    </ul>
                    <hr>
                    <!-- My ToDo Lists end -->

                    <!-- Settings -->
                    <ul class="nav flex-column mb-2 sidebarUl bottomUl">
                        <li class="nav-item">
                            <a class="nav-link navItem" href="#" id="settings">
                                <img class="navImg" src="assets/icons/settings.svg" alt="">
                                Settings
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link navItem" href="/login.html">
                                <img class="navImg" src="assets/icons/logout.svg" alt="">
                                Log out
                            </a>
                        </li>
                    </ul>
                    <!-- Settings end -->
                </div>
            </nav>

            <main class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4 bg-light ml-auto mainFullHeight">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
                    <h1 class="h2" id="dashboardTitle">Dashboard</h1>
                </div>

                <!-- Liste ToDo -->
                <div class="d-flex flex-row justify-content-center align-items-start flex-wrap dasboardMyListsDisplay">
                    <div class="p-3 myListsItem">
                        <div class="d-flex">
                            <div class="colorTag BlueTag"></div>
                            <h3 class="myListsTitle">Course</h3>
                        </div>
                        <p class="myListsDate">Created on 19.08.2020</p>
                        <p class="myListsDescritpion">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.</p>
                    </div>
                    <div class="p-3 myListsItem">
                        <div class="d-flex">
                            <div class="colorTag RedTag"></div>
                            <h3 class="myListsTitle">Devoirs</h3>
                        </div>
                        <p class="myListsDate">Created on 19.08.2020</p>
                        <p class="myListsDescritpion">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.</p>
                    </div>
                    <div class="p-3 myListsItem">
                        <div class="d-flex">
                            <div class="colorTag GreenTag"></div>
                            <h3 class="myListsTitle">Vacances</h3>
                        </div>
                        <p class="myListsDate">Created on 19.08.2020</p>
                        <p class="myListsDescritpion">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.</p>
                    </div>
                    <a href="/lists.html" class="seeAllLists">See All &#62;</a>
                </div>

                <!-- ToDo due to today and Tomorow -->
                <div class="d-flex flex-row justify-content-center align-items-start flex-wrap dasboardTodoDisplay">

                    <!-- ToDo due today -->
                    <div class="p-3 todoElt">
                        <div class="d-flex">
                            <h3 class="toDoTitle mr-auto p-2">Due today :</h3>
                            <a class="p-2" href="/calendar.html#today">See All</a>
                        </div>
                        <div class="taskContainer">

                            <!-- Task#1 -->
                            <div class="d-flex flex-row align-items-center task">
                                <label class="containerCheckBox taskCheckBox">
                                    <input type="checkbox" class="BlueCheckBox taskIsDone" data-color="#497efe" data-taskId="1">
                                    <span class="checkmark BlueCheckBoxSpan"></span>
                                </label>
                                <p class="taskTitle">Acheter de la raclette</p>
                                <div class="d-flex flexEnd">
                                    <p class="taskDelai">Today - 10h00</p>
                                    <a class="taskStar" href="#" data-isFav="false">
                                        <img src="assets/icons/notFavourite.svg" width="29" height="29" alt="star icon">
                                    </a>

                                    <a class="taskTrash" href="#">
                                        <img src="assets/icons/trash.svg" width="26" height="29" alt="trash icon">
                                    </a>
                                </div>
                            </div>
                            <!-- Task#1 end -->

                            <!-- Task#2 -->
                            <div class="d-flex flex-row align-items-center task">
                                <label class="containerCheckBox taskCheckBox">
                                    <input type="checkbox" class="BlueCheckBox taskIsDone" data-color="#497efe" data-taskId="2">
                                    <span class="checkmark BlueCheckBoxSpan"></span>
                                </label>
                                <p class="taskTitle">Acheter de la fondue</p>
                                <div class="d-flex flexEnd">
                                    <p class="taskDelai">Today - 10h00</p>
                                    <a class="taskStar" href="#" data-isFav="true">
                                        <img src="assets/icons/favourite.svg" width="29" height="29" alt="star icon">
                                    </a>

                                    <a class="taskTrash" href="#">
                                        <img src="assets/icons/trash.svg" width="26" height="29" alt="trash icon">
                                    </a>
                                </div>
                            </div>
                            <!-- Task#2 end -->

                            <!-- Task#3 -->
                            <div class="d-flex flex-row align-items-center task">
                                <label class="containerCheckBox taskCheckBox">
                                    <input type="checkbox" class="RedCheckBox taskIsDone" data-color="#dc3545" data-taskId="3">
                                    <span class="checkmark RedCheckBoxSpan"></span>
                                </label>
                                <p class="taskTitle">Ex p.134 + p.135</p>
                                <div class="d-flex flexEnd">
                                    <p class="taskDelai">Today - 13h00</p>
                                    <a class="taskStar" href="#" data-isFav="true">
                                        <img src="assets/icons/favourite.svg" width="29" height="29" alt="star icon">
                                    </a>

                                    <a class="taskTrash" href="#">
                                        <img src="assets/icons/trash.svg" width="26" height="29" alt="trash icon">
                                    </a>
                                </div>
                            </div>
                            <!-- Task#3 end -->

                            <!-- Task#4 -->
                            <div class="d-flex flex-row align-items-center task">
                                <label class="containerCheckBox taskCheckBox">
                                    <input type="checkbox" class="RedCheckBox taskIsDone" data-color="#dc3545" data-taskId="4">
                                    <span class="checkmark RedCheckBoxSpan"></span>
                                </label>
                                <p class="taskTitle">Rendre MCD</p>
                                <div class="d-flex flexEnd">
                                    <p class="taskDelai">Today - 16h40</p>
                                    <a class="taskStar" href="#" data-isFav="false">
                                        <img src="assets/icons/notFavourite.svg" width="29" height="29" alt="star icon">
                                    </a>

                                    <a class="taskTrash" href="#">
                                        <img src="assets/icons/trash.svg" width="26" height="29" alt="trash icon">
                                    </a>
                                </div>
                            </div>
                            <!-- Task#4 end -->

                        </div>
                    </div>
                    <!-- ToDO due today end -->

                    <!-- ToDO due tomorrow start -->
                    <div class="p-3 todoElt">
                        <div class="d-flex">
                            <h3 class="toDoTitle mr-auto p-2">Due tomorrow :</h3>
                            <a class="p-2" href="/calendar.html#tomorrow">See All</a>
                        </div>
                        <div class="taskContainer">

                            <!-- Task#1 -->
                            <div class="d-flex flex-row align-items-center task">
                                <label class="containerCheckBox taskCheckBox">
                                    <input type="checkbox" class="RedCheckBox taskIsDone" data-color="#dc3545" data-taskId="5">
                                    <span class="checkmark RedCheckBoxSpan"></span>
                                </label>
                                <p class="taskTitle">Compta - Ex 38.5</p>
                                <div class="d-flex flexEnd">
                                    <p class="taskDelai">Tomorrow - 08h50</p>
                                    <a class="taskStar" href="#" data-isFav="false">
                                        <img src="assets/icons/notFavourite.svg" width="29" height="29" alt="star icon">
                                    </a>

                                    <a class="taskTrash" href="#">
                                        <img src="assets/icons/trash.svg" width="26" height="29" alt="trash icon">
                                    </a>
                                </div>
                            </div>
                            <!-- Task#1 end -->

                            <!-- Task#2 -->
                            <div class="d-flex flex-row align-items-center task">
                                <label class="containerCheckBox taskCheckBox">
                                    <input type="checkbox" class="RedCheckBox taskIsDone" data-color="#dc3545" data-taskId="6">
                                    <span class="checkmark RedCheckBoxSpan"></span>
                                </label>
                                <p class="taskTitle">Test chapitre 23 economie</p>
                                <div class="d-flex flexEnd">
                                    <p class="taskDelai">Tomorrow - 11h00</p>
                                    <a class="taskStar" href="#" data-isFav="true">
                                        <img src="assets/icons/favourite.svg" width="29" height="29" alt="star icon">
                                    </a>

                                    <a class="taskTrash" href="#">
                                        <img src="assets/icons/trash.svg" width="26" height="29" alt="trash icon">
                                    </a>
                                </div>
                            </div>
                            <!-- Task#2 end -->

                            <!-- Task#3 -->
                            <div class="d-flex flex-row align-items-center task">
                                <label class="containerCheckBox taskCheckBox">
                                    <input type="checkbox" class="RedCheckBox taskIsDone" data-color="#dc3545" data-taskId="7">
                                    <span class="checkmark RedCheckBoxSpan"></span>
                                </label>
                                <p class="taskTitle">Ex p.134 + p.135</p>
                                <div class="d-flex flexEnd">
                                    <p class="taskDelai">Tomorrow - 13h00</p>
                                    <a class="taskStar" href="#" data-isFav="true">
                                        <img src="assets/icons/favourite.svg" width="29" height="29" alt="star icon">
                                    </a>

                                    <a class="taskTrash" href="#">
                                        <img src="assets/icons/trash.svg" width="26" height="29" alt="trash icon">
                                    </a>
                                </div>
                            </div>
                            <!-- Task#3 end -->

                            <!-- Task#4 -->
                            <div class="d-flex flex-row align-items-center task">
                                <label class="containerCheckBox taskCheckBox">
                                    <input type="checkbox" class="RedCheckBox taskIsDone" data-color="#dc3545" data-taskId="8">
                                    <span class="checkmark RedCheckBoxSpan"></span>
                                </label>
                                <p class="taskTitle">Rendre Sujet TPI</p>
                                <div class="d-flex flexEnd">
                                    <p class="taskDelai">Tomorrow - 17h30</p>
                                    <a class="taskStar" href="#" data-isFav="false">
                                        <img src="assets/icons/notFavourite.svg" width="29" height="29" alt="star icon">
                                    </a>

                                    <a class="taskTrash" href="#">
                                        <img src="assets/icons/trash.svg" width="26" height="29" alt="trash icon">
                                    </a>
                                </div>
                            </div>
                            <!-- Task#4 end -->

                        </div>

                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- MODAL -->
    <!-- addToDoModal -->
    <div class="modal fade" id="addToDoModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add a ToDo</h5>
                </div>
                <div class="modal-body">
                    <form class="form-signin">
                        <div class="d-flex flex-column justify-content-center align-items-center loginCard">
                            <input type="text" class="formInput" placeholder="Title" required="" name="title">

                            <div class="d-flex flex-row justify-content-center inlineDiv">
                                <input type="date" class="formInput inlineInput" placeholder="Date" required="" name="date">

                                <select name="ListsSelect" class="formInput inlineInput">
                                    <option value="" disabled="" selected="" hidden="">List</option>
                                    <option value="Devoirs">Devoirs</option>
                                    <option value="Course">Course</option>
                                </select>

                            </div>

                            <textarea class="descriptionText form-control" placeholder="Description" required="" name="description"></textarea>
                        </div>
                        <div class="d-flex">
                            <button type="button" class="modalBtn btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="modalBtn btn btn-primary">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- editToDoModal -->
    <div class="modal fade" id="editToDoModal" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit a ToDo</h5>
                    <button type="button" class="trash close modalTrash">
                        <img src="../assets/icons/trash.svg" alt="">
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-signin">
                        <div class="d-flex flex-column justify-content-center align-items-center loginCard">
                            <input type="text" class="formInput" placeholder="Title" required="" name="title" value="Template" id="editToDoModalTitle">

                            <div class="d-flex flex-row justify-content-center inlineDiv">
                                <input type="datetime-local" class="formInput inlineInput" placeholder="Date" required="" name="date" value="2020-09-28T14:50" id="editToDoModalTime">

                                <select name="ListsSelect" class="formInput inlineInput">
                                    <option value="Devoirs" selected="">Devoirs</option>
                                    <option value="Course">Course</option>
                                </select>

                            </div>

                            <textarea class="descriptionText form-control" placeholder="Description" required="" name="description">Template</textarea>
                        </div>
                        <div class="d-flex">
                            <button type="button" class="modalBtn btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="modalBtn btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirm delete -->
    <div class="modal fade" id="confirmDelete" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content confirmDeleteContent">
                <div class="modal-header">
                    <h5 class="modal-title" id="">Are you sure ?</h5>
                </div>
                <div class="modal-body">
                    <form class="form-signin">
                        <div class="d-flex flex-column justify-content-center align-items-center loginCard">
                            <input type="text" required name="inputId" hidden disabled>
                        </div>

                        <div class="d-flex">
                            <button type="button" class="modalBtn btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="modalBtn btn btn-danger">Yes, delete it</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Settings -->
    <div class="modal fade" id="settingsModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="">Edit profile</h5>
                </div>
                <div class="modal-body">
                    <div class="d-flex flex-column justify-content-center align-items-center loginCard">
                        <form action="upload.php" method="post" enctype="multipart/form-data">
                            <label for="fileToUpload">
                                <div class="profile-pic" style="background-image: url('../assets/profilePictures/default.jpg')" id="profilePicturesPreview">
                                    <span><i class="fa fa-pencil" aria-hidden="true"></i></span>
                                </div>
                            </label>
                            <input type="File" name="fileToUpload" id="fileToUpload" accept="image/*">
                        </form>
                        <form class="form-signin" width="inherit">
                            <div class="d-flex flex-row justify-content-center inlineDiv">
                                <input type="text" id="inputLastName" class="formInput inlineInput" placeholder="Last name" required name="lastName" value="Zurflüh">
                                <input type="text" id="inputFirstName" class="formInput inlineInput" placeholder="First name" required name="firstName" value="Jérémie">
                            </div>
                            <input type="email" id="inputEmail" class="formInput" placeholder="email" required name="email" value="zurfluh.jeremie@gmail.com">
                            <p class="text-center" id="changePasswordP">Change password <a id="changePasswordLink">here</a></p>

                            <div class="d-flex">
                                <button type="button" class="modalBtn btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="modalBtn btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Change password -->

    <div class="modal fade" id="changePassword" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="">Change your password</h5>
                </div>
                <div class="modal-body">
                    <form class="form-signin">
                        <div class="d-flex flex-column justify-content-center align-items-center loginCard">
                            <input type="password" id="inputPasswordOld" class="formInput" placeholder="Old password" required="" name="inputPasswordOld">
                            <input type="password" id="inputPasswordNew" class="formInput" placeholder="New password" required="" name="inputPasswordNew">
                            <input type="password" id="inputPasswordNewBis" class="formInput" placeholder="Repeat new password" required="" name="inputPasswordNewBis">

                        </div>

                        <div class="d-flex">
                            <button type="button" class="modalBtn btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="modalBtn btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Lib -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom common-->
    <!-- <script src="js/navScript.js"></script>
    <script src="js/profilePicture.js"></script>
    <script src="js/searchBar.js"></script>
    <script src="js/modal.js"></script>
    <script src="js/taskScript.js"></script> -->

    <!-- Custom specific-->
    <!-- <script src="js/lists.js"></script> -->
</body>

</html>
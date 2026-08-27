<?php
require_once __DIR__ . "/backend/helpers.php";
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="./shared/css/bootstrap.css">
    <link rel="stylesheet" href="./shared/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/index.css">
    <link rel="stylesheet" href="./assets/css/index.responsive.css">
</head>

<body class="text-light">
    <div id="Register">
        <div class="container py-5">
            <div class="head mb-5 text-center m-auto">
                <img src="./assets/images/logo.png" class="img-fluid" alt="">
            </div>
            <form class="py-4 px-3 m-auto formStudent" action="<?= isset($_SESSION['status']) ? './backend/editStudentForm.php' : './backend/register.php' ?>" method="POST">
                <p class="mb-3"><?= showError("invalidInput") ?></p>
                <input type="hidden" class="inputId" name="student_id" value="<?= old('student_id') ?>">
                <div class="row">
                    <div class="col-md-6">
                        <div class="item mb-4 position-relative">
                            <div class="input-group">
                                <label class="input-group-text" for="firstName"><i class="fa-solid fa-user"></i></label>
                                <input type="text" class="form-control input" placeholder="First Name *" value="<?= old("firstName") ?>" name="firstName"
                                    id="firstName" autocomplete="off">
                            </div>
                            <?= showError("firstName") ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="item mb-4 position-relative">
                            <div class="input-group">
                                <label class="input-group-text" for="lastName"><i class="fa-solid fa-user"></i></label>
                                <input type="text" class="form-control input" value="<?= old("lastName") ?>" name="lastName" id="lastName" autocomplete="off"
                                    placeholder="Last Name *" data-rtl-listener="true">
                            </div>
                            <?= showError("lastName") ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="item mb-4 position-relative">
                            <div class="input-group">
                                <label class="input-group-text" for="Email"><i class="fa-solid fa-envelope"></i></label>
                                <input id="Email" autocomplete="off" class="form-control input" type="text"
                                    placeholder="Your email (example@gmail.com) *" value="<?= old("email") ?>" name="email">
                            </div>
                            <?= showError("email") ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="item mb-4 position-relative">
                            <div class="input-group">
                                <label class="input-group-text" for="Password">
                                    <i class="fa-solid fa-lock"></i>
                                </label>
                                <input id="Password" autocomplete="off" class="form-control" type="password"
                                    placeholder="Your Password *" value="<?= old("password") ?>"
                                    name="password">
                            </div>
                            <?= showError("password") ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="item mb-4 position-relative">
                            <div class="input-group">
                                <label class="input-group-text" for="Age"><i
                                        class="fa-solid fa-person-cane"></i></label>
                                <input type="number" class="form-control input" value="<?= old("age") ?>" name="age" id="Age"
                                    autocomplete="off" placeholder="Age *">
                            </div>
                            <?= showError("age") ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="item mb-4 position-relative">
                            <div class="input-group">
                                <label class="input-group-text" for="phone">
                                    <i class="fa-solid fa-mobile-button"></i>
                                </label>
                                <input type="text" class="form-control input" name="phone" id="phone" autocomplete="off"
                                    placeholder="Phone *" value="<?= old("phone") ?>">
                            </div>
                            <?= showError("phone") ?>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="item d-flex justify-content-center align-items-center flex-wrap flex-md-nowrap">
                            <button class=" btn <?= isset($_SESSION['status']) ? 'btn-info text-light' : '' ?>" id="Submit"><?= isset($_SESSION['status']) ? 'Edit Your Account' : 'Add your account' ?></button>
                            <button class=" btn cancel <?= isset($_SESSION['status']) ? '' : 'd-none' ?> ms-0 ms-md-4 mt-3 mt-md-0" onclick="cancelEdit()" type="button" id="Cancel">Cancel</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div id="Search">
        <div class="container py-5">
            <form class="py-4 px-3 m-auto" id="FormSearch">
                <div class="input-group mb-3">
                    <label class="input-group-text">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </label>
                    <input id="Search" autocomplete="off" class="form-control" type="search" placeholder="Search...."
                        name="search">
                </div>
                <button class="btn  w-100">Search</button>
            </form>
        </div>
    </div>

    <div id="Table-student" class="py-4">
        <div class="table-responsive m-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Password</th>
                        <th scope="col">Age</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Options</th>
                    </tr>
                </thead>
                <tbody id="TableBody" class="text-light">

                </tbody>
                <p class="mt-3 empty w-100 d-block text-center alert alert-warning d-none">No Student Found</p>
            </table>
        </div>
    </div>
    <div class="nav-links">
        <nav aria-label="Page navigation example" class="Page navigation d-flex justify-content-center align-items-center navbar">
            <ul class="pagination" id="Pagination">

            </ul>
        </nav>
    </div>

    <script src="shared/js/bootstrap.js"></script>
    <script src="shared/js/jquery.js"></script>
    <script src="shared/js/sweetalert.js"></script>
    <script src="assets/js/index.js"></script>
</body>

</html>
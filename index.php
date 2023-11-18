<?php

require 'dbcon.php';
$insert = false;
$update = false;
$delete = false;
if (isset($_GET['delete'])) {

    $sno = $_GET['delete'];
    $delete = true;
    $sql = "DELETE FROM `llx_data` WHERE `rowid` = $sno";

    $result = $db->query($sql);
    // $result = $db->query($sql);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['snoEdit'])) {

        $sno = $_POST["snoEdit"];
        $title = $_POST["titleEdit"];
        $description = $_POST["descriptionEdit"];

        // Sql query to be executed
        $sql = "UPDATE `llx_data` SET `title` = '$title', `Description` = '$description' WHERE `llx_data`.`rowid` = " . $sno;


        $resultupdate = $db->query($sql);
        if ($resultupdate) {
            $update = true;
        } else {
            echo "We could not update the record successfully";
        }
    } else {
        if (isset($_POST['title']) && isset($_POST['Description'])) {
            $title = $_POST['title'];
            $dewscription = $_POST['Description'];

            $sqlins = "INSERT INTO `llx_data`(`title`,`Description`) VALUES ('$title','$dewscription')";

            $resultinss = $db->query($sqlins);
        }
    }
}






?>

<!doctype html>
<html lang="en">

<head>


    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">


    <title>iNotes - Notes taking made easy</title>

</head>

<body>
    <!--  modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit this Note</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="index.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="snoEdit" id="snoEdit">
                        <div class="form-group">
                            <label for="title">Note Title</label>
                            <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
                        </div>

                        <div class="form-group">
                            <label for="desc">Note Description</label>
                            <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update changes</button>
                </form>
            </div>
            <div class="modal-footer d-block mr-auto">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>

        </div>
    </div>
    </div>

    <nav class="navbar bg-dark border-bottom border-body" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">App</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Dropdown
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">About us</a></li>
                            <li><a class="dropdown-item" href="#">Contact us</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" aria-disabled="true">Disabled</a>
                    </li>
                </ul>
                <!-- <form class="d-flex" role="search"> -->

                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>

                <!-- </form> -->
            </div>
        </div>
    </nav>

    <?php


    ?>
    <div class="container my-4">

        <h2>Add Notes</h2>
        <form action="index.php" method="POST">
            <div class="form-group">
                <label for="title"> Note Title </label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
            </div>

            <div class="form-group">
                <label for="Description"> Note Description </label>
                <textarea class="form-control" id="Description" name="Description" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <div class="container my-4">
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>TMS</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM llx_data";
                $result = $db->query($sql);
                $rowid = 0;
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_object()) {
                        $rowid = $rowid + 1;
                        echo "<tr>
                        <th scope='row'>" . $row->rowid . "</th>
                        <td> " . $row->title . "</td>
                        <td>" . $row->Description . "</td>
                        <td>" . $row->tms . "</td>
                        <td> <button class='edit btn btn-sm btn-primary' id=" . $row->rowid . ">Edit</button> <button class='delete btn btn-sm btn-primary' id=d" . $row->rowid . ">Delete</button>  </td>
                      </tr>";
                    }
                }
                ?>

            </tbody>


        </table>

    </div>
    <hr>
    <!-- !-- Optional JavaScript --> -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();

        });
    </script>
    <script>
        edits = document.getElementsByClassName('edit');
        Array.from(edits).forEach((element) => {
            element.addEventListener("click", (e) => {
                console.log("edit");
                tr = e.target.parentNode.parentNode;
                title = tr.getElementsByTagName("td")[0].innerText;
                Description = tr.getElementsByTagName("td")[1].innerText;
                console.log(title, Description);
                titleEdit.value = title;
                descriptionEdit.value = Description;
                snoEdit.value = e.target.id;
                console.log(e.target.id)
                $('#editModal').modal('toggle');
            })
        })
        deletes = document.getElementsByClassName('delete');
        Array.from(deletes).forEach((element) => {
            element.addEventListener("click", (e) => {
                console.log("edit ");
                sno = e.target.id.substr(1);

                if (confirm("Are you sure you want to delete this note!")) {
                    console.log("yes");
                    window.location = `/app/index.php?delete=${sno}`;
                    // TODO: Create a form and use post request to submit a form
                } else {
                    console.log("no");
                }
            })
        })
    </script>

</body>

</html>
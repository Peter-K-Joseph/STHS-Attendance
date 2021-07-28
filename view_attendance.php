<!DOCTYPE html>
<html lang="en">
<?php

$Server="localhost";
$DatabaseName="nuvieliv_school_attendance";
$DatabaseUserID="nuvieliv_theresia";
$DatabasePasscode="peter@2002";
$conn = mysqli_connect($Server,$DatabaseUserID,$DatabasePasscode,$DatabaseName);
session_start();
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance</title>
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/notie/dist/notie.min.css">
    <script src="https://unpkg.com/notie"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</head>
<script>
    const name_logger = `<?php echo $_SESSION["user"]; ?>`;
</script>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">STHS Attendance</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="./attendance.php">Mark Attendance</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">View Individual Attendance</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="./overview_attendance.php">View All Attendance</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container"><br>
        <div class="card">
            <div class="card-header">
                Search
            </div>
            <div class="card-body">
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                Select By Tag
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">

                                <form>
                                    <?php
                                    $sql = "SELECT * FROM `register` WHERE `user` LIKE '" . $_SESSION["user"] . "'";
                                    $result = $conn->query($sql);
                                    
                                    if ($result->num_rows > 0){
                                        for ($i = 0; $row = $result->fetch_assoc(); $i++) {
                                            $theDate = str_replace(" ", " T", $row["timestamp"]);
                                            $theDate = new DateTime($theDate);
                                            $stringDate = $theDate->format('d-m-Y g:i a');
                                            echo '<button type="button" onclick="send_check(`' . $row["class"] . '`,`'.$row["timestamp"].'`,`' . $row["subject"] . '`)" class="btn btn-primary m-2">' . $row["class"] . ' - ' . $row["subject"] . '<br>' . $stringDate . '</button>&nbsp;&nbsp;&nbsp;';
                                        }
                                    } else {
                                        echo "<h4>Feature Unavailable</h4><h5>No Associated Registers found</h5>";
                                    }
                                    ?>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Search By Class and Subject
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <h3>Select Class</h3>
                                <form>
                                    <?php

                                    for ($classLen = 0; $classLen < count($_SESSION["class"]); $classLen++) {
                                        echo '
                                    <div class="form-check">
                                        <input class="form-check-input search_class" type="radio" name="classList" id="class_' . $_SESSION["class"][$classLen] . '" value="' . $_SESSION["class"][$classLen] . '" checked>
                                        <label class="form-check-label" for="class_' . $_SESSION["class"][$classLen] . '">
                                        ' . $_SESSION["class"][$classLen] . '
                                        </label>
                                    </div>';
                                    }
                                    ?>
                                </form>
                                <br>
                                <h3>Select Subject</h3>
                                <form>
                                    <?php

                                    for ($i = 0; $i < count($_SESSION["subject"]); $i++) {
                                        echo '<div class="form-check form-check-inline">
<input class="form-check-input subject" type="radio" name="inlineRadioOptions" id="subject_' . $i . '" value="' . $_SESSION["subject"][$i] . '">
<label class="form-check-label" for="subject_' . $i . '">' . $_SESSION["subject"][$i] . '</label>
</div>';
                                    }
                                    ?>
                                </form><br>
                                <button type="button" class="btn btn-primary" onclick="search_class()">Search</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><br>
        <div class="card">
            <div class="card-header">
                View Report
            </div>
            <div class="card-body" id="tableData">
                <h3 class="text-center">Search by Name or Search by Class and Subject to continue</h3>
            </div>
        </div>
</body>
<script src="./view_attendance.js"></script>

</html>
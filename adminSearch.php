<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="search_style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV">
</head>
    <body>
    <nav class="navbar fixed-top navbar-expand-sm navbar-dark"style="background-color:black">
    <a href="#" class="navbar-brand mb-0 h1">Car Rental</a>
    <div class="collapse navbar-collapse" id="nav_id">
    <ul class="navbar-nav">
        <li
            class="nav-item active">
            <a href="admin_main.php" class="nav-link">Back</a>
        </li>
        <li
            class="nav-item active">
            <a href="registration_login.html" class="nav-link">Signout</a>
        </li>

    </ul></div>
    </nav>
    <div style="margin-top:30px">
        <div class="container-fluid">
            <div class="row min-vh-100 flex-column flex-md-row">
                <aside class="col-12 col-md-20 col-xl-2 p-0 flex-shrink-1" style="background-color:black">
                    <nav class="navbar navbar-expand-md navbar-dark bd-dark flex-md-column flex-row align-items-center py-2 text-center sticky-top" id=sidebar >
                        <div class="text-center p-3">
                            <button class="dropdown-btn">car 
                                <i class="fa fa-caret-down"></i>
                            </button>
                            <div class="dropdown-container">
                                <form name="carsearch" method="post" >
            
                                    <label style="color:White;" for="plate">car plate:</label><br>
                                    <input type="text" id="fname" name='car_plate'>
                                    <br>
                                    <label style="color:White;" for="model">model:</label><br>
                                    <input type="text" id="em" name="model" ><br>


                                    <label style="color:White;" for="model_year">model year:</label><br>
                                    <input type="text" id="model_year" name="model_year" ><br>

                                    <label style="color:White;" for="daily_price">daily price:</label><br>
                                    <input type="text" id="daily_price" name="daily_price"><br>

                                    <label style="color:White;" for="color">color:</label><br>
                                    <input type="text" id="color" name="color"><br>
                                    <br>
                                    <input type="submit" name="button" value="Search"/>
                                </form>
                            </div>
                            <button class="dropdown-btn">customer 
                                <i class="fa fa-caret-down"></i>
                            </button>
                            <div class="dropdown-container">
                                <form name="customersearch" method="post" >
            
                                    <label style="color:White;" for="name">customer name:</label><br>
                                    <input type="text" id="cname" name='cname'>
                                    <br>
                                    <label style="color:White;" for="email">email:</label><br>
                                    <input type="email" id="email" name="email" ><br>
                                    <br>
                                    <input type="submit" name="button" value="Search"/>
                                </form>
                            </div>
                            <button class="dropdown-btn">Reservation 
                                <i class="fa fa-caret-down"></i>
                            </button>
                            <div class="dropdown-container">
                                <form name="reservationsearch" method="post" >
            
                                    <label style="color:White;" for="rday">Reservation Day:</label><br>
                                    <input type="date" id="rday" name='rday'><br>
                                    <br>
                                    <input type="submit" name="button" value="Search"/>
                                </form>
                            </div>
                            <script>
                            /* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
                            var dropdown = document.getElementsByClassName("dropdown-btn");
                            var i;
                            for (i = 0; i < dropdown.length; i++) {
                            dropdown[i].addEventListener("click", function() {
                                this.classList.toggle("active");
                                var dropdownContent = this.nextElementSibling;
                                if (dropdownContent.style.display === "block") {
                                dropdownContent.style.display = "none";
                                } else {
                                dropdownContent.style.display = "block";
                                }
                                });
                            }
                            </script>
                        </div>
                    </nav>
                </aside>
                <main class="col px-0 flex-grow-1">
                    <div class="container py-3">
                        <?php
                            if (isset($_POST['car_plate'])) {
                                $plate = $_POST['car_plate'];
                            }
                            if (isset($_POST['model'])) {
                                $model = $_POST['model'];
                            }
                            if (isset($_POST['model_year'])) {
                                $model_year = $_POST['model_year'];
                            }
                            if (isset($_POST['daily_price'])) {
                                $daily_price = $_POST['daily_price'];
                            }
                            if (isset($_POST['color'])) {
                                $color = $_POST['color'];
                            }
                            if (isset($_POST['cname'])) {
                                $cust_name = $_POST['cname'];
                            }
                            if (isset($_POST['email'])) {
                                $cust_email = $_POST['email'];
                            }
                            if (isset($_POST['rday'])) {
                                $res_day = $_POST['rday'];
                            }
                            $conn = new mysqli('localhost', 'root', '', 'car_rental');
                            if ($conn->connect_error) {
                                echo "$conn->connect_error";
                                die("Connection Failed : " . $conn->connect_error);
                            }
                            if (isset($plate) || isset($model) || isset($model_year) || isset($daily_price) || isset($color)) {
                                $where = array();
                                if ($plate) {
                                    $where[] = "car_plate = '$plate'";
                                }
                                if ($model) {
                                    $where[] = "model='$model'";
                                }
                                if ($model_year) {
                                    $where[] = "model_year= $model_year";
                                }
                                if ($daily_price) {
                                    $where[] = "daily_price=$daily_price";
                                }
                                if ($color) {
                                    $where[] = "color='$color'";
                                }
                                $where = implode(' and ', $where);

                                $result = "select * from car where " . $where;
                                // echo $result;
                                $qLog = mysqli_query($conn, $result);
                                $count = mysqli_num_rows($qLog);
                                
                                if ($count != 0) {
                        ?>
                                    // Process all rows
                                    <div style="margin-top:15px">
                                    <div class ="container">
                                    <div class ="row">
                        <?php
                                    while ($row = mysqli_fetch_array($qLog)) {
                                        $imageURL = 'uploads/'.$row["image"];
                        ?>
                                        <div class="col-md-3  mt-2">
                                            <div class="card" name="display">
                                                <img class="card-img-top" src="<?php echo $imageURL; ?>" alt="" />
                                                <div class="card-body">
                                                    <h5 class="card-title">
                                                    <?php echo $row['car_plate']; ?>
                                                    </h5>
                                                    <strong><br> <?php echo $row['model']?></strong><br>
                                                    <strong> <?php echo $row['model_year']?></strong><br>
                                                    <strong> <?php echo $row['color']?></strong><br>
                                                    <strong>Daily Rent Price :$<?php echo $row['daily_price']?></strong><br>
                                                </div>    
                                            </div>
                                        </div>
                        <?php
                                        $count--;
                                    }
                        ?>
                                    </div>
                                    </div>
                                    </div>
                        <?php
                                }else{
                                    echo "<div style='margin-top:30px'>"."Not Found"."</div>";
                                    return False;
                                }
                            }else if (isset($cust_email) || isset($cust_name)) {
                                $where = array();
                                if ($cust_name) {
                                    $where[] = "name = '$cust_name'";
                                }
                                if ($cust_email) {
                                    $where[] = "email='$cust_email'";
                                }

                                $where = implode(' and ', $where);
                    
                                $result = "select * from customer where " . $where;
                                // echo $result;
                                $qLog = mysqli_query($conn, $result);
                                $count = mysqli_num_rows($qLog);
                                
                                if ($count != 0) {
                                    // Process all rows
                                    while ($row = mysqli_fetch_array($qLog)) {
                        ?>
                                        <div style="margin-top:15px">
                                        <div class="col-md-3  mt-2">
                                            <div class="card" name="display">
                                                <div class="card-body">
                                                    <h5 class="card-title">
                                                    <?php echo $row['name']; ?>
                                                    </h5>
                                                    <strong><br> <?php echo $row['email']?></strong><br>
                                                </div>
                                            </div>    
                                        </div>
                                        </div>
                        <?php
                                        $count--;
                                    }
                                } else {
                                    echo "<div style='margin-top:30px'>"."Not Found"."</div>";
                                    return False;
                                }
                            }else if (isset($res_day)) {
                                $where = array();
                                if ($res_day) {
                                    $where[] = "start_date = '$res_day'";
                                }
                                $where = implode(' and ', $where);
                    
                                $result = "select * from registration natural join car where  " . $where;
                                // echo $result;
                                $qLog = mysqli_query($conn, $result);
                                $count = mysqli_num_rows($qLog);
                                
                                if ($count != 0) {
                        ?>
                                    <div style="margin-top:15px">
                                    <div class ="container">
                                    <div class ="row">
                        <?php
                                    // Process all rows
                                    while ($row = mysqli_fetch_array($qLog)) {
                                        $imageURL = 'uploads/'.$row["image"];
                        ?>
                                        <div class="col-md-3  mt-2">
                                        <div class="card" name="display">
                                            <img class="card-img-top" src="<?php echo $imageURL; ?>" alt="" />
                                            <div class="card-body">
                                                <h5 class="card-title">
                                                <?php echo $row['car_plate']; ?>
                                                </h5>
                                                <strong><br> <?php echo $row['model']?></strong><br>
                                                <strong> <?php echo $row['model_year']?></strong><br>
                                                <strong> <?php echo $row['color']?></strong><br>
                                                <strong>Daily Rent Price :$<?php echo $row['daily_price']?></strong><br>
                                            </div>    
                                        </div>
                                        </div>
                        <?php
                                        $count--;
                                    }
                        ?>            
                                    </div>
                                    </div>
                                    </div>
                        <?php
                                } else {
                                    echo "<div style='margin-top:30px'>"."Not Found"."</div>";
                                    return False;
                                }
                            }
                        ?>
                    </div>
                </main>
            </div>
        </div>
    </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    </body>
</html>
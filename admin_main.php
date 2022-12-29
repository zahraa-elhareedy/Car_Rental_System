<!DOCTYPE html>
<html>

<head>
    <title>Admin</title>
    <link rel="stylesheet" href="admin_style.css">
    
    <!--w =word-->
    <script>
            function validateForm() {
                return true;
                
            }
        </script>
    
</head>

<body>
<div class="Admin">       
    <div class="form"  >
            <form name="register_car" id="register_car"  method="post" action="register_car.php"   class= "Register-car-form" enctype="multipart/form-data">  
            <h2>Register</h2> 
            <input type="date" id="start_date" name='start_date' required>
            <input type="text" id="car_plate" name="car_plate" class="input-box" placeholder="Car Plate" required >
            <input type="text" id="model" name="model" class="input-box" placeholder="Model" required>
            <input type="text" id="year" name="year" class="input-box" placeholder="Year" required >
            <input type="text" id="color" name="color" class="input-box" placeholder="Color" required >
            <input type="text" id="daily_price" name="daily_price" class="input-box" placeholder="Daily Rent Price" required>
            <?php
                // Connect to database
                $con = mysqli_connect("localhost","root","","car_rental");  
                // Get all the offices from category table
                $sql = "SELECT * FROM office ";
                $all_offices = mysqli_query($con,$sql);
            ?>
            <br><label style="color:White;">Select an Office</label>
            <select name="office" id="office" >
            <option selected value="0">Location</option>
                <?php
                    // use a while loop to fetch data
                    // from the $all_offices variable
                    // and individually display as an option
                    while ($office_name = mysqli_fetch_array(
                            $all_offices,MYSQLI_ASSOC)):;
                ?>
                    <option  value="<?php echo $office_name["office_id"];
                        // The value we usually set is the primary key
                    ?>">
                        <?php echo $office_name["location"];
                            // To show the location to the user
                        ?>
                    </option>
                <?php
                    endwhile;
                    // While loop must be terminated
                ?>
            </select>
            <br>

            <label style="color:White;">Select image to upload:</label>
            <input style="color:White;" type="file" name="file" id="file"required>
            <button type="submit" name="submit" >Add Car</button>
            <p class="message"><a href = "#">Update Status</a> </p>
            </form>
            <form name="register_office" id="register_office"  method="post" action="insert_office.php"   class= "insert_office-form" >  
            <h2>Register Office</h2> 
            <input type="text" id="office_name" name="office_name" class="input-box" placeholder="Office Name" required >
            <button type="submit">Add Office</button>
            </form>
            <form name="update_status" id="update_status" onsubmit="return update_status_validation()" method="post" action="update_status.php" class= "update-status-form"  > 
            <h2>Update Status</h2> 
            <input type="text" id="car_plate" name="car_plate" class="input-box" placeholder="Car Plate" required >
            <label style="color:White;"   for="edate">Start Date:</label><br>
            <input type="date" id="startdate" name='startdate' required><br>
            <label style="color:White;"  for="edate">End Date:</label><br>
            <input type="date" id="enddate" name='enddate' required>
            <button type="submit">Check status</button>
            <p class="message"><a href = "#">Register Car</a> </p>
            <p class="message"><a href = "adminSearch.php">Search</a> </p>
            <p class="message"><a href = "reports.php">Reports</a> </p>
            <p class="message"><a href="registration_login.html">Signout</a></p>;
            </form>
    <script src='https://code.jquery.com/jquery-3.6.1.min.js'>
     </script>
     <script>
        $('.message a').click(function(){
            $('form').animate({height: "toggle", opacity : "toggle"}, "slow");
        });
     </script>

    </div>
    </div>

</body>

</html>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="reports.css">
</head>
<body >
<div class="reports">

    <div class="form">
	<center>
                        <button class="dropdown-btn">Reservations within a specific period: 
                            <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="dropdown-container">
                            <form name="reservation period" method="post" action="periodReservations.php" >
        
                                <label style="color:White;" for="startdate">From:</label><br>
                                <input type="date" id="startdate" name="startdate" required>
                                <br>
                                <label style="color:White;" for="enddate">To:</label><br>
                                <input type="date" id="enddate" name="enddate" required><br>
                                <br>
                                <input type="submit" name="button" value="Search"/>
                            </form>
                        </div>
                        <button class="dropdown-btn"> Reservations of a car within a specific period:
                            <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="dropdown-container">
                            <form name="customersearch" method="post" action="carReservations.php">
                                <label style="color:White;" for="carreservations">From:</label><br>
                                <input type="date" id="startdate" name="startdate" required>
                                <br>
                                <label style="color:White;" for="enddate">To:</label><br>
                                <input type="date" id="enddate" name="enddate" required><br>
                                <label style="color:White;" for="car_plate">Car Plate:</label><br>
                                <input type="text" id="car_plate" name="car_plate" required>
                                <br>
                                <br>
                                <input type="submit" name="button" value="Search"/>
                            </form>
                        </div>
                        <button class="dropdown-btn">Status of all cars on a specific day: 
                            <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="dropdown-container">
                            <form name="carstate" method="post" action="carStatus.php" >
        
                                <label style="color:White;" for="today">At:</label><br>
                                <input type="date" id="today" name="today" required>
                                <br>
                                <br>
                                <input type="submit" name="button" value="Search"/>
                            </form>
                        </div>
                        <button class="dropdown-btn"> Reservations of a specific customer:
                            <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="dropdown-container">
                            <form name="customersearch" method="post" action="customerReservations.php">
                                <label style="color:White;" for="cust_email">Customer Email:</label><br>
                                <input type="email" id="cust_email" name="cust_email" required>
                                <br>
                                <br>
                                <input type="submit" name="button" value="Search"/>
                            </form>
                        </div>

                        <button class="dropdown-btn">Payments within a specific period: 
                            <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="dropdown-container">
                            <form name="reservation period" method="post" action="payments.php" >
        
                                <label style="color:White;" for="startdate">From:</label><br>
                                <input type="date" id="startdate" name="startdate">
                                <br>
                                <label style="color:White;" for="enddate">To:</label><br>
                                <input type="date" id="enddate" name="enddate" ><br>
                                <br>
                                <input type="submit" name="button" value="Search"/>
                            </form>
                        </div>

                        <a style="color:White;" href="admin_main.php">Back</a>

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
</center>
                    </form>
</body>
</html>

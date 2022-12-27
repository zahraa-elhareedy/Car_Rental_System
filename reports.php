<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="return.css">
</head>
<body >
	<center>
        
    <button class="dropdown-btn">Reservations within a specific period: 
                            <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="dropdown-container">
                            <form name="carsearch" method="post" action="reservationWithinPeriod.php" >
        
                                <label style="color:White;" for="startdate">From:</label><br>
                                <input type="date" id="startdate" name='startdate'>
                                <br>
                                <label style="color:White;" for="enddate">To:</label><br>
                                <input type="date" id="enddate" name="enddate" ><br>
                                <br>
                                <input type="submit" name="button" value="Search"/>
                            </form>
                        </div>
                        <button class="dropdown-btn"> Reservations of a car within a specific period
                            <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="dropdown-container">
                            <form name="customersearch" method="post" >
                                <label style="color:White;" for="startdate">From:</label><br>
                                <input type="date" id="startdate" name='startdate'>
                                <br>
                                <label style="color:White;" for="enddate">To:</label><br>
                                <input type="date" id="enddate" name="enddate" ><br>
                                <br>
                                <label style="color:White;" for="car_plate">Car Plate:</label><br>
                                <input type="text" id="car_plate" name='car_plate'>
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

</form>
</center>
</body>
</html>

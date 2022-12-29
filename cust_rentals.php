<?php 
    session_start();
    $conn = mysqli_connect("localhost","root","","car_rental");  
    $cust_id = $_SESSION['cust_id'];
    if($conn->connect_error){
        echo "$conn->connect_error";
    die("Connection Failed : ". $conn->connect_error);
} 
 else{
    $statement = $conn->prepare("select * from registration natural join car where cust_id= ?");
    $statement->bind_param("d", $cust_id);
    $statement->execute();
    $car = $statement->get_result();
    $statement->close();
    $conn->close();
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
    content="width=device-width, initial-scale=1.0">  
    <link rel="stylesheet" href="return.css">
       <!-- Bootstrap CSS -->
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
            <a href="customer_home.php" class="nav-link">Back</a>
        </li>
        <li
            class="nav-item active">
            <a href="registration_login.html" class="nav-link">Signout</a>
        </li>
    </ul></div>
    </nav>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" 
    crossorigin="anonymous"></script>
    
    <div style="margin-top:60px">
    <h2 style = "text-align : center;">My Rentals</h2>
  <div class ="container">
  <div class ="row">
  <?php
  foreach($car as $car){
      $imageURL = 'uploads/'.$car["image"];
      ?>
  <div class="col-md-3  mt-2">
                <div class="card">
                <img class="card-img-top" src="<?php echo $imageURL; ?>" alt="" />
                <div class="card-body">
                        <h5 class="card-title">
                        <?php echo $car['car_plate']?>
                        </h5>
                        <strong><br> <?php echo $car['model']?></strong><br>
                        <strong> <?php echo $car['model_year']?></strong><br>
                        <strong> <?php echo $car['color']?></strong><br>
                        <strong>Payment :$<?php echo $car['payment']?></strong><br>
                        <strong>Pick up date :<?php echo $car['start_date']?></strong><br>
                        <strong>Expected Return date :<?php echo $car['end_date']?></strong><br>
                <?php
                if( $car['is_returned']==FALSE)
                {
                ?>         
                        <button class="dropdown-btn">Return 
                            <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="dropdown-container">
                            <form name="carsearch" action="return.php?car=<?php echo $car['car_plate']?>" method="post" >
                            <label  for="rdate">Choose Return Date:</label><br>
                            <input type="date" id="returndate" name='returndate' required>
                            <input type="hidden" id="register_no" name="register_no" value="<?php echo $car['register_no']; ?>">

                            <input type="hidden" id="end_date" name="end_date" value="<?php echo $car['end_date']; ?>">
                            <input type="hidden" id="daily_price" name="daily_price" value="<?php echo $car['daily_price']; ?>">

                            <input type="hidden" id="startres" name="startres" value="<?php echo $car['start_date']; ?>">

                            <br>
                            <input type="submit" name="button" value="submit"/>
                            </form>
                        </div>
                        <?php
                        }else{?>
                            <strong style=" color: #013dca;">Returned</strong><br>
                            <strong>Actual Return date :<?php echo $car['return_date']?></strong><br>
                            <?php
                            $penalty = 0;
                               $sdate=new DateTime($car['return_date']);
                               $edate=new DateTime($car['end_date']);
                               if($sdate>$edate){
                                $conn = new mysqli('localhost','root','','car_rental');
                                if($conn->connect_error){
                                echo "$conn->connect_error";
                                die("Connection Failed : ". $conn->connect_error);
                                                } 
                                else{
                                   $interval=$sdate->diff($edate);
                                   $days=$interval->d;
                                   $penalty=$days*$car['daily_price'];
                                   $statement = $conn->prepare("update registration SET penalty = ? where car_plate = ? AND register_no = ?");
                                   $statement->bind_param("dsd",$penalty,$car['car_plate'],$car['register_no']);
                                   $execval = $statement->execute();
                                   $statement->close();
                             
                               } }?>
                               <strong>Penalty : $<?php echo $penalty?></strong><br>

                            <?php }?>
                       </div>
                        </div>
                        </div>
    <?php
    }
    ?>
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
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script> 
</body>
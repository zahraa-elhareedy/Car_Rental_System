<?php
    // Connect to database
    $con = mysqli_connect("localhost","root","","car_rental");  
    // Get all the offices from category table
    $sql = "SELECT * FROM office ";
    $all_offices = mysqli_query($con,$sql);
?>
<?php
 session_start();
$ci= $_SESSION['cust_id'];
$today=$_SESSION['today_date'];
$conn = new mysqli('localhost','root','','car_rental');
if($conn->connect_error){
    echo "$conn->connect_error";
    die("Connection Failed : ". $conn->connect_error);
}
$rented='rented';
$inactive='inactive';
$available='available';
$statement1 = $conn->prepare("UPDATE CAR set status = ? WHERE car_plate in (SELECT car_plate from car_status where (start_date <= ? and end_date >= ?) and status =? ) "); 
$statement1->bind_param("ssss",$inactive,$today,$today,$inactive);
$statement1->execute();
$cars = $statement1->get_result();
$statement1->close();
$statement1 = $conn->prepare("UPDATE CAR set status = ? WHERE car_plate in (SELECT car_plate from car_status where (start_date <= ? and (end_date >= ? or end_date is null)) and status =? ) "); 
$statement1->bind_param("ssss",$available,$today,$today,$available);
$statement1->execute();
$cars = $statement1->get_result();
$statement1->close();

$statement1 = $conn->prepare("UPDATE CAR set status = ? WHERE car_plate in (SELECT car_plate from registration where (start_date <= ? and return_date >= ?) OR (return_date <= ? and is_returned = 0) ) and status !=?"); 
$statement1->bind_param("sssss",$rented,$today,$today,$today,$inactive);
$statement1->execute();
$cars = $statement1->get_result();
$statement1->close(); 

$statement1 = $conn->prepare("UPDATE CAR set status = ? WHERE car_plate not in (SELECT car_plate from registration where (start_date <= ? and return_date >= ?) OR (return_date <= ? and is_returned = 0) ) and status !=?"); 
$statement1->bind_param("sssss",$available,$today,$today,$today,$inactive);
$statement1->execute();
$cars = $statement1->get_result();
$statement1->close(); 
     

if(isset($_POST['search_for']) && ($_POST['office']!=0)){
    $stat_avail='available';
    $value=$_POST['office'];
    if($_POST['search_for']!= "" || $_POST['search_for'] != null){
      $search_for = $_POST['search_for'];
      $statement1 = $conn->prepare("SELECT * FROM CAR natural join office  WHERE office_id = ?  AND(model = ? OR model_year = ? OR daily_price = ? OR color = ? ) "); 
      $statement1->bind_param("dsdds",$value,$search_for,$search_for,$search_for,$search_for);
      $statement1->execute();
      $cars = $statement1->get_result();
      $statement1->close();
      
    }
    else{$statement = $conn->prepare("SELECT * FROM CAR natural join office WHERE office_id = ?  "); 
    $statement->bind_param("d",$value);
    $statement->execute();
    $cars = $statement->get_result();
    $statement->close();
    }
  }
else{
  $stat_avail='available';
  $statement = $conn->prepare("SELECT * FROM CAR natural join office "); 
  $statement->execute();
  $cars = $statement->get_result();
  $statement->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
    content="width=device-width, initial-scale=1.0">  
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
            <a href="cust_rentals.php" class="nav-link">My Rentals</a>
        </li>
        <li
            class="nav-item active">
            <a href="registration_login.html" class="nav-link">Signout</a>
        </li>
    </ul></div>
    <div >
    <form class="d-flex" name="select_form" method="POST" >
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

        <input type="text" id="search_for" name="search_for">
        <button type="submit" class="btn btn-outline-success" name = "search" >Search</button>
    </form>
   
    </div>
    </nav>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" 
    crossorigin="anonymous"></script>
    <div style="margin-top:60px">
  <div class ="container">
  <div class ="row">
    <?php
    foreach($cars as $car){
      $imageURL = 'uploads/'.$car["image"];
      ?>
      <div class="col-md-3  mt-2">
                <div class="card">
                <a href="SingleProduct.php?car=<?php echo $car['car_plate']?>">
                <img class="card-img-top" src="<?php echo $imageURL; ?>" alt="" />
                </a>
                <div class="card-body">
                        <h5 class="card-title">
                        <a href="SingleProduct.php?car=<?php echo $car['car_plate']?>">
                        <?php echo $car['car_plate']?>
                        </a>
                        </h5>
                        <strong><br> <?php echo $car['model']?></strong><br>
                        <strong> <?php echo $car['model_year']?></strong><br>
                        <strong> <?php echo $car['color']?></strong><br>
                        <strong>Daily Rent Price :$<?php echo $car['daily_price']?></strong><br>
                        <strong>Status Today :<?php if($car['status']=='inactive'){echo "out of service";}else{echo $car['status'];}?></strong><br>
                        <strong> <?php echo $car['location']?></strong><br>
                        <p class="card-text">
                            <a href="SingleProduct.php?car=<?php echo $car['car_plate']?>" class="btn btn-primary btn-sm">
                                View
                            </a>
                        </p>
                        </div>
                        </div>
                        </div>
                      
    <?php
    }
    ?>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script> 
</body>
  
</html>
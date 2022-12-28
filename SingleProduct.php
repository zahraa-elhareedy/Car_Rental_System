<?php 
    session_start();
    $car_plate=$_GET['car'];
    $conn = new mysqli('localhost','root','','car_rental');
    if($conn->connect_error){
        echo "$conn->connect_error";
    die("Connection Failed : ". $conn->connect_error);
} 
 else{
    $statement1 = $conn->prepare("select * from car where car_plate = ? ");
    $statement1->bind_param("s",$car_plate);
    $statement1->execute();
    $car = $statement1->get_result()->fetch_assoc();
    $statement1->close();
    $conn->close();
 }
$imageURL = 'uploads/'.$car["image"];
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
    <div class="row mt-3">
		<div class="col-md-5">
        <img class="card-img-top" src="<?php echo $imageURL; ?>" alt="" />
		</div>
		<div class="col-md-7">
			<form class="form-inline" method="POST" action="rent.php">
				<div class="form-group mb-2">
                <label  for="sdate">Start Date:</label><br>
                <input type="date" id="startdate" name='startdate' required><br>
                <label  for="edate">End Date:</label><br>
                <input type="date" id="enddate" name='enddate' required>
                <input type="hidden" id="car_plate" name="car_plate" value="<?php echo $car_plate; ?>">
                <input type="hidden" id="daily_price" name="daily_price" value="<?php echo $car['daily_price']; ?>">
				</div>
				<div class="form-group mb-2 ml-2">
					<button type="submit" class="btn btn-primary" name="rent" value="rent">Rent</button>
				</div>
			</form>
		</div>
	</div>
	<div class="row mt-3">
		<div class="col-md-12">
            <strong><?php echo $car['car_plate']?></strong>
            <strong><br> <?php echo $car['model']?></strong><br>
            <strong> <?php echo $car['model_year']?></strong><br>
            <strong> <?php echo $car['color']?></strong><br>
            <strong>Daily Rent Price :$<?php echo $car['daily_price']?></strong><br>
		</div>
	</div>
</div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script> 
                        </body>
  
</html>
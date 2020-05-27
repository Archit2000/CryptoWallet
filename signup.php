<?php include('headerfooters/Initial_Plugin.php'); ?>
<?php include('headerfooters\navbar_pre_login.php'); ?>

<?php 
    //create connection
    $conn = mysqli_connect('localhost','Cryptowallet','4PLJ0AoqqdExiL1W','cryptowallet');
    //check connection
    if(!$conn){
        echo 'errro: '.mysqli_connect_error();
    }
    $sqlerror="";
    $email=$name=$password=$confirmpassword="";
    $errors = array('name' => '','email'=>'','password'=>'','confirmpassword'=>'');
	if(isset($_POST['submit'])){
		
		// check email
		if(empty($_POST['email'])){
			$errors['email'] = 'An email is required';
		} else{
			$email = $_POST['email'];
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				$errors['email'] = 'Email must be a valid email address';
			}
		}

		// check password
		if(empty($_POST['password'])){
			$errors['password'] = 'A password is required';
		} else{
			$password = $_POST['password'];
		}

		// check confirmpassword
		if(empty($_POST['confirmpassword'])){
			$errors['confirmpassword'] = 'Enter password for confirmation';
		} else{
            $confirmpassword = $_POST['confirmpassword'];  
        }
        //check both passwords
        if($password!=$confirmpassword){
            $errors['password']='Enter same password';
        }

        //check name
        if(empty($_POST['name'])){
			$errors['name'] = 'A name is required';
		} else{
			$name = $_POST['name'];
        }
        


		if(array_filter($errors)){
			//echo 'errors in form';
		} else {
			// escape sql chars
			$email = mysqli_real_escape_string($conn, $_POST['email']);
			$password = mysqli_real_escape_string($conn, $_POST['password']);
			$confirmpassword = mysqli_real_escape_string($conn, $_POST['confirmpassword']);

			// create sql
			$sql = "INSERT INTO userdetails(email,password,name) VALUES('$email','$password','$name')";

			// save to db and check
			if(mysqli_query($conn, $sql)){
				// success
				header('Location: index.php');
			} else if(mysqli_error($conn)){
				$sqlerror= 'This Email address is already registered';
			}

		}

	} // end POST check

?>  
    <div style="margin-top:2%; padding:25px; border-radius:15px; min-width:325px; max-width:500px; width:60%; " class="col mx-auto align-self-center bg-light shadow">
    <h3 class="text-center">SIGN-UP</h3>
        <?php if($sqlerror!=''){?>    
        <div class="alert-error">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
            <strong><?php echo $sqlerror; ?></strong>
        </div>
        <?php } ?>
        <form class=" " method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($name) ?>">
                <div class="error-display"><?php echo $errors['name']; ?></div>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" name="email" class="form-control" value="<?php echo htmlspecialchars($email) ?>">
                <div class="error-display"><?php echo $errors['email']; ?></div>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo htmlspecialchars($password) ?>">
                <div class="error-display"><?php echo $errors['password']; ?></div>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirmpassword" class="form-control" value="<?php echo htmlspecialchars($confirmpassword) ?>">
                <div class="error-display"><?php echo $errors['confirmpassword']; ?></div>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</html>
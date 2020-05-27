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
	$email = $password = '';
	$errors = array('email' => '', 'password' => '');

    //////////////////////////////////
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
		if(array_filter($errors)){
			//echo 'errors in form';
		} else {
			// escape sql chars
			$email = mysqli_real_escape_string($conn, $_POST['email']);
			$password = mysqli_real_escape_string($conn, $_POST['password']);

			// create sql
			$sql = "SELECT * FROM USERDETAILS WHERE Email='$email'";
            //get query result
            $result=mysqli_query($conn,$sql);
            //fetch result in array
            $data=mysqli_fetch_assoc($result);
            // save to db and check
            if(gettype($data)!='NULL'){
                // if query sucess 
                if($data['email']==$email && $data['password'] == htmlspecialchars($password)){
                    //data matched
                    //tranfer user data to server
                    $_SESSION['email']=$data['email'];
                    $_SESSION['name']=$data['name'];
                    header('Location: dashboard.php');
                }
                else if($data['email']==$email && $data['password'] != htmlspecialchars($password)){
                    $errors['password']='Re-enter the password';
                }
                else if($data['email']!=$email && $data['password'] == htmlspecialchars($password)){
                    $errors['email']='Re-enter the email';
                }
            }
            else {
                $sqlerror="Email address is not registered";
            }
            

		}

	} // end POST check

?>  
    <div style="margin-top:10%; padding:25px; border-radius:15px; min-width:325px; max-width:500px; width:60%; " class="col mx-auto align-self-center bg-light shadow">
    <h3 class="text-center">LOG In</h3>
        <?php if($sqlerror!=''){?>    
        <div class="alert-error">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
            <strong><?php echo $sqlerror; ?></strong>
        </div>
        <?php }?>
        <form class=" " method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
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
            <button type="submit" name="submit" class="btn btn-primary">LOGIN</button>
        </form>
    </div>
</html>
<?php

session_start();


require_once('config/db.php');
require_once('config/security.php');


$user_id = secure($_POST['user_id']);
$pass = secure($_POST['password']);

// Check if form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (isset($_POST['submit']) && !empty($_POST['submit'])) {

    // Prepare and bind SQL statement to protect against SQL injection attacks
    $stmt = $conn->prepare("SELECT * FROM pet_info WHERE pet_id=? AND pass=?");
    $stmt->bind_param("ss", $user_id, $pass);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists and password is correct
    if ($result->num_rows == 1) {
        // User authenticated, redirect to dashboard
        while($row = $result->fetch_assoc()){
          $_SESSION['user'] = $row['pet_id'];
        }
        
        header("Location: public/pages/pet.php?id=".$_SESSION['user']);
        echo "it is exist";
        exit();
    } else if($user_id == "admin" & $pass == "123"){
      $_SESSION['admin'] = "admin";
      header('Location: private/admin/admin.php');

    }else {
        // Invalid username or password
        $error_message = "Invalid username or password";
    }
    
  }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, height=device-height">
    <title>Document</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css?v=<?php echo time(); ?>"
      rel="stylesheet"
      integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="public/main.css?v=<?php echo time(); ?>">
</head>
<body class="text-center">
    
    <form action="" method="post" class="form-signin">
        <img class="mb-4" src="public/images/logo_shadow.svg" alt="" width="220" >
        <h1 class="h3 mb-3 font-weight-normal">Please log in</h1>
        
        <?php if (isset($error_message)) : ?>
            <div class="alert alert-danger"><?= $error_message ?></div>
        <?php endif; ?>
        
          <input type="pet_id" name="user_id" id="inputEmail" style="width: 300px;margin-top: 15px;" class="form-control" placeholder="Pet's ID" required autofocus>
          <input type="password" name="password" id="inputPassword" style="width: 300px;margin-top: 15px;" class="form-control" placeholder="Password" required>
        
            
        <input class="btn btn-lg btn-warning btn-block" style="margin-top: 15px;" type="submit" name="submit" value="Log in">
        <p class="mt-5 mb-3 text-muted">&copy; 2023</p>
    </form>
    
  </body>
</html>
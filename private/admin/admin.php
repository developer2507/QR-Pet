<?php

session_start();
ob_start();

echo "admin page";

//Check Admin log in
if (!isset($_SESSION['admin']) & empty($_SESSION['admin'])) {
    header('Location: ../../index.php');
}

//Log out function
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['submit']) & !empty($_POST['submit'])) {
        session_destroy();
        session_unset();
        header('Location: ../../index.php');
    }
}


// *** XSS ATTAC PROTECTION ***

function secure($data) {
    $data = trim($data);
    // $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// function to generate unique ID
function generateID() {
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $id = '';
  for ($i = 0; $i < 7; $i++) {
    $id .= $characters[rand(0, strlen($characters) - 1)];
  }
  return $id;
}

// function to generate unique password
function generatePassword() {
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $password = '';
  for ($i = 0; $i < 5; $i++) {
    $password .= $characters[rand(0, strlen($characters) - 1)];
  }
  return $password;
}

// function to insert data into database
function insertData($count) {
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "qrpet";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // generate IDs and passwords
  $ids = array();
  $passwords = array();
  for ($i = 0; $i < $count; $i++) {
    $id = generateID();
    $password = generatePassword();
    array_push($ids, $id);
    array_push($passwords, $password);
  }

  // Use prepared statements to prevent SQL injection attacks
  $stmt = $conn->prepare("INSERT INTO pet_info (pet_id, pass) VALUES (?, ?)");
  $stmt->bind_param("ss", $id, $password);

  // insert data into database
  for ($i = 0; $i < $count; $i++) {
    $id = secure($ids[$i]);
    $password = secure($passwords[$i]);
    if ($stmt->execute() === FALSE) {
      echo "Error: " . $stmt->error;
    }else{
        echo "SUCCESSFULLY ADDED";
    }
  }

  $stmt->close();

  $conn->close();
}

// generate and insert data
$count = 5;
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['generate'])) {
        $count = secure($_POST['count']);
        insertData($count);
    }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <form action="" method="POST">
        <label>Enter count:</label>
        <input type="number" name="count" value="<?php echo $count; ?>">
        <button type="generate" name="generate">Generate</button>
    </form>


    <form action="" method="post">
        <input type="submit" name="submit" value="Log out">
    </form>

    <ul>
      <li><a href="admin.php">Add users</a></li>
      <li><a href="generator/generate-exel.php">Generate QR Exel File</a></li>
    </ul>
</body>
</html>
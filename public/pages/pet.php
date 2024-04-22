<?php

session_start();

require_once('../../config/db.php');
require_once('../../config/security.php');


//Check for existing of user session
if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {

$check_social_media = true;

}else{
  $disabled = 'disabled';
  $check_social_media = false;
  
}
//End of checking

//Get ID number
if (isset($_GET['id']) && !empty($_GET['id'])) {
  $get_id = secure($_GET['id']);
  
}

//Log out functionality
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['logout'])) {
    session_destroy();
    session_unset();
    header('Location: ../../index.php');
  }
}
//End of log out



// Select Retrieve data from database
$stmt = $conn->prepare('SELECT * FROM pet_info WHERE pet_id = ?');
$stmt->bind_param('s', $get_id);
$stmt->execute();
$result = $stmt->get_result();

 if ($result->num_rows == 1) {
  $row = $result->fetch_assoc();
 }else{
  echo "Dont exist Redirect to 404.php";
 }




//Uploading an image functionality
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $target_dir = "uploads/";
  $unique_filename = uniqid('', true) . '.' . strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));
  $target_file = $target_dir . $unique_filename;
  $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

  

  // Check if image file is a actual image or fake image
  if(isset($_POST["save"])) {
    if ($_FILES["fileToUpload"]["name"] != '') {
      $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
      $photo_check = $unique_filename;
      if($check !== false) {
        // echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
      } else {
        echo "File is not an image.";
        $uploadOk = 0;
      }
    } else{
      $uploadOk = 1;
      $photo_check = $row['photo'];
    }
  

    // Check if file already exists
    if (file_exists($target_file)) {
      echo "Sorry, file already exists.";
      $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 1000000) {
      echo "Sorry, your file is too large.";
      $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
      // echo "Sorry, only JPG, JPEG, PNG files are allowed.";
      $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      // echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        // echo "The file ". htmlspecialchars($unique_filename). " has been uploaded.";
      } else {
        echo "Sorry, there was an error uploading your file.";
      }
    }
  }
}
 else {
  // Redirect or show an error message
  // ...
  
}




//NOTES:
// check to not update if photo is empty
// Make an Update functionality
// Add padding-right 20px



 
// UPDATING DATA
  $wp = secure($_POST['wp']);
  $fb = secure($_POST['fb']);
  $instagram = secure($_POST['instagram']);
  $photo = secure($photo_check);
  $pet_name = secure($_POST['pet_name']);
  $breed = secure($_POST['breed']);
  $age = secure($_POST['age']);
  $pet_msg = secure($_POST['pet_msg']);
  $info = secure($_POST['info']);
  $owner_name = secure($_POST['owner_name']);
  $phone_number = secure($_POST['phone_number']);
  $reward = secure($_POST['reward']);
  $address = secure($_POST['address']);
  $email = secure($_POST['email']);


  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['save'])) {

      // Prepare the SQL statement with placeholders for the values
      $stmt = $conn->prepare("UPDATE pet_info SET photo=?, pet_name=?,breed=?, age=?,msg=?, 
      more_info=?,owner_name=?, owner_num=?,reward=?, address=?,email=?, wp=?,fb=?, 
      instagram=? WHERE pet_id=?");
      $stmt->bind_param("ssssssssssssssi", $photo, $pet_name, $breed, $age, $pet_msg, $info, 
      $owner_name, $phone_number, $reward, $address, $email, $wp, $fb, $instagram, $get_id);
  
      // Execute the SQL statement
      $stmt->execute();
  
      // Check if the data was updated successfully
      if ($stmt->affected_rows > 0) {
          // echo "Data updated successfully";
      } else {
          // echo "Error updating data: " . $conn->error;
      }
      header('Location: pet.php?id='.$get_id.'&submitted=true');
      // header("Refresh:0");
    }
  }


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="../css/main.css?v=<?php echo time(); ?>" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css?v=<?php echo time(); ?>"
      rel="stylesheet"
      integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
      crossorigin="anonymous"
    />
    

    <!-- font family Montserrat -->
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600&display=swap"
      rel="stylesheet"
    />
    <!-- font family Montserrat -->


    <!-- font awesome -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
    />
    <!-- font awesome -->


  </head>
  <body>




    





    <!-- Modal start for submit -->
    <div
      class="modal fade"
      id="staticBackdrop"
      data-bs-backdrop="static"
      data-bs-keyboard="false"
      tabindex="-1"
      aria-labelledby="staticBackdropLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">
              Congratulations!
            </h1>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            You have successfully added your data.
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-bs-dismiss="modal"
            >
              Close
            </button>
            <button type="button" class="btn btn-primary">Understood</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal end for submit -->




    <!-- header section starts -->

    <nav class="navbar backgroundHeader">
      <div class="container-fluid">
        <a class="navbar-brand" href="../../index.php"><img src="../images/logo_shadow.svg" width="90" alt=""></a>
        
        <?php if ($check_social_media == true) {
          ?>
          <form action="" method="post">
            <input type="submit" name="logout" class="btn" style="background: #f4bb53" value="Log Out">
          </form>
        <?php
        }else{
        ?>
          <a href="../../index.php"><button class="btn" style="background: #f4bb53">Log in</button></a>
        <?php
        }
        ?>

        <!-- <form action="" method="post">
          <input type="submit" name="logout" class="btn" style="background: #f4bb53" value="Log Out">
        </form> -->

      </div>
    </nav>

    <!-- header section ends -->


  <form action="" method="post" enctype="multipart/form-data">


  <!-- modal start for social media links  -->
    
  <?php 
    
    if ($check_social_media == true) {
    ?>
    <div
      class="modal fade"
      id="exampleModal"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Social media contacts</h1>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <!-- <form action="" method="post"> -->
              <div class="mb-3 d-flex">
                <label for="recipient-name" class="col-form-label" style="margin-right: 15px;"
                  ><i class="fa-brands fa-whatsapp"></i
                ></label>
                <div>
                  <p style="margin-bottom: -1rem;">Your Whatsup:</p>
                  <input type="text" name="wp" value="<?= $row['wp']?>" class="form-control" placeholder="+48 123 456 789" id="recipient-name" />
                </div>
              </div>

              <div class="mb-3 d-flex">
                <label for="recipient-name" class="col-form-label" style="margin-right: 15px;"
                  ><i class="fa-brands fa-facebook"></i
                ></label>
                <div>
                  <p style="margin-bottom: -1rem;">Your Facebook Nickname:</p>
                  <input type="text" name="fb" value="<?= $row['fb']?>" class="form-control" placeholder="Type your facebook nickname" id="recipient-name" />              
                </div>
              </div>

              <div class="mb-3 d-flex">
                <label for="recipient-name" class="col-form-label" style="margin-right: 15px;"
                  ><i class="fa-brands fa-instagram"></i
                ></label>
                <div>
                  <p style="margin-bottom: -1rem;">Your Instagram Nickname:</p>
                  <input type="text" name="instagram" value="<?= $row['instagram']?>" class="form-control" placeholder="Type your instagram nickname" id="recipient-name" />            
                </div>
              </div>
            <!-- </form> -->
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-primary"
              data-bs-dismiss="modal"
            >
              Ok
            </button>
            <!-- <button type="button" class="btn btn-primary">Ok</button> -->
          </div>
        </div>
      </div>
    </div>
    <?php
    }
    
    ?>

    <!-- modal end for social media links -->



    <div class="customWrapper">
      <div class="container">


        <!-- section 1 starts -->

        <div class="row justify-content">
          <div class="col-md-6 col-sm-12">
            <div class="title justify-center">
              <div class="fs-2 fw-normal decreaseSizeTitle">
                Pet's Information 
              </div>
              <div class="pawSize">
                <img src="../images/ph_paw-print-fill.svg" alt="pet print" />
              </div>
            </div>

            <div>
              <div>
                <div class="d-flex justify-content-center mb-4">
                  <img
                    <?php 
                      if (empty($row['photo'])) {
                      
                    ?>
                      src="https://mdbootstrap.com/img/Photos/Others/placeholder-avatar.jpg";
                    <?php
                      } else {
                    ?>
                      src="uploads/<?= $row['photo'];?>";
                    <?php
                        // $petimg ="uploads/".$row['photo'];
                      }
                    ?>
                    
                    class="rounded-circle"
                    alt="example placeholder"
                    style="width: 200px; height: 200px;"
                  />
                  <!-- https://mdbootstrap.com/img/Photos/Others/placeholder-avatar.jpg -->
                </div>
                <div class="d-flex justify-content-center">
                
                <!-- <div class="btn btn-danger text-white m-1">Reward $100</div> -->

                <?php 
                  if ($check_social_media == false) {
                ?>
                  <div class="btn btn-warning text-white m-1" style="font-weight: 700;">Reward $<?= $row['reward'];?></div>
                <?php
                  }
                ?>

                <?php 
                  if ($check_social_media == true) {
                ?>
                    <div class="btn btn-primary btn-rounded">
                      <label class="form-label text-white m-1" for="customFile2">Upload photo</label>
                      <!-- <form action="" method="post" enctype="multipart/form-data"> -->
                        <input
                          type="file"
                          name="fileToUpload"
                          class="form-control d-none"
                          id="customFile2"
                        />
                      <!-- </form> -->
                    </div>
                <?php
                  }
                ?>
                
                <!-- <div class="btn btn-primary btn-rounded">
                    <label class="form-label text-white m-1" for="customFile2"
                      >Upload photo</label
                    >
                    <form action="" method="post">
                      <input
                      type="file"
                      name="photo"
                      class="form-control d-none"
                      id="customFile2"
                    />
                    </form>
                  </div> -->
                </div>
              </div>
            </div>

            <!-- <form action="" method="post"> -->
              <div class="inputs">
                  <p style="margin-bottom: -1rem;">Pet's Name:</p>
                  <input
                  type="text"
                  name="pet_name"
                  value="<?= $row['pet_name']?>"
                  class="form-control"
                  aria-label="First name"
                  <?php echo $disabled;?>
                />
                <p style="margin-bottom: -1rem;">Pet's Breed:</p>
                <input
                  type="text"
                  name="breed"
                  value="<?= $row['breed']?>"
                  class="form-control"
                  aria-label="First name"
                  <?php echo $disabled;?>
                />
                <p style="margin-bottom: -1rem;">Age:</p>
                <input
                  type="text"
                  name="age"
                  value="<?= $row['age']?>"
                  class="form-control"
                  aria-label="First name"
                  <?php echo $disabled;?>
                />
                
              </div>

              <!-- <div class="genders">
                <div class="gender male active">
                  <i class="fas fa-mars"></i>
                </div>
                <div class="gender female active">
                  <i class="fas fa-venus"></i>
                </div>
              </div> -->

            
              <p >Pet's Message:</p>
              <select
                name="pet_msg"
                value="<?= $row['msg']?>"
                class="form-select form-control"
                style="margin-top: 10px"
                aria-label="Default select example"
                <?php echo $disabled;?>
              >
                <option value="Please, help me to get home">Please, help me to get home</option>
                <option value="I'm scared, please call to my parents">I'm scared, please call to my parents</option>
                <option value="I'm starving, please take me home">I'm starving, please take me home</option>
              </select>
              
              <div>
                <p style="margin-bottom: -1rem;">Additional Information:</p>
                <div class="input-group" style="margin-top: 10px">
                  <textarea
                    name="info"
                    class="form-control"
                    aria-label="With textarea"
                    <?php echo $disabled;?>
                  ><?= $row['more_info']?></textarea>
                </div>
              </div>
              
            <!-- </form> -->
          </div>


          <!-- banner -->
          <div class="col-md-5 .offset-md-1 custom-class">
            <img src="../images/pet banner smallsized.svg" alt="as" />
          </div>
          <!-- banner -->


        </div>

        <!-- section 1 ends -->
















        <!-- section 2 starts -->

        <div class="row justify-content">
          <div class="col-md-6 col-sm-12">
            <div class="title justify-center">
              <div class="fs-2 fw-normal decreaseSizeTitle">
                Owner's Information
              </div>
              <div class="pawSize">
                <img src="../images/foot print.svg" alt="pet print" />
              </div>
            </div>


            <div class="inputs">
              <p style="margin-bottom: -1rem;">Name:</p>
              <!-- <form action="" method="post"> -->
                <input
                  type="text"
                  name="owner_name"
                  value="<?= $row['owner_name']?>"
                  class="form-control"
                  aria-label="First name"
                  <?php echo $disabled;?>
                />
                <p style="margin-bottom: -1rem;">Phone Number:</p>
                <input
                  type="text"
                  name="phone_number"
                  value="<?= $row['owner_num']?>"
                  class="form-control"
                  aria-label="First name"
                  <?php echo $disabled;?>
                />

                <?php 
                  if ($check_social_media == true) {
                ?>
                  <p style="margin-bottom: -1rem;">Reward (How much are you ready to pay?):</p>
                  <input
                    type="text"
                    name="reward"
                    value="<?= $row['reward']?>"
                    class="form-control"
                    aria-label="First name"/>
                <?php
                  }
                ?>
                <!-- <input
                  type="text"
                  name="reward"
                  class="form-control"
                  placeholder="Reward (How much are you ready to pay?)"
                  aria-label="First name"
                /> -->
                <p style="margin-bottom: -1rem;">Address:</p>
                <input
                  type="text"
                  name="address"
                  value="<?= $row['address']?>"
                  class="form-control"
                  aria-label="First name"
                  <?php echo $disabled;?>
                />
                <p style="margin-bottom: -1rem;">E-mail:</p>
                <input
                  type="text"
                  name="email"
                  value="<?= $row['email']?>"
                  class="form-control"
                  aria-label="First name"
                  <?php echo $disabled;?>
                />
              <!-- </form> -->

              <div class="fs-3 fw-normal">Social media contacts</div>
            </div>

            <div class="socialMeadia">
              <?php 
                if ($check_social_media == true) {
              ?>
                  <i
                  class="fa-brands fa-whatsapp"
                  data-bs-toggle="modal"
                  data-bs-target="#exampleModal"
                  data-bs-whatever="@mdo"
                ></i>
                <i
                  class="fa-brands fa-facebook"
                  data-bs-toggle="modal"
                  data-bs-target="#exampleModal"
                  data-bs-whatever="@mdo"
                ></i>
                <i
                  class="fa-brands fa-instagram"
                  data-bs-toggle="modal"
                  data-bs-target="#exampleModal"
                  data-bs-whatever="@mdo"
                >
                </i>
              <?php
                }else{
              ?>
              <a href="https://wa.me/<?= $row['wp']?>" class="fa-brands fa-whatsapp" style="text-decoration: none; color: black;"></a>
              <a href="https://www.facebook.com/<?= $row['fb']?>" class="fa-brands fa-facebook" style="text-decoration: none; color: black;"></a>
              <a href="https://www.instagram.com/<?= $row['instagram']?>/" class="fa-brands fa-instagram" style="text-decoration: none; color: black;"></a>
              
              <?php
                }
              ?>
              
            </div>

            <?php 
              if ($check_social_media == true) {
            ?>
              <!-- <form action="" method="post"> -->
                <input type="submit" 
                class="btn btn-warning"
                style="margin-bottom: 50px; margin-top: 25px;" 
                name="save" 
                value="Save">
              <!-- </form> -->
            <?php
              }
            ?>

            <!-- <button
              type="button"
              class="btn btn-warning"
              data-bs-toggle="modal"
              data-bs-target="#staticBackdrop"
              style="margin-bottom: 50px; margin-top: 25px;"
            >
              Save
            </button> -->
          </div>


          <!-- banner -->
          <div class="col-md-5 .offset-md-1 custom-class">
            <img src="../images/pet owner banner  smallsized.svg" alt="as" />
          </div>
          <!-- banner -->

        </div>

        <!-- section 2 ends -->



      </div>
    </div>
  </form>
</body>

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <!-- bootstrap script -->
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
    crossorigin="anonymous"
  ></script>
  <!-- bootstrap script -->



  <!-- fontawesome script -->
  <script
    src="https://kit.fontawesome.com/571327e52c.js"
    crossorigin="anonymous"
  ></script>
  <!-- fontawesome script -->


  <!-- javaScript -->
  <script>

  <?php if (isset($_GET['submitted']) && $_GET['submitted'] === 'true'): ?>
    
      // Wait for the page to finish loading
      window.addEventListener('load', function() {
        // Open the modal window
        $('#staticBackdrop').modal('show');
      });
  <?php endif; ?>
      // // Wait for the page to finish loading
      // window.addEventListener('load', function() {
      //   // Open the modal window
      //   $('#staticBackdrop').modal('show');
      // });

    // function setDefaultFile(){
    //   const input = document.querySelector('#customFile2');
    //   input.click();
    //   input.value = 'uploads/<?= $row['photo']?>';
    // }

      // const male = document.querySelector('.male');
      // const female = document.querySelector('.female');

      // male.addEventListener('click', (e) => {
      //   male.classList.add('male-color');
      //   female.classList.remove('female-color');
      // });
      
      // female.addEventListener('click', () => {
      //   female.classList.add('female-color');
      //   male.classList.remove('male-color');
      // });
    
  </script>
  <!-- javaScript -->
</html>

<?php
include_once ("updateSaveCateg.php");
session_start();
include_once("../check_login.php");
if($_SESSION['signed_in']==true){
if (
    (!isset($_COOKIE['isOwner']) || $_COOKIE['isOwner'] == "false") &&
    (!isset($_COOKIE['isAdmin']) || $_COOKIE['isAdmin'] == "false")
)
    header("location:../index.php");
}
else header("Location:../index.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" type="image/x-icon" href="../logos/primary_icon.jpeg" /> <!-- modified -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Update Category</title>
</head>

<body>
    <!-- -------------------------------------------------------------------------------------------------------------------------- -->
    <header>
        <nav class="nav-container">
            <div class='left-nav'>
                <div>
                    <a href="../index.php"><img src="../logos/primary_logo.png" alt="logo" width='220rem'
                            height='90rem'></a>
                </div>
            </div>

            <?php
            include_once ("../check_login.php");
            // if ($isAdmin == true)
            //     header("Location:admin.php");
            if ($isClient == true)
                header("Location:../index.php");

            if ($_SESSION['signed_in'] == true /*&& $isClient==true*/) {
                if ($isClient == true) {
                    $client = $dbHelper->getClientByToken($_COOKIE['token']);
                    if($client==null){
                        header("Location:../sign_out.php?isClient=1");
                    }
                    echo '<div><li>Hello ' . $client->getFirstName() . '<br>Points:  ' . $client->getPoints() . '</li>';
                    echo '<li><a href="../manageAccount.php?user=client">Account</a>/<a href="../sign_out.php?isClient=1">Sign Out</a></li>';
                    echo '<li><a href="#about">About</a></li>';
                    echo '<li><a href="../cart.php">Cart</a></li></div>';
                } else if ($isAdmin == true) {
                    $admin = $dbHelper->getAdminByToken($_COOKIE['token']);
                    if($admin==null){
                        header("Location:../sign_out.php?isAdmin=1");
                    }
                    echo '<div class="center-nav"><div><h1>Category Administration</h1></div></div>
                    <div class="right-nav"><div><h3>Admin : ' . $admin->getFirstName() . ' </h3></div>';
                    // echo '<div><a href="../manageAccount.php?user=admin"><i class="bi bi-person-fill-gear"></i></a></div>
                    // <div><a href="../sign_out.php?isAdmin=1"><i class="bi bi-box-arrow-right"></i></a></div></div>';
                    //echo '<p><a href="#about">About</a></p></div>';
                    // Account
                    // Sign Out

                    
                    echo '<div class="account-select">
                    <i class="bi bi-person-fill-gear"></i>
                    <select id="accountSelect" onchange="goToPage(this.value)">
                        <option disabled selected>--choose--</option>
                        <option value="../manageAccount.php?forward=updateProfile">Update Profile</option>
                        <option value="../manageAccount.php?forward=changePassword">Change Password</option>
                        <option value="delete">Delete Account</option>
                    </select></div>';
                    echo '<div><a href="../sign_out.php?isAdmin=1"><i class="bi bi-box-arrow-right"></i> </a></div></div>';
                } else if ($isOwner == true) {
                    echo '<div class="center-nav"><div><h1>Category Administration</h1></div></div>
                        <div class="right-nav"><div><h3>Owner : ' . OWNER_NAME . ' </h3></div>';
                    echo '<div><p><a href="../sign_out.php?isOwner=1">
                    <i class="bi bi-box-arrow-right"></i> Sign Out</a></p></div></div>';
                }
            } else {
                echo '<p><a href="../sign_in.php">Sign in</a>/<a href="../createAccount.php">Create account</a></p>';
            }
            ?>
            <!-- <li><a href="#about">About</a></li>
                <li><a href="cart.php">Cart</a></li> -->
            </div>
        </nav>
    </header>
    <!-- -------------------------------------------------------------------------------------------------------------------------- -->
    <?php
    if (isset($_GET['id']) || isset($_POST['submit'])) {
        if (isset($_GET['id'])) { //case main page --> update category
            $cat = $dbHelper->getCategoryById(htmlspecialchars($_GET['id']));
        } else { //case update category --> fail update
            $cat = $dbHelper->getCategoryById(htmlspecialchars($_POST['category']));
        }
        if (!empty($cat)) {
            $id = $cat->getCategoryId();
            $name = $cat->getName();
            if ($error == 0) {
                $name = htmlspecialchars($_POST['name']);
            }
            echo "<div class='add-container'><br><br>";
            if (isset($message))
                echo "
        <div class='error-container'>" . $message . " </div>
        ";
            // echo "<form action='updateCategory.php' method='POST'>
            //          <table>
            //            <tr>
            //             <td>Category ID</td>
            //             <td><input type='text' disabled name='id' class='add-input' value='" . $id . "'></td> 
            //            </tr>
            //            <tr>
            //             <td>Category Name</td>
            //             <td><input type='text' name='name' class='add-input' required value='" . $name . "'></td>
            //            </tr>
            //         </table>
            //        <input type='hidden' name='category' class='search-button' value='" . $id . "'>
            //       <br>
            //        <input type='submit' name='submit' class='search-button' value='Update Category'>
            //       <button class='search-button'><a href='manageCategories.php'>Back</a></button>
            //        </form>
            //     </div>";

            echo "<form action='updateCategory.php' method='POST'>
            <table>
              <tr>
               <td>Category ID</td>
               <td><input type='text' disabled name='id' class='add-input' value='" . $id . "'></td> 
              </tr>
              <tr>
               <td>Category Name</td>
               <td><input type='text' name='name' class='add-input' required value='" . $name . "'></td>
              </tr>
           </table>
          <input type='hidden' name='category' class='search-button' value='" . $id . "'>
         <br>
          <input type='submit' name='submit' class='search-button' value='Update Category'>
          </form>
          <br><button class='text-button'><a href='manageCategories.php'>Back</a></button>
       </div>";
        }
    }
    ?>
    <div class="popup-overlay" id="popup-overlay" style="display:none;">
            <div class="popup-content" id="popup-content">
                <h2>Are you sure you want to delete this account?</h2>
                <button class='add-button' onclick="deleteAccount()">Yes</button>
                <button class='add-button' onclick="closePopUp()">No</button>
            </div>
        </div>
    
  <script type="text/javascript" src="script.js"></script>
    <footer>
        <!-- common footer -->
    </footer>
</body>

</html>
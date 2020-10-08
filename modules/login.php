<?php
if(isset($_COOKIE['EMAIL']) && isset($_COOKIE['PASSWORD'])) {
    $_GET['action'] = "login";
}
if (isset($_GET['action'])){
    if ($_GET['action'] == "login") {
        if(isset($_COOKIE['EMAIL']) && isset($_COOKIE['PASSWORD'])) {
            $email = $_COOKIE['EMAIL'];
            $decodedpw = substr_replace($_COOKIE['PASSWORD'], "", 6, 1);
            $decodedpw = substr_replace($decodedpw, "", 4, 1);
            $decodedpw = substr_replace($decodedpw, "", 2, 1);
            $decodedpw = base64_decode($decodedpw);
            $password = $decodedpw;
        } else {
            $email = strtolower($_POST['email']);
            $password = $_POST['password'];
        }
        $query = mysqli_query($mysqli, "SELECT * FROM users JOIN permissions_roles ON users.ROLE = permissions_roles.ROLEID WHERE LOWER(EMAIL) = '" . $email . "'");

        if ($query->num_rows > 0) {
            while ($row = $query->fetch_assoc()) {
                $hashed_password = $row['PASSWORD'];
                $uid = $row['USERID'];
                $uname = $row['USERNAME'];
                $uphoto = $row['USERPHOTO'];
                $role = $row['ROLE'];
                $rolename = $row['ROLENAME'];
                $firstname = $row['FIRSTNAME'];
                $lastname = $row['LASTNAME'];
            }
            if(password_verify($password, $hashed_password)) {
                $_SESSION['USERID'] = $uid;
                $_SESSION['USERNAME'] = $uname;
                $_SESSION['USERPHOTO'] = $uphoto;
                $_SESSION['ROLE'] = $role;
                $_SESSION['ROLENAME'] = $rolename;
                $_SESSION['FIRSTNAME'] = $firstname;
                $_SESSION['LASTNAME'] = $lastname;
                $query2 = mysqli_query($mysqli, "SELECT * FROM permissions_access LEFT JOIN sections ON permissions_access.SECTIONID = sections.IDSECTION WHERE ROLEID = " . $role);
                while ($row2 = $query2->fetch_assoc()) {
                    $_SESSION['ACCESS'][$row2['SECTIONNAME']] = '1';
                }
                if ($_POST['setcookie'] == "on") {
                    $encodedpw = str_replace("=", "", base64_encode($password));
                    $encodedpw = substr_replace($encodedpw, "M", 2, 0);
                    $encodedpw = substr_replace($encodedpw, "W", 4, 0);
                    $encodedpw = substr_replace($encodedpw, "V", 6, 0);
                    setcookie("EMAIL", $email, time() + (86400 * 30), "/"); // 86400 = 1 day
                    setcookie("PASSWORD", $encodedpw, time() + (86400 * 30), "/"); // 86400 = 1 day
                }
                mysqli_query($mysqli, "UPDATE users SET LASTLOGIN = NOW() WHERE USERID = " . $uid);

                header("Location: ?");
                die();
            } else {
                $message = "Login failed, password incorrect";
                if(isset($_COOKIE['EMAIL']) && isset($_COOKIE['PASSWORD'])) {
                    header("Location: ?logout=true");
                    die();
                }
            }
        } else {
            $message = "Login failed, E-Mail not found";
            if(isset($_COOKIE['EMAIL']) && isset($_COOKIE['PASSWORD'])) {
                header("Location: ?logout=true");
                die();
            }
        }
    }
}
if (!isset($message)) {
    $message = "";
}
include('modules/header.php');
?>

<div class="account-pages mt-5 mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card">

                    <div class="card-body p-4">

                        <div class="text-center w-75 m-auto">
                            <p class="text-muted mb-4 mt-3"><h3><?php echo $message; ?></h3><br>Enter your email address and password to access admin panel.</p>
                        </div>

                        <form action="?action=login&login=true" method="POST">
                            <div class="form-group mb-3">
                                <label for="emailaddress">Email address</label>
                                <input class="form-control" type="email" id="emailaddress" name="email" required="" placeholder="Enter your email">
                            </div>
                            <div class="form-group mb-3">
                                <label for="password">Password</label>
                                <input class="form-control" type="password" required="" id="password" name="password" placeholder="Enter your password">
                            </div>
                            <div class="form-group mb-3">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="setcookie" id="checkbox-signin" checked>
                                    <label class="custom-control-label" for="checkbox-signin">Remember me</label>
                                </div>
                            </div>
                            <div class="form-group mb-0 text-center">
                                <button class="btn btn-primary btn-block" type="submit"> Log In </button>
                            </div>
                        </form>

                    </div> <!-- end card-body -->
                </div>
                <!-- end card -->

                <div class="row mt-3">
                    <div class="col-12 text-center">
                        <p> <a href="?" class="text-muted ml-1">Forgot your password?</a></p>
                    </div> <!-- end col -->
                </div>
                <!-- end row -->

            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!-- end page -->


<!-- Vendor js -->
<script src="assets/js/vendor.min.js"></script>

<!-- App js -->
<script src="assets/js/app.min.js"></script>

</body>
</html>

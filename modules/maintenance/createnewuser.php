<?php
include ('../sql.php');
if (isset($_GET['action'])) {
    $query = mysqli_query($mysqli, "INSERT INTO users (EMAIL, PASSWORD, USERNAME, ROLE) VALUES ('" . $_POST['email'] . "', '" . password_hash($_POST['password'], PASSWORD_DEFAULT) . "', '" . $_POST['username'] . "', '" . $_POST['role'] . "')");
    echo "INSERT INTO users (EMAIL, PASSWORD, USERNAME, ROLE) VALUES ('" . $_POST['email'] . "', '" . password_hash($_POST['password'], PASSWORD_DEFAULT) . "', '" . $_POST['username'] . "', '" . $_POST['role'] . "')";
}
echo '<form method="POST" action="?action=submit">
Email <input type="text" name="email"><br>
Password <input type="text" name="password"><br>
Username <input type="text" name="username"><br>
Role <input type="text" name="role"><br>
<input type="submit" value="Submit">
</form>
';
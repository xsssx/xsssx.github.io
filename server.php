<?php
session_start();

$configs = include('config.php');
$conn = mysqli_connect($host, $dbuser, $password, $dbname);
$errors = array();
$user = "";
$name = "";
$surname = "";

if (isset($_POST['register_user'])) {
    // receive all input values from the form
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $surname = mysqli_real_escape_string($conn, $_POST['surname']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $passwordcheck = mysqli_real_escape_string($conn, $_POST['passwordcheck']);

    if (empty($user)) {
        array_push($errors, "Nezadali ste prihlasovacie meno!<br>");
    }
    if (empty($email)) {
        array_push($errors, "Nezadali ste email!<br>");
    }
    if (empty($name)) {
        array_push($errors, "Nezadali ste krstné meno!<br>");
    }
    if (empty($surname)) {
        array_push($errors, "Nezadali ste priezvisko!<br>");
    }
    if (empty($password)) {
        array_push($errors, "Nezadali ste heslo!<br>");
    }
    if ($password != $passwordcheck) {
        array_push($errors, "Heslá sa nezhodujú!<br>");
    }

    $user_check_query = "SELECT * FROM user WHERE username='$user' LIMIT 1";
    $result = mysqli_query($conn, $user_check_query);
    $user_check = mysqli_fetch_assoc($result);

    if ($user_check) {
        if ($user_check['username'] === $user) {
            array_push($errors, "Prihlasovacie meno je obsadené!<br>");
        }
    }

    if (count($errors) == 0) {
        $datetime = date('Y-m-d H:i:s');
        $password = md5($password);
        $sql = "INSERT INTO `user`(`name`, `surname`, `password`, `username`, `registered`)
          VALUES ('$name', '$surname', '$password', '$user', '$datetime');";
        mysqli_query($conn, $sql);
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are now logged in";
        header('location: index.php');
    }
}
if (isset($_POST['login_user'])) {
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if (empty($user)) {
        array_push($errors, "Nezadali ste prihlasovacie meno!<br>");
    }
    if (empty($password)) {
        array_push($errors, "Nezadali ste prihlasovacie heslo!<br>");
    }

    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM user WHERE username='$user'";
        $result = mysqli_query($conn, $query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row['password'] == $password) {
                $_SESSION['username'] = $user;
                $_SESSION['success'] = "You are now logged in";
                $datetime = date('Y-m-d H:i:s');
                $id = $row['id'];
                $type = 1;
                $sql = "INSERT INTO `logged`(`datetime`, `type`, `user_id`) VALUES ('$datetime', '$type', '$id');";
                if ($conn->query($sql) != TRUE)
                    echo "Error: " . $conn->error;
                header('location: index.php');
            } else array_push($errors, "Prihlasovacie meno alebo heslo je nesprávne!<br>");
        } else {
            array_push($errors, "Prihlasovacie meno alebo heslo je nesprávne!<br>");
        }
    }
}

if (isset($_POST['ais'])) {
    $user = $_POST['username'];
    $password = $_POST['password'];

    if (empty($user)) {
        array_push($errors, "Nezadali ste prihlasovacie meno!<br>");
    }
    if (empty($password)) {
        array_push($errors, "Nezadali ste prihlasovacie heslo!<br>");
    }

    if (count($errors) == 0) {
        $dn = 'ou=People, DC=stuba, DC=sk';
        $ldaprdn = "uid=" . $user . "," . $dn;

        $ldaphost = "ldap.stuba.sk";
        $ldapconn = ldap_connect($ldaphost)
        or die("Could not connect.");

        if ($ldapconn) {
            ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);

            if (ldap_bind($ldapconn, $ldaprdn, $password)) {
                $results = ldap_search($ldapconn, $dn, "uid=" . $user, array("givenname", "employeetype", "surname", "mail", "faculty", "cn", "uisid", "uid"));
                $info = ldap_get_entries($ldapconn, $results);
                $ais_uid = $info[0]['uid'][0];
                $query = "SELECT * FROM user WHERE username='$ais_uid'";
                $result = mysqli_query($conn, $query);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $_SESSION['username'] = $ais_uid;
                    $_SESSION['success'] = "You are now logged in";
                    $datetime = date('Y-m-d H:i:s');
                    $id = $row['id'];
                    $type = 3;
                    $sql = "INSERT INTO `logged`(`datetime`, `type`, `user_id`) VALUES ('$datetime', '$type', '$id');";
                    if ($conn->query($sql) != TRUE)
                        echo "Error: " . $conn->error;
                    header('location: index.php');
                }
                else {
                    $datetime = date('Y-m-d H:i:s');
                    $password = md5($password);
                    $name = $info[0]['givenname'][0];
                    $surname = $info[0]['sn'][0];
                    $sql = "INSERT INTO `user`(`name`, `surname`, `password`, `username`, `registered`)
                            VALUES ('$name', '$surname', '$password', '$user', '$datetime');";
                    mysqli_query($conn, $sql);
                    $_SESSION['username'] = $user;
                    $_SESSION['success'] = "You are now logged in";
                    header('location: index.php');
                }
            } else echo "Fail";
        }
    }
}

?>

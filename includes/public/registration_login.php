<?php
// variable declaration
$username = "";
$email = "";
$errors = array();

// LOG USER IN
if (isset($_POST['login_btn'])) {
    $username = esc($_POST['username']);
    $password = esc($_POST['password']);

    if (empty($username)) {
        array_push($errors, "Username required");
    }

    if (empty($password)) {
        array_push($errors, "Password required");
    }

    if (empty($errors)) {
        $password = md5($password); // encrypt password
        $sql = "SELECT * FROM users WHERE username='$username' and password='$password' LIMIT 1";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            // get id of created user
            $reg_user_id = mysqli_fetch_assoc($result)['id'];
            //var_dump(getUserById($reg_user_id)); die();
            // put logged in user into session array
            $_SESSION['user'] = getUserById($reg_user_id);

            // if user is admin, redirect to admin area
            if (in_array($_SESSION['user']['role'], ["Admin"])) {
                $_SESSION['message'] = "You are now logged in";
                // redirect to admin area
                header('location: ' . BASE_URL . '/admin/dashboard.php');
                exit(0);
            } else {
                $_SESSION['message'] = "You are now logged in";
                // redirect to public area
                header('location: index.php');
                exit(0);
            }
        } else {
            array_push($errors, 'Wrong credentials');
        }
    }
}

if(isset($_POST['reg_btn'])){
    $username = esc($_POST['username']);
    $email = esc($_POST['email']);
    $password = esc($_POST['password_reg']);
    $passwordConf = esc($_POST['passwordConf']);

    if(empty($username)){
        array_push($errors, "Username required");
    }
    if(empty($email)){
        array_push($errors, "Email required");
    }
    if(empty($password)){
        array_push($errors, "Password required");
    }
    if($password !== $passwordConf){
        array_push($errors, "The two passwords do not match");
    }   
    if(empty($errors)){
        $sql = "SELECT * FROM users WHERE username='$username' AND email='$email' LIMIT 1";
        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_assoc($result);
        if($user) {
            if ($user['username'] === $username) {
                array_push($errors, "Username already exists");
            }
            if ($user['email'] === $email) {
                array_push($errors, "Email already exists");
            }
        }
       else{
        $password = md5($password); //encrypt password
        $sql = "INSERT INTO users (username, email,role, password,created_at , updated_at) VALUES('$username', '$email','Author', '$password', now(), now())";
        mysqli_query($conn, $sql);
        
        $_SESSION['user']=getUserById(mysqli_insert_id($conn)); // put logged in user into session array
        if(in_array($_SESSION['user']['role'], ["Author"])){
            $_SESSION['message'] = "vous êtes inscrit!";
            // redirect to users area
            header('location: index.php');
            exit(0);
        }
        if(in_array($_SESSION['user']['role'] ,["Admin"]))
        {
            $_SESSION['message'] = "vous êtes inscrit!";
            // redirect to admin area
            header('location: ' . BASE_URL . '/admin/dashboard.php');
            exit(0);
        }
    }      
}
}

function esc(String $value) 
{ 
    //à compléter ultérieurement 
    $val = trim($value); // remove empty space sorrounding string 
    return $val; 
} 

function getUserById($id)
{
 global $conn; //rendre disponible, à cette fonction, la variable de connexion $conn
 $sql ="SELECT u.username ,u.role FROM users as u WHERE u.id='$id' LIMIT 1"; // requête qui récupère le user et son rôle
 $result = mysqli_query($conn, $sql); 
 $user =  mysqli_fetch_assoc($result);  // transforme le résultat de la requête en tableau associatif
 return $user;
}
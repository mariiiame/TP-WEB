<?php
// Admin user variables
$admin_id = 0;
$isEditingUser = false;
$username = "";
$email = "";
// Topics variables
$topic_id = 0;
$isEditingTopic = false;
$topic_name = "";
// general variables
$errors = [];
/* - - - - - - - - - -
- Admin users actions
- - - - - - - - - - -*/
// if user clicks the create admin button
if (isset($_POST['create_admin'])) {
    createAdmin($_POST);
}

if (isset($_POST['update_admin'])) {
    updateAdmin($_POST);
}
 

if (!empty($_GET["edit-admin"])) {
    $admin_id = $_GET["edit-admin"];
    $isEditingUser = true;

    $sql = "SELECT * FROM users WHERE id=$admin_id LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $user= mysqli_fetch_assoc($result);
    $username = $user['username'];
    $email = $user['email'];
    
} 


function getAdminUsers(){
    global $conn, $roles;
     $sql = "SELECT * FROM users  ";
    $result = mysqli_query($conn, $sql);
    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $users;
    }

    function getAdminRoles(){
        global $conn;
       $sql2 = "SELECT * FROM roles";
        $result = mysqli_query($conn, $sql2);
        $roles = mysqli_fetch_all($result, MYSQLI_ASSOC);
     
        return $roles;
        }

 function createAdmin($request_values){
            global $conn, $errors, $username, $email;
            $username = esc($request_values['username']);
            $email = esc($request_values['email']);
            $password = esc($request_values['password']);
            $passwordConfirmation = esc($request_values['passwordConfirmation']);
            $role = esc($request_values['role_id']);

            // form validation: ensure that the form is correctly filled
            if (empty($username)) { array_push($errors, "Uhmm... We gonna need the username"); }
            if (empty($email)) { array_push($errors, "Oops.. Email is missing"); }
            if (empty($password)) { array_push($errors, "uh-oh you forgot the password"); }
            if ($password != $passwordConfirmation) { array_push($errors, "The two passwords do not match"); }
            if (empty($role)) { array_push($errors, "Role is required for admin users"); }

            // Ensure that no user is registered twice.
            $user_check_query = "SELECT * FROM users WHERE username='$username' 
                                OR email='$email' LIMIT 1"; 
            $result = mysqli_query($conn, $user_check_query);
            $user = mysqli_fetch_assoc($result);
            if ($user) { // if user exists
                if ($user['username'] === $username) {
                  array_push($errors, "Username already exists");
                }
                if ($user['email'] === $email) {
                  array_push($errors, "Email already exists");
                }
            }
            // register user if there are no errors in the form
            if (count($errors) == 0) {
                $password = md5($password);//encrypt the password before saving in the database
                //encrypt the password before saving in the database
                $query = "INSERT INTO users (username, email, role, password, created_at, updated_at) VALUES ('$username', '$email', '$role', '$password', now(), now())";
                mysqli_query($conn, $query);
            
            $_SESSION['message'] = "Admin user created successfully";
            header('location: users.php');
            exit(0);
           }
           //return all admin users and their roles
        }

        
        

function updateAdmin($request_values){
    var_dump($request_values);
    global $conn, $errors, $username, $isEditingUser, $admin_id, $email;
    $username = esc($request_values['username']);
    $email = esc($request_values['email']);
    $admin_id = esc($request_values['admin_id']);
    if(empty($username)){array_push($errors,"Username is requested");}
    if(empty($email)){array_push($errors,"email is requested");}
    
    
    if(count($errors)==0){
        $sql = "UPDATE users SET username='$username', email='$email' WHERE id=$admin_id";
        mysqli_query($conn, $sql);
        $_SESSION['message'] = "Admin user updated successfully";
        header('location: users.php');
        exit(0);
    }
    
}
  
if (isset($_GET['delete-admin'])) {
    $admin_id = $_GET['delete-admin'];
    deleteAdmin($admin_id);
}


function deleteAdmin($admin_id){
    global $conn;
    $sql = "DELETE FROM users WHERE id=$admin_id";
    if (mysqli_query($conn, $sql)) {
        $_SESSION["message"]="Utilisateur administrateur supprimé avec succès";
        return "Utilisateur supprimé avec succès";
    } else {
        return "Erreur lors de la suppression de l'utilisateur administrateur";
    }
}
    
function esc(String $value) 
{ 
    //à compléter ultérieurement 
    $val = trim($value); // remove empty space sorrounding string 
    return $val; 
} 
           ?>
        
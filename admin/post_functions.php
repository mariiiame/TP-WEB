
<?php

// Définition des variables relatives aux articles
$post_id = 0;
$isEditingPost = false;
$published = 0;
$title = "";
$post_slug = "";
$body = "";
$featured_image = "";
$post_topic = "";

// Fonctions liées aux articles

/**
 * Récupère tous les articles de la base de données
 *
 * @return array Tableau contenant tous les articles
 */
function getAllPosts() {
    global $conn;
    $sql = "SELECT p.*, u.username as author FROM posts p JOIN users u ON p.user_id = u.id";
    $result = mysqli_query($conn, $sql);
    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
    
    return $posts;
}

function createPost($request_values) {}

function getPostAuthorById($user_id){
    global $conn;
    
    $sql = "SELECT username FROM users WHERE id=$user_id";
    $result = mysqli_query($conn, $sql);
    
    if ($result) {
        // return username
        return mysqli_fetch_assoc($result)['username'];
    } else {
        return null;
    }
}

function editPost($post_id) {
    global $conn, $title, $post_slug, $body, $isEditingPost, $post_id;
    
}

function updatePost($request_values){
    global $conn, $errors, $post_id, $title, $featured_image, $topic_id, $body, $published;
}

function deletePost($post_id){
    global $conn;
    
    $sql = "DELETE FROM posts WHERE id=$post_id";
    
    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = "Article supprimé avec succès";
        header("location: posts.php");
        exit(0);
    }
}

function togglePublishPost($post_id, $message){
    global $conn;
    
    $sql = "UPDATE posts SET published=!published WHERE id=$post_id";
    
    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = $message;
        header("location: posts.php");
        exit(0);
    }
}

?>

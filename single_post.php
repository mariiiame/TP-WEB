<?php
include('config.php');
include(ROOT_PATH . '/includes/public/head_section.php');
include(ROOT_PATH . '/includes/public/navbar.php');

if (isset($_GET['post-slug'])) {
    $slug = $_GET['post-slug'];
    include(ROOT_PATH . '/includes/all_functions.php');
    $post = getPost($slug);
    
    if ($post) {
        echo "<title>" . $post['title'] . " | MyWebSite</title>";
?>
    <div class="container">
        <div class="content">
            <div class="post-wrapper">
                <div class="full-post-div">
                    <h2 class="post-title"><?php echo $post['title']; ?></h2>
                    <div class="post-body-div">
                        <?php echo $post['body']; ?>
                    </div>
                </div>
            </div>
            <div class="post-sidebar">
                <div class="card">
                    <div class="card-header">
                        <h2>Topics</h2>
                    </div>
                    <div class="card-content">
                        <?php 
                            $topics = getAllTopics();
                        ?>
                        <?php foreach ($topics as $topic): ?>
                            <a href="filtered_posts.php?topic=<?php echo $topic['id']; ?>"><?php echo $topic['name']; ?></a><br>
                        <?php endforeach; ?>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
    } else {
        // Afficher un message si l'article n'est pas trouvé
        echo "<div class='container'>L'article demandé n'existe pas.</div>";
    }
} else {
    // Rediriger si le paramètre "post-slug" est manquant
    header("Location: index.php");
    exit();
}
// Inclure le footer
include(ROOT_PATH . '/includes/public/footer.php');
?>


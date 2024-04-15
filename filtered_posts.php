<?php
include('config.php');
include('includes/all_functions.php');

if (isset($_GET['topic'])) {
    $topic_id = $_GET['topic'];
    $posts = getPublishedPostsByTopic($topic_id);
    include('includes/public/head_section.php');
    include('includes/public/navbar.php');
?>
    <!-- Contenu de la page -->
    <div class="container">
        <h2>Articles pour ce sujet</h2>
        <div class="content">
            <!-- Boucle pour afficher les articles -->
            <?php foreach ($posts as $post): ?>
                <div class="post">
                    <h2 class="post-title"><?php echo $post['title']; ?></h2>
                    <p class="post-content"><?php echo $post['content']; ?></p>
                    <!-- Lien vers l'article complet -->
                    <a href="single_post.php?post-slug=<?php echo $post['slug']; ?>" class="read-more">Lire l'article complet</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

<?php
    // Inclure le pied de page
    include('includes/public/footer.php');
} else {
    // Rediriger si le paramètre topic est manquant
    header("Location: index.php");
    exit();
}
?>


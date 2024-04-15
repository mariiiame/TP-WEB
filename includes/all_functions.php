 
<?php

function getPublishedPosts() {
    global $conn;
    $sql = "SELECT * FROM posts WHERE published=true"; 
    $result = mysqli_query($conn, $sql);
    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

    foreach ($posts as &$post) {
        $post_id = $post['id'];
        $topic = getPostTopic($post_id);
        $post['topic'] = $topic;
    }

    return $posts;
}

function getPostTopic($post_id) {
    global $conn;
    $query = "SELECT topics.name FROM topics JOIN post_topic ON topics.id = post_topic.topic_id WHERE post_topic.post_id = $post_id";
    $result = mysqli_query($conn, $query);
    $topics = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $topics[] = $row['name'];
    }
  
    return $topics;
}


function DisplayPosts($posts) {
    foreach ($posts as $post): ?>
    <div class="content">
        <div class="post">
            <div class="post_info">
                    <?php
                    $topics = $post['topic'];
                    foreach ($topics as $topic) {
                        echo "<span  >" . $topic . "</span>";
                    }
                    ?>
            </div>
            <img src="<?php echo $post['image']; ?>" class="post_image" alt="Post Image">
            <h3 class="post_info"><?php echo $post['title']; ?></h3>
            <p class="post_info"><?php echo $post['updated_at']; ?></p>
            <span class='read_more'>
           <a href="single_post.php?post-slug=<?php echo $post['slug']; ?>"  >Read more</a>
            </span>
        </div>
    <?php endforeach;
}

function getPost($slug)
{
    global $conn;
    $query = "SELECT * FROM posts WHERE slug='$slug' AND published=1";
    $result = mysqli_query($conn, $query);
    $post = mysqli_fetch_assoc($result);
    return $post;
}

// Fonction pour récupérer tous les topics depuis la base de données
function getAllTopics()
{
    global $conn;
    $query = "SELECT * FROM topics";
    $result = mysqli_query($conn, $query);
    $topics = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $topics;
}
function getPublishedPostsByTopic($topic_id) {
    global $conn;
    
    // Prepare the SQL query to fetch published posts filtered by topic ID
    $sql = "SELECT posts.id, posts.title, posts.content, posts.updated_at 
            FROM posts 
            INNER JOIN post_topic ON posts.id = post_topic.post_id 
            WHERE post_topic.topic_id = $topic_id AND posts.published = 1";

    // Execute the SQL query
    $result = mysqli_query($conn, $sql);

    // Initialize an array to store filtered posts
    $final_posts = array();

    // Check if there are any results
    if(mysqli_num_rows($result) > 0) {
        // Fetch all posts as an associative array
        $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
        
        // Iterate through each post
        foreach ($posts as $post) {
            // Add additional topic information to the post
            $post['topic'] = getPostTopic($post['id']);
            // Add the post to the final array
            $final_posts[] = $post;
        }
    }

    // Return the filtered posts array
    return $final_posts;
}

?>



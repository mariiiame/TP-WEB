
<?php include('../config.php'); ?>
<?php include(ROOT_PATH . '/admin/post_functions.php'); ?>
<?php include(ROOT_PATH . '/includes/admin/head_section.php'); ?>

<?php
$posts = getAllPosts(); // Récupérer tous les articles
?>

<title>Admin | Manage posts</title>
</head>

<body>
	<!-- Barre de navigation admin -->
	<?php include(ROOT_PATH . '/includes/admin/header.php'); ?>
	<div class="container content">
		<!-- Menu latéral gauche -->
		<?php include(ROOT_PATH . '/includes/admin/menu.php'); ?>

		<!-- Affichage des enregistrements depuis la base de données -->
		<div class="table-div">
			<!-- Affichage du message de notification -->
			<?php include(ROOT_PATH . '/includes/public/messages.php'); ?>

			<?php if (empty($posts)) : ?>
				<h1>No posts in the database.</h1>
			<?php else : ?>
				<table class="table">
					<thead>
						<th>N</th>
						<th>Author</th>
						<th>Title</th>
						<th>Views</th>
						<th colspan="1">Publish</th>
						<th colspan="1">Edit</th>
						<th colspan="1">Delete</th>
					</thead>
					<tbody>
						<?php foreach ($posts as $key => $post) : ?>
							<tr>
								<td><?php echo $key + 1; ?></td>
								<td><?php echo $post['author']; ?></td>
								<td>
									<a href="http://localhost:2024/single_post.php?post-slug=<?php echo $post['slug']; ?>">
										<?php echo $post['title']; ?>
									</a>
								</td>
								<td><?php echo $post['views']; ?></td>
								<td>
									<?php if ($post['published']): ?>
										<a class="fa fa-pencil btn publish" href="posts.php?publish-post=<?php echo $post['id']; ?>"></a>
									<?php else: ?>
										<a class="fa fa-pencil btn unpublish" href="posts.php?publish-post=<?php echo $post['id']; ?>"></a>
									<?php endif; ?>
								</td>
								<td>
									<a class="fa fa-pencil btn edit" href="users.php?edit-admin=<?php echo $admin['id'] ?>">
									</a>
								</td>
								<td>
									<a class="fa fa-trash btn delete" href="users.php?delete-admin=<?php echo $admin['id'] ?>">
									</a>
								</td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			<?php endif ?>
		</div>
		<!-- // Affichage des enregistrements depuis la base de données -->
	</div>

</body>

</html>

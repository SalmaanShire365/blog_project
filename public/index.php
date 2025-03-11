<?php
ini_set('display_errors',1);
error_reporting(E_ALL);

// connection to the database
include __DIR__ .'/../includes/db.php';

$sql = "SELECT * FROM posts ORDER BY created_at DESC LIMIT 5";  // Get latest 5 posts

$result = $conn->query($sql);

?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
     <meta charset="UTF-8">
	 <meta name="viewport" content="width=device-width, initial-scale=1.0">
	     <title>My Simple Blog</title>                 
		<link rel="stylesheet" href="../assets/css/style.css">
		 </head>
		 <body>

		 <h1>Welcome to My Simple Blog</h1>

		 <!-- Link to create a new post -->
	<a href="create_post.php">Create a New Post</a>

<?php
// If there are posts, display them
if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		echo "<div>";
		echo "<h2>" . htmlspecialchars($row["title"]) . "</h2>"; // Title of the post
		echo "<p>" . nl2br(htmlspecialchars($row["content"])) . "</p>"; // Post content
		echo "<p><em>Posted on: " . htmlspecialchars($row["created_at"]) . "</em></p>"; // Post date        

		echo "<a href='edit_post.php?id=".$row['id'] . "'>Edit</a>";
		echo "<br>";
		echo "</br>";		
		echo "<a href='delete_post.php?id=".$row['id'] . "'>Delete</a>";
		echo "<hr>";
		echo "</div>";
	}
} else {
	echo "<p>No posts yet. <a href='create_post.php'>Create one now!</a></p>";
}
?>

</body>									
</html>

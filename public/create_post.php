<?php

// include db connection
include __DIR__ . '/../includes/db.php';


if($_SERVER["REQUEST_METHOD"] == "POST") {
	// get form data
	$title = htmlspecialchars($_POST['title']);
	$content = htmlspecialchars($_POST['content']);

	// Prepare SQL statement
	$sql = "INSERT INTO posts (title, content, created_at) VALUES (?,?,NOW())";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('ss',$title,$content); // Bind parameters

	if($stmt->execute()) {
		echo "new post created";
	} else {
		echo "Error: " . $stmt->error;
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Post</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<h1>Create a New Post</h1>
<form action="create_post.php" method="POST">
    <label for="title">Title:</label><br>
    <input type="text" id="title" name="title" required><br><br>

    <label for="content">Content:</label><br>
    <textarea id="content" name="content" rows="4" cols="50" required></textarea><br><br>

    <button type="submit">Submit</button>
</form>

<a href="index.php">Back to Blog</a>

</body>
</html>

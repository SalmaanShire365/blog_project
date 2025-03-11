<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


include __DIR__ . '/../includes/db.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
	$post_id = $_GET['id'];
	echo "The post ID is: " . $post_id;
} else {
	echo "Invalid post ID!";
	exit();
}

$query = "SELECT * FROM posts WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $post_id);

$stmt->execute();

if ($stmt->error) {
	echo "Query error: " . $stmt->error;
	exit();
}

$result = $stmt->get_result();

if ($result->num_rows == 0) {
	echo "Post not found!";
	exit();
} else {
	$post = $result->fetch_assoc();
	echo "<pre>";
	print_r($post);
	echo "</pre>";
}

if(isset($_POST['update'])) {
	// get updated values from form
	$update_title=$_POST['title'];
	$update_content=$_POST['content'];
	$post_id=$_POST['post_id'];

	$query = "UPDATE posts SET title = ?, content= ? WHERE id = ?";
	$stmt = $conn->prepare($query);
	$stmt->bind_param("ssi",$update_title,$update_content,$post_id);

	if($stmt->execute()) {
		echo "Updated post.";
	} else {
		"Error updating post: " . $stmt->error;
	}
	$stmt->close();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<h1>Edit Post</h1>

<!-- Edit form: pre-fill with the existing post data -->
<form method="POST" action="">
    <label for="title">Title:</label>
    <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required><br><br>

    <label for="content">Content:</label><br>
    <textarea id="content" name="content" rows="10" cols="50" required><?php echo htmlspecialchars($post['content']); ?></textarea><br><br>
    <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
    <button type="submit" name="update">Update Post</button>
</form>

<a href="index.php">Back to Blog</a>
</body>
</html>


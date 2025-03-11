<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

// connection to database 
include __DIR__ . '/../includes/db.php';


// check if id parameter is passed in the URL
if (isset($_GET['id'])) {
    $post_id = $_GET['id'];


    // ensure that id is a valid number
    if (!is_numeric($post_id)) {
        die('Invalid post ID.');
    }


    // query to fetch post to confirm deletion
    $query = "SELECT * FROM posts WHERE id = ?";
    if ($stmt = $conn->prepare($query)) {
	 // bind the 'id' parameter to the query and execute it
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $result = $stmt->get_result();

	// Check if post if found
	
	if ($post = $result->fetch_assoc()) {

	// Display post details and a confirmation form for deletion
            echo "<h1>Are you sure you want to delete this post?</h1>";
            echo "<p><strong>Title:</strong> " . htmlspecialchars($post['title']) . "</p>";
            echo "<p><strong>Content:</strong> " . htmlspecialchars($post['content']) . "</p>";
	    
	// Form to confirm deletion with a hidden post_id field
	    echo '<form method="POST">
                    <input type="hidden" name="post_id" value="' . htmlspecialchars($post_id) . '">
                    <input type="submit" name="delete" value="Delete Post">
                  </form>';
	} else {
		// Post not found message
            echo "Post not found.";
        }
    }
    $stmt->close(); // Close the statement after use
}

// Handle the form submission for deletion 
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete']) && isset($_POST['post_id'])) {
	
$post_id = $_POST['post_id'];
	// check if post_id is valid
if (is_numeric($post_id)) {
	// prepare query to delete the post
        $query = "DELETE FROM posts WHERE id = ?";
	if ($stmt = $conn->prepare($query)) {
		// bind the 'post_id' param to query and execute
		$stmt->bind_param("i", $post_id);
		if ($stmt->execute()) {
		// Confirm successful deletion
                echo "Post deleted successfully.";
		} else {
		// Error message if the deletion fails
                echo "Error deleting post.";
            }
            $stmt->close(); // Close the statement after use
        }
    }
}
// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Post</title>
</head>
<body>
<a href="index.php">Back to Home</a>
</body>
</html>


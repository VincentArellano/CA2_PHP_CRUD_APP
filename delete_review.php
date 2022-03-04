<?php
// Get ID
$review_id = filter_input(INPUT_POST, 'review_id', FILTER_VALIDATE_INT);

// Validate inputs
if ($review_id == null || $review_id == false) {
    $error = "Invalid review ID.";
    include('error.php');
} else {
    require_once('database.php');

    // Add the product to the database  
    $query = 'DELETE FROM reviews 
              WHERE reviewID = :review_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':review_id', $review_id);
    $statement->execute();
    $statement->closeCursor();

    // Display the Category List page
    include('index.php');
}
?>
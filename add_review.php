
<?php


$name = $name = filter_input(INPUT_POST, 'name');
$comment = $comment = filter_input(INPUT_POST, 'comment');
$record_id = filter_input(INPUT_POST, 'record_id', FILTER_VALIDATE_INT);

// Validate inputs
if ($name == null || $comment == null) {
    $error = "Invalid review data. Check all fields and try again.";
    include('error.php');
} else {
    require_once('database.php');

    // Add the product to the database
    $query = "INSERT INTO reviews (recordID,reviewName, comment)
              VALUES (:record_id,:name, :comment)";
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':comment', $comment);
    $statement->bindValue(':record_id', $record_id);
    $statement->execute();
    $statement->closeCursor();

    include('reviews.php');
}
?>
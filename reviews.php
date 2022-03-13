
<?php
require_once('database.php');

// Get record ID
if (!isset($record_id)) {
$record_id = filter_input(INPUT_GET, 'record_id', 
FILTER_VALIDATE_INT);
if ($record_id == NULL || $record_id == FALSE) {
$record_id = 1;
}
}

$record_id = filter_input(INPUT_POST, 'record_id', FILTER_VALIDATE_INT);
$query = 'SELECT *
          FROM records
          WHERE recordID = :record_id';
$statement = $db->prepare($query);
$statement->bindValue(':record_id', $record_id);
$statement->execute();
$records = $statement->fetch(PDO::FETCH_ASSOC);
$statement->closeCursor();

// Get name for current record
$queryRecord = "SELECT * FROM records
WHERE recordID = :record_id";
$statement1 = $db->prepare($queryRecord);
$statement1->bindValue(':record_id', $record_id);
$statement1->execute();
$record = $statement1->fetch();
$statement1->closeCursor();
$record_name = $record['name'] ?? 'Pc Part';

// Get reviews for slected record
$queryReviews = "SELECT * FROM reviews
WHERE recordID = :record_id
ORDER BY reviewID";
$statement3 = $db->prepare($queryReviews);
$statement3->bindValue(':record_id', $record_id);
$statement3->execute();
$reviews = $statement3->fetchAll();
$statement3->closeCursor();
?>
<!-- the head section -->
<head>
    <link rel="stylesheet" type="text/css" href="scss/main.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<div class="container">
<?php
include('includes/header.php');
?>
    <h1>Reviews for <?php echo $record_name; ?></h1>
    <table style="margin: 20px; border: 1px solid #898F9C; border-radius: 20px;">
        <?php foreach ($reviews as $review) : ?>
        <tr>
            <td style="padding: 15px;"><?php echo $review['reviewName']; ?></td>
        </tr>
            <tr style="border-bottom: 1px solid #898F9C;">
            <td style="padding: 15px;"><?php echo $review['comment']; ?></td>
            <td>
                <form action="delete_review.php" method="post"
                      id="delete_review_form" style="padding: 15px;">
                    <input type="hidden" name="review_id"
                           value="<?php echo $review['reviewID']; ?>">
                    <input class="margin-left" type="submit" value="Delete">
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <br>

    <h2 style="text-align: center;">Add Review</h2>
    <form style="text-align: center;" action="add_review.php" method="post"
          id="add_review_form">

        <label>Name:</label>
        <input type="input" name="name" required>
        <label class="ml-3">Add Review:</label>
        <input type="input" name="comment" required>
        <input type="hidden" name="record_id"
value="<?php echo $record['recordID']; ?>">
        <input id="add_review_button" type="submit" value="Add">
        <div class="padding-top add-button"><a style="text-decoration: none;" href="index.php" class="button">Back</a></div>
    </form>

    <?php
include('includes/footer.php');
?>
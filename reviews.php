
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

$queryRecord = "SELECT Count(*) FROM reviews 
Where recordID = :record_id";
$statement2 = $db->prepare($queryRecord);
$statement2->bindValue(':record_id', $record_id);
$statement2->execute();
$count = $statement2->fetchColumn();
$statement2->closeCursor();

?>
<!-- the head section -->
<head>
<link rel="stylesheet" type="text/css" href="./scss/mainstyle.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<div class="container">
<?php
include('includes/header.php');
?>
    <table class="reviewTable">
    <h2 class="reviewHeader"><?php echo $count; ?> Reviews for  <?php echo $record_name; ?></h2>
        <?php foreach ($reviews as $review) : ?>
        <tr>
            <td class="reviewName"><?php echo $review['reviewName']; ?></td>
        </tr>
            <tr class="trComment">
            <td class="reviewComment"><?php echo $review['comment']; ?></td>
            <td>
                <form action="delete_review.php" method="post"
                      id="delete_review_form" class="reviewDelete">
                    <input type="hidden" name="review_id"
                           value="<?php echo $review['reviewID']; ?>">
                    <input class="margin-left" type="submit" value="Delete">
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <br>

    <h2 class="addHeader">Add Review</h2>
    <form class="addHeader" action="add_review.php" method="post"
          id="add_review_form">

        <label>Name:</label>
        <input type="input" name="name" required>
        <label class="ml-3">Add Review:</label>
        <input type="input" name="comment" required>
        <input type="hidden" name="record_id"
value="<?php echo $record['recordID']; ?>">
        <input id="add_review_button" type="submit" value="Add">
        <div class="backButton"><a class="Addbutton button" href="index.php" class="button">Back</a></div>
    </form>

    <?php
include('includes/footer.php');
?>
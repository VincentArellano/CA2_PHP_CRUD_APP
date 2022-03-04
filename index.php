<head>
<link rel="stylesheet" type="text/css" href="scss/main.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>
<?php
require_once('database.php');

// Get category ID
if (!isset($category_id)) {
$category_id = filter_input(INPUT_GET, 'category_id', 
FILTER_VALIDATE_INT);
if ($category_id == NULL || $category_id == FALSE) {
$category_id = 1;
}
}

// Get name for current category
$queryCategory = "SELECT * FROM categories
WHERE categoryID = :category_id";
$statement1 = $db->prepare($queryCategory);
$statement1->bindValue(':category_id', $category_id);
$statement1->execute();
$category = $statement1->fetch();
$statement1->closeCursor();
$category_name = $category['categoryName'];

// Get all categories
$queryAllCategories = 'SELECT * FROM categories
ORDER BY categoryID';
$statement2 = $db->prepare($queryAllCategories);
$statement2->execute();
$categories = $statement2->fetchAll();
$statement2->closeCursor();

// Get records for selected category
$queryRecords = "SELECT * FROM records
WHERE categoryID = :category_id
ORDER BY recordID";
$statement3 = $db->prepare($queryRecords);
$statement3->bindValue(':category_id', $category_id);
$statement3->execute();
$records = $statement3->fetchAll();
$statement3->closeCursor();
?>
<div>
<?php
include('includes/header.php');
?>
<nav>
<ul>
<?php foreach ($categories as $category) : ?>
<li><a style="text-decoration: none;" href=".?category_id=<?php echo $category['categoryID']; ?>">
<?php echo $category['categoryName']; ?>
</a>
</li>
<?php endforeach; ?>
</ul>
</nav>      

<!-- display a table of records -->
<div class="container-xl">
	<div class="table-responsive">
		<div class="table-wrapper">
<div class="table-title">
				<div class="row">
					<div class="col-sm-6">
                    <h2><?php echo $category_name; ?></h2>
					</div>
					<div class="col-sm-6">
						<a href="add_record_form.php" class="btn btn-color"><i class="material-icons">&#xE147;</i><span>Add New Part</span></a>
                        <a href="category_list.php" class="btn btn-color"><span>Manage Categories</span></a>	
					</div>
				</div>
			</div>
<table class="table table-striped table-hover">
    <thead>
<tr>
<th>Image</th>
<th>Name</th>
<th>Description</th>
<th>MSRP</th>
<th>Current Price</th>
<th>Delete</th>
<th>Edit</th>
<th>Reviews</th>
</tr>
</thead>
<?php foreach ($records as $record) : ?>
<tr>
<td><img src="image_uploads/<?php echo $record['image']; ?>" width="100px" height="100px" /></td>
<td><?php echo $record['name']; ?></td>
<td class="right"><?php echo $record['description']; ?></td>
<td class="right">€<?php echo $record['msrp']; ?></td>
<td class="right">€<?php echo $record['current_price']; ?></td>

<td><form action="delete_record.php" method="post"
id="delete_record_form">
<input type="hidden" name="record_id"
value="<?php echo $record['recordID']; ?>">
<input type="hidden" name="category_id"
value="<?php echo $record['categoryID']; ?>">
<input type="submit" value="Delete" class="delete">
</form></td>

<td><form class="edit" action="edit_record_form.php" method="post"
id="delete_record_form">
<input type="hidden" name="record_id"
value="<?php echo $record['recordID']; ?>">
<input type="hidden" name="category_id"
value="<?php echo $record['categoryID']; ?>">
<input type="submit" value="Edit">
</form></td>

<td><form class="review" action="reviews.php" method="post"
id="reviews">
<input type="hidden" name="record_id"
value="<?php echo $record['recordID']; ?>">
<input type="hidden" name="category_id"
value="<?php echo $record['categoryID']; ?>">
<input type="submit" value="Reviews">
</form></td>
</tr>
<?php endforeach; ?>
</table>
</div>
	</div>        
</div>
<?php
include('includes/footer.php');
?>
<?php
require('database.php');

$record_id = filter_input(INPUT_POST, 'record_id', FILTER_VALIDATE_INT);
$query = 'SELECT *
          FROM records join categories using(categoryID)
          WHERE recordID = :record_id';
$statement = $db->prepare($query);
$statement->bindValue(':record_id', $record_id);
$statement->execute();
$records = $statement->fetch(PDO::FETCH_ASSOC);
$statement->closeCursor();

$query = 'SELECT *
          FROM categories
          ORDER BY categoryID';
$statement = $db->prepare($query);
$statement->execute();
$categories = $statement->fetchAll();
$statement->closeCursor();
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
        <h1>Edit Product</h1>
        <form action="edit_record.php" method="post" enctype="multipart/form-data"
              id="add_record_form">
            <input type="hidden" name="original_image" value="<?php echo $records['image']; ?>" />
            <input type="hidden" name="record_id"
                   value="<?php echo $records['recordID']; ?>">


        <div class="container">
                        <form id="contact-form" role="form">
                            <div class="controls">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group"> <label for="form_name">Name *</label> <input id="form_name" type="input" class="form-control" name="name" value="<?php echo $records['name']; ?>" placeholder="Name" required> </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"> <label for="form_lastname">MSRP *</label> <input id="form_MSRP" type="input" class="form-control" name="msrp" value="<?php echo $records['msrp']; ?>" placeholder="Manufacturer's Suggested Retail Price (MSRP)" required> </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group"> <label for="form_email">Current Price *</label> <input id="form_MSRP" type="input" class="form-control" name="current_price" value="<?php echo $records['current_price']; ?>" placeholder="Current Price" required> </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"> <label for="form_need">Category *</label> <select name="category_id" class="form-control">
            <?php foreach ($categories as $category) : ?>
                <option value="<?php echo $category['categoryID']; ?>">
                    <?php echo $category['categoryName']; ?>
                </option>
            <?php endforeach; ?>
            </select></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group"> <label for="form_message">Description *</label> <input type="text" id="form_message" class="form-control" rows="4"  name="description" placeholder="Description" value="<?php echo $records['description']; ?>" required> </div>
                                    </div>
                                    <div class="col-md-12">
                                    <div class="form-group"> <label for="form_need">Image *</label> 
            <input type="file" name="image" accept="image/*" class="form-control"/> <?php if ($records['image'] != "") { ?>
            <p><img src="image_uploads/<?php echo $records['image']; ?>" height="150" /></p>
            <?php } ?>
            </div>
            </div>
            <div class="padding-left padding-top add-button"><input type="submit" value="Save Changes"/></div>
            <div class="padding-top add-button"><a style="text-decoration: none;" href="index.php" class="button">Cancel</a></div>
            
                                </div>
                            </div>
                        </form>
                    </div>
    <?php
include('includes/footer.php');
?>
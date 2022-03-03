<?php
require('database.php');
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
 <div>
<?php
include('includes/header.php');
?>
        <h1>Add Record</h1>
        <form action="add_record.php" method="post" enctype="multipart/form-data"
              id="add_record_form">

        <div class="container">
                        <form id="contact-form" role="form">
                            <div class="controls">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group"> <label for="form_name">Name *</label> <input id="form_name" type="input" class="form-control" name="name" placeholder="Name" required> </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"> <label for="form_lastname">MSRP *</label> <input id="form_MSRP" type="input" class="form-control" name="msrp" placeholder="Manufacturer's Suggested Retail Price (MSRP)" required> </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group"> <label for="form_email">Current Price *</label> <input id="form_MSRP" type="input" class="form-control" name="current_price" placeholder="Current Price" required> </div>
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
                                        <div class="form-group"> <label for="form_message">Description *</label> <textarea id="form_message" class="form-control" rows="4"  name="description" placeholder="Description" required></textarea> </div>
                                    </div>
                                    <div class="col-md-12">
                                    <div class="form-group"> <label for="form_need">Image *</label> 
            <input type="file" name="image" accept="image/*" class="form-control"  required/>
            </div>
            </div>
            <div class="padding-left padding-top add-button"><input type="submit" value="Add Record"/></div>
            <div class="padding-top add-button"><a style="text-decoration: none;" href="index.php" class="button">Cancel</a></div>
            
                                </div>
                            </div>
                        </form>
                    </div>
    <?php
include('includes/footer.php');
?>
            
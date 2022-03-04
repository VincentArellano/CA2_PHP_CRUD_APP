<?php
    require_once('database.php');

    // Get all categories
    $query = 'SELECT * FROM categories
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
    <h1>Category List</h1>
    <table style="margin: 0 auto;">
        <tr>
            <th>Name</th>
            <th>&nbsp;</th>
        </tr>
        <?php foreach ($categories as $category) : ?>
        <tr>
            <td><?php echo $category['categoryName']; ?></td>
            <td>
                <form action="delete_category.php" method="post"
                      id="delete_product_form">
                    <input type="hidden" name="category_id"
                           value="<?php echo $category['categoryID']; ?>">
                    <input class="margin-left" type="submit" value="Delete">
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <br>

    <h2 style="text-align: center;">Add Category</h2>
    <form style="text-align: center;" action="add_category.php" method="post"
          id="add_category_form">

        <label>Name:</label>
        <input type="input" name="name" requried>
        <input id="add_category_button" type="submit" value="Add">
        <div class="padding-top add-button"><a style="text-decoration: none;" href="index.php" class="button">Cancel</a></div>
    </form>

    <?php
include('includes/footer.php');
?>
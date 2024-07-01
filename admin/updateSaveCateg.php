<?php
include_once ($_SERVER['DOCUMENT_ROOT']."/connection.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>

<body>
    <?php
    $error=1;
    if (isset ($_POST['submit'])) {
        if (isset ($_POST['name']) && !empty ($_POST['name'])) {
            if ($dbHelper->category_unique($_POST['name']) == 0) {
                $category = $dbHelper->getCategoryById(htmlspecialchars($_POST['category']));
                $category->setName(htmlspecialchars($_POST['name']));
                $dbHelper->updateCategory($category);
                $message = "<p style='color:green ; font-weight:bold'>Category updated successfully</p>";
            } else {
                $error=0;
                $message = "<p style='color:red ; font-weight:bold'>Category name already token!</p>";
            }
        }
    }

    ?>
</body>

</html>
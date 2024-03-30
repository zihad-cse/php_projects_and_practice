<!DOCTYPE html>
<html lang="en">
<?php
ini_set('display_errors', 1);
error_reporting();
include 'config.php';
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>Document</title>
</head>

<body class="bg-dark">
    <div class="container bg-light">
        <table class="text-center table table-bordered table-hover">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
            </tr>
            <?php if ($read) { ?>
                <?php while ($row = $read->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['customer_id'] ?></td>
                        <td><?php echo $row['customer_name'] ?></td>
                        <td><?php echo $row['email'] ?></td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <p>Data not available</p>
            <?php } ?>
        </table>
    </div>
    </div>
</body>

</html>
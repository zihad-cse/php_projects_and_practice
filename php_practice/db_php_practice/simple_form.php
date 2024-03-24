<!DOCTYPE html>
<html lang="en">
    <?php include 'db_info_insert.php'?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
        <table>
            <tr>
                <td><label for="fullname">Full Name</label></td>
                <td><input name="fullName" type="text"></td>
            </tr>
            <tr>
                <td><label for="email">Email</label></td>
                <td><input name="eMail" type="email"></td>
            </tr>
            <tr>
                <td><input type="submit"></td>
            </tr>
            <tr>
                <td><?php echo $infoStatus?></td>
            </tr>
        </table>
    </form>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<?php
include 'db_conn.php';

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            var commentCount = 4;
            $("#btn").click(function() {
                commentCount = commentCount + 2;
                $("#comments").load("comments.php", {
                    commentNewCount: commentCount
                });
            });
        });
    </script>
    <title>Document</title>
</head>

<body class="bg-light">
    <div class="p-5" id="comments">
        <?php
        $sql = "SELECT * FROM Comments LIMIT 4";
        $result = mysqli_query($link, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<p>";
                echo $row['id'];
                echo "<br>";
                echo $row['commenter'];
                echo "<br>";
                echo $row['comment'];
                echo "</p>";
            }
        } else {
            echo "No Data";
        }

        ?>

    </div>
    <button id="btn" class="btn btn-dark">Show More</button>
</body>

</html>
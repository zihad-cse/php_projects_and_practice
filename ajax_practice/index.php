<?php 
include 'php/data.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../jobsite_project/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../jobsite_project/css/landing_page.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Document</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-4">
                <input id="query" class="form-control" type="text">
            </div>
            <div class="col-4">
                <button id="get-button" class="btn btn-primary">Get Data</button>
            </div>
            <div id="result" class="col-4"></div>
        </div>
    </div>


    <script type="text/javascript">
        $(document).ready(function() {
            $('#get-button').click(function() {
                $.ajax({
                    type: 'POST',
                    url: 'php/data.php',
                    data: {
                       query:$('#query').val(),
                    },
                    success:function(results){
                        $('#result').html(results);
                    }                    
                });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>
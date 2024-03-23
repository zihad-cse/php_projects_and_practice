
<?php include 'php-script.php'?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>Document</title>
</head>
<body>
    <div class="vh-100 d-flex flex-column justify-content-center bg-dark">
        <div class="container card">
            <form action="#" method="post" name="practiceForm" class="d-flex flex-column align-items-center card-body bg-light">
                <div>
                    <label for="userName">Username</label>
                    <input type="text" name="username" id="userName" class="form-control">
                    <p class="text-danger"><?php echo $errusername?></p>
                </div>
                <div>
                    <label for="passWord">Password</label>
                    <input type="password" name="password" id="passWord" class="form-control">
                    <p class="text-danger"><?php echo $errpassword?></p>
                </div>
                <div class="m-3">
                    <select name="dropdown" id="dropDown">
                        <option value="">Select an option</option>
                        <option value="Apple">Apple</option>
                        <option value="Pineapple">Pineapple</option>
                        <option value="Jackfruit">Jackfruit</option>
                        <option value="Orange">Orange</option>
                    </select>
                    <p class="text-danger"><?php echo $errdropdown?></p>
                </div>
                <div class="m-3">
                <div>
                    <ul class="list-group">
                        <li class="list-group-item"><input name="sounds[]" type="checkbox" value="Meow">Meow </li>
                        <li class="list-group-item"><input name="sounds[]" type="checkbox" value="Bark">Bark </li>
                        <li class="list-group-item"><input name="sounds[]" type="checkbox" value="Chirp">Chirp </li>
                    </ul>
                    <p class="text-danger"><?php echo $errsound;?></p>
                </div>
                <div>
                    <ul class="list-group">
                        <li class="list-group-item"><input name="animals" type="radio" value="Cat">Cat </li>
                        <li class="list-group-item"><input name="animals" type="radio" value="Dog">Dog </li>
                        <li class="list-group-item"><input name="animals" type="radio" value="Bird">Bird </li>
                    </ul>
                    <p class="text-danger"><?php echo $erranimals;?></p>
                </div>  
                </div>
                <div><p class="text-danger"><?php echo $errmsg?></p></div>
                <div>
                    <input type="submit" class="btn btn-outline-primary">
                </div>
            </form>
            <div>
                <table class="table table-striped">
                    <tr>
                        <td>Username</td>
                        <td><span id="showUserName"><?php echo $username?></span></td>
                    </tr>
                    <tr>
                        <td>password</td>
                        <td><span id="showPassWord"><?php echo $password?></span></td>
                    </tr>
                    <tr>
                        <td>Fruit</td>
                        <td><span id="showFruit"><?php echo $dropdown?></span></td>
                    </tr>
                    <tr>
                        <td>Sound</td>
                        <td><span id="showSound"><?php echo $selected_sounds_string?></span></td>
                    </tr>
                    <tr>
                        <td>Animal</td>
                        <td><span id="showAnimal"><?php echo $animals?></span></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
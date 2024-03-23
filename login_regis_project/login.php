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
    <title>Sign in</title>
</head>

<body class="bg-dark">

    <div class="container card bg-light vh-100">
        <div class="row">
            <div class="col-12 text-center p-3">
                <h2>Log in</h2>
            </div>
        </div>
        <form class="mx-5">
            <div class="row py-3">
                <div class="col-6">
                    <div>
                        <label for="userName">Username</label>
                        <input name="username" type="text" class="form-control">
                    </div>
                </div>
                <div class="col-6">
                    <div>
                        <label for="password">Password</label>
                        <input name="password" type="password" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row py-3">
                <div class="col">
                    <div>
                        <input value="Sign in" type="submit" class="btn btn-success">
                    </div>
                </div>
            </div>
            <div class="row py-3">
                <div class="col">
                    <div>
                        <a href="signup.php" class="btn btn-info">Sign Up</a>
                    </div>
                </div>
            </div>
        </form>
    </div>

</body>

</html>
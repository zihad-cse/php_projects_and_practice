<?php 
$username = $password = $dropdown = $sounds = $animals = $selected_sounds_string = '';
$errusername = $errpassword = $errmsg = $errdropdown = $errsound = $erranimals = '';
$selected_sounds = [];
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if (isset($_POST['username'])){
        $username = $_POST["username"];
    } else {
        $errusername = "Username Required";
    }
    if (isset($_POST['password'])){
        $password = $_POST["password"];
    } else {
        $errpassword = "Password Required";
    }
    if (isset($_POST['dropdown']) && !empty($_POST['dropdown'])){
        $dropdown = $_POST['dropdown'];
    } else {
        $errdropdown = "Please Select an Option";
    }
    if (isset($_POST['sounds']) && !empty($_POST['sounds'])){
        $sounds = $_POST['sounds']; 
        foreach($sounds as $sound) {
            $selected_sounds[] = $sound;
            $selected_sounds_string = implode(', ', $selected_sounds);
        }
    } else {
        $errsound = 'Please Select at least One Sound';
    }
    if (isset($_POST['animals']) && !empty($_POST['animals'])){
        $animals = $_POST['animals'];
    } else {
        $erranimals = 'Please Select one';
    }
}


// if ($password == '' && $username == ''){
//     $errmsg = "";
// } elseif ($password !== 'submit'){
//     $errmsg = "Password doesn't match";
// } else {
//     $errmsg = '';
// }

?>
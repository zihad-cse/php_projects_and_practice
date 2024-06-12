 <?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$dsn = 'mysql:host=localhost;dbname=jobsite';
$username = 'huda';
$password = 'huda123';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e){
    echo 'Database connection failed '. $e->getMessage(); 
}

// {
//     "hostname": "localhost",
//     "apiKey": "ckey_0149960de588fbdca86c1a52cd31",
//     "secret": "csec_74adf7ee2db134df442edfe3589c951c66a211b87fc077c7",
//     "license": "This API key is provided free of charge. Use of this key or the API it accesses is at your own risk with no warranty or liability. By using this key you agree to properly attribute ALTCHA on your website as described in the documentation (https://altcha.org/docs/api/api_keys#attribution-for-free-api-keys). Terms of Service apply ((https://altcha.org/terms-of-service).",
//     "verification": {
//       "DNS": {
//         "name": "@",
//         "type": "TXT",
//         "value": "altcha-verification=88b7318558bdf02f"
//       }
//     }
//   }
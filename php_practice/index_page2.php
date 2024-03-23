<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>PHP Practice Page 2</title>
</head>

<body class="bg-secondary">
    <div class="container bg-light">

        <?php
        echo '<hr>';
        $multiDimensionalArray1 = [
            'sn01' => [
                'id' => '201',
                'username' => 'cheese',
                'dob' => '24.09.01',
            ],
            'sn02' => [
                'id' => '202',
                'username' => 'pepper',
                'dob' => '22.01.99',
            ],
            'sn03' => [
                'id' => '203',
                'username' => 'milk',
                'dob' => '14.02.98',
            ]
        ];
        
        echo '<pre>';
        print_r($multiDimensionalArray1);
        echo '</pre>';
        echo '<hr>';
        $username = array_column($multiDimensionalArray1, 'username', 'id'); //array_column($array, item, items_thatre_keys);
        $dob = array_column($multiDimensionalArray1, 'dob', 'username');

        echo '<pre>';
        print_r($username);
        echo '</pre>';
        echo '<pre>';
        print_r($dob);
        echo '</pre>';
        echo '<hr>';
        echo '<h3>The above arrays were extracted from the multidimensional array printed above using the array_column() Function</h3>';
        echo '<hr>';

        $uncombinedArray1 = [203, 205, 290];
        $uncombinedArray2 = ['cheese', 'carrot', 'milk'];
              
        echo '<pre>';
        print_r($uncombinedArray1);
        echo '</pre>';     
        echo '<pre>';
        print_r($uncombinedArray2);
        echo '</pre>';
        echo '<hr>';

        $combinedArray1 = array_combine($uncombinedArray1, $uncombinedArray2); //array_combine($key_array, $value_array);

        echo '<pre>';
        print_r($combinedArray1);
        echo '</pre>';
        echo '<hr>';
        echo '<h3>The above array is a combination of the two different arrays printed above. one array is a value and the other the keys</h3>';
        echo '<hr>';

        $arrayWithRepeatedValues1 = ['cheese','egg','cheese','cheese','cheese','cheese','cheese','cheese','milk','egg','egg','egg','milk','milk','milk','milk',];
        echo '<pre>';
        print_r($arrayWithRepeatedValues1);
        echo '</pre>';

        $countedArray1 = array_count_values($arrayWithRepeatedValues1);


        echo '<pre>';
        print_r($countedArray1);
        echo '</pre>';

        echo '<hr>';
        echo '<h3>The above array shows how many times each value has been repeated in the array that was printed above that</h3>';
        echo '<hr>';

        $unnamedArray1 = [
            'cow' => 'moo',
            'cat' => 'meow',
            'dog' => 'bark',
            'bird' => 'chirp'
        ];
        $unnamedArray2 = [
            'cow' => 'moo',
            'cat' => 'meow',
            'dog' => 'bark',
        ];
        
        echo '<pre>';
        print_r($unnamedArray1);
        echo '</pre>';
        echo '<pre>';
        print_r($unnamedArray2);
        echo '</pre>';

        $diffArray1 = array_diff($unnamedArray1, $unnamedArray2); //array_diff($base_array, $compared_array);

        echo '<pre>';
        print_r($diffArray1);
        echo '</pre>';

        echo '<hr>';
        echo '<h3>The above array shows which unique values it has compared to other arrays that it is comparing itself to</h3>';
        echo '<hr>';

        $unnamedArray3 = [
            'meow' => 'cat',
            'bark' => 'dog',
            'quack' => 'duck',
            'chirp' => 'bird'
        ];
        $unnamedArray4 = [
            'miau' => 'cat',
            'woof' => 'dog',
            'quack' => 'duck',
            'chirp' => 'bird'
        ];
                
        echo '<pre>';
        print_r($unnamedArray3);
        echo '</pre>';
        echo '<pre>';
        print_r($unnamedArray4);
        echo '</pre>';

        $diffArray2 = array_diff_assoc($unnamedArray3, $unnamedArray4); //array_diff_assoc($base_array, $compared_array);

        echo '<pre>';
        print_r($diffArray2);
        echo '</pre>';

        echo '<hr>';
        echo '<h3>The above array did the same thing but only compared the keys instead of the values</h3>';
        echo '<hr>';


        $unnamedArray5 = [
            202 => 'Robert',
            206 => 'James',
            203 => 'Oppenheimer',
            209 => 'Linda',
        ];
        $unnamedArray6 = [
            202 => 'Robert',
            220 => 'Juniper',
            212 => 'Theodore',
            209 => 'Linda',
        ];
        $unnamedArray7 = [
            202 => 'Robert',
            278 => 'Keehan',
            298 => 'Abigail',
            209 => 'Linda',
        ];

        echo '<pre>';
        print_r($unnamedArray5);
        echo '</pre>';
        echo '<pre>';
        print_r($unnamedArray6);
        echo '</pre>';
        echo '<pre>';
        print_r($unnamedArray7);
        echo '</pre>';

        $intersectedArray = array_intersect($unnamedArray5, $unnamedArray6, $unnamedArray7);

        echo '<pre>';
        print_r($intersectedArray);
        echo '</pre>';

        echo '<hr>';
        echo '<h3>The above array shows which items are common throughout the three arrays mentioned above that.</h3>';
        echo '<hr>';

        ?>
    </div>

</body>

</html>
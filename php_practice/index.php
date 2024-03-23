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
    <title>PHP Practice</title>
</head>

<body class="bg-secondary">
    <div class="container bg-light">

<?php
//STRINGS

$firstname = 'Will';
$lastname = 'Smith';

$name = "$firstname" . " " . "$lastname"; //to combine different variables or values, use "."

echo '<hr>';
echo '<a href="index_page2.php">Another PHP file</a>';
echo '<hr>';
echo $name;
echo '<hr>';


// ARRAYS 

// $programminglanguages1 = 'PHP';
// $programminglanguages2 = 'JAVA';
// $programminglanguages3 = 'PYTHON';

$programminglanguages = ['PHP', 'JAVA', 'PYTHON']; //all the values of an array must be of the same data type.

echo '<pre>';
print_r($programminglanguages);
echo '</pre>';

echo '<br>';

$programminglanguages[] = 'C++'; //this pushes a single value into the array.

echo '<pre>';
print_r($programminglanguages);
echo '</pre>';

echo '<br>';

array_push($programminglanguages, 'GO', 'RUBY', 'LARAVEL'); //this pushes multiple values into the array

echo '<pre>';
print_r($programminglanguages);
echo '</pre>';

echo '<br>';

$variablea = [1, 2, 5]; //variable declaration is done with []

echo count($variablea); //shows how many variables there are in the array

echo '<br>';

$keysDeclared = [       //this is how you declare keys if needed. instead of the default values like 0, 1, 2...etc.
    'red' => 'Apple',   // you can set your custom keys by declaring the keys alongside the values in an array
    'yellow' => 'Banana', //it goes like $arrayVariable = ['key' => 'value', 'key2' => 'value2'];
    'orange' => 'orange'
];



echo '<pre>';
print_r($keysDeclared);
echo '</pre>';

echo '<br>';

echo $keysDeclared['red']; //Now you can call different values using the declared keys for them.


echo '<br>';

$keysDeclared['white'] = 'coconut'; //You can directly push a value with it's own custom key like this if you need.


echo '<pre>';
print_r($keysDeclared);
echo '</pre>';

echo '<br>';

$customVariable = 'magenta';
//instead of hardcoding it, you can use a variable as a key as well.
$keysDeclared[$customVariable] = 'PomeGranate';


echo '<pre>';
print_r($keysDeclared);
echo '</pre>';

echo '<br>';

$keysDeclared2 = [
    'php' => [
        'creator' => 'Rasmus Lerdorf',
        'extension' => '.php',
        'website' => 'www.php.net',
        'isOpenSource' => true,
        'versions' => [
            ['version' => 8, 'releaseDate' => 'Nov 26, 2020'],
            ['version' => 7.4, 'releaseDate' => 'Nov 28, 2019'],
        ],
    ],                                                                      //This example here shows that arrays can have other arrays nested in them.
    'python' => [
        'creator' => 'Guido Van Rossum',
        'extension' => '.py',
        'website' => 'www.python.org',
        'isOpenSource' => true,
        'versions' => [
            'firstVersion' => ['version' => 3.9, 'releaseDate' => 'Oct 5, 2020'],
            'secondVersion' => ['version' => 3.8, 'releaseDate' => 'Oct 14, 2019'],
        ],
    ],
];

echo '<pre>';
print_r($keysDeclared2);
echo '</pre>';

echo '<br>';

echo $keysDeclared2['python']['versions']['firstVersion']['releaseDate'];  //this example shows that specific keys can be selected even within nested arrays.

echo '<br>';

echo '<pre>';
print_r(array_pop($keysDeclared2)); //this example shows how to remove the last item of an array and return it
echo '</pre>';

echo '<br>';                        //If the array was echoed after the array_pop or the array_shift it would return it without the last item or the first item respectively.

echo '<pre>';
print_r(array_shift($keysDeclared2)); //while this example shows how to remove the first item of an array and return it.
echo '</pre>';

echo '<br>';

$keySearchArray = ['apple', 'banana', 'watermelon'];
echo '<pre>';
print_r($keySearchArray);
echo '</pre>';
echo '<br>';                                                    //This searches the key of a value in an array
echo 'This is the key of the value "banana" in the array';
echo '<br>';
$searchedKey = array_search('banana', $keySearchArray);

echo $searchedKey;

echo '<br>';

echo '<hr>';

//SORTING BEGINS HERE

$arraysUnsorted = [60, 25, 30];
echo "This array is unsorted";
echo '<br>';
echo '<pre>';
print_r($arraysUnsorted);
echo '</pre>';
echo '<br>';

sort($arraysUnsorted);
echo "This array's values are sorted in ascending order";
echo '<br>';
echo '<pre>';
print_r($arraysUnsorted);
echo '</pre>';
echo '<br>';

rsort($arraysUnsorted);
echo "This array's values are sorted in descending order";
echo '<br>';

echo '<pre>';
print_r($arraysUnsorted);
echo '</pre>';
echo '<br>';


$secondUnsortedArrayWithKeys = [
    'Carrot' => 'Vegetable',
    'Apple' => 'Fruit',
    'Banana' => 'Both?',
];

echo "This array Has custom keys and is unsorted";
echo '<br>';
echo '<pre>';
print_r($secondUnsortedArrayWithKeys);
echo '</pre>';
echo '<br>';

asort($secondUnsortedArrayWithKeys);
echo "This associative array is sorted in ascending order according to value";
echo '<br>';

echo '<pre>';
print_r($secondUnsortedArrayWithKeys);
echo '</pre>';
echo '<br>';

ksort($secondUnsortedArrayWithKeys);
echo "This associative array is sorted in ascending order according to key";
echo '<br>';

echo '<pre>';
print_r($secondUnsortedArrayWithKeys);
echo '</pre>';
echo '<br>';

arsort($secondUnsortedArrayWithKeys);
echo "This associative array is sorted in descending order according to value";
echo '<br>';

echo '<pre>';
print_r($secondUnsortedArrayWithKeys);
echo '</pre>';
echo '<br>';

krsort($secondUnsortedArrayWithKeys);
echo "This associative array is sorted in descending order according to key";
echo '<br>';

echo '<pre>';
print_r($secondUnsortedArrayWithKeys);
echo '</pre>';
echo '<br>';

//SORTING ENDS HERE

echo '<hr>';

//Array Splicing Starts Here.

$unsplicedArray = [
    'a' => 'red',
    'b' => 'blue',
    'c' => 'green',
];

echo 'This array has no values being spliced in.';
echo '<br>';

echo '<pre>';
print_r($unsplicedArray);
echo '</pre>';
echo '<br>';

$arrayBeingSplicedIn = [
    'p' => 'cyan',
];

array_splice($unsplicedArray, 1, 0, $arrayBeingSplicedIn);

echo 'This is the same array with values spliced in';
echo '<br>';

echo '<pre>';
print_r($unsplicedArray);
echo '</pre>';
echo '<br>';



$unsplicedArray2 = [
    'a' => 'red',
    'b' => 'blue',
    'c' => 'green',
];


echo 'This is the Unspliced array once again';
echo '<br>';

echo '<pre>';
print_r($unsplicedArray2);
echo '</pre>';
echo '<br>';


$arrayBeingSplicedIn2 = [
    'a' => 'pink',
    'b' => 'aqua',
];

array_splice($unsplicedArray2, 1, 2, $arrayBeingSplicedIn2);

echo 'This is the array with two values from a different array replacing some values in the';
echo '<br>';


echo '<pre>';
print_r($unsplicedArray2);
echo '</pre>';
echo '<br>';

echo '<hr>';

//Arraysplicing Ends here.

//Loops

// $variableb = [1, 2, 3, 4, 5, 6, 7, 8, 9];

// for ($i = 0; $i < count($variableb); $i++) {  //for conditions go like <for (variableDeclare; durationOfCode; incrementOrDecrement)


//     echo $variableb[$i];
// }

// echo '<br>';


// foreach ($variableb as $no) { //foreach is used only for array
//     echo $no;
// }

// echo '<br>';

$matrixVariables = [
    [1, 2, 3],
    [4, 5, 6],
    [7, 8, 9],
];

echo 'This is a matrix array printed using foreach loop';
echo '<br>';

foreach ($matrixVariables as $row) {
    foreach ($row as $value) {
        echo $value;
    }
    echo '<br>';
};



$matrixVariables = [
    [1, 2, 3],
    [4, 5, 6],
    [7, 8, 9],
];

echo 'This is a matrix array printed using foreach loop but 5 is skipped over using continue';
echo '<br>';

foreach ($matrixVariables as $row) {
    foreach ($row as $value) {
        if ($value == 5) {
            echo ' ';
            continue;
        }
        echo $value;
    }
    echo '<br>';
};

//loops end here

//functions start here

function myFirstFunction()
{
    echo 'Why is my skin red';
};

echo 'The string below was called using a user defined function called myFirstFunction()';
echo '<br>';

myFirstFunction();

echo '<br>';

echo 'using arguments we can use functions a bit more flexibly.';

echo '<br>';

function myFirstFunctionName($name)
{
    echo $name;
}

myFirstFunctionName('Roger');
echo '<br>';

myFirstFunctionName(21);
echo '<br>';

myFirstFunctionName(2.90);
echo '<br>';

myFirstFunctionName(true);
echo '<br>';

myFirstFunctionName(null);
echo '<br>';

echo 'In the examples above, the function call method was used to call an already defined function, but added value types within the parentheses as arguments.';

echo '<br>';

echo 'The example below shows that a function can have more than one variables that can be used as arguments. also the return statement is used to return a value from within a command.';
echo '<br>';

function myFirstFunctionSum($x, $y)
{
    $z = $x + $y;
    return $z;
}

echo "10 + 2 = " . myFirstFunctionSum(10, 2) . "<br>";
echo "28 + 9 = " . myFirstFunctionSum(28, 9) . "<br>";

function myFirstFunctionWithReference(&$referenceValue)
{
    $referenceValue += 5;
}

$myFirstReferenceValue = 12949;
echo '<hr>';

echo $myFirstReferenceValue;

myFirstFunctionWithReference($myFirstReferenceValue);

echo '<br>';
echo $myFirstReferenceValue;
echo '<br>';

$myFirstReferenceValue = 5;

echo $myFirstReferenceValue;

myFirstFunctionWithReference($myFirstReferenceValue);

echo '<br>';
echo $myFirstReferenceValue;
echo '<br>';

echo '<hr>';

function simpleFunction($valuex)
{
    if ($valuex % 2 == 0) {
        echo 'This is Even';
    } else {
        echo 'This is Odd';
    }
}

simpleFunction(283746);
echo '<br>';

echo 'This function above is a simple calculation that determines whether a value is odd or even';
?>
    </div>
</body>

</html>

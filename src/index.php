<?php
//this line makes PHP behave in a more strict way
declare(strict_types=1);

//we are going to use session variables so we need to enable sessions
session_start();
$_SESSION['City'] = 'Liège';
$_SESSION['Street'] = 'rue Mulhouse';
$_SESSION['Streetnumber'] = '36';
$_SESSION['Zipcode'] = '4020';

function whatIsHappening() {
    echo '<h2>$_GET</h2>';
    var_dump($_GET);
    echo '<h2>$_POST</h2>';
    var_dump($_POST);
    echo '<h2>$_COOKIE</h2>';
    var_dump($_COOKIE);
    echo '<h2>$_SESSION</h2>';
    var_dump($_SESSION);
}
$email = $street = $streetnumber = $city = $zipcode =  "";

$streetnumber = filter_input(INPUT_GET, 'streetnumber', FILTER_SANITIZE_NUMBER_INT);
$zipcode =  filter_input(INPUT_GET, 'zipcode', FILTER_SANITIZE_NUMBER_INT);


if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo("$email is a valid email address");
} else {
    echo("$email is not a valid email address");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = test_input($_POST["Email"]);
    $street = test_input($_POST["Street"]);
    $streetnumber = test_input($_POST["Street number"]);
    $city = test_input($_POST["City"]);
    $zipcode = test_input($_POST["Zip code"]);}

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $emailErr = $streetErr = $streetnumberErr = $cityErr = $zipcodeErr =  "";
    $invalidEmail = "";
    $streetnumberIntErr = $zipcodeIntErr = "";

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (empty($_POST['email'])) {
            $emailErr = 'Email is required';
        } else {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $email = $_POST['email'];}
            else {
                $invalidEmail = 'Invalid email format';
            }
        }


        if (empty($_POST['street'])) {
            $streetErr = '*  Street is required';
        } else {
            $street = $_POST['street'];
        }

        if (empty($_POST['streetnumber'])) {
            $streetnumberErr = '*  Street number is required';
        } else {
            if(filter_var($_POST['streetnumber'], FILTER_VALIDATE_INT)) {
            $streetnumber = $_POST['streetnumber'];
        } else {
             $streetnumberIntErr = "* Street number must be a number";
            }
        }


        if (empty($_POST['city'])) {
            $cityErr = 'City is required';
        } else {
            $city = $_POST['city'];
        }

        if (empty($_POST['zipcode'])) {
            $zipcodeErr = 'Zip code is required';
        }  else {
            if(filter_var($_POST['zipcode'], FILTER_VALIDATE_INT)) {
                $zipcode = $_POST['zipcode'];
            } else {
                $zipcodeIntErr = "* Zipcode must be a number";
            }
        }
    }

if(isset($email, $street, $streetnumber, $city, $zipcode)) {
    $correctForm = "Your order placed with this email '$email' has been sent to the following address: $street $streetnumber, $city $zipcode";
}

//your products with their price.
$products = [
    ['name' => 'Margherita', 'price' => 8],
    ['name' => 'Hawaï', 'price' => 8.5],
    ['name' => 'Salami pepper', 'price' => 10],
    ['name' => 'Prosciutto', 'price' => 9],
    ['name' => 'Parmiggiana', 'price' => 9],
    ['name' => 'Vegetarian', 'price' => 8.5],
    ['name' => 'Four cheeses', 'price' => 10],
    ['name' => 'Four seasons', 'price' => 10.5],
    ['name' => 'Scampi', 'price' => 11.5]
];

$products = [
    ['name' => 'Water', 'price' => 1.8],
    ['name' => 'Sparkling water', 'price' => 1.8],
    ['name' => 'Cola', 'price' => 2],
    ['name' => 'Fanta', 'price' => 2],
    ['name' => 'Sprite', 'price' => 2],
    ['name' => 'Ice-tea', 'price' => 2.2],
];

$totalValue = 0;



require 'form-view.php';
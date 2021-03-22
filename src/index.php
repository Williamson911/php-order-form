<?php
//this line makes PHP behave in a more strict way
declare(strict_types=1);

session_start();

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

$totalValue = 0;

$email = $street = $streetNumber = $city = $zipcode = "";
$emailErr = $streetErr = $streetNumberErr = $cityErr = $zipcodeErr = "";
$invalidEmail = $streetNumberIntErr = $zipcodeIntErr = "";

    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        if (empty($_POST['email'])) {
            $emailErr = "* Email is required";
        } else {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $email = $_POST['email'];}
            else {
                $invalidEmail = "* " . $_POST['email'] . " Invalid email";

             }
        }


        if (empty($_POST['street'])) {
            $streetErr = "*  Street is required";
        } else {
            $street = $_POST['street'];
        }

        if (empty($_POST['streetnumber'])) {
            $streetNumberErr = "*  Street number is required";
        } else {
            if(filter_var($_POST['streetnumber'], FILTER_VALIDATE_INT)) {
            $streetNumber = $_POST['streetnumber'];
        } else {
             $streetnumberIntErr = "* Street number must be a number";
            }
        }


        if (empty($_POST['city'])) {
            $cityErr = "* City is required";
        } else {
            $city = $_POST['city'];
        }

        if (empty($_POST['zipcode'])) {
            $zipcodeErr = "* Zip code is required";
        }  else {
            if(filter_var($_POST['zipcode'], FILTER_VALIDATE_INT)) {
                $zipcode = $_POST['zipcode'];
            } else {
                $zipcodeIntErr = "* Zipcode must be a number";
            }
        }
    }


//your products with their price.
$pizzas = [
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

$drinks = [
    ['name' => 'Water', 'price' => 1.8],
    ['name' => 'Sparkling water', 'price' => 1.8],
    ['name' => 'Cola', 'price' => 2],
    ['name' => 'Fanta', 'price' => 2],
    ['name' => 'Sprite', 'price' => 2],
    ['name' => 'Ice-tea', 'price' => 2.2],
];


//pizzas as deault
$products = $pizzas;

if (isset($_GET['food'])) {
    $value = $_GET['food'];
    if ($value == 'drinks') {
        $products = $drinks;
    }
};

// Time
$localHour = date_create('now', new DateTimeZone('Europe/Brussels'))->format('G:i');

// check if express delivery is enabled
$standardDeliveryTime = date("G:i", strtotime('+1 hour', strtotime($localHour)));
$expressDeliveryTime = date("G:i", strtotime('+30 minutes', strtotime($localHour)));

if (isset($_POST['express_delivery'])) {
    $deliveryTime = $expressDeliveryTime;
    $totalValue += 5;
} else {
    $deliveryTime = $standardDeliveryTime;
}

// total price
if (isset($_POST['products'])) {
    $selectedProducts = $_POST['products'];

    foreach ($selectedProducts AS $i => $choice) {
        $choice = $products[$i]['price'];
        $totalValue += $choice;
    }
    $_SESSION['total-price'] = $totalValue;
}

// correct form
if (isset($email, $street, $streetNumber, $city, $zipcode, $totalValue, $deliveryTime)) {
    $correctForm = "Your order placed with the email '$email' for &euro; $totalValue has been sent to the following address: $street $streetNumber, $city $zipcode. Delivery is expected at: $deliveryTime";

// session
    $_SESSION["address"] = "$street $streetNumber, $city $zipcode";
}
require 'form-view.php';
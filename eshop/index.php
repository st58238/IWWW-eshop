<?php require_once('../php/user.class.php'); require_once('../php/database.php'); require_once('../php/html.php'); require_once('../php/control.php'); ?>
<?php if (empty(session_id())) {session_start();}; ?>
<?php
ob_start();

if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = array();
}

$db = new DB("mysql", "localhost", "iwww-eshop", "utf8mb4", "root", "");

$catalog = array();

$stmt = $db->query("SELECT * FROM zbozi", array());
foreach ($stmt as $key => $value) {
  array_push($catalog, $value);
}
unset($stmt);

function getBy($att, $value, $array) {
  foreach ($array as $key => $val) {
    if ($val[$att] == $value) {
      return $key;
    }
  }
  return null;
}

if (isset($_GET["action"])) {
  if ($_GET["action"] == "add" && !empty($_GET["id"])) {
      addToCart($_GET["id"]);
      header("Location: kosik/");
  }

  if ($_GET["action"] == "remove" && !empty($_GET["id"])) {
      removeFromCart($_GET["id"]);
      header("Location: kosik/");
  }

  if ($_GET["action"] == "delete" && !empty($_GET["id"])) {
      deleteFromCart($_GET["id"]);
      header("Location: kosik/");
  }
}

function addToCart($productId)
{
    if (!array_key_exists($productId, $_SESSION["cart"])) {
        $_SESSION["cart"][$productId]["quantity"] = 1;
    } else {
        $_SESSION["cart"][$productId]["quantity"]++;
    }
}

function removeFromCart($productId)
{
    if (array_key_exists($productId, $_SESSION["cart"])) {
        if ($_SESSION["cart"][$productId]["quantity"] <= 1) {
            unset($_SESSION["cart"][$productId]);
        } else {
            $_SESSION["cart"][$productId]["quantity"]--;
        }
    }
}

function deleteFromCart($productId)
{
    unset($_SESSION["cart"][$productId]);
}


?>

<html>
<head>
  <base href="../">
  <title>Košík</title>
  <link rel="stylesheet" href="css/main.css">
  <style>
    .user > * {
      width: 80%;
    }

    #catalog-items {
      max-width: 100%;
    }
  </style>
</head>
<body>
<div class="background"></div>
<div class="main">
  <?php echo SIDEPANEL; ?>
  <div class="user">
      <section>
        <h2>Eshop</h2>
<section id="catalog-items">

    <?php
    

    foreach ($catalog as $item) {
        echo '
<div class="catalog-item">
<div class="catalog-img">
' . $item["img"] . '
</div>
<h3>
' . $item["name"] . '
</h3>
<div>
' . number_format($item["price"], 2, ",", "") . ' Kč,-
</div>
<a href="kosik/?action=add&id=' . $item["id"] . '" class="catalog-buy-button">
Přidat do košíku
</a>
</div>';

    }

    ?>
</section>
</div>
</div>
</body>
</html>
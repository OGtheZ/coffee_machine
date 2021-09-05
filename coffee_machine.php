<?php

$customer = new stdClass();
$customer->wallet = [
    200 => 1,
    100 => 3,
    50 => 4,
    20 => 10,
    10 => 10,
    5 => 10,
    2 => 10,
    1 => 10,
];

function createProduct(string $name, int $price): stdClass
{
    $product = new stdClass();
    $product->name = $name;
    $product->price = $price;

    return $product;
}

$products = [
    createProduct("Latte", 150),
    createProduct("Espresso", 250),
    createProduct("Black Coffee", 120),
    createProduct("Hot CoCo", 100),
];

echo "Welcome to the Coffee Shop!" . PHP_EOL;
echo "The options are: " . PHP_EOL;
foreach($products as $id => $item) {
    $price = $item->price / 100;
    echo "[{$id}]" . "|" . "[{$item->name}]" . "|" . "[{$price} $]" . PHP_EOL;
}

$choiceIsLive = true;
while ($choiceIsLive) {
    $selection = readline("Enter selection! ");

    if (!is_numeric($selection) || !in_array($selection, array_keys($products))) {
        echo "Invalid selection!" . PHP_EOL;
        continue;
    } else {
        $choiceIsLive = false;
    }
}

$selectedProduct = $products[$selection];

$insertedCoins = 0;

while ($insertedCoins < $selectedProduct->price)
{
    echo "Amount left to insert: " . ($selectedProduct->price - $insertedCoins) / 100 . " $" . PHP_EOL;
    $coin = (int) readline('Insert coin: ');

    if (!in_array($coin, array_keys($customer->wallet)))
    {
        echo "Invalid coin!" . PHP_EOL;
        continue;
    }

    if (isset($customer->wallet[$coin]) && $customer->wallet[$coin] <= 0)
    {
        echo "Coin not found!";
        continue;
    }
    $customer->wallet[$coin] -= 1;

    $insertedCoins += $coin;
}

$return = $insertedCoins - $selectedProduct->price;
echo "Returning " . ($return / 100) . "$!" . PHP_EOL;

foreach ((array_keys($customer->wallet)) as $coin)
{
    $quantity = intdiv($return, $coin);
    $customer->wallet[$coin] += $quantity;
    $return -= $coin * $quantity;
    if ($quantity > 0) {
        echo "Returning $quantity of " . ($coin / 100) . " $ coins!" . PHP_EOL;
    }
}

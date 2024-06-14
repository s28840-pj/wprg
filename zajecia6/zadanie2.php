<?php

class Product {
    private $name;
    private $price;
    private $quantity;

    public function __construct($name, $price, $quantity) {
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }

    public function __toString() {
        return "Product: {$this->name}, Price: {$this->price}, Quantity: {$this->quantity}";
    }
}

class Cart {
    private $products;

    public function __construct() {
        $this->products = [];
    }

    public function addProduct(Product $product) {
        foreach ($this->products as $key => $existingProduct) {
            if ($existingProduct->getName() === $product->getName()) {
                $this->products[$key]->setQuantity($existingProduct->getQuantity() + $product->getQuantity());
                return;
            }
        }
        $this->products[] = $product;
    }

    public function removeProduct(Product $product) {
        foreach ($this->products as $key => $existingProduct) {
            if ($existingProduct->getName() === $product->getName()) {
                $quantity = $existingProduct->getQuantity() - $product->getQuantity();
                if ($quantity <= 0) {
                    unset($this->products[$key]);
                } else {
                    $this->products[$key]->setQuantity($quantity);
                }
                return;
            }
        }
    }

    public function getTotal() {
        $total = 0;
        foreach ($this->products as $product) {
            $total += $product->getPrice() * $product->getQuantity();
        }
        return $total;
    }

    public function __toString() {
        $output = "Products in cart:<br>";
        foreach ($this->products as $product) {
            $output .= $product . "<br>";
        }
        $output .= "Total price: " . $this->getTotal();
        return $output;
    }
}

$product1 = new Product("Laptop", 1500, 1);
$product2 = new Product("Mouse", 50, 2);

$cart = new Cart();
$cart->addProduct($product1);
$cart->addProduct($product2);

echo $cart . "<br>";

$product3 = new Product("Laptop", 1500, 1);
$cart->addProduct($product3);

echo $cart . "<br>";

$cart->removeProduct(new Product("Mouse", 50, 1));

echo $cart . "<br>";

$cart->removeProduct(new Product("Laptop", 1500, 2));

echo $cart . "<br>";

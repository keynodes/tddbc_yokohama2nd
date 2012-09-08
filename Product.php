<?php

class Product
{
    private $name ;
    private $price;
    private $stock;

    public function __construct()
    {
    }

    public function setProductName($name)
    {
        $this->name = $name;
    }

    public function getProductName()
    {
        return $this->name;
    }

    public function setProductPrice($price)
    {
        $this->price = $price;
    }

    public function getProductPrice()
    {
        return $this->price;
    }

    public function setProductStock($stock)
    {
        $this->stock = $stock;
    }

    public function getProductStock()
    {
        return $this->stock;
    }

    public function increaseProductStock($num)
    {
        $this->stock += $num;
    }

    public function getProductInfo()
    {
        return array('name' => $this->name, 'price' => $this->price, 'stock' => $this->stock);
    }
}


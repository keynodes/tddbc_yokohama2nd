<?php

class Product
{
    private $name ;
    private $price;
    private $stock;

    public function __construct()
    {
        $this->name  = "コーラ";
        $this->price = 120;
        $this->stock = 5;
    }

    public function getProductInfo()
    {
        return array('name' => $this->name, 'price' => $this->price, 'stock' => $this->stock);
    }
}


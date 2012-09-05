<?php

require_once 'Product.php';

class VendingMachine
{
    private $receivedArray = array();
    private $whiteListMoney = array(10, 50, 100, 500, 1000);

    private $product;

    public function __construct()
    {
        $this->product = new Product();
    }

    public function totalAmount()
    {
        $amount = 0;
        foreach($this->receivedArray as $received)
        {
            $amount += $received;
        }
        return $amount;
    }

    public function receive($amount)
    {
        if (!in_array($amount, $this->whiteListMoney)){
            return $amount;
        }

        array_push($this->receivedArray, $amount);
    }

    public function refund()
    {
        $change = $this->receivedArray;
        $this->receivedArray = array();

        return $change;
    }

    public function setProductName($name)
    {
        $this->product->setProductName($name);
    }

    public function getProductName()
    {
        return $this->product->getProductName();
    }
    public function getProductInfo()
    {
        return $this->product->getProductInfo();
    }
}

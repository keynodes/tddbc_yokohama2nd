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

        // 初期状態をセット
        $this->product->setProductPrice(120);
        $this->product->setProductStock(5);
        $this->product->setProductName('コーラ');
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

    public function setProductPrice($price)
    {
        $this->product->setProductPrice($price);
    }

    public function getProductPrice()
    {
        return $this->product->getProductPrice();
    }

    public function setProductStock($stock)
    {
        $this->product->setProductStock($stock);
    }

    public function getProductStock()
    {
        return $this->product->getProductStock();
    }

    public function getProductInfo()
    {
        return $this->product->getProductInfo();
    }

    public function getSaleAmount() {
        return 0;
    }

    public function isPurchasable()
    {
        if($this->product->getProductPrice() <= $this->totalAmount()) {

            return '購入可能';
        }

        return '購入不可';
    }
}

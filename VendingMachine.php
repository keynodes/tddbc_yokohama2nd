<?php

require_once 'Product.php';

class VendingMachine
{
    private $receivedArray = array();
    private $whiteListMoney = array(10, 50, 100, 500, 1000);

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

        // 払い戻しした後の処理がない。
        return $change;
    }

    public function getProductInfo()
    {
        $product = new Product();
        return $product->getProductInfo();
    }
}

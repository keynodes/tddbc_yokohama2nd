<?php

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
        // 払い戻しした後の処理がない。
        return $this->receivedArray;
    }

    public function getProductInfo()
    {
    }
}

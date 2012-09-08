<?php

require_once 'Product.php';

class VendingMachine
{
    private $received       = 0;
    private $whiteListMoney = array(10, 50, 100, 500, 1000);

    private $product;
    private $saleAmount;

    public function __construct()
    {
        $this->product = new Product();

        // 初期状態をセット
        $this->product->setProductPrice(120);
        $this->product->setProductStock(5);
        $this->product->setProductName('コーラ');
        $this->saleAmount = 0;
    }

    public function totalAmount()
    {
        return $this->received;
    }

    public function receive($amount)
    {
        if (!in_array($amount, $this->whiteListMoney)){
            return $amount;
        }

        $this->received += $amount;
    }

    public function refund()
    {
        $change = $this->totalAmount();
        $this->received = 0;

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
        return $this->saleAmount;
    }

    public function addSaleAmount($saleAmount) {
        $this->saleAmount += $saleAmount;
    }

    public function isPurchasable()
    {
        if($this->product->getProductPrice() <= $this->totalAmount() &&
            $this->product->getProductStock() > 0
        ) {

            return true;
        }

        return false;
    }

    public function purchse()
    {
        if(!$this->isPurchasable())
        {
            return false;
        }

        // 在庫を減らす
        $stock = $this->product->getProductStock();
        $stock--;
        $this->product->setProductStock($stock);

        // 売上金に加算
        $saleAmount = $this->getProductPrice();
        $this->addSaleAmount($saleAmount);

        // 総計から減算
        $this->received -= $saleAmount;

        return true;

    }

    public function increaseProductStock($num)
    {
       $this->product->increaseProductStock($num);
    }

    public function reduceProductStock($num)
    {
       $this->product->reduceProductStock($num);
    }
}

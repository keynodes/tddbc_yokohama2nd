<?php

require_once 'Product.php';

class VendingMachine
{
    private $whiteListMoney = array(10, 50, 100, 500, 1000);

    private $productList;
    private $saleAmount;
    private $received;

    public function __construct($productList)
    {
        foreach($productList as $product) {
            $this->productList[] = new Product($product);
        }

        // お金に関する情報をセット
        $this->saleAmount = 0;
        $this->received   = 0;
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

    public function getProductPrice($name)
    {
        foreach($this->productList as $product) {
            if ($product->getProductName() === $name) {
                return $product->getProductPrice();
            }
        }
        return false;
    }

    public function setProductStock($name, $stock)
    {
        foreach($this->productList as $product) {
            if ($product->getProductName() === $name) {
                $product->setProductStock($stock);

                return true;
            }
        }
    }

    public function getProductStock($name)
    {
        foreach($this->productList as $product) {
            if ($product->getProductName() === $name) {
                return $product->getProductStock();
            }
        }
        return false;
    }

    public function getProductInfo($name)
    {
        foreach($this->productList as $product) {
            if ($product->getProductName() === $name) {
                return $product->getProductInfo();
            }
        }
        return false;
    }

    public function getSaleAmount() {
        return $this->saleAmount;
    }

    public function addSaleAmount($saleAmount) {
        $this->saleAmount += $saleAmount;
    }

    public function isPurchasable($name)
    {
        foreach($this->productList as $product) {
            if ($product->getProductName() === $name) {

                if($product->getProductPrice() <= $this->totalAmount() &&
                    $product->getProductStock() > 0
                ) {
                    return true;
                }
            }
        }

        return false;
    }

    public function purchse($name)
    {
        foreach($this->productList as $product) {
            if ($product->getProductName() === $name) {

                if(!$this->isPurchasable($name))
                {
                    return false;
                }

                // 在庫を減らす
                $product->reduceProductStock(1);

                // 売上金に加算
                $saleAmount = $product->getProductPrice();
                $this->addSaleAmount($saleAmount);

                // 総計から減算
                $this->received -= $saleAmount;

                return true;
            }
        }
    }

    public function increaseProductStock($name, $num)
    {
        $product = $this->getInstanceByName($name);
        if($product instanceof Product) {
            $product->increaseProductStock($num);

            return $product->getProductStock();
        }

        return false;
    }

    public function reduceProductStock($name, $num)
    {
        $product = $this->getInstanceByName($name);
        if($product instanceof Product) {
            $product->reduceProductStock($num);

            return $product->getProductStock();
        }

        return false;
    }

    public function getProductList()
    {
        $productList = array();
        foreach($this->productList as $product) {
            $productList[] = $product->getProductInfo();
        }
        return $productList;
    }

    public function getInstanceByName($name)
    {
        foreach($this->productList as $product) {
            if ($product->getProductName() === $name) {
                return $product;
            }
        }
        return null;
    }
}

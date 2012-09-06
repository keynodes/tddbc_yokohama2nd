<?php
require_once 'VendingMachine.php';

class VendingMachineTest extends PHPUnit_Framework_TestCase
{
    private $vendingMachine;

    public function setUp()
    {
        $this->vendingMachine = new VendingMachine();
    }

    public function test何も投入しないとゼロ円が表示される()
    {
        $this->assertSame(0, $this->vendingMachine->totalAmount());
    }

    public function test10円を投入すると総計が10円になる()
    {
        $this->vendingMachine->receive(10);
        $this->assertSame(10, $this->vendingMachine->totalAmount());
    }

    public function test10円と50円を投入すると総計が60円になる()
    {
        $this->vendingMachine->receive(10);
        $this->vendingMachine->receive(50);
        $this->assertSame(60, $this->vendingMachine->totalAmount());
    }

    public function test何も投入していない時払い戻しで空が返る()
    {
        $this->assertEmpty($this->vendingMachine->refund());
    }

    public function test10円を投入した時払い戻しで10円が表示される()
    {
        $this->vendingMachine->receive(10);
        $this->assertSame(array(10), $this->vendingMachine->refund());
    }

    public function test100円と1000円札を投入して払い戻すと100円と1000円札が返ってくる()
    {
        $this->vendingMachine->receive(100);
        $this->vendingMachine->receive(1000);
        $this->assertSame(array(100,1000), $this->vendingMachine->refund());
    }

    public function test払い戻し後の総計は0円になる()
    {
        $this->vendingMachine->receive(100);
        $this->assertSame(array(100), $this->vendingMachine->refund());
        $this->assertSame(0,   $this->vendingMachine->totalAmount());
    }

    public function test10円投入後に1円投入すると想定外として1円が返却されて総額は10円になる()
    {
        $this->vendingMachine->receive(10);
        $this->assertSame(1, $this->vendingMachine->receive(1));
        $this->assertSame(10, $this->vendingMachine->totalAmount());
    }

    public function testジュースの情報を取得すると初期状態の情報が返却される()
    {
       $this->assertSame(array('name' => 'コーラ', 'price' => 120, 'stock' => 5), $this->vendingMachine->getProductInfo());
    }

    public function testジュースの名前を設定できる()
    {
        $this->vendingMachine->setProductName('ダイエットコーラ');
        $this->assertSame('ダイエットコーラ', $this->vendingMachine->getProductName());
    }

    public function test初期状態のジュースの値段は120円()
    {
        $this->assertSame(120, $this->vendingMachine->getProductPrice());
    }

    public function testジュースの価格を150円に設定する()
    {
        $this->vendingMachine->setProductPrice(150);
        $this->assertSame(150, $this->vendingMachine->getProductPrice());
    }

    public function test初期状態のジュースの在庫は5本()
    {
        $this->assertSame(5, $this->vendingMachine->getProductStock());

    }

    public function testジュースの在庫を10本に設定する()
    {
        $this->vendingMachine->setProductStock(10);
        $this->assertSame(10, $this->vendingMachine->getProductStock());
    }

    public function test販売していない状態での売上金額は0円となる()
    {
        $this->assertSame(0, $this->vendingMachine->getSaleAmount());
    }
}

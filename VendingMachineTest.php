<?php
require_once 'VendingMachine.php';

class VendingMachineTest extends PHPUnit_Framework_TestCase
{
    private $vendingMachine;

    public function setUp()
    {
        $productList[] = array("name" => "コーラ",      "price" => 120, "stock" => 5);
        $productList[] = array("name" => "レッドブル",  "price" => 200, "stock" => 5);
        $productList[] = array("name" => "水",          "price" => 100, "stock" => 5);
        $this->vendingMachine = new VendingMachine($productList);
    }

    /**
     * 総計表示に関するテスト
     */
    public function test何も投入しないとゼロ円が表示される()
    {
        $this->assertSame(0, $this->vendingMachine->totalAmount());
    }

    /**
     * 投入に関するテスト
     */
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

    /**
     * 払い戻しに関するテスト
     */
    public function test何も投入していない時払い戻すと0円が返る()
    {
        $this->assertSame(0, $this->vendingMachine->refund());
    }

    public function test10円を投入した時払い戻しで10円が表示される()
    {
        $this->vendingMachine->receive(10);
        $this->assertSame(10, $this->vendingMachine->refund());
    }

    public function test100円と1000円札を投入して払い戻すと1100円が返ってくる()
    {
        $this->vendingMachine->receive(100);
        $this->vendingMachine->receive(1000);
        $this->assertSame(1100, $this->vendingMachine->refund());
    }

    public function test払い戻し後の総計は0円になる()
    {
        $this->vendingMachine->receive(100);
        $this->assertSame(100, $this->vendingMachine->refund());
        $this->assertSame(0,   $this->vendingMachine->totalAmount());
    }

    public function test10円投入後に1円投入すると想定外として1円が返却されて総額は10円になる()
    {
        $this->vendingMachine->receive(10);
        $this->assertSame(1, $this->vendingMachine->receive(1));
        $this->assertSame(10, $this->vendingMachine->totalAmount());
    }

    /**
     * ジュースの状態に関するテスト
     */
    public function test商品の一覧を取得すると商品一覧の配列が返る()
    {
        $expectedArray[] = array("name" => "コーラ",      "price" => 120, "stock" => 5);
        $expectedArray[] = array("name" => "レッドブル",  "price" => 200, "stock" => 5);
        $expectedArray[] = array("name" => "水",          "price" => 100, "stock" => 5);

        $this->assertSame($expectedArray, $this->vendingMachine->getProductList());
    }

    public function test商品名を指定して商品の情報を取得できる()
    {
        $this->assertSame(array('name' => 'コーラ', 'price' => 120, 'stock' => 5), $this->vendingMachine->getProductInfo("コーラ"));
    }

    public function test存在しない商品の情報を取得すると空の配列が返る()
    {
        $this->assertEmpty($this->vendingMachine->getProductInfo("ダイエットコーラ"));
    }

    /**
     * ジュースの価格に関するテスト
     */
    public function test初期状態の水の価格は100円()
    {
        $this->assertSame(100, $this->vendingMachine->getProductPrice("水"));
    }

    /**
     * ジュースの在庫に関するテスト
     */
    public function test初期状態のレッドブルの在庫は5本()
    {
        $this->assertSame(5, $this->vendingMachine->getProductStock("レッドブル"));
    }

    public function testジュースの在庫を10本に設定する()
    {
        $this->vendingMachine->setProductStock("水", 10);
        $this->assertSame(10, $this->vendingMachine->getProductStock("水"));
    }

    public function test初期状態からコーラの在庫を1増やすと在庫が6になる()
    {
        $this->vendingMachine->increaseProductStock("コーラ", 1);
        $this->assertSame(6, $this->vendingMachine->getProductStock("コーラ"));
    }

    public function test初期状態からコーラの在庫を1減らすと在庫が4になる()
    {
        $this->vendingMachine->reduceProductStock("コーラ", 1);
        $this->assertSame(4, $this->vendingMachine->getProductStock("コーラ"));
    }

    public function test水の在庫が0の状態で在庫を減らすと何も起こらない()
    {
        $this->vendingMachine->reduceProductStock("水", 5);
        $this->vendingMachine->reduceProductStock("水", 1);
        $this->assertSame(0, $this->vendingMachine->getProductStock("水"));
    }

    /**
     * 売上金額に関するテスト
     */
    public function test販売していない状態での売上金額は0円となる()
    {
        $this->assertSame(0, $this->vendingMachine->getSaleAmount());
    }

    public function test初期状態で購入操作を行うと売上金は0円である()
    {
        $this->assertSame(0, $this->vendingMachine->getSaleAmount());
    }

    /**
     * 購入可能かの判定に関するテスト
     */
    public function test初期状態で150円投入しコーラが購入できるか確認するとtrue()
    {
        $this->vendingMachine->receive(50);
        $this->vendingMachine->receive(100);

        $this->assertTrue($this->vendingMachine->isPurchasable("コーラ"));
    }

    public function test初期状態で150円投入しレッドブルが購入できるか確認するとfalse()
    {
        $this->vendingMachine->receive(150);

        $this->assertFalse($this->vendingMachine->isPurchasable("レッドブル"));

    }

    /**
     * 購入操作に関するテスト
     */
    public function test投入金額不足時にコーラを購入操作をすると何も起こらない()
    {
        $this->assertFalse($this->vendingMachine->purchse("コーラ"));
    }

    public function test在庫不足時に購入操作をすると何も起こらない()
    {
        $this->vendingMachine->reduceProductStock("レッドブル", 10);
        $this->assertSame(0, $this->vendingMachine->getProductStock("レッドブル"));
        $this->assertFalse($this->vendingMachine->purchse("レッドブル"));
    }

    public function test初期状態で150円投入し購入操作を行うと売上金120円、ジュースの在庫4本、払い戻し金30円になる()
    {
        $this->vendingMachine->receive(50);
        $this->vendingMachine->receive(100);
        $this->vendingMachine->purchse("コーラ");

        $this->assertSame(  4, $this->vendingMachine->getProductStock("コーラ"));
        $this->assertSame(120, $this->vendingMachine->getSaleAmount());
        $this->assertSame( 30, $this->vendingMachine->refund());
    }
}

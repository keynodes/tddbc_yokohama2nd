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

    public function test商品の一覧を取得すると商品一覧の配列が返る()
    {
        $expectedArray[] = array("name" => "コーラ",      "price" => 120, "stock" => 5);
        $expectedArray[] = array("name" => "レッドブル",  "price" => 200, "stock" => 5);
        $expectedArray[] = array("name" => "水",          "price" => 100, "stock" => 5);

        $this->assertSame($expectedArray, $this->vendingMachine->getProductList());
    }


    /**
     * ジュースの状態に関するテスト
     */

/*
    public function testジュースの情報を取得すると初期状態の情報が返却される()
    {
       $this->assertSame(array('name' => 'コーラ', 'price' => 120, 'stock' => 5), $this->vendingMachine->getProductInfo());
    }

    public function testジュースの名前を設定できる()
    {
        $this->vendingMachine->setProductName('ダイエットコーラ');
        $this->assertSame('ダイエットコーラ', $this->vendingMachine->getProductName());
   }
*/

    /**
     * ジュースの価格に関するテスト
     */
/*
    public function test初期状態のジュースの価格は120円()
    {
        $this->assertSame(120, $this->vendingMachine->getProductPrice());
    }

    public function testジュースの価格を150円に設定する()
    {
        $this->vendingMachine->setProductPrice(150);
        $this->assertSame(150, $this->vendingMachine->getProductPrice());
    }
*/
    /**
     * ジュースの在庫に関するテスト
     */
/*
    public function test初期状態のジュースの在庫は5本()
    {
        $this->assertSame(5, $this->vendingMachine->getProductStock());
    }

    public function testジュースの在庫を10本に設定する()
    {
        $this->vendingMachine->setProductStock(10);
        $this->assertSame(10, $this->vendingMachine->getProductStock());
    }

    public function test初期状態から在庫を1増やすと在庫が6になる()
    {
        $this->vendingMachine->increaseProductStock(1);
        $this->assertSame(6, $this->vendingMachine->getProductStock());
    }

    public function test初期状態から在庫を1減らすと在庫が4になる()
    {
        $this->vendingMachine->reduceProductStock(1);
        $this->assertSame(4, $this->vendingMachine->getProductStock());
    }

    public function test在庫0の状態で在庫を減らすと何も起こらない()
    {
        $this->vendingMachine->reduceProductStock(5);
        $this->vendingMachine->reduceProductStock(1);
        $this->assertSame(0, $this->vendingMachine->getProductStock());
    }
*/
    /**
     * 売上金額に関するテスト
     */
/*
    public function test販売していない状態での売上金額は0円となる()
    {
        $this->assertSame(0, $this->vendingMachine->getSaleAmount());
    }

    public function test初期状態で購入操作を行うと売上金は0円である()
    {
        $this->assertSame(0, $this->vendingMachine->getSaleAmount());
    }
 */
    /**
     * 購入可能かの判定に関するテスト
     */
/*
    public function test初期状態で150円投入し購入できるか確認するとtrue()
    {
        $this->vendingMachine->receive(50);
        $this->vendingMachine->receive(100);

        $this->assertTrue($this->vendingMachine->isPurchasable());
    }

    public function test初期状態で100円投入し購入できるか確認するとfalse()
    {
        $this->vendingMachine->receive(100);

        $this->assertFalse($this->vendingMachine->isPurchasable());

    }
 */
    /**
     * 購入操作に関するテスト
     */
/*
    public function test投入金額不足時に購入操作をすると何も起こらない()
    {
        $this->assertFalse($this->vendingMachine->purchse());
    }

    public function test在庫不足時に購入操作をすると何も起こらない()
    {
        $this->vendingMachine->reduceProductStock(10);
        $this->assertSame(0, $this->vendingMachine->getProductStock());
        $this->assertFalse($this->vendingMachine->purchse());
    }

    public function test初期状態で150円投入し購入操作を行うと売上金120円、ジュースの在庫4本、払い戻し金30円になる()
    {
        $this->vendingMachine->receive(50);
        $this->vendingMachine->receive(100);
        $this->vendingMachine->purchse();

        $this->assertSame(  4, $this->vendingMachine->getProductStock());
        $this->assertSame(120, $this->vendingMachine->getSaleAmount());
        $this->assertSame( 30, $this->vendingMachine->refund());
    }
 */
}

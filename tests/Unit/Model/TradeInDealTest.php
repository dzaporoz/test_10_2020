<?php

namespace App\Tests\Unit\Model;


use App\Showroom\Model\CarModel\CarModel;
use App\Showroom\Model\TradeInDeal\TradeInDeal;
use App\Tests\Fixture\CarModelFixture;
use PHPUnit\Framework\TestCase;

class TradeInDealTest extends TestCase
{
    protected CarModelFixture $carModelFixture;

    public function setUp()
    {
        $this->carModelFixture = new CarModelFixture();
    }

    /**
     * @test
     */
    public function itShouldSetTradeInPrice()
    {
        $carModel = $this->carModelFixture->get(CarModelFixture::DEFAULT_MODEL);

        $tradeInDeal = new TradeInDeal();
        $tradeInDeal->setCustomerCarModel($carModel);

        $this->assertInstanceOf(CarModel::class, $tradeInDeal->getCustomerCarModel());
        $this->assertEquals(
            $tradeInDeal->getCustomerCarModel()->getPrice()->getTradeInPrice(),
            $tradeInDeal->getCustomerCarPrice()
        );
    }

    /**
     * @test
     */
    public function itShouldSetShowroomPrice()
    {
        $carModel = $this->carModelFixture->get(CarModelFixture::MODEL_WITHOUT_TRADE_IN);

        $tradeInDeal = new TradeInDeal();
        $tradeInDeal->setShowroomCarModel($carModel);

        $this->assertInstanceOf(CarModel::class, $tradeInDeal->getShowroomCarModel());
        $this->assertEquals(
            $tradeInDeal->getShowroomCarModel()->getPrice()->getPrice(),
            $tradeInDeal->getShowroomCarPrice()
        );
    }
}

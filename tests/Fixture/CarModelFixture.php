<?php


namespace App\Tests\Fixture;


use App\Showroom\Model\CarModel\CarModel;
use App\Showroom\Model\CarModel\CarPrice;

class CarModelFixture
{
    const DEFAULT_MODEL = 'default';
    const MODEL_WITHOUT_TRADE_IN = 'no_trade_in';

    public function get(string $carModelType)
    {
        switch ($carModelType) {
            case self::DEFAULT_MODEL:
                $carModel = new CarModel();
                $carModel->setManufacturerName('Opel');
                $carModel->setModelName('Insignia');
                $carModel->setClass('D');
                $price = new CarPrice();
                $price->setPrice(22000.40);
                $price->setTradeInPrice(12040.51);
                $price->setCarModel($carModel);
                $carModel->setPrice($price);
                return $carModel;
            case self::MODEL_WITHOUT_TRADE_IN:
                $carModel = new CarModel();
                $carModel->setManufacturerName('ZAZ');
                $carModel->setModelName('Slavuta');
                $carModel->setClass('B');
                $price = new CarPrice();
                $price->setPrice(2044.99);
                $price->setCarModel($carModel);
                $carModel->setPrice($price);
                return $carModel;
        }
    }
}
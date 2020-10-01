<?php

namespace App\DataFixtures;

use App\Showroom\Model\CarModel\CarModel;
use App\Showroom\Model\CarModel\CarPrice;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CarModelFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Manufacturer, Model, Class, Sell price, Trade-in price
        $data = 'BMW;1 Series;C;19000;11250
                 BMW;3 Series;D;29700;19450
                 BMW;5 Series;E;41200;30050.21
                 BMW;7 Series;F;70837;42450.65
                 BMW;Z4;S;44970;30092
                 Audi;A1;A;25000;16786.6
                 Audi;A3;C;31980;21168.5
                 Audi;A6;E;49350;36150.49
                 Audi;A8;F;87940;51987.4
                 Bugatti;Chiron;S;2987000;
                 Chevrolet;Spark;A;9500;
                 Chevrolet;Impala;E;13800;2300
                 Chevrolet;Camaro;S;35650;21800
                 Chevrolet;Orlando;M;27920;
                 Chevrolet;Suburban;J;45975;31850
                 Kia;Rio;B;11400;2198.7
                 Mercedes-Benz;A-class;C;36740;25013.5
                 Mercedes-Benz;C-class;D;41220;31690
                 Mercedes-Benz;E-class;E;67980;49351.2
                 Mercedes-Benz;S-class;F;95671;59371
                 Toyota;Corolla;C;14300;5900
                 Toyota;Camry;D;31050;19850
                 Toyota;Sienna;M;29080;13200.49
                 Toyota;RAV4;J;27038.5;16894.2';

        foreach (explode(PHP_EOL, $data) as $carModelDataLine) {
            $carModelData = str_getcsv(trim($carModelDataLine), ';');
            $carModel = new CarModel();
            $carModel->setManufacturerName($carModelData[0]);
            $carModel->setModelName($carModelData[1]);
            $carModel->setClass($carModelData[2]);

            $carPrice = new CarPrice();
            $carPrice->setCarModel($carModel);
            $carPrice->setPrice($carModelData[3]);
            $carPrice->setTradeInPrice($carModelData[4] ?: null);

            $manager->persist($carModel);
            $manager->persist($carPrice);
        }

        $manager->flush();
    }
}

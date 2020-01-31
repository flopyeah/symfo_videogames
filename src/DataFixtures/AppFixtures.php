<?php

namespace App\DataFixtures;

use App\Entity\Console;
use App\Entity\JeuVideo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $consolePS4 = new Console();
        $consolePS4->setNom('Playstation 4')
                ->setMarque('Sony')
                ->setImage('https://media.playstation.com/is/image/SCEA/playstation-4-slim-vertical-product-shot-01-us-07sep16?$native_t$');
         $manager->persist($consolePS4);

        $consoleSW = new Console();
        $consoleSW->setNom('Switch')
            ->setMarque('Nintendo')
            ->setImage('https://www.ma-reduc.com/upload/cfs/CMS/Page/Nintendo/Switch/test%20console/switch-prez_opt5d7ebd05a5a4c8.17475073.jpg');
        $manager->persist($consoleSW);

        $consoleXB = new Console();
        $consoleXB->setNom('XBox')
            ->setMarque('Microsoft')
            ->setImage('https://img-prod-cms-rt-microsoft-com.akamaized.net/cms/api/am/imageFileData/RWvb19?ver=d602&q=90&m=6&h=400&w=800&b=%23FFFFFFFF&f=jpg&o=f&aim=true');
        $manager->persist($consoleXB);

        $jeuVideo = new JeuVideo();
        $jeuVideo->setTitre('GTA V')
                    ->setImage('https://images-na.ssl-images-amazon.com/images/I/713f69-28ZL._AC_SY500_.jpg')
                    ->setPrix(50.99)
                    ->setDateSortie(new \DateTime('2017-08-30'))
                    ->addConsole($consolePS4)
                    ->addConsole($consoleXB)
                    ;
        $manager->persist($jeuVideo);

        $jeuVideo = new JeuVideo();
        $jeuVideo->setTitre('Mario Switch')
            ->setImage('https://cdn.cdkeys.com/500x706/media/catalog/product/n/e/new-super-mario-bros-u-deluxe-switch.jpg')
            ->setPrix(50.99)
            ->setDateSortie(new \DateTime('2018-08-30'))
            ->addConsole($consoleSW)
        ;
        $manager->persist($jeuVideo);

        $jeuVideo = new JeuVideo();
        $jeuVideo->setTitre('FIFA 2020')
            ->setImage('https://images-na.ssl-images-amazon.com/images/I/61VuGTQJvWL._AC_SX385_.jpg')
            ->setPrix(50.99)
            ->setDateSortie(new \DateTime('2019-11-30'))
            ->addConsole($consolePS4)
            ->addConsole($consoleXB)
            ->addConsole($consoleSW)
        ;
        $manager->persist($jeuVideo);

        $manager->flush();
    }
}

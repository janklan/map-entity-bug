<?php

namespace App\DataFixtures;

use App\Entity\Another;
use App\Entity\First;
use App\Entity\Foo;
use App\Entity\Second;
use App\Entity\Third;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $id = 1;
        foreach(range(1, 2) as $number) {
            $first = new Foo($id++);
            $first->setName('Root '.$number);
            $first->setRoot($first);
            $manager->persist($first);

            $second = new Foo($id++);
            $second->setName('Parent '.$number);
            $second->setParent($first);
            $manager->persist($second);

            $third = new Foo($id++);
            $third->setName('Child '.$number);
            $third->setParent($second);
            $manager->persist($third);
        }

        $manager->flush();
    }
}

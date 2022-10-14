<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

final class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $categories = ['boots', 'men', 'women', 'electronics', 'kitchen'];
        // create test products.
        for ($i = 0; $i < 20; $i++) {
            $product = new Product();
            $product->setName($faker->sentence(2));
            $product->setCost($faker->randomNumber(5, 1, 1000));
            $product->setCategory($categories[array_rand($categories)]);
            $product->setSku('00000' . $faker->randomDigitNotZero());
            $manager->persist($product);
        }

        $manager->flush();
    }
}

<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Manager;
use App\Entity\HolidayRequest;
use App\Entity\Worker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use DateTime;

final class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        // create test workers.
        for ($i = 0; $i < 10; $i++) {
            $worker = new Worker();
            $worker->setName($faker->name);
            $worker->setLeaveBalance($faker->unique()->randomDigit());
            $manager->persist($worker);
        }

        // create test mangers.
        for ($i = 0; $i < 5; $i++) {
            $workerManager = new Manager();
            $workerManager->setName($faker->name);
            $manager->persist($workerManager);
        }

        $status = ['approved', 'rejected', 'pending'];
        // create test requests.
        for ($i = 0; $i < 15; $i++) {
            $request = new HolidayRequest();
            $request->setAuthor(rand(1, 9));
            $request->setResolvedBy(rand(1, 4));
            $request->setStatus($status[array_rand($status)]);
            $request->setRequestCreatedAt(new DateTime());

            $request->setVacationStartDate((new DateTime())->setTimestamp(rand(1666216800, 1666648800))
            );

            $request->setVacationEndDate((new DateTime())->setTimestamp(rand(1666821600, 1668034800))
            );

            $manager->persist($request);
        }

        $manager->flush();
    }
}

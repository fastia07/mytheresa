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

        $listWorkers = [];
        $listManagers = [];
        // create test workers.
        for ($i = 0; $i < 10; $i++) {
            $worker = new Worker();
            $worker->setName($faker->name);
            $worker->setLeaveBalance($faker->unique()->randomDigit());
            $manager->persist($worker);
            $listWorkers[$i] = $worker;
        }

        // create test mangers.
        for ($i = 0; $i < 3; $i++) {
            $workerManager = new Manager();
            $workerManager->setName($faker->name);
            $manager->persist($workerManager);
            $listManagers[$i] = $workerManager;
        }

        $status = ['approved', 'rejected', 'pending'];
        // create test requests.
        for ($i = 0; $i < 15; $i++) {
            $request = new HolidayRequest();
            $request->setAuthor($listWorkers[rand(0,9)]);
            $request->setStatus($status[array_rand($status)]);
            if ($request->getStatus() != 'pending')
                $request->setResolvedBy($listManagers[rand(0,2)]);
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

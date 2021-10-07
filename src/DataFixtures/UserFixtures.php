<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $admin = (new User())
            ->setUsername('admin')
            ->setRoles(["ROLE_USER","ROLE_ADMIN"])
            ->setPassword('$2y$13$Gkj4g1DWVIsYcRZtTX7OHe6ZyDJeZngrL9irG7sHVe6gFUiq3o1nK')
            ->setPlainPassword('Not available if ROLE_ADMIN')
            ;
        $manager->persist($admin);

        $user1 = (new User())
            ->setUsername('user1')
            ->setRoles(["ROLE_USER","ROLE_ADMIN"])
            ->setPassword('$2y$13$t3kEbXQa1yCrlZYYxHFlsO1yIMZoTKK9laFVzzMIdfxK7gjJky3tK')
            ->setPlainPassword('Not available if ROLE_ADMIN')
            ;
        $manager->persist($user1);

        $user2 = (new User())
            ->setUsername('user2')
            ->setPassword('$2y$13$nACGzaqcHUJlYF12AmkYmurJxH1roBbSmv6aYoS8kGFyIv11qy.0y')
            ->setPlainPassword('0000')
            ;
        $manager->persist($user2);

        $user3 = (new User())
            ->setUsername('user3')
            ->setPassword('$2y$13$KdsAcDi.8hjBcOgtT1FSI.4rvGX6eYdBQyD3AlMdksvKCpImzKROm')
            ->setPlainPassword('0000')
            ;
        $manager->persist($user3);

        $manager->flush();
    }
}

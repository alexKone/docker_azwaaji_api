<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\Profile;
use App\Entity\User;
use App\Enums\GenderEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i <= 100; $i++) {
            $address = new Address();
            $address->setStreet($faker->streetAddress());
            $address->setCity($faker->city());
            $address->setZipcode($faker->postcode());
            $address->setCountry($faker->countryCode());

            $profile = new Profile();
            $profile->setLastname($faker->lastName());
            $profile->setBirthdate($faker->dateTimeBetween('-60 years', '-18 years'));
            $profile->setFirstname($faker->firstNameMale());
            $profile->setGender(GenderEnum::Male);
            $profile->setAddress($address);

            if ($i % 3 === 0) {
                $profile->setFirstname($faker->firstNameFemale());
                $profile->setGender(GenderEnum::Female);
            }

            $user = new User();
            $user->setEmail('profile_' . $i . '@mail.com');
            $user->setUsername($faker->userName());

            $password = $this->hasher->hashPassword($user, '000000');
            $user->setPassword($password);

            $user->setProfile($profile);

            $manager->persist($user);
        }

        $manager->flush();
    }
}

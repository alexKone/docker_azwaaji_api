<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\Information;
use App\Entity\Profile;
use App\Entity\User;
use App\Enums\GenderEnum;
use App\Enums\HijraEnum;
use App\Enums\MaritalStatusEnum;
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

        $maritalStatusArr = [
            MaritalStatusEnum::CELIBATE,
            MaritalStatusEnum::DIVORCED,
            MaritalStatusEnum::MARRIED,
            MaritalStatusEnum::WIDOWER,
        ];

        $hijraArr = [
            HijraEnum::YES,
            HijraEnum::NO,
            HijraEnum::MAYBE
        ];

        for ($i = 0; $i <= 100; $i++) {
            $address = new Address();
            $address->setStreet($faker->streetAddress());
            $address->setCity($faker->city());
            $address->setZipcode($faker->postcode());
            $address->setCountry($faker->countryCode());

            $information = new Information();
            $information->setSmoke(rand(true, false));
            $information->setMaritalStatus(array_rand($maritalStatusArr));
            $information->setHijra($hijraArr[rand(0, 2)]);
            $information->setChildren(rand(0, 8));
            $information->setSport($faker->text());
            $information->setDescription($faker->realText());
            $information->setProfileSought($faker->text(5000));

            $profile = new Profile();
            $profile->setLastname($faker->lastName());
            $profile->setBirthdate($faker->dateTimeBetween('-60 years', '-18 years'));
            $profile->setFirstname($faker->firstNameMale());
            $profile->setGender(GenderEnum::Male);

            $profile->setAddress($address);
            $profile->setInformation($information);

            if ($i % 3 === 0) {
                $profile->setFirstname($faker->firstNameFemale());
                $profile->setGender(GenderEnum::Female);
            }

            $createdDate = $faker->dateTimeBetween('-4 years', 'now');
            $lastLoginDate = $faker->dateTimeBetween($createdDate, 'now');

            $user = new User();
            $user->setEmail('profile_' . $i . '@mail.com');
            $user->setUsername($faker->userName());
            $user->setCreatedAt($createdDate);
            $user->setLastLogin($lastLoginDate);

            $password = $this->hasher->hashPassword($user, '000000');
            $user->setPassword($password);

            $user->setProfile($profile);

            $manager->persist($user);
        }

        $manager->flush();
    }
}

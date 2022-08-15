<?php

namespace App\DataFixtures;

use App\Entity\BlogPost;
use App\Entity\BlogPostLike;
use App\Entity\Category;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    /**
     * @var UserPasswordHasherInterface
     */
    private UserPasswordHasherInterface $passwordHasher;

    /**
     * @param UserPasswordHasherInterface $passwordHasher
     */
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {

        // Create 1 Admin
        $user = new User();
        $user->setEmail(sprintf('admin@mail.com'))
            ->setPassword($this->passwordHasher->hashPassword($user, "password"))
            ->setRoles(["ROLE_ADMIN"]);
        $manager->persist($user);

        // Create 20 Users

        $users = [];
        for ($i = 0; $i < 20; $i++) {
            $user = new User();
            $user->setEmail(sprintf('user%d@mail.com', $i))
                ->setPassword($this->passwordHasher->hashPassword($user, "password"));
            $manager->persist($user);
            $users[] = $user;
        }

        $categories = [];
        for ($l = 1; $l < 4; $l++) {
            $category = new Category();

            $category->setTitle(sprintf('categorie %d', $l));
            $manager->persist($category);
            $categories[] = $category;
        }

        $blogposts = [];
        for ($k = 1; $k < 20; $k++) {
            $blogpost = new BlogPost();
            $blogpost->setTitle(sprintf('titre%d', $k))
                    ->setContent('lorem')
                    ->setCreatedAt(new \DateTimeImmutable())
                    ->setUpdatedAt(new \DateTimeImmutable())
                    ->setCategory($categories[array_rand($categories)]);
            $manager->persist($blogpost);
            $blogposts[] = $blogpost;
        }

        for ($j = 0; $j < 20; $j++) {
            $like = new BlogPostLike();

            $like->setUser($users[array_rand($users)])
                ->setBlogpost($blogposts[array_rand($blogposts)]);
            $manager->persist($like);
        }

        $manager->flush();
    }
}

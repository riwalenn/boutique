<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {

        $user = new User();
        $user->setEmail('riwalenn@gmail.com');
        $password = $this->hasher->hashPassword($user, 'g9CRd5^11LHuuHg');
        $user->setPassword($password);
        $user->setIsVerified(1);
        $user->setRoles(["ROLE_ADMIN"]);

        $manager->persist($user);

        $user = new User();
        $user->setEmail('test@gmail.com');
        $password = $this->hasher->hashPassword($user, 'g9CRd5^11LHuuHg');
        $user->setPassword($password);
        $user->setIsVerified(1);
        $user->setRoles(["ROLE_USER"]);

        $manager->persist($user);

        $category = new Category();
        $category->setName('Appareils Photo numériques');

        $manager->persist($category);

        $category = new Category();
        $category->setName('Appareils Photo Hybrides');

        $manager->persist($category);

        $product = new Product();
        $product->setName('Appareil Photo numérique 4K Ultra HD 48 MP');
        $product->setCategory($category);
        $product->setDescription('Le petit appareil photo numérique 4k avec une résolution vidéo de 30 ips et 48 mégapixels, qui peut capturer chaque excellent moment tout en vlog, le meilleur appareil photo pour youtube. Équipé d\'objectifs grand angle et macro et prend en charge le zoom numérique 16X pour obtenir une mise au point plus rapprochée de loin et prendre des photos ou des vidéos en gros plan avec des détails clairs et un plus large éventail de paysages.');
        $product->setIllustration('dda04cdd3ed9979438e14302d5d1d32ba10d831c.jpg');
        $product->setPrice('18900');
        $product->setSlug('appareil-photo-numerique-4k-ultra-hd-48-mp');
        $product->setSubtitle('Appareil Photo numérique 4K Ultra HD 48MP Appareil Photo Vlogging avec Objectif Grand Angle Zoom numérique 16 x, Appareil Photo Compact à écran 3,0 Pouces');

        $manager->persist($product);

        $product = new Product();
        $product->setName('Panasonic Lumix S5K');
        $product->setCategory($category);
        $product->setDescription('- UNE QUALITÉ D\'IMAGE INCROYABLE : un capteur plein format de 24,2 MP avec Double ISO natif, pour des images époustouflantes même en basse lumière
- DOUBLE STABILISATION : jusqu’à 6.5 stops en capteur+optique pour des images ultra nettes dans toutes les conditions
- VIDEO PROFESSIONNELLE : vidéo 4K en 4:2:2 10bit avec fonctions V-Log & Mode Anamorphique, Slow Motion 180ips
- AUTOFOCUS PRÉCIS ET INTELLIGENT : mise au point ultra rapide sur les yeux, visages et animaux, de près comme de loin
- ERGONOMIE OPTIMISÉE : un boîtier plein format ultra compact et léger, résistant et tropicalisée, avec écran tactile orientable et une autonomie de 1500 images
- Taille d\'affichage: 3.0 pouces
- Distance focale max: 60.0 millimètres
- Zoom optique: 3.0 multiplier x');
        $product->setIllustration('8d55a42eaf262840c7cea3ca2b7b771a156f5b0f.jpg');
        $product->setPrice('234900');
        $product->setSlug('panasonic-lumix-s5k');
        $product->setSubtitle('Panasonic Lumix S5K | Appareil Photo Hybride Plein Format + Objectif Lumix S 20-60mm F3.5-5.6 + Batterie (24MP, Vidéo 4K 4:2:2 10bit, Double Stabilisation, V-Log, Tropicalisé) – Version');

        $manager->persist($product);

        $manager->flush();
    }
}

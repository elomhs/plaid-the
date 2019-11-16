<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Region;
use App\Entity\Room;
use App\Entity\Owner;


class AppFixtures extends Fixture
{
    // définit un nom de référence pour une instance de Region
    public const IDF_REGION_REFERENCE = 'idf-region';
    
    public function load(ObjectManager $manager)
    {
        //...
        
        $region = new Region();
        $region->setCountry("FR");
        $region->setName("Ile de France");
        $region->setPresentation("La région française capitale");
        $manager->persist($region);

        $region = new Region();
        $region->setCountry("FR");
        $region->setName("Corse");
        $region->setPresentation("L'île de beauté");
        $manager->persist($region);

        $region = new Region();
        $region->setCountry("FR");
        $region->setName("Alsace");
        $region->setPresentation("La région presqu'allemande");
        $manager->persist($region);

        $region = new Region();
        $region->setCountry("FR");
        $region->setName("Bretagne");
        $region->setPresentation("Objectivement la plus belle région de France");
        $manager->persist($region);

        $region = new Region();
        $region->setCountry("FR");
        $region->setName("Auvergne");
        $region->setPresentation("La région de la diagonale du vide");
        $manager->persist($region);

        //$manager->flush();
        // Une fois l'instance de Region sauvée en base de données,
        // elle dispose d'un identifiant généré par Doctrine, et peut
        // donc être sauvegardée comme future référence.
        //$this->addReference(self::IDF_REGION_REFERENCE, $region);
        
        $owner = new Owner();
        $owner->setFirstname("Roger");
        $owner->setFamilyName("Martin");
        $owner->setAddress("5 rue des champignons");
        $owner->setCountry("France");
        $manager->persist($owner);
        
        //$manager->flush();
        
        
        $room = new Room();
        $room->setSummary("Beau poulailler ancien à Évry");
        $room->setDescription("très joli espace sur paille");
        $room->addRegion($region);
        $room->setOwner($owner);
        $room->setCapacity(2);
        $room->setPrice(2);
        $room->setSuperficy(2);
        $room->setAddress(2);
        $manager->persist($room);

        $room = new Room();
        $room->setSummary("Mat typiquement provençal");
        $room->setDescription("la piscine et le terrain de pétanque rendront vos soirées innoubliables");
        $room->addRegion($region);
        $room->setOwner($owner);
        $room->setCapacity(5);
        $room->setPrice(1000);
        $room->setSuperficy(200);
        $room->setAddress("1 rue des cigales");
        $manager->persist($room);

        $room = new Room();
        $room->setSummary("Sublime phare breton");
        $room->setDescription("littéralement à deux pas de l'océan");
        $room->addRegion($region);
        $room->setOwner($owner);
        $room->setCapacity(2);
        $room->setPrice(50);
        $room->setSuperficy(100);
        $room->setAddress("au bout du chemin");
        $manager->persist($room);

        $room = new Room();
        $room->setSummary("Maison familiale chaleureuse");
        $room->setDescription("les cigognes sauront vous dépayser");
        $room->addRegion($region);
        $room->setOwner($owner);
        $room->setCapacity(5);
        $room->setPrice(200);
        $room->setSuperficy(200);
        $room->setAddress("2 rue des colombages");
        $manager->persist($room);

        $room = new Room();
        $room->setSummary("Villa au plein coeur des montagnes");
        $room->setDescription("la vue est dégagée");
        $room->addRegion($region);
        $room->setOwner($owner);
        $room->setCapacity(10);
        $room->setPrice(2000);
        $room->setSuperficy(1000);
        $room->setAddress("1 chemin des paturages");
        $manager->persist($room);

        // On peut plutôt faire une référence explicite à la référence
        // enregistrée précédamment, ce qui permet d'éviter de se
        // tromper d'instance de Region :
        //$room->addRegion($this->getReference(self::IDF_REGION_REFERENCE));
        $manager->persist($room);
        
        $manager->flush();
        
        //...
    }
    
    //...
}

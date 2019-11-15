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

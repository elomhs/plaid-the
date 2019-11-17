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
        
        $region1 = new Region();
        $region1->setCountry("FR");
        $region1->setName("Ile de France");
        $region1->setPresentation("La région française capitale");
        $region1->setImage("idf.jpg");
        $manager->persist($region1);

        $region2 = new Region();
        $region2->setCountry("FR");
        $region2->setName("Corse");
        $region2->setPresentation("L'île de beauté");
        $region2->setImage("cor.jpg");
        $manager->persist($region2);

        $region3 = new Region();
        $region3->setCountry("FR");
        $region3->setName("Alsace");
        $region3->setPresentation("La région presqu'allemande");
        $region3->setImage("al.jpg");
        $manager->persist($region3);

        $region4 = new Region();
        $region4->setCountry("FR");
        $region4->setName("Provence");
        $region4->setPresentation("La région du mistral toujours gagnant");
        $region4->setImage("pro.jpg");
        $manager->persist($region4);

        $region5 = new Region();
        $region5->setCountry("FR");
        $region5->setName("Bretagne");
        $region5->setPresentation("Objectivement la plus belle région de France");
        $region5->setImage("bre.jpg");
        $manager->persist($region5);

        $region6 = new Region();
        $region6->setCountry("FR");
        $region6->setName("Auvergne");
        $region6->setImage("auv.jpg");
        $region6->setPresentation("La région de la diagonale du vide");
        $manager->persist($region6);

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
        $room->setDescription("Très joli espace sur paille");
        $room->addRegion($region1);
        $room->setOwner($owner);
        $room->setCapacity(2);
        $room->setPrice(2);
        $room->setSuperficy(2);
        $room->setAddress(2);
        $room->setImage("evry.jpg");
        $manager->persist($room);

        $room = new Room();
        $room->setSummary("U2");
        $room->setDescription("Un peu bruyant le vendredi, le mardi et parfois le mercredi aussi");
        $room->addRegion($region1);
        $room->setOwner($owner);
        $room->setCapacity(2);
        $room->setPrice(25);
        $room->setSuperficy(20);
        $room->setAddress("6 rue Charles Fourier");
        $room->setImage("evry2.jpg");
        $manager->persist($room);

        $room = new Room();
        $room->setSummary("Mat typiquement provençal");
        $room->setDescription("La piscine et le terrain de pétanque rendront vos soirées innoubliables");
        $room->addRegion($region2);
        $room->setOwner($owner);
        $room->setCapacity(5);
        $room->setPrice(1000);
        $room->setSuperficy(200);
        $room->setAddress("1 rue des cigales");
        $room->setImage("provence.jpg");
        $manager->persist($room);

        $room = new Room();
        $room->setSummary("Sublime phare breton");
        $room->setDescription("Littéralement à deux pas de l'océan");
        $room->addRegion($region3);
        $room->setOwner($owner);
        $room->setCapacity(2);
        $room->setPrice(50);
        $room->setSuperficy(100);
        $room->setAddress("au bout du chemin");
        $room->setImage("bretagne.jpg");
        $manager->persist($room);

        $room = new Room();
        $room->setSummary("Maison familiale chaleureuse");
        $room->setDescription("Les cigognes sauront vous dépayser");
        $room->addRegion($region4);
        $room->setOwner($owner);
        $room->setCapacity(5);
        $room->setPrice(200);
        $room->setSuperficy(200);
        $room->setAddress("2 rue des colombages");
        $room->setImage("alsace.jpg");
        $manager->persist($room);

        $room = new Room();
        $room->setSummary("Villa au plein coeur des montagnes");
        $room->setDescription("La vue est dégagée");
        $room->addRegion($region5);
        $room->setOwner($owner);
        $room->setCapacity(10);
        $room->setPrice(2000);
        $room->setSuperficy(1000);
        $room->setAddress("1 chemin des paturages");
        $room->setImage("corse.jpg");
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

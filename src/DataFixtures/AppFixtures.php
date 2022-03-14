<?php

namespace App\DataFixtures;

use App\Entity\Employe;
use App\Entity\Metier;
use App\Entity\Project;
use App\Entity\Worktime;
use DateTime;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
/** @var ObjectManager */
private $manager; 

public function load(ObjectManager $manager): void
{

    $this->manager = $manager; 
    $this->loadJobs();
    $this->loadProject();
    $this->loadEmployees(); 

    $this->manager->flush(); 
    // $product = new Product();
    // $manager->persist($product);

}

public function loadJobs():void{

    $array=['Front-dev','Manager','Back-dev','Facteur'];

    foreach ($array as $key => $job) {
        $Job =(new Metier())->setName($job);
        $this->manager->persist($Job);
        $this->addReference(Metier::class. $key,$Job);
    }

}

public function loadProject():void{
    $debut = new DateTimeImmutable('2000-10-10');
    $fin = new DateTimeImmutable('2010-10-10');
    for($i = 0; $i < 20 ; $i++){
        $randomDate=$this->getRandomDate($debut,$fin); 
        $projet =(new Project())->setNom("Projet : ".$i)->setDescription("Description du project : ".$i)->setCost(mt_rand(1000,30000));
        $projet->setCreatedAt($randomDate);
        $this->manager->persist($projet);
        $this->addReference(Project::class.$i,$projet);
    }
}

public function getRandomDate(DateTimeImmutable $debut,DateTimeImmutable $fin):DateTimeImmutable{
    $randomTimestamp = mt_rand($debut->getTimestamp(),$fin->getTimestamp());
    $randomDate = new DateTimeImmutable();
    return  $randomDate->setTimestamp($randomTimestamp);
}

public function loadEmployees(): void{
    $noms=['Paul','Jacque','Ginette','Bertrand','Juliette','Jacquot','SymfonyMan','Schumacher','Perpignan','Morgan','Zinedin','Zidan','Messi','Alexandre','Sofiane','Florian'];

    $debut = new DateTimeImmutable('2010-10-10');
    $fin = new DateTimeImmutable('2022-10-10');

    for($i = 0; $i < 40 ; $i++){
        $randomDate=$this->getRandomDate($debut,$fin); 
        $metier=$this->getReference(Metier::class . random_int(0,3));

        $projet=$this->getReference(Project::class . random_int(0,19));
        $int = random_int(0,19);
        $projet2=$this->getReference(Project::class . $int);
        
        if($int%2==0)
            $projet2->setDeliveredAt(new DateTimeImmutable());

        $Worktime1=(new Worktime())->setProjet($projet)->setTime(random_int(1,20));
        $Worktime2=(new Worktime())->setProjet($projet2)->setTime(random_int(1,20));

        $this->addReference(Worktime::class.uniqid(),$Worktime1);
        $this->addReference(Worktime::class.uniqid(),$Worktime2);
        $this->manager->persist($Worktime1);
        $this->manager->persist($Worktime2);

        $Employe = (new Employe())->setName($noms[random_int(0,15)])->setSurname($noms[random_int(0,15)])->setCost(mt_rand(100, 500))->setHired($randomDate)->setJob($metier)->setMail('mail'.$i.'@yes.fr'); 
        $Employe->addWorktime($Worktime1)->addWorktime($Worktime2);

        $this->manager->persist($Employe); 
    }
}


}
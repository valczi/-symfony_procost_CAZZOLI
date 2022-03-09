<?php

namespace App\DataFixtures;

use App\Entity\Employe;
use App\Entity\Metier;
use App\Entity\Project;
use App\Entity\Worktime;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\Date;

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

    foreach ($array as $key => $brand) {
        $Job =(new Metier())->setName($brand);
        $this->manager->persist($Job);
        $this->addReference(Metier::class. $key,$Job);
    }

}

public function loadProject():void{
    for($i = 0; $i < 20 ; $i++){
        $projet =(new Project())->setNom("Projet : ".$i)->setDescription("Description du project : ".$i)->setCost(mt_rand(500,2000));
        $this->manager->persist($projet);
        $this->addReference(Project::class.$i,$projet);
    }
}

public function getDate(DateTime $start, DateTime $end):DateTime {
    $randomTimestamp = mt_rand($start->getTimestamp(), $end->getTimestamp());
    $randomDate = new DateTime();
    $randomDate->setTimestamp($randomTimestamp);
    return $randomDate;
}


public function loadEmployees(): void{
    $debut = new DateTime('2010-10-10');
    $fin = new DateTime('2022-10-10');
    $randomTimestamp = mt_rand($debut->getTimestamp(),$fin->getTimestamp());

    for($i = 0; $i < 40 ; $i++){
        $randomDate = new DateTime();
        $randomDate->setTimestamp($randomTimestamp);
        $metier=$this->getReference(Metier::class . random_int(0,3));
        Do{
            $projet=$this->getReference(Project::class . random_int(0,19));
            $projet2=$this->getReference(Project::class . random_int(0,19));
        }while($projet==$projet2);

        $Worktime1=(new Worktime())->setProjet($projet)->setTime(random_int(0,20));
        $Worktime2=(new Worktime())->setProjet($projet2)->setTime(random_int(0,20));

        $this->manager->persist($Worktime1);
        $this->addReference(Worktime::class.uniqid(),$Worktime1);
        $this->manager->persist($Worktime2);
        $this->addReference(Worktime::class.uniqid(),$Worktime2);

        $Employe = (new Employe())->setName('prénom :  ' . $i)->setSurname('nom : ' . $i)->setCost(mt_rand(1000, 5000))->setHired($randomDate)->setJob($metier)->setMail('mail'.$i.'@yes.fr'); 
        $Employe->addWorktime($Worktime1)->addWorktime($Worktime2);
        $this->manager->persist($Employe); 
    }
}


}
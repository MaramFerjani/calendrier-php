<?php
namespace App\Date;
class Month{
    public $month;
    public $year;
private $months = ['Janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre','décembre'];
public $jours= ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi' ,'dimanche'];
public function __construct(?int $month=null,?int $year=null){
    if($month===null || $month<1 || $month>12){
        $month=(int)date('m');
    }

    if($year===null){
        $year=(int)date('Y');
    }

$this->month=$month;
$this->year=$year;
}
//renvoyer le 1er jour du mois
public function getStartingDay(): \DateTime{
return new \DateTime("{$this->year}-{$this->month}-01");
}

public function toString(){
    return $this->months[$this->month-1] . ' ' .$this->year;
}

public function getWeeks(){
    $start=$this->getStartingDay();
    $end=(clone $start)->modify('+1 month -1 day');
    $weeks= intval($end->format('W')) - intval($start->format('W')) + 1;
    if($weeks<0){
       $weeks= intval($end->format('W'));
    }
    return $weeks;
}
//est ce que le jour est dans le mois en cours
public function withinMonth(\DateTime $date) {
    return $this->getStartingDay()->format('Y-m') === $date->format('Y-m');
}

public function nextMonth():Month{
    $month=$this->month+1;
    $year=$this->year;
    if($month>12){
        $month=1;
        $year=$year+1;
    }
    return new Month($month,$year);
}

public function previousMonth(){
    $month = $this->month - 1;
    $year = $this->year;
    if ($month < 1) {
        $month = 12;
        $year =$year- 1;
    }
    return new Month($month, $year);
}

}

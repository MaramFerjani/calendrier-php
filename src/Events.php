<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/calendar.css" > 
</head>
<body>
<nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="/index.php">Mon calendrier</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarColor01">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link active" href="#">Home
            <span class="visually-hidden">(current)</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Features</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Pricing</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Dropdown</a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <a class="dropdown-item" href="#">Something else here</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Separated link</a>
          </div>
        </li>
      </ul>
      <form class="d-flex">
        <input class="form-control me-sm-2" type="search" placeholder="Search">
        <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav><br>
<?php

class Events{
private $cnx;


    public function getEventsBetween(\DateTime $start, \DateTime $end) : array{
        $dsn = "mysql:host=localhost;port=3308;dbname=tutocalendar";
        $user = "root";
        $pw ="";
            
        try {
                $cnx = new PDO($dsn, $user, $pw);
        } catch (Exception $e) {
                echo "Un problème de connexion : " . $e->getMessage();
        }

        $sql="SELECT * FROM events WHERE start BETWEEN '{$start->format('Y-m-d 00:00:00')}' AND '{$end->format('Y-m-d 23:59:59')}'";
        $statement=$cnx->query($sql);
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    public function getEventsByDay(\DateTime $start, \DateTime $end) : array{
    $events=$this->getEventsBetween($start,$end);
    $days=[];
    foreach($events as $event){
      $date=explode(' ',$event['start'])[0]; //pour prendre une partie de la date
    if(!isset($days[$date])){
      $days[$date]=[$event]; //ajouté l'evenement
    }else{
        $days[$date][]=$event; //prendre le tableau des evenements existant et ajouter un autre événement.
    }
}
return $days;
}


}
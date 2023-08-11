<?php 
use App\Date\Month;
require "../src/Month.php";
require "../src/Events.php";
$month = new App\Date\Month($_GET['month'] ?? null, $_GET['year'] ?? null);
$start=$month->getStartingDay();
$weeks=$month->getWeeks();
$start=$start->format('N') === '1' ? $start : $month->getStartingDay()->modify('last monday');//ça donne le précédent lundi.
$events=new Events(); //initialisation de la classe Events
$end=(clone $start)->modify('+' . (6 + 7 * ($weeks-1)). 'days');
$events=$events->getEventsByDay($start,$end); //pour prendre tous les événements a une date particuliére

?>


<div class="d-flex flex-row align-items-center justify-content-between mx-sm">
<h1><?= $month->toString(); ?></h1>
<div>
  <a href="/index.php?month=<?= $month->previousMonth()->month;?>&year=<?= $month->previousMonth()->year;?>" class="btn btn-primary">&lt;</a>
  <a href="/index.php?month=<?= $month->nextMonth()->month;?>&year=<?= $month->nextMonth()->year;?>" class="btn btn-primary">&gt;</a>
</div>
</div>

<table class="calendar__table calendar__table--<?= $month->getWeeks(); ?>weeks">
<?php for ($i=0;$i<$month->getWeeks(); $i++): ?>
<tr>
<?php foreach($month->jours as $k=> $day): 
  $date =(clone $start)->modify( "+". ($k + $i * 7). "days");
  $eventsForDay= $events[$date->format('Y-m-d')] ?? [] //pour récupérer l'événement du jour
  ?>
<td class="<?= $month->withinMonth($date)? '' : 'calendar__othermonth'; ?>">
  <?php if ($i===0): ?>
    <div class="calendar__weekday">
  <?= $day; ?>
  </div>
  <?php endif; ?>
  <div class="calendar__day">
    <?php foreach( $eventsForDay as $event):?>
<div class="calendar__event">
<?= (new DateTime($event['start']))->format('H:i') ?> 
  <a href="/event.php?id=<?=$event['id'] ?>"><?= $event['name'] ?></a>
</div>
    <?php endforeach ?>
  <?= $date->format('d'); ?>
  </div>
</td>
<?php endforeach; ?>
</tr>
<?php endfor; ?>
</table>
</body>
</html>

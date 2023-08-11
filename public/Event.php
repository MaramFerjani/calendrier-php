<?php 


require "..\src\Month.php";
require "..\src\Events.php";
require "..\src\header.php";
function get_pdo(){
    $dsn = "mysql:host=localhost;port=3308;dbname=tutocalendar";
    $user = "root";
    $pw ="";
    
    try {
        $cnx = new PDO($dsn, $user, $pw);
    } catch (Exception $e) {
        echo "Un problème de connexion : " . $e->getMessage();
    }
}
$pdo= get_pdo();
$events=new Events($pdo);
if(!isset($_GET['id'])){
    header('location: /404.php');
}
$event=$events->find($_GET['id']);
var_dump($event);

?>

<h1></h1>
<?php   header('location: ..\src\header.php');?>


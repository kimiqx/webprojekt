<?php
include 'db/movie.class.php';

$movieName = "";
$movNaErr = "";

if($_SERVER["REQUEST_METHOD"] == "GET") {
  $movieName = $_GET["moviename"];

  if(empty($movieName)){
    $movNaErr = "Error";
  }

  $movieName = str_replace(' ', '', $movieName);

  $movieID = getMovieIdApi($movieName);

  if($movieID != 0){
    
    $check = new setMovie();
    $check->checkMoviesStmt($movieID);
        
    $movieObj = new getMovie();
    $film = $movieObj->getMovieDb($movieID);
  
    $genreArr = new getMovie();
    $genres = $genreArr->getGenreDb($movieID);
 
    $actorArr = new getMovie();
    $actors = $actorArr->getActorsDb($movieID);
  } else {
    
    $movNaErr = "This is not a movie";
  }
}


if($_SERVER["REQUEST_METHOD"] == "GET" && empty($movNaErr) && !empty($movieObj)){ ?>
  <!DOCTYPE html>
  <html lang="de" id="top">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="">
    <title>Filmwert</title>
    <meta name="description" content="Filme finden">
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
  <h2><?php echo " {$film->Title} <br>";?></h2>
  <?php echo "<img src='{$film->Poster}' width='300' height='400' />"; ?>
  <div>
    <h2>Runtime</h2>
    <p> <?php echo "{$film->Runtime} Minutes"; ?> </p>
  </div>
  <div>
    <h2>Genres</h2>
  <?php foreach($genres as $genre) {
    echo "<p>". $genre['Genre'] . '</p> '; } ?>    
  </div>
  <div>
    <h2>Stars</h2>
  <?php foreach($actors as $actor) { 
    echo "<p>" . $actor['Actor'] . "</p>" ; }?>
  </div>
  </body>
<?php } ?>


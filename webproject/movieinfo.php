<?php
include 'db/movie.class.php';

$movieID = "";
$movErr = "";

if($_SERVER["REQUEST_METHOD"] == "GET") {
  $movieID = $_GET["movieID"];

  if(empty($movieID)){
    $movErr = "Error";
  }

  $movieObj = new getMovie();
  $film = $movieObj->getMovieDb($movieID);
  
  $genreArr = new getMovie();
  $genres = $genreArr->getGenreDb($movieID);
 
  $actorArr = new getMovie();
  $actors = $actorArr->getActorsDb($movieID);
 
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

    <header>
      <div class="inside">
        <h1>Movie Search</h1>
      </div>
    </header>
    <nav class="site-nav">
      <div class="inside">
        <ul>
          <li><a href="index.php">Frontpage</a></li>     
         <!-- <li><a href="projekte.html">Projekte</a></li>
          <li><a href="ueber-mich.html">Über mich</a></li>
          <li><a href="kontakt.html">Kontakt</a></li> -->
        </ul>
      </div>
    </nav>

    <main class="site-content" id="content">
      <div class="inside">
        <h2><?php echo " {$film->Title} <br>";?></h2>
        <?php echo "<img src='{$film->Poster}' width='300' height='400' />"; ?>
      </div>

      <?php if(!empty($film->Plot)){ ?>
      <div class="inside">
        <p> <?php echo "{$film->Plot}"; ?> </p>
      </div>
      <?php } ?>

      <?php if(!empty($film->ReleaseYear)){ ?>
      <div class="inside">
        <h2>Release Year</h2>
        <p> <?php echo "{$film->ReleaseYear}"; ?> </p>
      </div>
      <?php } ?>

      <?php if(!empty($film->SpokenLanguage)){ ?>
      <div class="inside">
        <h2>Spoken Language</h2>
        <p> <?php echo "{$film->SpokenLanguage}"; ?> </p>
      </div>
      <?php } ?>
      
      <?php if(!empty($film->Runtime)){ ?>
      <div class="inside">
        <h2>Runtime</h2>
        <p> <?php echo "{$film->Runtime} Minutes"; ?> </p>
      </div>
      <?php } ?>

      <?php if(!empty($film->FSK)){ ?>
      <div class="inside">
        <h2>FSK</h2>
        <p> <?php echo "{$film->FSK}"; ?> </p>
      </div>
      <?php } ?>

      <?php if(!empty($film->Warning)){ ?>
      <div class="inside">
        <h2>Warnings</h2>
        <p> <?php echo "{$film->Warning}"; ?> </p>
      </div>
      <?php } ?>
      
      <?php if(!empty($film->Director)){ ?>
      <div class="inside">
        <h2>Director</h2>
        <p> <?php echo "{$film->Director}"; ?> </p>
      </div>
      <?php } ?>

      <?php if(!empty($genres)){ ?>
      <div class="inside">
        <h2>Genres</h2>
      <?php foreach($genres as $genre) {
        echo "<p>". $genre['Genre'] . '</p> '; } ?>    
      </div>
      <?php } ?>
      
      <?php if(!empty($actors)){ ?>
      <div class="inside">
        <h2>Stars</h2>
      <?php foreach($actors as $actor) { 
        echo "<p>" . $actor['Actor'] . "</p>" ; }?>
      </div>
      <?php } ?>

    </main>
    <footer class="site-footer">
      <div class="inside">
        <a href="#top">Nach oben</a>
      </div>

    </footer>
  </body>
<?php } ?>
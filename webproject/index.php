<?php
include 'db/movie.class.php';

$sort = $errMessage = "";
$filter = $error = "";

if(isset($_GET['filter'])){
  $filter = $_GET['filter'];
    
  if($filter == 'Alphabetical'){
    $sort = 'Title';
    $moviesArr = new getMovie();
    $movies = $moviesArr->getMoviesDb($sort);
  } else {
    $sort = $filter;
    $moviesArr = new getMovie();
    $movies = $moviesArr->getMoviesDb($sort);
  }

}else {
  $sort = 'Rating';
  $moviesArr = new getMovie();
  $movies = $moviesArr->getMoviesDb($sort);
}

if(isset($_GET['error'])){
  $error = $_GET['error'];

  if($error = 'title'){
    $errMessage = "* Movie not found, check title";
  }
}

?>

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
        <li><a href="#" aria-current="page">Frontpage</a></li>     
        <!-- <li><a href="projekte.html">Projekte</a></li>
        <li><a href="ueber-mich.html">Über mich</a></li>
        <li><a href="kontakt.html">Kontakt</a></li> -->
      </ul>
    </div>
  </nav>
  <main class="site-content" id="content">
    <div class="inside">
      
      <form action="moviesearch.php" method="get">
        <input type="text" name="moviename" id="moviename" placeholder="Search" required>
        <button type="submit">Search</button>
        <span> <?php echo $errMessage; ?> </span>
        
      </form>
    </div>

    <section class="infoboxen">
      <div class="inside">
        <form class="filtering" action="index.php" method="get">
          <select onchange="this.form.submit()" class="pickFilter" name="filter" id="filter" required>
            <?php if(!empty($filter)) { ?><option value=""><?php if($filter == 'ReleaseYear'){ echo 'Newest';}else echo $filter; ?> </option> <?php } ?>
            <?php if($filter != "Rating") { ?><option value="Rating">Rating</option> <?php } ?>
            <?php if($filter != "Alphabetical") { ?><option value="Alphabetical">Alphabetical</option> <?php } ?>
            <?php if($filter != "Runtime") { ?><option value="Runtime">Runtime</option> <?php } ?>
            <?php if($filter != "ReleaseYear") { ?><option value="ReleaseYear">Newest</option> <?php } ?>
          </select>
        </form>
      </div>

      <div class="inside">
        <?php foreach($movies as $movie){ ?>
          <figure class="infobox">
            <h3><?php echo $movie['Title'];?> </h3>
            <a href="movieinfo.php?movieID=<?php echo $movie['MovieID'];?> ">
            <img src='<?php echo $movie['Poster']; ?>' width='300' height='400' /> 
            </a>
            <?php if($sort != 'Title'){ ?> <p class="sort"><?php if($sort != 'ReleaseYear'){ echo $sort.": ";} echo $movie[$sort]; if($sort == 'Runtime'){ echo ' Min';} } ?> </p>
          </figure>
          
        <?php } ?>       
      </div>
    </section>

  </main>
  <footer class="site-footer">
    <div class="inside">
      <a href="#top">Nach oben</a>
    </div>

  </footer>
</body>
</html>
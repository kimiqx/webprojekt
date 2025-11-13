<?php
include 'db.class.php';
include 'functions.php';
include 'moviedb.php';

class setMovie extends Db {


  public function checkMoviesStmt($movieID) {
    $sql = "SELECT COUNT(*) FROM movies WHERE movies.movieID = ? ";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$movieID]);
    $count = $stmt->fetchColumn();

    if($count == 0){
      saveMovieDataDb($movieID);
    }
  }


  public function setMoviesStmt($movieID, $poster, $title, $releaseYear, $fsk, $warning, $rating, $runtime, $plot, $spokenlanguage, $director) {
    $sql = "INSERT INTO movies(MovieID, Poster, Title, ReleaseYear, FSK, Warning, Rating, Runtime, Plot, SpokenLanguage, Director) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$movieID, $poster, $title, $releaseYear, $fsk, $warning, $rating, $runtime, $plot, $spokenlanguage, $director]);
   
  }

  public function setActorStmt($movieID, $actorName) {
    $sql = "INSERT INTO actors(MovieID, Actor) VALUES (?, ?)";
    $stmt = $this->connect()->prepare($sql);
    foreach($actorName as $name){
      $stmt->execute([$movieID, $name]);
    }
    
  }

  public function setGenreStmt($movieID, $genres){
    $sql = "INSERT INTO genres(MovieID, Genre) VALUES (?, ?)";
    $stmt = $this->connect()->prepare($sql);
    foreach($genres as $genre){
      $stmt->execute([$movieID, $genre]);
    }


 }
}

class getMovie extends Db {

  public function getMovieDb($movieID){
    $sql = "SELECT Title, Poster, ReleaseYear, FSK, Warning, Rating, Runtime, Plot, SpokenLanguage, Director FROM movies WHERE movieID = ?";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$movieID]);
    $stmt->setFetchMode(PDO::FETCH_OBJ);
    return $stmt->fetch();

  }

  public function getGenreDb($movieID){
    $sql = "SELECT Genre FROM genres WHERE movieID = ?";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$movieID]);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    return $stmt->fetchAll();
  }

  public function getActorsDb($movieID){
    $sql = "SELECT Actor FROM actors WHERE movieID = ?";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$movieID]);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    return $stmt->fetchAll();
  }
}
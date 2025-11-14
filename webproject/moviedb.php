<?php

function saveMovieDataDb($movieID){
  $movieData = callApiDataToAssoArray($movieID);
  $movieArr = getMovieDataApi($movieData, $movieID);

  $movie =  new setMovie();
  $movie->setMoviesStmt($movieArr['MovieID'], $movieArr['Poster'], $movieArr['Title'], $movieArr['ReleaseYear'], $movieArr['FSK'], $movieArr['Warnings'], $movieArr['Rating'], $movieArr['Runtime'], $movieArr['Plot'], $movieArr['Language'], $movieArr['Director']);

  $actor = new setMovie();
  $actor->setActorStmt($movieArr['MovieID'], $movieArr['Stars']);

  $genre = new setMovie();
  $genre->setGenreStmt($movieArr['MovieID'], $movieArr['Genres']);
}

?>
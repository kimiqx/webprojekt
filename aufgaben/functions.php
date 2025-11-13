<?php
include 'getDataFields.php';

function getMovieIdApi($movieName) {
  $json = file_get_contents('https://api.imdbapi.dev/search/titles?query='.$movieName.'&limit=1'); 

  if ($json === false) {
    die('Error reading the JSON file');
  }

  $json_data = json_decode($json, true); 

  if ($json_data === null) {
    die('Error decoding the JSON file');
  }

  $key = "titles";

  $movieArr = $json_data[$key];

  if($movieArr['0']['type'] == "movie"){
    return $movieArr["0"]["id"];
  }else {
    return 0;
  }
    
}

function callApiDataToAssoArray($movieID){
  $json = file_get_contents('https://api.imdbapi.dev/titles/'.$movieID); 

  if ($json === false) {
    die('Error reading the JSON file');
  }

  $json_data = json_decode($json, true); 

  if ($json_data === null) {
    die('Error decoding the JSON file');
  }

  return $json_data;
}

function getMovieDataApi($json_data, $movieID) {
  
  $rating = getMovieRatingApi($json_data);
  $title = getMovieTitleApi($json_data);
  $poster = getMoviePosterApi($json_data);
  $genres = getMovieGenresApi($json_data);
  $runtime = getMovieRuntimeApi($json_data);
  $fsk = getMovieFskScrape($movieID);
  $year = getMovieYearApi($json_data);
  $director = getMovieDirectorApi($json_data);
  $stars = getMovieStarsApi($json_data);
  $plot = getMoviePlotApi($json_data);
  $language = getMovieLanguageApi($json_data);
  $warnings = getMovieFskReasonScrape($movieID);

  $movieData = array('MovieID' => $movieID, 'Poster' => $poster, 'Title' => $title, 'ReleaseYear' => $year, 'FSK' => $fsk, 'Warnings' => $warnings, 'Rating' => $rating,  'Runtime' => $runtime, 'Genres' => $genres, 'Plot' => $plot, 'Language' => $language, 'Director' => $director, 'Stars' => $stars);

  return $movieData;
}



?>
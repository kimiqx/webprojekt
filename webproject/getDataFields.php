<?php

function getMovieRatingApi($json_data) {
  
  $key = "rating";

  if(isset($json_data[$key])){
    $rating = $json_data[$key];
    return $rating["aggregateRating"];
  } else {
    return "X";
  }
}

function getMovieTitleApi($json_data) {
  
  $key = "primaryTitle";

  if(isset($json_data[$key])){
    return $json_data[$key];
  } else {
    return "X";
  }
}

function getMoviePosterApi($json_data) {
  $key = "primaryImage";

  if(isset($json_data[$key])){
    $poster = $json_data[$key];
    return $poster["url"];
  } else {
    return "X";
  }
}

function getMovieLanguageApi($json_data) {
  $key = "spokenLanguages";

  if(isset($json_data[$key])){
    $language = $json_data[$key];
    return $language["0"]['name'];
  } else {
    return "X";
  }
}

function getMoviePlotApi($json_data) {
  
  $key = "plot";

  if(isset($json_data[$key])){
    return $json_data[$key];
  } else {
    return "X";
  }
}
function getMovieYearApi($json_data) {
  $key = "startYear";

  if(isset($json_data[$key])){
    return $json_data[$key];
  } else {
    return "X";
  }
}

function getMovieGenresApi($json_data) {
  $key = "genres";

  if(isset($json_data[$key])){
    foreach($json_data[$key] as $genre){
      $genres[] = $genre;
    }
    return $genres;
  } else {
    return "X";
  }
}

function getMovieRuntimeApi($json_data) {
  $key = "runtimeSeconds";

  if(isset($json_data[$key]) && is_numeric($json_data[$key])) {
    $timeSec = $json_data[$key];
    $runtime = $timeSec / 60;
    return $runtime . " Min";
  } else {
    return "X";
  }
}

function getMovieDirectorApi($json_data) {
  
  $key = "directors";

  if(isset($json_data[$key])){
    $director = $json_data[$key];
    return $director["0"]["displayName"];
  } else {
    return "X";
  }
}

function getMovieStarsApi($json_data) {
  
  $key = "stars";

  if(isset($json_data[$key])){
    $director = $json_data[$key];
    foreach($json_data[$key] as $star){
      $stars[] = $star['displayName'];
    }
    return $stars;
  } else {
    return "X";
  }
}

function getMovieFskScrape($movieID) {

  $opts = array(
  'http'=>array(
    'method'=>"GET",
    'header'=>"Accept: application/json, text/plain, */*\r\n" .
              "Referer: https://www.imdb.com/\r\n" .
              "User-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36\r\n"
  )
);

$context = stream_context_create($opts);

$file = file_get_contents('https://www.imdb.com/de/title/'.$movieID, false, $context);

$html = htmlspecialchars($file);

$stringPos = strpos($html, 'og:description');
$place = $stringPos + 44;
$fsk = "";

for($i = $place; $i < $place + 20; $i++){
  if($html[$i] == "&"){
    break;
  } else {
    $fsk .= $html[$i];
  }
}
 
return $fsk;
}

function getMovieFskReasonScrape($movieID) {
  $findReason = "";
  $fskReason = "";

  $opts = array(
    'http'=>array(
      'method'=>"GET",
      'header'=>"Accept: application/json, text/plain, */*\r\n" .
              "Referer: https://www.imdb.com/\r\n" .
              "User-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36\r\n"
    )
  );

  $context = stream_context_create($opts);

  $file = file_get_contents('https://www.imdb.com/de/title/'.$movieID.'/parentalguide/?ref_=tt_stry_pg', false, $context);

  $html = htmlspecialchars($file);

  $stringPos = strpos($html, 'ratingReason');
  $place = $stringPos + 89;

  for($i = $place; $i < $place + 150; $i++){
    if($html[$i] == '&'){
      break;
    }else{
      $findReason .= $html[$i];
    }
  }
  $start = strpos($findReason, 'for', $offset = 1);
  $len = strlen($findReason);

  for($i = $start + 4; $i < $len; $i++){
    $fskReason .= $findReason[$i];  
  }
  if(!ctype_alpha($fskReason)){
    return "";
  }else {
    $warnings = ucfirst($fskReason);
    return $warnings;
  }
  
}
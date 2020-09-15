<?php
require_once('omdb/omdb.class.php');
require_once('tmdb/TMDb.php');
$tmdb = new OMDb(['tomatoes' => TRUE, 'apikey' => 'ec09efa5']);
$tmdb2 = new TMDB('69cb3f06410c8f14bba163e5dfca5d7c');

function getPersonName($array){
    $actors = '';
    foreach($array as $key => $value){
        $actors .= $value.',<br/>';
    }
    return $actors;
}

function getActors($id, $tmdb2){
    $allMembers = $tmdb2->getMovieCast($id);
    return $allMembers['cast'];
}

function getGenre($array){
    $genre = '';
    foreach($array as $key => $value){
        $genre .= $value.',<br/>';
    }
    return $genre;
}

function getGenresList($tmdb){
    return $tmdb->getGenres();
}

function findInArray($value, $array){ 
    return(array_search($value, $array));
}
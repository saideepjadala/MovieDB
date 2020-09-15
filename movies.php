<?php
    require_once('functions.php');
    require_once('./includes/header.php');
    require_once('languages.php');

    // print_r($_POST);die;
    $array_count = array_filter($_POST);

    if(isset($_POST['movie'])  && !empty($_POST['movie'])){
        $title = $_POST['movie'];
        $list = $tmdb2->searchMovie($title);

        $list = $list['results'];
        $movies = [];

        $tempList = array_filter($list, function ($var) use ($tmdb2) {
            if(isset($_POST['genre']) && !empty($_POST['genre'])){
                $genre = $_POST['genre'];
                foreach($var['genre_ids'] as $genre_id => $genre_value){
                    if($genre_value == $genre){
                        return true;
                    }
                }
            }
        });
        if(count($tempList) > 0){
            $movies = $tempList;
            $tempList = [];
        }
        $tempList = array_filter($list, function ($var) use ($tmdb2) {
            if(isset($_POST['actor']) && !empty($_POST['actor'])){
                $actor = ucwords($_POST['actor']);
                $cast = getActors($var['id'], $tmdb2);
                foreach($cast as $l => $value){
                    if(strpos($value['name'], $actor) !== false){
                        return true;
                    }
                }
            }
        });
        if(count($tempList) > 0){
            $movies = $tempList;
            $tempList = [];
        }
        $tempList = array_filter($list, function ($var) use ($tmdb2) {
            // print_r($_POST['lang']);die;
            if(isset($_POST['lang']) && !empty($_POST['lang'])){
                $lang = $_POST['lang'];
                if($lang == $var['original_language']){
                    return true;
                }
            }
        });
        if(count($tempList) > 0){
            $movies = $tempList;
            $tempList = [];
        }
        $tempList = array_filter($list, function ($var) use ($tmdb2) {
            if(isset($_POST['year']) && !empty($_POST['year'])){
                $year = (int) $_POST['year'];
                $release_year = (int) date('Y', strtotime($var['release_date']));
                if($release_year == $year){
                    return true;
                }
            }
        });

        if(count($tempList) > 0){
            $movies = $tempList;
            $tempList = [];
        }
    }
?>

<div class="jumbotron mb-0 rounded-0 p-5" style="background-image: linear-gradient(to right top, #051937, #004d7a, #008793, #00bf72, #a8eb12);">
    <?php
        if(count($array_count) == 1){
            $movies = $list;
        }
    ?>
    <h3 class="text-white">Movies</h3>
    <p class="text-white"><?php echo count($movies); ?> results found</p>
    <div class="table-responsive">
        <table class="table text-white table-striped">
            <thead>
                <tr>
                    <th>Poster</th>
                    <th>Title</th>
                    <th>Year</th>
                    <th>Runtime</th>
                    <th style="width:500px">Plot</th>
                    <th style="width:300px">Genre</th>
                    <th>Director</th>
                    <th>Writer</th>
                    <th style="width:500px">Actors</th>
                    <th>Langauge</th>
                    <th>Country</th>
                    <th>Total Votes</th>
                    <th>IMDB Rating</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(count($movies) > 0){
                        foreach($movies as $key){
                            $movie = $tmdb->get_by_title($key['title']);
                            // print_r($movie);die;
                            if($movie['Response'] == null){
                                ?><tr><td colspan="13">A <?php echo $movie['Error']; ?></td></tr><?php
                            }else{
                                ?>
                                <tr>
                                    <td><img src="<?php echo $movie['Poster']; ?>" class="img-fluid"></td>
                                    <td><?php echo $movie['Title']; ?></td>
                                    <td><?php echo strtok($movie['Released'], '-'); ?></td>
                                    <td><?php echo $movie['Runtime']; ?></td>
                                    <td style="width:50% !important"><?php echo $movie['Plot']; ?></td>
                                    <td><?php
                                        if(is_array($movie['Genre'])){
                                            echo getGenre($movie['Genre']);
                                        }else{
                                            echo $movie['Genre'];
                                        }
                                    ?></td>
                                    <td><?php
                                        if(is_array($movie['Director'])){
                                            echo getPersonName($movie['Director']);
                                        }else{
                                            echo $movie['Director'];
                                        }
                                    ?></td>
                                    <td><?php
                                        if(is_array($movie['Writer'])){
                                            echo getPersonName($movie['Writer']);
                                        }else{
                                            echo $movie['Writer'];
                                        }
                                    ?></td>
                                    <td><?php
                                        if(is_array($movie['Actors'])){
                                            echo getPersonName($movie['Actors']);
                                        }else{
                                            echo $movie['Actors'];
                                        }
                                    ?></td>
                                    <td><?php
                                        if(is_array($movie['Language'])){
                                            echo getPersonName($movie['Language']);
                                        }else{
                                            echo $movie['Language'];
                                        }
                                    ?></td>
                                    <td><?php
                                        if(is_array($movie['Country'])){
                                            echo getPersonName($movie['Country']);
                                        }else{
                                            echo $movie['Country'];
                                        }
                                    ?></td>
                                    <td><?php echo $movie['imdbVotes']; ?></td>
                                    <td><?php echo $movie['imdbRating']; ?></td>
                                </tr>
                                <?php
                                }
                            }
                        }
                    ?>
            </tbody>
        </table>
    </div>
</div>

<?php
    require_once('./includes/footer.php');
?>
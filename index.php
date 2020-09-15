<?php
    require_once('./includes/header.php');
    require_once('functions.php');
    require_once('languages.php');
?>

<div class="jumbotron mb-0 rounded-0 p-5 main" style="background-image: linear-gradient(to right top, #051937, #004d7a, #008793, #00bf72, #a8eb12);">
    <div class="container mt-4">
        <div class="row">
            <div class="col-sm-8 mx-auto text-center">
                <h3 class="mb-5 text-white p-1">Search Movies</h3>
                <form action="movies.php" method="post" class="mb-5">
                    <div class="form-group">
                        <input type="text" class="form-control" name="movie" id="movie" placeholder="Search Movies" required>
                    </div>
                    <div class="form-group">
                        <select name="genre" id="genre" class="form-control">
                            <option value="">Select Genre</option>
                            <?php
                                $genres = $tmdb2->getGenres();
                                $genres = $genres['genres'];
                                foreach($genres as $genre){
                                    ?><option value="<?php echo $genre['id']; ?>"><?php echo $genre['name']; ?></option><?php
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="lang" id="lang" class="form-control">
                            <option value="">Select Language</option>
                            <?php
                                foreach($codes as $lang => $name){
                                    ?><option value="<?php echo $lang; ?>"><?php echo $name; ?></option><?php
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="year" id="year" placeholder="Release Year">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="actor" id="actor" placeholder="Actor's Name">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Search Movies</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
    require_once('./includes/footer.php');
?>
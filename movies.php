<?php
// Load JSON
$data = json_decode(file_get_contents('./assets/movies-list-db.json'), true);
$genres = $data['genres'];
$movies = $data['movies'];

$filteredMovies = $movies; // default: all movies
$pageTitle = "All Movies";

//=== Include favorites.php to get the $voted_movies array ===
include_once("favorites.php");
// === Check if page=favorites ===
if (isset($_GET['page']) && $_GET['page'] === 'favorites') {
    if (!empty($voted_movies)) {
        $filteredMovies = array_filter($movies, function ($movie) use ($voted_movies) {
            return in_array($movie['id'], $voted_movies);
        });
        $pageTitle = "Your Favorite Movies";
    } else {
        // No favorites
        $filteredMovies = [];
        $pageTitle = "Your Favorite Movies";
    }
}

// Check for valid genre in GET
if (isset($_GET['genre'])) {
    $genre = $_GET['genre'];
    if (in_array($genre, $genres)) {
        $filteredMovies = array_filter($movies, function ($movie) use ($genre) {
            return in_array($genre, $movie['genres']);
        });
        $pageTitle = $genre . " Movies";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Movies</title>
    <link rel="stylesheet" href="style.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous" />
</head>

<body class="movie-back">

    <?php require_once("includes/header.php"); ?>

    <!-- Hero Section -->
    <section class="hero-section" style="background: url('https://static.vecteezy.com/system/resources/thumbnails/007/992/391/small/cinema-movie-background-concept-cinema-seat-watch-movie-concept-with-copy-space-3d-rendering-photo.jpg') center/cover no-repeat; color: #fff; padding: 60px 0 40px 0; text-align: center;">
        <div class="container">
            <h1 style="font-size: 2.5rem; font-weight: bold; margin-bottom: 18px;"><?= htmlspecialchars($pageTitle) ?></h1>
            <p style="font-size: 1.2rem; margin-bottom: 25px;">
                Explore our movie collection based on your favorite genres.
            </p>
        </div>
    </section>

    <!-- Movie Cards -->
    <section class="new-movies" id="new">
        <div class="container">
            <hr>
            <div class="row mt-4">
                <?php if (count($filteredMovies) > 0): ?>
                    <?php foreach ($filteredMovies as $movie): ?>
                        <div class="col-lg-4 col-md-6" id="movie-<?= htmlspecialchars($movie['id']) ?>">
                            <a href="movie.php?movie_id=<?= urlencode($movie['id']) ?>" target="_blank">
                                <div class="card movie-cards mb-5">
                                    <img src="<?= htmlspecialchars($movie['posterUrl']) ?>" class="card-img-top" alt="<?= htmlspecialchars($movie['title']) ?> poster">
                                    <div class="card-body">
                                        <div class="card-title d-flex">
                                            <h4><?= htmlspecialchars($movie['title']) ?></h4>
                                        </div>
                                        <h6 class="card-subtitle mb-1"><?= htmlspecialchars($movie['year']) ?></h6>
                                        <p class="card-text">
                                            <?php
                                            $plot = $movie['plot'] ?? $movie['description'] ?? '';
                                            $trimmedPlot = mb_substr($plot, 0, 100);
                                            echo htmlspecialchars(strlen($plot) > 100 ? $trimmedPlot . '...' : $plot);
                                            ?>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center">
                        <?php if (isset($_GET['page']) && $_GET['page'] === 'favorites'): ?>
                            <p class="text-danger">Nu ai adăugat încă niciun film la favorite.</p>
                            <a href="movies.php" class="btn btn-secondary mt-3">Vezi toate filmele</a>
                        <?php elseif (isset($_GET['genre'])): ?>
                            <p class="text-danger">Nu s-au găsit filme pentru genul <strong><?= htmlspecialchars($_GET['genre']) ?></strong>.</p>
                            <a href="genres.php" class="btn btn-secondary mt-3">Înapoi la genuri</a>
                        <?php else: ?>
                            <p class="text-danger">Nu există filme disponibile momentan.</p>
                            <a href="index.php" class="btn btn-secondary mt-3">Înapoi la Home</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </section>


    <?php require_once("includes/footer.php"); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous">
    </script>
</body>

</html>
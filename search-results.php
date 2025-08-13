<?php
require_once("includes/header.php");

$searchQuery = '';

// Accept parameters: q, search or s
if (!empty($_GET['q'])) {
    $searchQuery = trim($_GET['q']);
} elseif (!empty($_GET['search'])) {
    $searchQuery = trim($_GET['search']);
} elseif (!empty($_GET['s'])) {
    $searchQuery = trim($_GET['s']);
}

// If no search term is provided, show a message and exit
if (empty($searchQuery)) {
    echo '<div class="container mt-5 text-center">
            <h2 class="text-danger">No search term provided.</h2>
            <a href="movies.php" class="btn btn-primary mt-3">Back to Movies</a>
          </div>';
    require_once("includes/footer.php");
    exit;
}

// Check if the search term is too short
if (mb_strlen($searchQuery) < 3) {
    echo '<div class="container mt-5 text-center">
            <h2 class="text-warning">Please enter at least 3 characters in the search field.</h2>
            <a href="movies.php" class="btn btn-primary mt-3">Back to Movies</a>
          </div>';
    require_once("includes/footer.php");
    exit;
}

// Read the movies from the JSON file
$data = json_decode(file_get_contents('./assets/movies-list-db.json'), true);
$movies = $data['movies'] ?? [];

// Căutare filme
$searchResults = array_filter($movies, function ($movie) use ($searchQuery) {
    return stripos($movie['title'], $searchQuery) !== false;
});

// Afișare rezultate
echo '<div class="container mt-5">';
echo '<h2 class="mb-4">Search results for: <em>' . htmlspecialchars($searchQuery) . '</em></h2>';
require_once('includes/search-form.php');
if (empty($searchResults)) {
    echo '<div class="alert alert-warning text-center">';
    echo '<h4>No movies found for "<strong>' . htmlspecialchars($searchQuery) . '</strong>"</h4>';
    echo '<p>Try a different search term.</p>';
    echo '<a href="movies.php" class="btn btn-outline-primary mt-2">Back to all movies</a>';
    echo '</div>';
} else {
    echo '<div class="row">';
    foreach ($searchResults as $movie) {
        echo '<div class="col-lg-4 col-md-6 mb-4">';
        echo '<div class="card movie-cards h-100">';
        echo '<a href="movie.php?movie_id=' . htmlspecialchars($movie['id']) . '">';
        echo '<img src="' . htmlspecialchars($movie['posterUrl'] ?? 'path/to/default_poster.png') . '" class="card-img-top" alt="' . htmlspecialchars($movie['title']) . ' poster">';
        echo '</a>';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . htmlspecialchars($movie['title']) . '</h5>';
        echo '<p class="card-text">';
        echo htmlspecialchars($movie['plot'] ?? $movie['description'] ?? 'No description available.');
        echo '</p>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    echo '</div>';
}
echo '</div>';
require_once("includes/footer.php");

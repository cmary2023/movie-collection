<?php

//=== Start the session to manage user data===
session_start();
//=== Get the movie ID from the GET request (URL)===
$movie_id = isset($_GET['movie_id']) ? (int)$_GET['movie_id'] : 0;
//=== Name of the JSON file to store favorite movies===
$file = './assets/movie_favorites.json';
//===Check if the file exists===
if (!file_exists($file)) {
    file_put_contents($file, json_encode([], JSON_PRETTY_PRINT));
}
// === Read the JSON file===
$jsonData = file_get_contents($file);
// === Decode the JSON data into an associative array ===
$favMovies = json_decode($jsonData, true) ?? [];
// === Fișierul JSON unde salvăm rating-urile ===
$ratingFile = './assets/movie-rating.json';

// ===If the file does not exist, create it ===
if (!file_exists($ratingFile)) {
    file_put_contents($ratingFile, json_encode([], JSON_PRETTY_PRINT));
}

// === Read the existing data from the rating file ===
$ratingData = file_get_contents($ratingFile);
$ratingData = file_get_contents($ratingFile);
$movieRatings = json_decode($ratingData, true) ?? [];

// === Cookie pentru filme notate ===
$rated_movies = isset($_COOKIE['rated_movies']) ? json_decode($_COOKIE['rated_movies'], true) ?? [] : [];

//===Cookies for voted movies===
$voted_movies = [];
// === Check if the 'voted_movies' cookie exists and decode it if it does ===
if (isset($_COOKIE['voted_movies']) && !empty($_COOKIE['voted_movies'])) {
    $decoded = json_decode($_COOKIE['voted_movies'], true);
    if (is_array($decoded)) {
        $voted_movies = $decoded;
    }
}


//=== Check if the movie ID exists in the voted movies array===
if (!isset($_GET['movie_id']) || !is_numeric($_GET['movie_id'])) {
    showError("Invalid or missing movie ID.");
    exit;
}
$movieId = (int)$_GET['movie_id']; // Cast movie_id to an integer for comparison

//=== Handle form submission for adding/removing favorites ===
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $favorite = $_POST['favorite'] ?? null;

    if ($favorite !== null) {
        if ($favorite == '1') {
            // Add to favorites
            if (!in_array($movie_id, $voted_movies)) {
                $voted_movies[] = $movie_id;

                // Increment in global JSON file
                if (isset($favMovies[$movie_id])) {
                    $favMovies[$movie_id]++;
                } else {
                    $favMovies[$movie_id] = 1;
                }
            }
        } elseif ($favorite == '0') {
            // Remove from favorites
            if (in_array($movie_id, $voted_movies)) {
                $voted_movies = array_diff($voted_movies, [$movie_id]);

                // Decrement in global JSON file
                // If the movie exists in the favorites, decrement its count
                if (isset($favMovies[$movie_id])) {
                    $favMovies[$movie_id]--;
                    if ($favMovies[$movie_id] <= 0) {
                        unset($favMovies[$movie_id]);
                    }
                }
            }
        }

        //=== Update cookie and JSON file===
        setcookie('voted_movies', json_encode(array_values($voted_movies)), time() + 31556926, "/");
        file_put_contents($file, json_encode($favMovies, JSON_PRETTY_PRINT));

        //=== Redirect to the same movie page to reflect the changes ===
        header("Location: movie.php?movie_id=" . urlencode($movie_id));
        exit;
    }
}
//=== Handle form submission for rating movies ===
if (isset($_POST['submit_rating'])) {
    $rating = intval($_POST['rating']);
    if ($rating >= 1 && $rating <= 5) {
        // If the movie ID is not set, show an error
        if (!isset($movieRatings[$movie_id])) {
            $movieRatings[$movie_id] = [];
        }

        // Increment the rating count
        if (!isset($movieRatings[$movie_id][$rating])) {
            $movieRatings[$movie_id][$rating] = 1;
        } else {
            $movieRatings[$movie_id][$rating]++;
        }

        // === Save the updated ratings to the JSON file ===
        file_put_contents($ratingFile, json_encode($movieRatings, JSON_PRETTY_PRINT));

        // ===Add movie to rated movies list===
        if (!in_array($movie_id, $rated_movies)) {
            $rated_movies[] = $movie_id;
            setcookie('rated_movies', json_encode(array_values($rated_movies)), time() + 31556926, "/");
        }

        //=== Redirect to the same movie page to reflect the changes ===
        header("Location: movie.php?movie_id=" . urlencode($movie_id));
        exit;
    } else {
        showError("Rating invalid!");
    }
}

require_once("includes/functions.php");
require_once("includes/header.php");

// === Get the list of movies ===
$movies = getMovies();
$filteredMovies = array_filter($movies, fn($movie) => isset($movie['id']) && (int)$movie['id'] === $movie_id);
$selectedMovie = reset($filteredMovies);

if (!$selectedMovie) {
    showError("Movie not found.");
    exit;
}

// === Get the total number of global favorites ===
$global_fav_count = $favMovies[$movie_id] ?? 0;
// === Get the total number of global ratings for the movie ===
$global_rating_count = array_sum($movieRatings[$movie_id] ?? []);

function showError($message)
{
    echo '<div class="container mt-5 text-center">';
    echo '<h2 class="text-danger">' . htmlspecialchars($message) . '</h2>';
    echo '<a href="movies.php" class="btn btn-primary mt-3">Back to Movies</a>';
    echo '</div>';
}
// === Get the release year from the selected movie ===
$releaseYear = $selectedMovie['year'] ?? 'N/A';
// === Check if the movie is in the user's favorites ===
$is_favorite = in_array($movie_id, $voted_movies);

include_once "includes/functions.php";
// === Initialize variables for form submission ===
$submitted = false;
$successMessage = '';
$errorMessage = '';

// 1. Preluarea ID-ului filmului curent din URL
$movie_id = $_GET['movie_id'] ?? null; // Asigură-te că 'id' este numele parametrului din URL

// Validare simplă a ID-ului filmului
if ($movie_id === null || !is_numeric($movie_id) || $movie_id <= 0) {
    die("Eroare: ID-ul filmului lipsește sau este invalid.");
}
$movie_id = (int)$movie_id; // Converteste la integer pentru siguranță


//===Handle form submission for review===
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ===Check if the required fields are set and consent is given===
    if (isset($_POST['name'], $_POST['consent']) && $_POST['consent'] == '1') {
        // === Include the database connection file if not already included ===
        if (!isset($conn) || !$conn) {

            $conn = db_connect(); // Connect to the database
        }
        $sqlCreateTable = "CREATE TABLE IF NOT EXISTS reviews (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            movie_id INT(11) UNSIGNED NOT NULL,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL,
            review TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            INDEX (movie_id),
            UNIQUE KEY unique_movie_email (movie_id, email) -- Add a unique key to prevent duplicates at the DB level
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

        if (!$conn->query($sqlCreateTable)) {
            die("Error creating 'reviews' table: " . $conn->error);
        }

        // Retrieve and sanitize data for HTML and SQL
        $name = $conn->real_escape_string($_POST['name'] ?? '');
        $email = $conn->real_escape_string($_POST['email'] ?? '');
        $review = $conn->real_escape_string($_POST['review'] ?? '');

        // === Check if exists an review for the movie by the user ===
        $checkSql = "SELECT COUNT(*) AS count FROM reviews WHERE movie_id = ? AND email = ?";
        $stmtCheck = $conn->prepare($checkSql);
        $stmtCheck->bind_param("is", $movie_id, $email); // 'i' for int (movie_id), 's' for string (email)
        $stmtCheck->execute();
        $checkResult = $stmtCheck->get_result();
        $rowCheck = $checkResult->fetch_assoc();

        if ($rowCheck['count'] > 0) {
            // Exists a review for this movie by the user
            $errorMessage = "It seems you have already left a review for this movie. You cannot leave multiple reviews for the same movie.";
        } else {
            // No review exists, continue with insertion
            $sqlInsert = "INSERT INTO reviews (name, email, review, movie_id) VALUES (?, ?, ?, ?)";
            $stmtInsert = $conn->prepare($sqlInsert);
            $stmtInsert->bind_param("sssi", $name, $email, $review, $movie_id);

            if ($stmtInsert->execute()) {
                $successMessage = "Thank you, <strong>" . htmlspecialchars($name) . "</strong>. The review has been submitted successfully.";
                $submitted = true;
            } else {
                // Error inserting review (could also be due to UNIQUE key if added)
                $errorMessage = "Error inserting review: " . $stmtInsert->error;
            }
            $stmtInsert->close(); // Close the insert prepared statement
        }
        $stmtCheck->close(); // Close the check prepared statement
        $conn->close(); // Close the database connection
    } else {
        $errorMessage = "You must enter your name and agree to the processing of personal data.";
    }
}


?>

<!-- HTML structure for the movie details page -->
<div class="container py-5">
    <?php if ($selectedMovie): ?>
        <div class="row">
            <div class="col-md-4">
                <img src="<?= htmlspecialchars($selectedMovie['posterUrl']) ?>" alt="<?= htmlspecialchars($selectedMovie['title']) ?>" class="img-fluid rounded">
            </div>
            <div class="col-md-8">
                <h1><?= htmlspecialchars($selectedMovie['title']) ?></h1>
                <!-- Display favorite button with count -->
                <form method="POST" action="">
                    <input type="hidden" name="movie_id" value="<?= htmlspecialchars($movie_id) ?>">
                    <input type="hidden" name="favorite" value="<?= in_array($movie_id, $voted_movies) ? '0' : '1' ?>">
                    <button type="submit" class="btn <?= $is_favorite ? 'btn-danger' : 'btn-outline-danger' ?>">
                        <?= $is_favorite ? '💔 Șterge din favorite' : '❤️ Adaugă la favorite' ?>
                        <span class="badge bg-secondary"><?= $global_fav_count ?></span>
                    </button>
                </form>
                <!--Display runtime, genres, director, actors, and description -->
                <p><strong>Year:</strong> <?= $releaseYear ?> <?= displayOldMovieBadge($releaseYear) ?></p>
                <p><strong>Runtime:</strong> <?php echo runtime_prettier($selectedMovie['runtime']); ?></p>
                <p><strong>Genres:</strong> <?= htmlspecialchars(implode(', ', $selectedMovie['genres'])) // Join the genres array into a string 
                                            ?></p>
                <p><strong>Director:</strong> <?= htmlspecialchars($selectedMovie['director'] ?? 'N/A') ?></p>
                <p><strong>Actors:</strong>
                <ul>
                    <?php if (isset($selectedMovie['actors'])): ?>
                        <?php
                        // Check if actors is an array or a comma-separated string
                        $actorsList = is_array($selectedMovie['actors'])
                            ? $selectedMovie['actors']
                            : explode(',', $selectedMovie['actors']); // Split the string into an array if it's not already one
                        ?>
                        <?php foreach ($actorsList as $actor): ?>
                            <li><?= htmlspecialchars(trim($actor)) ?></li><!-- Trim whitespace around actor names -->
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li>N/A</li><!-- If no actors are provided, display N/A -->
                    <?php endif; ?>
                </ul>
                </p>
                <p><strong>Description:</strong> <?= htmlspecialchars($selectedMovie['plot']) ?></p>

                <?php
                displayMovieRating($movie_id, $movieRatings);
                $is_rated = isset($user_ratings) && isset($user_ratings[$movie_id]);
                ?>

                <!-- Form for rating the movie -->
                <h3>Rate this movie</h3>
                <form method="post" action="">
                    <input type="hidden" name="movie_id" value="<?php echo $movie_id; ?>">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <input type="radio" name="rating" required value="<?= $i ?>" id="rating-<?= $i ?>"
                            <?= ($is_rated && isset($movieRatings[$movie_id][$i])) ? 'checked' : '' ?>>
                        <label for="rating-<?= $i ?>"><?= $i ?> <?= str_repeat('⭐', $i) ?></label><br>
                    <?php endfor; ?></br>
                    <button type="submit" name="submit_rating" class="btn btn-danger">Send rating</button>
                </form></br>
                <div class="container">
                    <?php if ($submitted): ?>
                        <!-- Success Alert -->
                        <div class="alert alert-success" role="alert">
                            <?= $successMessage ?>
                        </div>
                    <?php else: ?>
                        <?php if (!empty($errorMessage)): ?>
                            <!-- Error Alert -->
                            <div class="alert alert-danger" role="alert">
                                <?= $errorMessage ?>
                            </div>
                        <?php endif; ?>
                        <h3 class="mt-4">Write a Review</h3>
                        <form method="post" action="" class="border p-4 rounded shadow-sm bg-black text-white">
                            <div class="mb-3">
                                <label for="name" class="form-label">Your Name</label>
                                <input
                                    type="text" name="name" required class="form-control"
                                    placeholder="Enter your name" />
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Your Email</label>
                                <input
                                    type="email"
                                    class="form-control"
                                    name="email"
                                    placeholder="Enter your email" />
                            </div>
                            <div class="mb-3">
                                <label for="review" class="form-label">Your Review</label>
                                <textarea
                                    class="form-control"
                                    name="review"
                                    rows="3"
                                    placeholder="Enter your review"></textarea>
                            </div>
                            <div class="form-check mb-3">
                                <input type="checkbox" name="consent" value="1" id="consent" required>
                                <label for="consent">I agree to the processing of personal data.</label><br><br>
                            </div>
                            <button type="submit" class="btn btn-info">Submit</button>

                        </form>
                        <?php
                        //===Display messages based on form submission===
                        // === Check if the form has been submitted and display messages ===
                        if ($submitted) {
                            echo '<p style="color: green;">' . $successMessage . '</p>';
                        } elseif (!empty($errorMessage)) {
                            echo '<p style="color: red;">' . $errorMessage . '</p>';
                        }

                        $conn = db_connect();
                        // === Get reviews for the current movie ===
                        $sqlSelectReviews = "SELECT name, review FROM reviews WHERE movie_id = $movie_id ORDER BY created_at DESC";
                        $result = $conn->query($sqlSelectReviews);

                        echo '<h3 class="mt-4">Reviews for this Movie</h3>';

                        if ($result->num_rows > 0) {
                            // Display each review
                            while ($row = $result->fetch_assoc()) {
                                echo '<div class="card mb-3 bg-light">';
                                echo '  <div class="card-body">';
                                echo '    <h5 class="card-title">' . htmlspecialchars($row["name"]) . '</h5>';
                                echo '    <p class="card-text">' . htmlspecialchars($row["review"]) . '</p>';
                                echo '  </div>';
                                echo '</div>';
                            }
                        } else {
                            // Message if there are no reviews for the current movie
                            echo '<p>Be the first to leave a review for this movie!</p>';
                        }

                        $conn->close(); // Close the connection after reading reviews
                        ?>
                    <?php endif; ?>
                </div>
                <a href="movies.php" class="btn btn-dark mt-3">Back to Archive</a>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-danger">
            Movie not found.
        </div>
    <?php endif; ?>
</div>

<?php require_once("includes/footer.php"); ?>
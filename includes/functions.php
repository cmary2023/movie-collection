<?php
// ===This function checks if a movie is old based on its release year.===
// ===It returns the age of the movie if it is 40 years or older, otherwise returns false.===
function displayOldMovieBadge(int $releaseYear): string
{
    $currentYear = (int)date("Y"); // Get the current year as an integer
    if ($releaseYear < 1900 || $releaseYear > $currentYear) {
        return '<span class="badge bg-danger">Invalid year</span>';
    }
    $age = $currentYear - $releaseYear;

    if ($age > 40) {
        return '<span class="badge bg-warning text-dark">Old movie: ' . $age . ' years</span>';
    } else {
        return '<span class="badge bg-success">New movie</span>';
    }
}

// ===This function formats a given number of minutes into a more readable string format,===
function runtime_prettier($minutes)
{
    //Convert minutes to hours and remaining minutes
    $hours = floor($minutes / 60); //round down to the nearest whole number
    $remainingMinutes = $minutes % 60; //get the remainder of minutes after dividing by 60

    $result = ''; // Initialize an empty result string

    // Append hours to the result(if any)
    if ($hours > 0) {
        $result .= $hours . ' hour' . ($hours > 1 ? 's' : '');/*If there's at least 1 hour, we add it to the result.If there's more than 1, we add "s" to make "hours" plural*/
    }
    // Add minutes (if any)
    if ($remainingMinutes > 0) {
        if ($hours > 0) {
            $result .= ' ';
        }
        $result .= $remainingMinutes . ' minute' . ($remainingMinutes > 1 ? 's' : '');
        /*If there's at least 1 minute, we add it to the result.If there's more than 1, we add "s" to make "minutes" plural*/
    }
    return $result; // Return the formatted string
}


// ===This function retrieves a list of movies from a JSON file.===
function getMovies(string $jsonPath = 'assets/movies-list-db.json'): array
{
    if (!file_exists($jsonPath)) {
        return [];
    }

    $data = file_get_contents($jsonPath);
    $parsed = json_decode($data, true);

    if (json_last_error() !== JSON_ERROR_NONE || !isset($parsed['movies'])) {
        return [];
    }

    return $parsed['movies'];
}
//===This function displays the movie rating based on the provided movie ID and ratings array.===
function displayMovieRating($movie_id, $movieRatings)
{
    if (!isset($movieRatings[$movie_id]) || !is_array($movieRatings[$movie_id]) || empty($movieRatings[$movie_id])) {
        echo "<p>Be the first to rate this movie!</p>";
        return;
    }

    $ratings = $movieRatings[$movie_id];
    $total_votes = 0;
    $sum = 0;
    foreach ($ratings as $note => $count) {
        $total_votes += (int)$count;
        $sum += (int)$note * (int)$count;
    }
    if ($total_votes > 0) {
        $average = round($sum / $total_votes, 2);
        echo "<p>The average rating is: <strong>$average / 5 ⭐</strong></p>";
        echo "<p><strong>$total_votes visitors</strong> have rated this movie.</p>";
    } else {
        echo "<p>Be the first to rate this movie!</p>";
    }
}
//===This function connects to a MySQL database using the provided credentials.===
//// It returns the connection object if successful, or exits with an error message if it fails.
function db_connect($host = "localhost", $user = "php-user", $password = "php-password", $dbname = "php-proiect")
{
    $conn = mysqli_connect($host, $user, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}

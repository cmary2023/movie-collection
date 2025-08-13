<?php
$data = json_decode(file_get_contents('./assets/movies-list-db.json'), true);
$genres = $data['genres'];
$movies = $data['movies'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cornea Maria</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT"
        crossorigin="anonymous" />
    <link rel="stylesheet" href="style.css" />
</head>

<body data-bs-spy="scroll" data-bs-target="#myScrollSpy" data-bs-root-margin="0px 0px -40%" data-bs-smooth-scroll="true"
    tabindex="0" id="top">

    <!--Navbar-->
    <?php
    // Include the header file
    require_once("includes/header.php");
    // Setează fusul orar pe București
    date_default_timezone_set('Europe/Bucharest');

    // Obține ora curentă (format 24h)
    $hour = date("H");

    // Determină mesajul în funcție de oră
    function getGreetingMessage($hour)
    {
        if ($hour >= 5 && $hour < 12) {
            return "Good Morning";
        } elseif ($hour >= 12 && $hour < 17) {
            return "Good Afternoon";
        } elseif ($hour >= 17 && $hour < 22) {
            return "Good Evening";
        } else {
            return "Good Night";
        }
    }

    $greeting = getGreetingMessage($hour);
    ?>
    <!--End of Navbar-->

    <!-- Home Section -->
    <section id="home">
        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active" data-bs-interval="5000">
                    <img src="./images/avatar.jpg" class="img" alt="avatar">
                    <div class="carousel-caption">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="home-carousel">
                                    <div class="gen-tag-line"><span>Top Rated</span></div>
                                    <div class="gen-movie-info mt-3">
                                        <h3 class="fs-1">Avatar:The way of water</h3>
                                    </div>
                                    <div class="gen-meta-after-title">
                                        <img src="./images/imdb.png" alt="imdb">
                                        <span class="ms-1">7.5 </span>
                                    </div>
                                    <div class="gen-meta-desc">
                                        <p class="mt-3">Jake Sully lives with his newfound family formed on the extrasolar moon Pandora. Once a familiar threat returns to finish what was previously started, Jake must work with Neytiri and the army of the Na'vi race to protect their home.
                                        </p>
                                    </div>
                                    <div class="gen-meta-info mt-4">
                                        <ul class="gen-meta-after-excerpt">

                                            <li class="mb-2">
                                                <strong>Genre :</strong>
                                                <span> Adventure,</span>
                                                <span>Action,</span>
                                                <span>Sci-fi</span>
                                            </li>

                                        </ul>
                                    </div>
                                    <div class="gen-meta-btn mt-4">
                                        <a href="movie-1.php" target="_blank">
                                            <button type="button"><i class="fa-solid fa-circle-info"></i>
                                                &nbsp;View Details</button>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 home-right-video">
                                <iframe width="560" height="315" src="https://www.youtube.com/embed/d6xdV8VAqBY?si=MD0QbeEmiWu8yFi7" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="carousel-item" data-bs-interval="5000">
                    <img src="./images/twilight.jpg" class="img opacity-75" alt="money-heist">
                    <div class="carousel-caption">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="home-carousel">
                                    <div class="gen-tag-line"><span>Dark Fantasy</span></div>
                                    <div class="gen-movie-info mt-3">
                                        <h3 class="fs-1">Twilight</h3>
                                    </div>
                                    <div class="gen-meta-after-title">
                                        <img src="./images/imdb.png" alt="imdb">
                                        <span class="ms-1">5.3</span>
                                    </div>
                                    <div class="gen-meta-desc">
                                        <p class="mt-3">
                                            When Bella Swan moves to a small town in the Pacific Northwest, she falls in love with Edward Cullen, a mysterious classmate who reveals himself to be a 108-year-old vampire.
                                        </p>
                                    </div>
                                    <div class="gen-meta-info mt-4">
                                        <ul class="gen-meta-after-excerpt">

                                            <li class="mb-2">
                                                <strong>Genre :</strong>
                                                <span> Fantasy,</span>
                                                <span>Romance</span>
                                                <span>Drama</span>
                                            </li>

                                        </ul>
                                    </div>
                                    <div class="gen-meta-btn mt-4">
                                        <a href="movie-2.php" target="_blank">
                                            <button type="button"><i class="fa-solid fa-circle-info"></i>
                                                &nbsp;View Details</button>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 home-right-video">
                                <iframe width="560" height="315" src="https://www.youtube.com/embed/nxvGVSc6Ls8?si=b6kfNl9aU6JKHY8y" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="carousel-item">
                    <img src="./images/escape_room.jpg" class="img opacity-75" alt="kong-skull-island">
                    <div class="carousel-caption">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="home-carousel">
                                    <div class="gen-tag-line"><span>Psihological Thriller</span></div>
                                    <div class="gen-movie-info mt-3">
                                        <h3 class="fs-1">Escape Room</h3>
                                    </div>
                                    <div class="gen-meta-after-title">
                                        <img src="./images/imdb.png" alt="imdb">
                                        <span class="ms-1">6.4</span>
                                    </div>
                                    <div class="gen-meta-desc">
                                        <p class="mt-3">Six strangers find themselves in a maze of deadly mystery rooms and must use their wits to survive.
                                        </p>
                                    </div>
                                    <div class="gen-meta-info mt-4">
                                        <ul class="gen-meta-after-excerpt">

                                            <li class="mb-2">
                                                <strong>Genre :</strong>
                                                <span> Action,</span>
                                                <span>Adventure,</span>
                                                <span>Horror</span>
                                            </li>

                                        </ul>
                                    </div>
                                    <div class="gen-meta-btn">
                                        <a href="movie-3.php" target="_blank">
                                            <button type="button"><i class="fa-solid fa-circle-info"></i>
                                                &nbsp;View Details</button>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 home-right-video">
                                <iframe width="560" height="315" src="https://www.youtube.com/embed/6dSKUoV0SNI?si=wvUQ4z3y3xQtOUSQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                            </div>

                        </div>
                    </div>
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section>
    <h1><?= $greeting ?>! Welcome to our website.</h1>
    <!-- Movies-->
    <section class="new-movies" id="new">
        <div class="container">
            <h2 class="text-center">MOVIES BY GENRES</h2>
            <hr>
            <div class="container ">
                <?php foreach ($genres as $genre): ?>
                    <?php
                    $genreMovies = array_filter($movies, fn($movie) => in_array($genre, $movie['genres']));
                    $genreMovies = array_slice($genreMovies, 0, 4); // max 4 filme pe gen
                    if (count($genreMovies) === 0) continue;
                    ?>
                    <section class="mb-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="text-light" style="color: yellow;"><?= htmlspecialchars($genre) ?></h3>
                            <a href="genres.php?genre=<?= urlencode($genre) ?>" class="btn btn-outline-light btn-sm">Vezi toate</a>
                        </div>
                        <div class="row">
                            <?php foreach ($genreMovies as $movie): ?>
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                    <a href="movie.php?movie_id=<?= urlencode($movie['id']) ?>" class="text-decoration-none text-light">
                                        <div class="card movie-cards h-100">
                                            <img src="<?= htmlspecialchars($movie['posterUrl']) ?>" class="card-img-top" alt="<?= htmlspecialchars($movie['title']) ?> poster">
                                            <div class="card-body">
                                                <h5 class="card-title"><?= htmlspecialchars($movie['title']) ?></h5>
                                                <p class="card-text"><?= htmlspecialchars($movie['year']) ?></p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endforeach; ?>
            </div>
        </div>
        <!-- End of .container -->

        <?php require_once("includes/footer.php"); ?>
        <!--End of Footer-->

        <!--Bootstrap JS-->
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
            crossorigin="anonymous">
        </script>
</body>

</html>
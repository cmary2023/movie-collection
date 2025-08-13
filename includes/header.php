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

<body data-bs-spy="scroll" data-bs-target="#myScrollSpy" data-bs-root-margin="0px 0px -40%" data-bs-smooth-scroll="true" tabindex="0" id="top">

    <?php
    // Include config
    require_once("config.php");
    require_once("functions.php");

    // Brand and navbar items
    $brand = [
        'logo' => 'images/movie_logo.png',
        'alt' => 'logo'
    ];
    // Include favorites.php to get the $voted_movies array
    include('favorites.php');
    $navbarItems = [
        ['name' => 'Home', 'link' => 'index.php'],
        ['name' => 'Movies', 'link' => 'movies.php'],
        ['name' => 'Genres', 'link' => 'genres.php'],
        ['name' => 'Favorites', 'link' => 'movies.php?page=favorites'],
        ['name' => 'Contact', 'link' => 'contact.php']
    ];
    // ===Remove "Favorites" if no favorite movies exist ===
    if (empty($voted_movies)) {
        $navbarItems = array_filter($navbarItems, function ($item) {
            return $item['name'] !== 'Favorites';
        });

        // Reindex the array to maintain sequential keys
        $navbarItems = array_values($navbarItems);
    }

    // ===Get the current page name to highlight the active link===
    $currentPage = basename($_SERVER['PHP_SELF']); // Ex: "movies.php"
    require_once("functions.php");
    ?>
    <!-- Navbar -->
    <header>
        <nav class="navbar navbar-expand-lg" style="background-color:rgb(253, 0, 0);" id="myScrollSpy">
            <div class="container">
                <a class="navbar-brand d-flex" href="index.php">
                    <img src="<?= htmlspecialchars($brand['logo']) ?>" alt="<?= htmlspecialchars($brand['alt']) ?>" width="40" class="align-text-top">
                    <div class="initials"><?= AUTHOR_INITIALS ?></div>
                    <h4 class="mt-2 ms-2"><span>Cinema</span></h4>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <ul class="navbar-nav ms-auto mb-lg-0 p-md-2">
                        <?php foreach ($navbarItems as $item): ?>
                            <?php
                            $isActive = ($currentPage === $item['link']) ? 'active' : '';
                            ?>
                            <li class="nav-item me-2">
                                <a class="nav-link <?= $isActive ?>" href="<?= htmlspecialchars($item['link']) ?>">
                                    <?= htmlspecialchars($item['name']) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php require_once("search-form.php"); ?>
                </div>
            </div>
        </nav>
    </header>

    <!-- Movies Array -->
    <?php
    $currentFile = basename($_SERVER['PHP_SELF']); // Get the current file name

    // Include funcția getMovies()
    include_once("functions.php");

    // Check if the current file is not index.php or contact.php
    if ($currentFile !== 'index.php' && $currentFile !== 'contact.php') {
        // Define the movies array only if not on index.php or contact.php
        // This prevents the movies array from being defined on those pages
        // so that it can be used in other pages like movies.php
        // This is useful for pages that need to display movie details
        // or a list of movies without duplicating the array definition.
        $movies = getMovies();
    }

    ?>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
        crossorigin="anonymous"></script>

</body>

</html>
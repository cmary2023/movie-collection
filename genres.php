<?php
// Load genres from JSON
$data = json_decode(file_get_contents('./assets/movies-list-db.json'), true);
$genres = $data['genres'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Genres</title>
    <link rel="stylesheet" href="style.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous" />
</head>

<body class="movie-back">

    <?php require_once("includes/header.php"); ?>

    <section class="py-5">
        <div class="container">
            <h1 class="text-center mb-4">Browse by Genre</h1>
            <div class="row justify-content-center">
                <?php foreach ($genres as $genre): ?>
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-3 text-center">
                        <a href="movies.php?genre=<?= urlencode($genre) ?>" class="btn btn-outline-primary w-100">
                            <?= htmlspecialchars($genre) ?>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous">
    </script>
    <?php include("includes/footer.php"); ?>
</body>

</html>
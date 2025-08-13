 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8" />
     <meta name="viewport" content="width=device-width, initial-scale=1.0" />
     <title>Cornea Maria</title>
     <link rel="stylesheet" href="style.css" />
     <link
         href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css"
         rel="stylesheet"
         integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT"
         crossorigin="anonymous" />
 </head>

 <body class="movie-back">

     <!--New Movies-->
     <section class="new-movies" id="new">
         <div class="container">
             <h2 class="text-center">Archive Movies</h2>
             <hr>
             <div class="row mt-4">
                 <?php foreach ($movies as $movie): ?> <!-- Loop through each movie and render the card -->

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
                                            // Display the plot or description, trimmed to 100 characters if it's too long 
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
             </div>
         </div>
     </section>
 </body>

 </html>
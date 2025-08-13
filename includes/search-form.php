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

 <body>
     <ul class="navbar-nav">
         <li class="nav-item me-2">
             <a class="nav-link" href="#">
                 <i class="fa fa-search" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Search Movies"></i>
             </a>
         </li>
     </ul>

     <?php
        $searchValue = '';
        // Check if 'search' or 's' parameter is set in the query string
        if (!empty($_GET['search'])) {
            $searchValue = trim($_GET['search']);
        } elseif (!empty($_GET['s'])) {
            $searchValue = trim($_GET['s']);
        } elseif (!empty($_GET['q'])) {
            $searchValue = trim($_GET['q']);
        }
        ?>

     <form class="d-flex" role="search" action="search-results.php" method="get">
         <input class="form-control me-2" type="search" name="s" placeholder="Search movies..." value="<?= isset($searchValue) ? htmlspecialchars($searchValue) : '' ?>" aria-label="Search">
         <button class="btn btn-outline-dark" id="searchBtn" type="submit">Search</button>
     </form>
 </body>

 </html>
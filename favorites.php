<?php
$voted_movies = [];
if (isset($_COOKIE['voted_movies']) && !empty($_COOKIE['voted_movies'])) {
    $decoded = json_decode($_COOKIE['voted_movies'], true);
    if (is_array($decoded)) {
        $voted_movies = $decoded;
    }
}

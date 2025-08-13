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
<!--Main content-->

<body class="contact-body">
  <!--Navbar-->
  <?php
  // Include the header file
  require_once("includes/header.php");
  ?>
  <!--End of Navbar-->

  <!-- Hero Section -->
  <section class="hero-section" style="background: linear-gradient(rgba(40,40,40,0.7),rgba(40,40,40,0.7)), url('https://img.freepik.com/free-vector/composition-cinema-elements-red-background_1419-2239.jpg?semt=ais_hybrid&w=740') center/cover no-repeat; color: #fff; padding: 60px 0 40px 0; text-align: center;">
    <div class="container">
      <h1 style="font-size: 2.5rem; font-weight: bold; margin-bottom: 18px;">Contact Us</h1>
      <p style="font-size: 1.2rem; margin-bottom: 25px;">
        We'd love to hear from you! Reach out with any questions, suggestions, or feedback.
      </p>
      <a href="movies.php" class="btn btn-primary btn-lg">Browse New Movies</a>
    </div>
  </section>
  <!-- End Hero Section -->

  <!--Contact Form-->
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <p style="font-weight: bold;">Email: info@corneamaria.com</p>
        <p><strong>Phone:</strong> +1 234 567 8901</p>
        <p><strong>Address:</strong> 123 Movie Lane, Film City, Country</p>
        <hr />
        <form class="contact-form">
          <div class="mb-3">
            <label for="name" class="form-label">Your Name</label>
            <input
              type="text"
              class="form-control"
              id="name"
              placeholder="Enter your name" />
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Your Email</label>
            <input
              type="email"
              class="form-control"
              id="email"
              placeholder="Enter your email" />
          </div>
          <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea
              class="form-control"
              id="message"
              rows="3"
              placeholder="Type your message">
            </textarea>
          </div>
          <button type="submit" class="btn btn-primary">Send</button>
        </form>
      </div>
    </div>
  </div>
  <!--End of Content-->

  <!--Footer-->
  <?php
  // Include the footer file
  require_once("includes/footer.php");
  ?>
  <!--End of Footer-->
  <!--Bootstrap JS-->
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
    crossorigin="anonymous">
  </script>
</body>

</html>
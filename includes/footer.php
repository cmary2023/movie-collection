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
     <?php
        if (!defined('AUTHOR_INITIALS')) {
            define('AUTHOR_INITIALS', 'MC');
        }
        ?>

     <!--Footer-->
     <div class="footer" style=" background-color:rgb(250, 0, 13);">
         <p>&copy; <?php echo date('Y') . ' ' . AUTHOR_INITIALS; ?>. All rights reserved.</p>
     </div>
     <!--End of Footer-->
 </body>

 </html>
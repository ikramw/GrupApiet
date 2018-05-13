<?php if(!isset($_SESSION["loggedIn"])) {
     header('Location: index.php');
} ?>

<?php if (isset($_SESSION["loggedIn"])): ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="css/style.css">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500|Roboto+Slab:300,400|Open+Sans:400,700" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <title>Frontend</title>
</head>

<body>
  <header class="header-navbar">
    <div class="nav-content">
      <div class="logo-wrapper">
          <a href="index.html"><img src="images/logo-white-small.png" class="logo" alt="Logo"></a>
      </div>
      <nav class="nav-main" id="content-toggle">
        <ul class="nav-menu">
          <li><a href="#" class="active">Home</a></li>
          <li><a href="#">Creators</a></li>
          <li><a href="#">Entries</a></li>
          <li><a href="#">Comments</a></li>
        </ul>
        <div class="nav-test">
          <input type="text" placeholder="Search" class="nav-search">
          <button type="submit" class="search-submit"><i class="fa fa-search"></i></button>

            <a href="#">Your Profile</a>
            <a href="#">Sign out</a>

        </div>
      </nav>
      <div id="mobile-menu">
        <a href="#" onclick="navToggle(); return false;">
          <i class="fa fa-bars"></i>
        </a>
      </div>
    </div>
  </header>

  <footer class="footer">
      <?php
        echo "<p>Copyright &copy; 2016-" . date("Y") . " company-name.com</p>";
      ?>
  </footer>

  <script src="scripts/main.js"></script>
</body>

</html>
<?php endif; ?>

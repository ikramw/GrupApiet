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
          <a href="index.html"><img src="images/logo.png" class="logo" alt="Logo"></a>
      </div>
      <nav class="nav-main" id="content-toggle">
        <ul class="nav-menu">
          <li><a href="#" onclick="showEntries()" class="active">Entries</a></li>
          <li><a href="#" onclick="showUsers()">Users</a></li>
          <li><a href="#" onclick="showComments()">Comments</a></li>
        </ul>
        <div class="nav-test">
          <input type="text" placeholder="Search" class="nav-search">
          <button type="submit" class="search-submit"><i class="fa fa-search"></i></button>

          <!-- Om användaren är utloggad visas: -->
          <?php if (!isset($_SESSION["loggedIn"])): ?>
            <a href="#">Sign in</a>
            <a href="#">Register</a>
          <?php endif; ?>

          <!-- Annars visas: -->
          <?php if (isset($_SESSION["loggedIn"])): ?>
            <a href="home.php">Your Profile</a>
            <a href="logout.php">Sign out</a>
          <?php endif; ?>

        </div>
      </nav>
      <div id="mobile-menu">
        <a href="javascript:void(0)" onclick="navToggle(); return false;">
          <i class="fa fa-bars"></i>
        </a>
      </div>
    </div>
  </header>

  <!-- Info om sidan för användare som inte har en blogg
  Visas bara om användaren inte är inloggad -->
  <?php if (!isset($_SESSION["loggedIn"])): ?>
    <section class="header-info">
      <div class="info-content">
        <h1>Create your own free blog</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing
          elit. Sed eu nunc id enim sodales cursus elementum
          quis turpis. Ut ac elit id ante egestas lacinia.</p>
        <button>Get started</button>
      </div>
    </section>
  <?php endif; ?>

  <div class="content-wrapper">
    <!-- Section som visar entries.
        Har skapat några entries direkt i html bara för att se hur det
        kommer att se ut. Valde att lägga till bilder i en ny mapp uploads,
        ifall det går att fixa så att man kan ladda upp bilder till inläggen -->
    <section class="entries-wrapper" id="entries-wrapper">
      <div class="display-number">
        <h1>Explore entries</h1>
        <div class="elements-displayed">
          <span>VIEW</span>
          <select>
            <option value="20">20</option>
            <option value="40">40</option>
            <option value="60">60</option>
            <option value="all">All</option>
          </select>
        </div>
      </div>
      <div class="entries-content">
        <article class="new-entry">
          <div class="entry-content">
            <h1><a href="#">Lorem Ipsum</a></h1>
            <img src="uploads/pencils.jpg" alt="Bild" />
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
              Sed eu nunc id enim sodales cursus elementum quis turpis.
              Ut ac elit id ante egestas lacinia...</p>
          </div>
          <div class="entry-info">
            <a href="#"><i class="fa fa-user"></i> username</a>
            <p>2018-03-24 17:45</p>
          </div>
        </article>
        <article class="new-entry">
          <div class="entry-content">
            <h1><a href="#">Lorem Ipsum</a></h1>
            <img src="uploads/bicycle.jpg" alt="Bild" />
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
              Sed eu nunc id enim sodales cursus elementum quis turpis.
              Ut ac elit id ante egestas lacinia...</p>
          </div>
          <div class="entry-info">
            <a href="#"><i class="fa fa-user"></i> username</a>
            <p>2018-03-24 17:45</p>
          </div>
        </article>
        <article class="new-entry">
          <div class="entry-content">
            <h1><a href="#">Lorem Ipsum</a></h1>
            <img src="uploads/flower.jpg" alt="Bild" />
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
              Sed eu nunc id enim sodales cursus elementum quis turpis.
              Ut ac elit id ante egestas lacinia...</p>
          </div>
          <div class="entry-info">
            <a href="#"><i class="fa fa-user"></i> username</a>
            <p>2018-03-24 17:45</p>
          </div>
        </article>
        <article class="new-entry">
          <div class="entry-content">
            <h1><a href="#">Lorem Ipsum</a></h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
              Sed eu nunc id enim sodales cursus elementum quis turpis.
              Ut ac elit id ante egestas lacinia. Sed eu nunc id enim sodales cursus elementum quis turpis.
              Ut ac elit id ante egestas lacinia...</p>
          </div>
          <div class="entry-info">
            <a href="#"><i class="fa fa-user"></i> username</a>
            <p>2018-03-24 17:45</p>
          </div>
        </article>
        <article class="new-entry">
          <div class="entry-content">
            <h1><a href="#">Lorem Ipsum</a></h1>
            <img src="uploads/railway.jpg" alt="Bild" />
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
              Sed eu nunc id enim sodales cursus elementum quis turpis.
              Ut ac elit id ante egestas lacinia...</p>
          </div>
          <div class="entry-info">
            <a href="#"><i class="fa fa-user"></i> username</a>
            <p>2018-03-24 17:45</p>
          </div>
        </article>
        <article class="new-entry">
          <div class="entry-content">
            <h1><a href="#">Lorem Ipsum</a></h1>
            <img src="uploads/photographer.jpg" alt="Bild" />
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
              Sed eu nunc id enim sodales cursus elementum quis turpis.
              Ut ac elit id ante egestas lacinia...</p>
          </div>
          <div class="entry-info">
            <a href="#"><i class="fa fa-user"></i> username</a>
            <p>2018-03-24 17:45</p>
          </div>
        </article>
      </div>
    </section>

    <!-- Section som visar users -->
    <section class="users-wrapper" id="users">
      <div class="display-number">
        <h1>Explore users</h1>
        <div class="elements-displayed">
          <span>VIEW</span>
          <select>
            <option value="20">20</option>
            <option value="40">40</option>
            <option value="60">60</option>
            <option value="all">All</option>
          </select>
        </div>
      </div>
      <div class="users-content">
        <div class="user">
          <img src="images/profile-picture.png" />
          <h2><a href="#">johannas</a></h2>
          <p>Joined April 15, 2017</p>
          <button>Visit user</button>
        </div>
        <div class="user">
          <img src="images/profile-picture.png" />
          <h2><a href="#">johannas</a></h2>
          <p>Joined April 15, 2017</p>
          <button>Visit user</button>
        </div>
        <div class="user">
          <img src="images/profile-picture.png" />
          <h2><a href="#">johannas</a></h2>
          <p>Joined April 15, 2017</p>
          <button>Visit user</button>
        </div>
        <div class="user">
          <img src="images/profile-picture.png" />
          <h2><a href="#">johannas</a></h2>
          <p>Joined April 15, 2017</p>
          <button>Visit user</button>
        </div>
        <div class="user">
          <img src="images/profile-picture.png" />
          <h2><a href="#">johannas</a></h2>
          <p>Joined April 15, 2017</p>
          <button>Visit user</button>
        </div>
      </div>
    </section>

    <!-- Section som visar comments -->
    <section class="comments-wrapper" id="comments">
      <div class="display-number">
        <h1>Explore comments</h1>
        <div class="elements-displayed">
          <span>VIEW</span>
          <select>
            <option value="20">20</option>
            <option value="40">40</option>
            <option value="60">60</option>
            <option value="all">All</option>
          </select>
        </div>
      </div>
    </section>

  </div>

  <footer class="footer">
      <?php
        echo "<p>Copyright &copy; 2016-" . date("Y") . " company-name.com</p>";
      ?>
  </footer>

  <script src="scripts/main.js"></script>
</body>

</html>

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
  <link href="https://fonts.googleapis.com/css?family=Muli:400,700|Open+Sans:400,700" rel="stylesheet">
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
        <ul class="nav-menu-left">
          <li><a href="#" onclick="showEntries()" class="active" id="entries-link">Entries</a></li>
          <li><a href="#" onclick="showUsers()" id="users-link">Users</a></li>
          <li><a href="#" onclick="showComments()" id="comments-link">Comments</a></li>
        </ul>
        <div class="nav-menu-right">
          <input type="text" placeholder="Search" class="nav-search">
          <button type="submit" class="search-submit"><i class="fa fa-search"></i></button>

          <!-- Om användaren är utloggad visas: -->
          <?php if (!isset($_SESSION["loggedIn"])): ?>
            <a href="javascript:void(0)" onclick="showSignin()">Sign in</a>
            <div class="login-form" id="login-form">
              <h3>Sign in</h3>
              <form action="" method="post">
                <label for="username">Username:</label>
                <input type="text" name="username" class="form-input" id="username" />
                <label for="password">Password:</label>
                <input type="password" name="password" class="form-input" id="password" />
                <input type="submit" id="submit" value="Submit" />
              </form>
            </div>
            <a href="javascript:void(0)" onclick="showRegister()">Register</a>
            <div class="register-form" id="register-form">
              <h3>Register</h3>
              <form action="" method="post">
                <label for="username">Username:</label>
                <input type="text" name="username" class="form-input" id="username" />
                <label for="password">Password:</label>
                <input type="password" name="password" class="form-input" id="password" />
                <input type="submit" id="submit" value="Submit" />
              </form>
            </div>
          <?php endif; ?>

          <!-- Annars visas: -->
          <?php if (isset($_SESSION["loggedIn"])): ?>
            <a href="#">Your Profile</a>
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

  <div class="content-wrapper">

    <section class="single-user-wrapper">

    </section>

    <!-- Visar ett inlägg och kommentarer till inlägget -->
    <section class="single-entry-wrapper">
      <article class="single-entry">
        <div class="single-entry-content">
          <div class="single-entry-info">
            <h1>This is the title of the entry</h1>
            <span>Written by </span><a href="#">username</a>
            <p>15 MAY 2018 - 17:45</p>
          </div>
          <img src="uploads/flower.jpg" alt="Bild" />
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
            Sed eu nunc id enim sodales cursus elementum quis turpis.
            Ut ac elit id ante egestas lacinia. Curabitur felis odio, lacinia
            quis orci id, porttitor bibendum sapien. Morbi porta, leo et ornare
            faucibus, tortor augue tincidunt mauris, vitae molestie mi diam vel
            massa. Cras id condimentum sem. Phasellus orci neque, sollicitudin
            sit amet tincidunt eget, varius eu ipsum. Vivamus accumsan, velit
            nec vulputate accumsan, lacus eros sagittis sapien, a pharetra odio
            leo a est. Aenean et dolor libero. Nullam egestas, augue eu mollis
            hendrerit, est quam ullamcorper arcu, fermentum molestie sapien
            neque quis massa. Ut rutrum diam id odio imperdiet, id dapibus nisi
            dictum. Fusce fermentum, urna auctor rutrum mattis, quam sapien
            dictum augue, ut tincidunt nibh enim in turpis.</p>
        </div>
      </article>
      <section class="entry-comments">
        <h2 class="heading-response"><span id="comments-amount">3</span> responses to <span id="entry-title">"Titel av inlägget"</span></h2>
        <div class="entry-comment">
          <div class="comment-profile-picture">
            <img src="images/profile-picture.png"/>
          </div>
          <div class="comment-text">
            <a href="#">username</a>
            <p class="display-time">2018-03-24 17:45</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
              Sed eu nunc id enim sodales cursus elementum quis turpis.
              Ut ac elit id ante egestas lacinia.</p>
          </div>
        </div>
        <div class="entry-comment">
          <div class="comment-profile-picture">
            <img src="images/profile-picture.png"/>
          </div>
          <div class="comment-text">
            <a href="#">username</a>
            <p class="display-time">2018-03-24 17:45</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec
              sed leo in lectus varius cursus. Suspendisse ornare eget nisi sit
              amet fringilla. Curabitur lacinia, massa commodo tempus tincidunt,
              sapien neque hendrerit lorem, vitae fermentum dolor nunc et ipsum.
              Mauris et enim et urna elementum venenatis. Nulla et est ac est
              feugiat pellentesque eget et urna. Quisque rutrum nunc sit amet
              fermentum luctus. Aenean at pretium ipsum. Cras malesuada arcu nec
              suscipit semper. Quisque dapibus ac augue at iaculis. Nunc non mattis
              dolor, nec congue urna. Nam nec nisl neque. Nulla ullamcorper mauris
              vitae neque cursus, posuere convallis eros tempor. Nam consectetur,
              tortor sed egestas pharetra, ante sapien ullamcorper tellus, id
              posuere est mauris in lorem.</p>
          </div>
        </div>
        <div class="entry-comment">
          <div class="comment-profile-picture">
            <img src="images/profile-picture.png"/>
          </div>
          <div class="comment-text">
            <a href="#">username</a>
            <p class="display-time">2018-03-24 17:45</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
              Sed eu nunc id enim sodales cursus elementum quis turpis.
              Ut ac elit id ante egestas lacinia.</p>
          </div>
        </div>

        <div class="leave-comment-wrapper">
          <?php if (!isset($_SESSION["loggedIn"])): ?>
            <h2 class="comment-message">Sign in to leave a comment</h2>
          <?php endif; ?>

          <?php if (isset($_SESSION["loggedIn"])): ?>
            <h2>Leave a comment</h2>
            <form action="" method="post">
              <textarea name="comment">Write your comment here...</textarea>
              <input type="submit" id="submit" value="Post comment" />
            </form>
          <?php endif; ?>
        </div>
      </section>
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
<?php endif; ?>

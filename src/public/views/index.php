<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="css/style.css">
  <link href="https://fonts.googleapis.com/css?family=Muli:400,700|Open+Sans:400,700" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <title>Gruppuppgift - API</title>
</head>

<body>
  <header class="header-navbar">
    <div class="nav-content">
      <div class="logo-wrapper">
          <a href="#"><img src="images/logo.png" class="logo" alt="Logo"></a>
      </div>
      <nav class="nav-main" id="content-toggle">
        <ul class="nav-menu-left">
          <li><a href="#" onclick="getAllEntries()" class="active" id="entries-link">Entries</a></li>
          <li><a href="#" onclick="getAllUsers()" id="users-link">Users</a></li>
          <li><a href="#" onclick="getAllComments()" id="comments-link">Comments</a></li>
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
                <label for="login-username">Username:</label>
                <input type="text" name="username" class="form-input" id="login-username" />
                <label for="login-password">Password:</label>
                <input type="password" name="password" class="form-input" id="login-password" />
                <input type="submit" id="login-submit" value="Submit" />
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

  <!-- Info om sidan för användare som inte har en blogg
  Visas bara om användaren inte är inloggad -->
  <?php if (!isset($_SESSION["loggedIn"])): ?>
    <section class="header-info" id="frontpage-header">
      <div class="info-content">
        <h1>Create your own free blog</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing
          elit. Sed eu nunc id enim sodales cursus elementum
          quis turpis. Ut ac elit id ante egestas lacinia.</p>
      </div>
    </section>
  <?php endif; ?>

  <!-- Namnet på användaren vars sida man är inne på -->
  <section class="header-info display-username" id="display-username">
    <div class="info-content">
      <h1 id="usernames-blog"></h1>
    </div>
  </section>

  <div class="content-wrapper" id="content-wrapper">
    <!-- Section som visar entries -->
    <section class="entries-wrapper" id="entries">
      <div class="elements-displayed-wrapper">
        <h1>Explore entries</h1>
        <div class="elements-displayed">
          <span>VIEW</span>
          <select id="selectEntryAmount" onchange="getAllEntries()">
            <option value="20">20</option>
            <option value="40">40</option>
            <option value="60">60</option>
            <option value="100">100</option>
          </select>
        </div>
      </div>
      <div class="entries-content" id="entries-content">
        <!-- Fylls på med entries -->
      </div>
    </section>

    <!-- Section som visar users -->
    <section class="users-wrapper" id="users">
      <div class="elements-displayed-wrapper">
        <h1>Explore users</h1>
        <div class="elements-displayed">
          <span>VIEW</span>
          <select id="selectUserAmount" onchange="getAllUsers()">
            <option value="20">20</option>
            <option value="40">40</option>
            <option value="60">60</option>
            <option value="100">100</option>
          </select>
        </div>
      </div>
      <div class="users-content" id="users-content">
        <!-- Fylls på med users -->
      </div>
    </section>

    <!-- Section som visar comments -->
    <section class="comments-wrapper" id="comments">
      <div class="elements-displayed-wrapper">
        <h1>Explore comments</h1>
        <div class="elements-displayed">
          <span>VIEW</span>
          <select id="selectCommentsAmount" onchange="getAllComments()">
            <option value="20">20</option>
            <option value="40">40</option>
            <option value="60">60</option>
            <option value="all">All</option>
          </select>
        </div>
      </div>
      <div class="comments-content" id="comments-content">
        <!-- Fylls på med comments -->
      </div>
    </section>

    <!-- Section som visar en användare och dennes inlägg -->
    <section class="single-user-wrapper" id="single-user">
      <!--<article class="single-entry">
        <div class="single-entry-info">
          <h1><a href="#" onclick="showSingleEntry()">This is the title of the entry</a></h1>
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
          <p>3 comments</p>
      </article>-->
    </section>

    <!-- Visar ett inlägg och kommentarer till inlägget -->
    <section class="single-entry-wrapper" id="single-entry">
      <div id="single-entry-content">
        <!-- Fylls på med ett entry -->
      </div>
      <section class="entry-comments">
        <h2 class="heading-responses"><span id="comments-amount"></span> responses</h2>
        <div class="comments-displayed">
          <span>VIEW</span>
          <select id="selectCommentAmount">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="all">All</option>
          </select>
        </div>
        <div id="entry-comments-content">
          <!-- Fylls på med kommentarer -->
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

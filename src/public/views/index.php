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
          <img src="images/logo.png" class="logo" alt="Logo">
      </div>
      <nav class="nav-main" id="content-toggle">
        <ul class="nav-menu-left">
          <li><a href="#" onclick="getAllEntries()" class="active" id="entries-link">Entries</a></li>
          <li><a href="#" onclick="getAllUsers()" id="users-link">Users</a></li>
        </ul>
        <div class="nav-menu-right">
          <input type="text" placeholder="Search" id="search" class="nav-search">
          <button type="submit" class="search-submit" onclick="searchByTitle()"><i class="fa fa-search"></i></button>

          <!-- Om användaren är utloggad visas: -->
          <?php if (!isset($_SESSION["loggedIn"])): ?>
            <a href="javascript:void(0)" onclick="showSignin()">Sign in</a>
            <div class="login-form" id="login-form">
              <h3>Sign in</h3>
              <form>
                <label for="login-username">Username:</label>
                <input type="text" name="username" class="form-input" id="login-username" />
                <label for="login-password">Password:</label>
                <input type="password" name="password" class="form-input" id="login-password" />
                <input type="button" id="login-submit" value="Submit" onclick="login()"/>
              </form>
            </div>
            <a href="javascript:void(0)" onclick="showRegister()">Register</a>
            <div class="register-form" id="register-form">
              <h3>Register</h3>
              <form>
                <label for="username">Username:</label>
                <input type="text" name="username" class="form-input" id="username" />
                <label for="password">Password:</label>
                <input type="password" name="password" class="form-input" id="password" />
                <input type="button" id="submit" value="Submit" onclick="registerUser()"/>
              </form>
            </div>
          <?php endif; ?>

          <!-- Annars visas: -->
          <?php if (isset($_SESSION["loggedIn"])): ?>
            <a href="#" onclick="getProfile()" id="profile-link">My Profile</a>
            <a href="#" id="logout" onclick="logOut()">Sign out</a>
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
    <section class="header-info" id="frontpage-header">
      <?php if (!isset($_SESSION["loggedIn"])): ?>
      <div class="info-content">
        <h1>Create your own free blog</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing
          elit. Sed eu nunc id enim sodales cursus elementum
          quis turpis. Ut ac elit id ante egestas lacinia.</p>
      </div>
      <?php endif; ?>
      <?php if (isset($_SESSION["loggedIn"])): ?>
          <div class="dashboard">
            <h1 class="welcome-text">Welcome, <?php echo $_SESSION["username"] ?>!</h1>
            <hr />
            <div class="dashboard-list">
              <ul>
                <li><a href="#" onclick="showCreatePost()"><i class="fa fa-edit"></i> Write a blog post</a></li>
                <li><a href="#" onclick="getProfile()"><i class="fa fa-desktop"></i> Visit your profile</a></li>
              </ul>
            </div>
          </div>
      <?php endif; ?>
    </section>

  <!-- Namnet på användaren vars sida man är inne på -->
  <section class="header-info display-username" id="display-username">
    <div class="info-content">
      <h1 id="usernames-blog"></h1>
    </div>
  </section>

  <div class="content-wrapper" id="content-wrapper">
    <!-- Inloggad användares sida -->
    <?php if (isset($_SESSION["loggedIn"])): ?>
      <section class="my-profile" id="my-profile">
        <div class="my-sidebar">
          <p>This is your profile</p>
          <a href="#" onclick="showCreatePost()"><i class="fa fa-edit"></i> Write a blog post</a>
        </div>
        <div class="my-entries" id="user-profile-entries">
          <!--Fylls på med inloggad användares entries -->
        </div>
      </section>

      <!-- Skriva ett inlägg -->
      <section class="create-entry-wrapper" id="create-entry-wrapper">
        <div class="create-entry">
          <h1>Create post</h1>
          <form>
            <input type="text" placeholder="Title" name="title" id="post-title" required>
            <textarea name="content" maxlength="1000" id="post-content" required></textarea>
            <br/>
            <input type="submit" value="Save" class="button" onclick="postEntry()" class="submit-btn"/>
          </form>
        </div>
      </section>

      <!-- Redigera ett inlägg -->
      <section class="create-entry-wrapper" id="edit-entry-wrapper">
        <div class="create-entry">
          <h1>Edit Post</h1>
          <form>
            <input type="text" placeholder="Title" name="title" id="edit-title" required>
            <textarea name="content" maxlength="1000" id="edit-content" required></textarea>
            <br/>
            <input type="submit" value="Save" class="button" onclick="editEntry()" class="submit-btn"/>
          </form>
        </div>
      </section>
    <?php endif; ?>

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

    <!-- Section som visar en användare och dennes inlägg -->
    <section class="single-user-wrapper" id="single-user">
      <div class="elements-displayed-wrapper">
        <div class="elements-displayed">
          <span>VIEW</span>
          <!-- HUR SKICKAR MAN MED ID FÖR ANVÄNDAREN!??? -->
          <select id="select-user-entry-amount" onchange="getSingleUser()">
            <option value="20">20</option>
            <option value="40">40</option>
            <option value="60">60</option>
            <option value="100">100</option>
          </select>
        </div>
      </div>
      <div id="single-user-content">
        <!-- Fylls på med users -->
      </div>
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
          <!-- HUR SKICKAR MAN MED ID FÖR ENTRY!??? -->
          <select id="selectCommentAmount">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="100">100</option>
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
              <textarea name="comment" id="post-comment" placeholder="Write your comment here..."></textarea>
              <input type="button" id="submit" value="Post comment" onclick="postComment()" class="submit-btn"/>
            </form>
          <?php endif; ?>
        </div>
      </section>
    </section>

  </div>

  <script src="scripts/main.js"></script>
</body>

</html>

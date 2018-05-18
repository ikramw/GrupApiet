<?php
if(empty($_POST) === false) {
$errors = array();
$name    = $_POST["name"];
$email   = $_POST["email"];
$message = $_POST["message"];

if(empty($name) === true || empty($email) === true || empty($message) ===true) {
  $errors[] = "Name, email and message are required";
} else {
if(filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
  $errors[] = "That\'s not a valid email address";

}
if(ctype_alpha($name) === false) {
  $errors[] = "Name must only contain letters";

}
}
if(empty($errors) === true) {
  //send Email
  //redirect user
}
}
 ?>

<!DOCTYPE html>
<html>
<head>
  <title>Contact form</title>
</head>
<body>
  <?php
  if(empty($errors) === false) {
    echo "<ul>";
    foreach($errors as $error) {
      echo "<li>", $error ,"</li>"

    }
    echo "</ul>";
  }
   ?>
  <form action="form.php" method ="post">
    <p>
      <label for ="name">Name</label><br>
      <input type="text" name="name" id="name">
    </p>
    <p>
      <label for ="email">Email</label><br>
      <input type="text" name="email" id="email">
    </p>
    <p>
      <label for ="message">Message:</label><br>
      <textarea name="message" id="message"></textarea>
    </p>
    <p>
      <input type ="submit" value="Submit">
    </p>
  </form>
</body>
</html>

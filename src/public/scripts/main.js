//Sections som ska gömmas eller visas
let frontpageHeader = document.getElementById("frontpage-header");
let entries = document.getElementById("entries");
let singleEntry = document.getElementById("single-entry");
let users = document.getElementById("users");
let singleUser = document.getElementById("single-user");
let comments = document.getElementById("comments");

//Elementen som ska fyllas på med information
let entriesContent = document.getElementById("entries-content");
let usersContent = document.getElementById("users-content");
let singleUserContent = document.getElementById("single-user");
let commentsContent = document.getElementById("comments-content");

//Länkarna i navigationen
let entriesLink = document.getElementById("entries-link");
let usersLink = document.getElementById("users-link");
let commentsLink = document.getElementById("comments-link");

//Sparar värdet på vald option i select för entries
function changeEntriesDisplayed() {
  let selectValue = document.getElementById("selectEntryAmount").value;
  return selectValue;
}
//Sparar värdet på vald option i select för users
function changeUsersDisplayed() {
  let selectValue = document.getElementById("selectUserAmount").value;
  return selectValue;
}
//Sparar värdet på vald option i select för comments
function changeCommentsDisplayed() {
  let selectValue = document.getElementById("selectCommentsAmount").value;
  return selectValue;
}

//Skapar element för att visa upp inlägg från databasen
function createEntryArticle(entryData) {

  let entryArticle = document.createElement("article");
  entryArticle.setAttribute("class", "new-entry");

  let entryContent = document.createElement("div");
  entryContent.setAttribute("class", "entry-content");

  let entryTitle = document.createElement("h1");
  let titleLink = document.createElement("a");
  titleLink.href = "#";
  titleLink.addEventListener("click", function(){
    getSingleEntry(entryData.entryID)
  });
  let titleText = document.createTextNode(entryData.title);
  titleLink.appendChild(titleText);
  entryTitle.appendChild(titleLink);

  let entryContentText = document.createElement("p");
  let entryContentTextNode = document.createTextNode(entryData.content);
  entryContentText.appendChild(entryContentTextNode);

  entryContent.appendChild(entryTitle);
  entryContent.appendChild(entryContentText);
  entryArticle.appendChild(entryContent);

  let entryInfo = document.createElement("div");
  entryInfo.setAttribute("class", "entry-info");

  let entryUsername = document.createElement("a");
  entryUsername.href = "#";
  entryUsername.addEventListener("click", function(){
    getSingleUser(entryData.createdBy)
  });
  let entryUsernameText = document.createTextNode(entryData.createdBy);
  entryUsername.appendChild(entryUsernameText);

  let entryDisplayTime = document.createElement("p");
  entryDisplayTime.setAttribute("class", "display-time");
  let entryDisplayTimeText = document.createTextNode(entryData.createdAt);
  entryDisplayTime.appendChild(entryDisplayTimeText);

  entryInfo.appendChild(entryUsername);
  entryInfo.appendChild(entryDisplayTime);
  entryArticle.appendChild(entryInfo);

  entriesContent.appendChild(entryArticle);
}
//Skapar element för att visa upp ett inlägg från databasen
function createSingleEntryArticle(entryData) {
  let singleEntryArticle = document.createElement("article");
  singleEntryArticle.setAttribute("class", "single-entry");

  let singleEntryInfo = document.createElement("div");
  singleEntryInfo.setAttribute("class", "single-entry-info");

  let entryTitle = document.createElement("h1");
  let titleText = document.createTextNode(entryData.title);
  entryTitle.appendChild(titleText);

  let writtenBy = document.createElement("span");
  let writtenByText = document.createTextNode("Written by ");
  writtenBy.appendChild(writtenByText);

  let entryUsername = document.createElement("a");
  entryUsername.href = "#";
  entryUsername.addEventListener("click", function(){
    getSingleUser(entryData.createdBy)
  });
  let entryUsernameText = document.createTextNode(entryData.createdBy);
  entryUsername.appendChild(entryUsernameText);

  let entryDisplayTime = document.createElement("p");
  let entryDisplayTimeText = document.createTextNode(entryData.createdAt);
  entryDisplayTime.appendChild(entryDisplayTimeText);

  let entryContentText = document.createElement("p");
  let entryContentTextNode = document.createTextNode(entryData.content);
  entryContentText.appendChild(entryContentTextNode);

  singleEntryInfo.appendChild(entryTitle);
  singleEntryInfo.appendChild(writtenBy);
  singleEntryInfo.appendChild(entryUsername);
  singleEntryInfo.appendChild(entryDisplayTime);
  singleEntryArticle.appendChild(singleEntryInfo);
  singleEntryArticle.appendChild(entryContentText);
  singleEntry.appendChild(singleEntryArticle);
}
//Skapar element för att visa upp användare från databasen
function createUserDiv(userData) {

  let userDiv = document.createElement("div");
  userDiv.setAttribute("class", "user");

  let userUsername = document.createElement("a");
  userUsername.href = "#";
  /* Lägger till ett event som kallar på funktionen getSingleUser och skickar
     med id för användaren */
  userUsername.addEventListener("click", function(){
    getSingleUser(userData.userID)
  });
  var usernameText = document.createTextNode(userData.username);
  userUsername.appendChild(usernameText);

  let userCreated = document.createElement("p");
  let userCreatedText = document.createTextNode("Joined " + userData.createdAt);
  userCreated.appendChild(userCreatedText);

  userDiv.appendChild(userUsername);
  userDiv.appendChild(userCreated);

  usersContent.appendChild(userDiv);
}
//Skapar element för att visa upp kommentarer från databasen
function createCommentDiv(userData) {

  let commentDiv = document.createElement("div");
  commentDiv.setAttribute("class", "comment");

  let commentText = document.createElement("p");
  var commentTextNode = document.createTextNode(userData.content);
  commentText.appendChild(commentTextNode);

  let writtenBy = document.createElement("p");
  var writtenByText = document.createTextNode("Written by ");
  writtenBy.appendChild(writtenByText);

  let commentUsername = document.createElement("a");
  commentUsername.href = "#";
  var commentUsernameText = document.createTextNode(userData.createdBy);
  commentUsername.appendChild(commentUsernameText);

  writtenBy.appendChild(commentUsername);

  let commentCreated = document.createElement("p");
  var commentCreatedText = document.createTextNode(userData.createdAt);
  commentCreated.appendChild(commentCreatedText);

  commentDiv.appendChild(commentText);
  commentDiv.appendChild(writtenBy);
  commentDiv.appendChild(commentCreated);

  commentsContent.appendChild(commentDiv);
}

//Hämtar alla entries
async function getAllEntries() {
  const response = await fetch('/api/entries');
  const { data } = await response.json();

  entries.style.display = "block";
  users.style.display = "none";
  comments.style.display = "none";
  singleEntry.style.display = "none";
  frontpageHeader.style.display = "block";

  entriesContent.innerHTML = "";
  usersContent.innerHTML = "";
  commentsContent.innerHTML = "";

  //Ändrar länk som är aktiv i nav
  entriesLink.classList.add("active");
  usersLink.classList.remove("active");
  commentsLink.classList.remove("active");

  let selectValue = document.getElementById("selectEntryAmount").value;

  //Skapar artikel element för antalet entries som är valt i select elementet
  for (let i = 0; i < selectValue && i < data.length; i++) {

    createEntryArticle(data[i]);
  }
}
//Kallar på funtionen för att hämta alla entries då de visas på startsidan
getAllEntries();

//Hämtar ett inlägg samt visar kommentarer till inlägget
async function getSingleEntry(id) {
  const response = await fetch('/api/entries/' + id);
  const { data } = await response.json();

  entries.style.display = "none";
  users.style.display = "none";
  comments.style.display = "none";
  singleUser.style.display = "none";
  singleEntry.style.display = "block";
  frontpageHeader.style.display = "none";

  entriesContent.innerHTML = "";
  usersContent.innerHTML = "";
  commentsContent.innerHTML = "";
  singleEntry.innerHTML = "";

  //Ändrar länk som är aktiv i nav
  entriesLink.classList.add("active");
  usersLink.classList.remove("active");
  commentsLink.classList.remove("active");

  createSingleEntryArticle(data);
}
//Hämtar alla användare
async function getAllUsers() {
  const response = await fetch('/api/users');
  const { data } = await response.json();

  entries.style.display = "none";
  users.style.display = "block";
  comments.style.display = "none";
  singleEntry.style.display = "none";
  frontpageHeader.style.display = "block";

  entriesContent.innerHTML = "";
  usersContent.innerHTML = "";
  commentsContent.innerHTML = "";

  //Ändrar länk som är aktiv i nav
  entriesLink.classList.remove("active");
  usersLink.classList.add("active");
  commentsLink.classList.remove("active");

  let selectValue = document.getElementById("selectUserAmount").value;

  //Skapar artikel element för antalet entries som är valt i select elementet
  for (let i = 0; i < selectValue && i < data.length; i++) {

    createUserDiv(data[i]);
  }
}
//Hämtar en användare samt visar alla användarens inlägg
async function getSingleUser(id) {
  const response = await fetch('/api/users/' + id);
  const { data } = await response.json();

  entries.style.display = "none";
  users.style.display = "none";
  comments.style.display = "none";
  singleUser.style.display = "block";
  frontpageHeader.style.display = "block";

  entriesContent.innerHTML = "";
  usersContent.innerHTML = "";
  commentsContent.innerHTML = "";

  //Ändrar länk som är aktiv i nav
  entriesLink.classList.remove("active");
  usersLink.classList.add("active");
  commentsLink.classList.remove("active");

  //Skapar element för att visa upp entries från databasen
  function createSingleUserArticle(entryData) {

    let singleUserArticle = document.createElement("article");
    singleUserArticle.setAttribute("class", "single-entry");

    let entryInfo = document.createElement("div");
    entryInfo.setAttribute("class", "single-entry-info");

    let entryTitle = document.createElement("h1");
    let titleLink = document.createElement("a");
    titleLink.href = "#";
    titleLink.addEventListener("click", getSingleEntry);
    var titleText = document.createTextNode(entryData.title);
    titleLink.appendChild(titleText);
    entryTitle.appendChild(titleLink);

    let entryCreated = document.createElement("p");
    var entryCreatedText = document.createTextNode(entryData.createdAt);
    entryCreated.appendChild(entryCreatedText);

    let entryContentText = document.createElement("p");
    var entryContentTextNode = document.createTextNode(entryData.content);
    entryContentText.appendChild(entryContentTextNode);

    let commentsAmount = document.createElement("p");
    var commentsAmountText = document.createTextNode("3" + "amount of comments");
    commentsAmount.appendChild(commentsAmountText);

    entryInfo.appendChild(entryTitle);
    entryInfo.appendChild(entryCreated);
    singleUserArticle.appendChild(entryInfo);
    singleUserArticle.appendChild(entryContentText);
    singleUserArticle.appendChild(commentsAmount);

    singleUser.appendChild(singleUserArticle);
  }

  //let selectValue = document.getElementById("selectEntryAmount").value;

  //Skapar artikel element för antalet entries som är valt i select elementet
  for (let i = 0; i < 20; i++) {

    createSingleUserArticle(data[i]);
  }

  console.log(data.username);
}
//Hämtar alla kommentarer
async function getAllComments() {
  const response = await fetch('/api/comments');
  const { data } = await response.json();

  entries.style.display = "none";
  users.style.display = "none";
  comments.style.display = "block";
  singleEntry.style.display = "none";

  entriesContent.innerHTML = "";
  usersContent.innerHTML = "";
  commentsContent.innerHTML = "";

  //Ändrar länk som är aktiv i nav
  entriesLink.classList.remove("active");
  usersLink.classList.remove("active");
  commentsLink.classList.add("active");

  let selectValue = document.getElementById("selectCommentsAmount").value;

  //Skapar artikel element för antalet entries som är valt i select elementet
  for (let i = 0; i < selectValue && i < data.length; i++) {

    createCommentDiv(data[i]);
  }
}

//Öppnar och stänger navigationen på mobiler
function navToggle() {
  var menu = document.getElementById("content-toggle");
  if (menu.className === "nav-main") {
    menu.className += " responsive";
  } else {
    menu.className = "nav-main";
  }
}

//Visar login och register form
let loginForm = document.getElementById("login-form");
let registerForm = document.getElementById("register-form");

function showSignin() {
  if (loginForm.className === "login-form") {
    loginForm.className += " visible";
    registerForm.className = "register-form";
  } else {
    loginForm.className = "login-form";
  }
}
function showRegister() {
  if (registerForm.className === "register-form") {
    registerForm.className += " visible";
    loginForm.className = "login-form";
  } else {
    registerForm.className = "register-form";
  }
}

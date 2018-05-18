<?php
if (session_status() == PHP_SESSION_NONE) {
    session_set_cookie_params(3600);
    session_start();
}

/**
 * Require the autoload script, this will automatically load our classes
 * so we don't have to require a class everytime we use a class. Evertime
 * you create a new class, remember to runt 'composer update' in the terminal
 * otherwise your classes may not be recognized.
 */
require_once '../../vendor/autoload.php';

/**
 * Here we are creating the app that will handle all the routes. We are storing
 * our database config inside of 'settings'. This config is later used inside of
 * the container inside 'App/container.php'
 */

$container = require '../App/container.php';
$app = new \Slim\App($container);
$auth = require '../App/auth.php';
require '../App/cors.php';


/********************************
 *          ROUTES              *
 ********************************/


$app->get('/', function ($request, $response, $args) {
    /**
     * This fetches the 'index.php'-file inside the 'views'-folder
     */
    return $this->view->render($response, 'index.php');
});


/**
 * I added basic inline login functionality. This could be extracted to a
 * separate class. If the session is set is checked in 'auth.php'
 */
$app->post('/login', function ($request, $response, $args) {
    /**
     * Everything sent in 'body' when doing a POST-request can be
     * extracted with 'getParsedBody()' from the request-object
     * https://www.slimframework.com/docs/v3/objects/request.html#the-request-body
     */
    $body = $request->getParsedBody();
    $fetchUserStatement = $this->db->prepare('SELECT * FROM users WHERE username = :username');
    $fetchUserStatement->execute([
        ':username' => $body['username']
    ]);
    $user = $fetchUserStatement->fetch();
    if (password_verify($body['password'], $user['password'])) {
        $_SESSION['loggedIn'] = true;
        $_SESSION['userID'] = $user['id'];
        header('Location: ../localhost:3000');
        return $response->withJson(['data' => [ $user['id'], $user['username'] ]]);
    }
    return $response->withJson(['error' => 'wrong password']);
});

/**
 * Basic implementation, implement a better response
 */
$app->get('/logout', function ($request, $response, $args) {
    session_destroy();
    return $response->withJson('Success');
});

$app->post('/register', function ($request, $response, $args) {

    $body = $request->getParsedBody();
    $newUser = $this->users->add($body);
    return $response->withJson(['data' => $newUser]);
});

$app->group('/api', function () use ($app) {

    // GET http://localhost:XXXX/api/users
    $app->get('/users', function ($request, $response, $args) {

        $allUsers = $this->users->getAll();

        return $response->withJson(['data' => $allUsers]);
    });

    // GET http://localhost:XXXX/api/users/5
    $app->get('/users/{id}', function ($request, $response, $args) {

        $id = $args['id'];
        $singleUser = $this->users->getOne($id);
        return $response->withJson(['data' => $singleUser]);
    });
    $app->post('/users', function ($request, $response, $args) {

        $body = $request->getParsedBody();
        $newUser = $this->users->add($body);
        return $response->withJson(['data' => $newUser]);
    });
    // GET http://localhost:XXXX/api/entries
    $app->get('/entries', function ($request, $response, $args) {

       $params = $request->getQueryParams();
       if($params == null) {
        $allEntries = $this->entries->getDefault();
    }
        elseif($params['title']!=null){
        $allEntries = $this->entries->getByTitle();
    }
        elseif($params['limit']!=null){
        $allEntries = $this->entries->getAll();
    }

        return $response->withJson(['data' => $allEntries]);
    });

    // GET http://localhost:XXXX/api/entries/5
    $app->get('/entries/{id}', function ($request, $response, $args) {

        $id = $args['id'];
        $singleEntry = $this->entries->getOne($id);
        return $response->withJson(['data' => $singleEntry]);
    });
    $app->post('/entries', function ($request, $response, $args) {

        $body = $request->getParsedBody();
        $newEntry = $this->entries->add($body);
        return $response->withJson(['data' => $newEntry]);
    });
    $app->delete('/entries/{id}', function ($request, $response, $args) {

        $id = $args['id'];
         $this->entries->delete($id);
        });
    $app->patch('/entries/{id}', function ($request, $response, $args) {
        $body = $request->getParsedBody();
        $id = $args['id'];
        $newEntry = $this->entries->update($body,$id);
        return $response->withJson(['data' => $newEntry]);
    });
     // GET http://localhost:XXXX/api/entries/user/5
    $app->get('/entries/user/{userId}', function ($request, $response, $args) {

        $id = $args['userId'];
        $EntryByUser = $this->entries->getByUser($id);
        return $response->withJson(['data' => $EntryByUser]);
    });
     // GET http://localhost:XXXX/api/entries/user/5
    $app->get('/entries/', function ($request, $response, $args) {

        $title = $args['title'];
        $EntryByTitle = $this->entries->getByTitle($title);
        return $response->withJson(['data' => $EntryByTitle]);
    });
      // GET http://localhost:XXXX/api/comments
    $app->get('/comments', function ($request, $response, $args) {

        $allComments = $this->comments->getAll();
        return $response->withJson(['data' => $allComments]);
    });

    // GET http://localhost:XXXX/api/comments/5
    $app->get('/comments/{id}', function ($request, $response, $args) {

        $id = $args['id'];
        $singleComment = $this->comments->getOne($id);
        return $response->withJson(['data' => $singleComment]);
    });
    $app->post('/comments', function ($request, $response, $args) {
        $body = $request->getParsedBody();
        $newComment = $this->comments->add($body);
        return $response->withJson(['data' => $newComment]);
    });
    $app->delete('/comments/{id}', function ($request, $response, $args) {
        $id = $args['id'];
        $this->comments->delete($id);
        });
    $app->get('/comments/entry/{entryId}', function ($request, $response, $args) {

        $id = $args['entryId'];
        $commentsByEntry = $this->comments->getByEntry($id);
        return $response->withJson(['data' => $commentsByEntry]);
    });
});

$app->run();

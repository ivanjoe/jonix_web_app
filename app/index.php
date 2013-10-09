<?php session_start(); ?>
<!doctype html>
<html lang="en" ng-app="myApp">
<head>
  <meta charset="utf-8">
  <title>jOnix WebApp</title>
  <script src="lib/angular/angular.js"></script>
  <script src="lib/ui.bootstrap/ui-bootstrap-tpls-0.6.0.js"></script>
  <script src="js/app.js"></script>
  <script src="js/services.js"></script>
  <script src="js/controllers.js"></script>
  <script src="js/filters.js"></script>
  <script src="js/directives.js"></script>
  <script src="js/xml2json.js"></script>
  <link rel="stylesheet" href="css/app.css"/>
  <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css" rel="stylesheet">
  <!-- <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet"> -->
  <!-- <link href="//netdna.bootstrapcdn.com/bootswatch/3.0.0/journal/bootstrap.min.css" rel="stylesheet"/> -->

</head>
<body>
  <div class="container">
    <div class="navbar">
      <div class="navbar-inner">
        <a class="brand" href="#">jOnix WebApp</a>
        <ul class="nav">
          <li class="active"><a href="#/onix-books">ONIX for books</a></li>
          <li><a href="#/view1">view1</a></li>
          <li><a href="#/view2">view2</a></li>
          <li>
            <form class="navbar-form navbar-left">
              <input type="text" class="form-control" placeholder="Search" ng-model="query">
            </form>
          </li>
          <li><a href="#/about">About</a></li>
        </ul>
      </div>
    </div>

    <?php
      if (isset($_SESSION['demo'])) {
        if($_SESSION['demo'] == md5(date("Ymd").'UserLoggedIn')) { ?>

      <div ng-view></div>

      <div ng-controller="ModalCtrl">
        <button class="btn" style="position: absolute; top: 8px; right: 10px" ng-click="logout()">Logout</button>
      </div>

    <?php
        } else {?>
        <div class="row">
          <alert class="alert-danger span5">You are trying something!</alert>
        </div>
    <?php
        }
      } else { ?>

      <div ng-controller="ModalCtrl">
        <button class="btn" style="position: absolute; top: 8px; right: 10px" ng-click="open()">Login</button>
      </div>

    <?php } ?>

    <div>Angular seed app: v<span app-version></span></div>
  </div>
</body>
</html>

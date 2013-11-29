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
  <script src="js/localize.js"></script>
  <script src="js/xml2json.js"></script>
  <link rel="stylesheet" href="css/app.css"/>
  <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css" rel="stylesheet">
  <!-- <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet"> -->
  <!-- <link href="//netdna.bootstrapcdn.com/bootswatch/3.0.0/journal/bootstrap.min.css" rel="stylesheet"/> -->

</head>
<body ng-controller="MainCtrl">
  <div class="container">
    <!-- Navigation bar -->
    <div class="navbar">
      <div class="navbar-inner">
        <a class="brand" href="#">jOnix WebApp</a>
        <ul class="nav">
          <li ng-class="getClass('/onix-books')"><a href="#/onix-books">ONIX for books</a></li>
          <li ng-class="getClass('/products')"><a href="#/products">Products</a></li>
          <!-- <li><a href="#/view1">view1</a></li>
          <li><a href="#/view2">view2</a></li>
          <li>
            <form class="navbar-form navbar-left">
              <input type="text" class="form-control" placeholder="Search" ng-model="query">
            </form>
          </li> -->
          <li ng-class="getClass('/about')"><a href="#/about">About</a></li>
        </ul>
      </div>
    </div>
    <!-- Navigation ends -->

      <div ng-view></div>

  </div>
  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <p>
        jOnix Web Application &copy; Metropolia 2013<br/>
        <a href="#" ng-click="setFinnishLanguage()">Suomi</a> |
        <a href="#" ng-click="setEnglishLanguage()">English</a>
      </p>
    </div>
  </footer>
  <!-- Footer ends -->
</body>
</html>

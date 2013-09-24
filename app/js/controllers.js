'use strict';

/* Controllers */

angular.module('myApp.controllers', ['ui.bootstrap']).
  controller('MyCtrl1', [function() {

  }])
  .controller('MyCtrl2', [function() {

  }])
  .controller('MessageCtrl', ['$scope', function($scope) {
  	$scope.master = {};

  	$scope.update = function(message) {
  		$scope.master = angular.copy(message);
  	}

  	$scope.reset = function () {
  		$scope.message = angular.copy($scope.master);
  	}

  	$scope.reset();
  }])
  .controller('DatepickerCtrl', ['$scope', '$timeout', function($scope, $timeout) {
  	 $scope.today = function() {
  	 	$scope.message.sentDate = new Date();
  	 };
	 $scope.today();

	 $scope.showWeeks = false;

	 $scope.clear = function () {
	    $scope.message.sentDate = null;
	 };

	 $scope.open = function() {
	    $timeout(function() {
	      $scope.opened = true;
	    });
	 };

	 $scope.dateOptions = {
	 	'year-format': "'yy'",
	    'starting-day': 1
	 };

  }]);
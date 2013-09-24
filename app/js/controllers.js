'use strict';

/* Controllers */

angular.module('myApp.controllers', []).
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
  }]);
'use strict';

/* Controllers */

angular.module('myApp.controllers', ['ui.bootstrap']).
  controller('MyCtrl1', [function() {

  }])
  .controller('MyCtrl2', [function() {

  }])

  .controller('MessageCtrl', ['$scope','$http', function($scope, $http) {

  	$scope.master = {
  		products: [
  			{}
  		]
  	};

  	// Get the list for the forms
  	$scope.productNotificationTypeList = {};
  	$http.get('assets/lists/list1.json').success(function(data){
  		$scope.productNotificationTypeList = data;
  	});

  	$scope.productIdTypeList = {};
  	$http.get('assets/lists/list5.json').success(function(data){
  		$scope.productIdTypeList = data;
  	});

  	$scope.productFormList = {};
  	$http.get('assets/lists/list7.json').success(function(data){
  		$scope.productFormList = data;
  	});

  	$scope.addProduct = function() {
  		$scope.message.products.push({type:'', value:''});
  	}

  	$scope.removeProduct = function(product) {
  		var products = $scope.message.products;
  		for (var i = 0, ii = products.length; i < ii; i++) {
  			if (product === products[i]) {
  				products.splice(i, 1);
  			}
  		}
  	}

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
  }])
  .controller('TimepickerCtrl', ['$scope', function($scope) {
  	$scope.message.sentTime = new Date();
  }]);
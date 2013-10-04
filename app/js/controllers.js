'use strict';

/* Controllers */

angular.module('myApp.controllers', ['ui.bootstrap']).
  controller('MyCtrl1', [function() {

  }])
  .controller('MyCtrl2', [function() {

  }])

  .controller('MessageCtrl', ['$scope','$http', function($scope, $http) {

  	$scope.master = {
      header: {
      },
  		products: [
  			{}
  		]
  	};

  	// Get the list for the forms
  	$scope.productNotificationTypeList = {};
  	$http.get('assets/lists/list1.json').success(function(data){
  		$scope.productNotificationTypeList = data;
  	});

    $scope.productCompositionList = {};
    $http.get('assets/lists/list2.json').success(function(data){
      $scope.productCompositionList = data;
    });

  	$scope.productIdTypeList = {};
  	$http.get('assets/lists/list5.json').success(function(data){
  		$scope.productIdTypeList = data;
  	});

    $scope.productTitleTypeList = {};
    $http.get('assets/lists/list15.json').success(function(data){
      $scope.productTitleTypeList = data;
    });

    $scope.productTitleElementLevelList = {};
    $http.get('assets/lists/list149.json').success(function(data){
      $scope.productTitleElementLevelList = data;
    });

  	$scope.productFormList = {};
  	$http.get('assets/lists/list7.json').success(function(data){
  		$scope.productFormList = data;
  	});

    $scope.productLanguageRoleList = {};
    $http.get('assets/lists/list22.json').success(function(data){
      $scope.productLanguageRoleList = data;
    });

    $scope.publishingRoleList = {};
    $http.get('assets/lists/list45.json').success(function(data){
      $scope.publishingRoleList = data;
    });

    // publishing status
    $scope.publishingStatusList = {};
    $http.get('assets/lists/list64.json').success(function(data){
      $scope.publishingStatusList = data;
    });

    // publishing date role
    $scope.publishingDateRoleList = {};
    $http.get('assets/lists/list163.json').success(function(data){
      $scope.publishingDateRoleList = data;
    });

    $scope.supplierRoleList = {};
    $http.get('assets/lists/list93.json').success(function(data){
      $scope.supplierRoleList = data;
    });

    // availibility
    $scope.productAvailabilityCodeList = {};
    $http.get('assets/lists/list65.json').success(function(data){
      $scope.productAvailabilityCodeList = data;
    });

    // upriced item type
    $scope.unpricedCodeList = {};
    $http.get('assets/lists/list57.json').success(function(data){
      $scope.unpricedCodeList = data;
    });

    // price code type -> in typehead

    // price code

    // currency code

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
  	 	$scope.message.header.sentDateTime = new Date();
  	 };
	 $scope.today();

	 $scope.showWeeks = false;

	 $scope.clear = function () {
	    $scope.message.header.sentDateTime = null;
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
  }])

  .controller('TypeheadCtrl', ['$scope','$http', function($scope, $http) {
    $scope.selected = undefined;

    $scope.productLanguageCodeList = [];
    $http.get('assets/lists/list74.json').success(function(data){
      $scope.productLanguageCodeList = data;
    });

    $scope.countryList = [];
    $http.get('assets/lists/list91.json').success(function(data){
      $scope.countryList = data;
    });

    $scope.productAvailabilityList = [];
    $http.get('assets/lists/list65_typehead.json').success(function(data){
      $scope.productAvailabilityList = data;
    });

    $scope.priceTypes = [];
    $http.get('assets/lists/list58_typehead.json').success(function(data){
      $scope.priceTypes = data;
    });

    $scope.currencies = [];
    $http.get('assets/lists/list96_typehead.json').success(function(data){
      $scope.currencies = data;
    });
  }]);
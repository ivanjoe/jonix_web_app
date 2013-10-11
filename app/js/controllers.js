'use strict';

/* Controllers */

angular.module('myApp.controllers', ['ui.bootstrap']).
  controller('MainCtrl', ['$scope', '$location', function($scope, $location) {

    $scope.getClass = function(path) {
      if ($location.path().substr(0, path.length) == path) {
        return "active";
      } else {
        return "";
      }
    }

  }])
  .controller('MyCtrl2', [function() {

  }])
  .controller('ModalCtrl', ['$scope', '$modal', '$log', '$http',
      function($scope, $modal, $log, $http) {
    $scope.password = '';

    $scope.open = function () {

      var modalInstance = $modal.open({
        templateUrl: 'partials/loginModal.html',
        controller: 'ModalInstanceCtrl'
      });

      modalInstance.result.then(function (enteredText) {
        // try log in the user
        $http.post('sessions.php?login=1', {password: enteredText})
          .success(function(data) {
            $log.info(data);
            if (data.status == 'notLoggedIn') {
              var modalFailedPass = $modal.open({
                templateUrl: 'partials/failedLogin.html',
                controller: 'ModalInstanceCtrl'
              });
            } else {
              // Reload the page
              location.reload();
            }
          })
          .error(function(data){
            alert("Couldn't log you in!");
          });
        $scope.password = enteredText;
      }, function () {
        $log.info('Modal dismissed at: ' + new Date());
      });
    };

    $scope.logout = function() {
      $http.get('sessions.php?logout=1')
        .success(function(data) {
          $log.info(data);
          // Reload the page
          location.reload();
          $log.info('Reload');
        })
        // shouldn't happen
        .error(function(data){
          alert("Couldn't log you out!");
        });
    };
  }])
  .controller('ModalInstanceCtrl', ['$scope', '$modalInstance', function($scope, $modalInstance) {
    $scope.input = {};

    $scope.ok = function() {
      $modalInstance.close($scope.input.pass);
    };

    $scope.cancel = function() {
      $modalInstance.dismiss('cancel');
    };
  }])
  .controller('MessageCtrl', ['$scope','$http', function($scope, $http) {
    // TODO: move to configurational file
    var jonix_proxy = "./send.php";

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

    // Send the filled in form
    // Get the info what is the response from the service
    $scope.send = function () {
      $http.post(jonix_proxy, $scope.message,
       {
        'Content-Type':'application/xml'
       }
      ).success(function(data,status) {
        $scope.$broadcast('answer', [data, status]);
        console.log(data);
      })
      .error(function(data, status){
        $scope.$broadcast('answer', [data, status]);
        alert('Proxy is down!');
      });
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
  }])

  .controller('AlertCtrl', ['$scope','$filter', function($scope, $filter) {
    $scope.alerts = [
    ];

    $scope.$on('answer', function(answer, data) {
      console.log(data);

      var now = $filter('date')(new Date(), 'dd MMMM yyyy h:mm:ss');

      var alert = {type: 'success', msg: 'I guess everything went fine' +
        '<br/><small>at ' + now + '</small>'};
      // types: success, info, warning, error
      // Connection with proxy (send.php) was succesful
      // TODO: prepare for all the HTTP codes
      if(data[1] == 200) {
        if (data[0].http_code == 406) {
          alert.type = "warning";
          alert.msg = '<strong>Backend responded:</strong><br/>' + data[0].result +
            '<br/>at <small>' + now + '</small>';
        }
      } else if (data[1] == 405) {
        alert.type = "error";
        alert.msg = "Failed! No connection!";
      } else {
        alert.type = "error";
        alert.msg = "Failed! Something else...";
      }
      $scope.alerts.push(alert);
    });

    $scope.closeAlert = function(index) {
      $scope.alerts.splice(index, 1);
    };
  }]);
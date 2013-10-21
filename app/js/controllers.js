'use strict';

/* Controllers */

angular.module('myApp.controllers', ['ui.bootstrap']).
  controller('MainCtrl', ['$scope', '$location', 'localize',
      function($scope, $location, localize) {

    $scope.getClass = function(path) {
      if ($location.path().substr(0, path.length) == path) {
        return "active";
      } else {
        return "";
      }
    };

    $scope.setFinnishLanguage = function() {
        localize.setLanguage('default');
    };

    $scope.setEnglishLanguage = function() {
        localize.setLanguage('en-UK');
    };

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
  .controller('MessageCtrl', ['$scope','$http', 'localize',
      function($scope, $http, localize) {

    // TODO: move to configurational file
    var jonix_proxy = "./send.php";
    var lang = localize.language;
    var availableLanguages = ['default', 'en-UK'];
    // is lang in array?
    if (availableLanguages.indexOf(localize.language) === -1) {
      lang = 'default';
    }

    $scope.master = {
      header: {
      },
  		products: [
  			{}
  		]
  	};

    // Get the lists for the forms
  	$scope.productNotificationTypeList = {};
  	$http.get('assets/lists/selects_'+lang+'.json').success(function(data){
  		$scope.productNotificationTypeList  = data.list1;
      $scope.productCompositionList       = data.list2;
      $scope.productFormList              = data.list7;
      $scope.productIdTypeList            = data.list5;
      $scope.productTitleTypeList         = data.list15;
      $scope.productLanguageRoleList      = data.list22;
      $scope.publishingRoleList           = data.list45;
      $scope.unpricedCodeList             = data.list57;
      $scope.publishingStatusList         = data.list64;
      $scope.supplierRoleList             = data.list93;
      $scope.productTitleElementLevelList = data.list149;
      $scope.publishingDateRoleList       = data.list163;
      //Save the data for later use
      $scope.lists = data;
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
      })
      .error(function(data, status){
        $scope.$broadcast('answer', [data, status]);
        alert('Proxy is down!');
      });
    }

    // Changes the available product forms based on the ID type
    $scope.changeProductForm = function(item) {
      console.log($scope.productFormList);
      switch(item)
      {
        case "02":
        case "15":
          $scope.productFormList = {
                "00":"Määrittelemätön",
                "BA":"Kirja",
                "BB":"Kovakantinen kirja",
                "BC":"Pehmeäkantinen kirja",
                "BD":"Irtolehtiä, irtolehtijulkaisu",
                "BE":"Kierreselkä",
                "BF":"Lehtivihko, moniste",
                "BG":"Leather / fine binding",
                "BH":"Pahvisivuinen kirja",
                "BI":"Kangaskirja",
                "BJ":"Bath book",
                "BK":"Poikkeavan muotoinen kirja",
                "BL":"Slide bound",
                "BM":"Big book",
                "BN":"Part-work (fascículo)",
                "BO":"Haitarikirja, 'Leporello'",
                "BP":"'Kylpykirja'",
                "BZ":"Jokin muu kirjan muoto",
                "CA":"Kartta",
                "CB":"Sheet map, folded",
                "CC":"Sheet map, flat",
                "CD":"Sheet map, rolled",
                "CE":"Globe",
                "CZ":"Other cartographic"
          };
          break;
        case "02":
          break;
        default:
          $scope.productFormList = $scope.lists.list7;
          break;
      }
    };

    $scope.reset();
  }])

  .controller('DatepickerCtrl', ['$scope', '$timeout', function($scope, $timeout) {
  	 $scope.today = function() {
  	 	$scope.message.header.sentDateTime = new Date();
  	 };
  	 $scope.today();

  	 $scope.showWeeks = false;

  	 $scope.clear = function () {
  	    //$scope.message.header.sentDateTime = null;
        $scope.dtPick = null;
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

  .controller('TypeheadCtrl', ['$scope','$http','localize',
      function($scope, $http, localize) {
    $scope.selected = undefined;

    var lang = localize.language;
    var availableLanguages = ['default', 'en-UK'];
    // is lang in array?
    if (availableLanguages.indexOf(localize.language) === -1) {
      lang = 'default';
    }

    $http.get('assets/lists/typeheads_'+lang+'.json').success(function(data){
      $scope.priceTypes              = data.list58;
      $scope.productAvailabilityList = data.list65;
      $scope.productLanguageCodeList = data.list74;
      $scope.countryList             = data.list91;
      $scope.currencies              = data.list96;
    });

    $http.get('assets/lists/ysa.json').success(function(data){
      $scope.keywords = data;
    });

    $scope.showLanguageCode = function(data) {
      alert(data);
    };

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
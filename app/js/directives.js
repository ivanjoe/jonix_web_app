'use strict';

/* Directives */


angular.module('myApp.directives', []).
  directive('appVersion', ['version', function(version) {
    return function(scope, elm, attrs) {
      elm.text(version);
    };
  }]).

  directive('onix', [function($scope, $route, message) {
  	return {
  		restrict:"E",
  		scope: {},
  		controller: function($scope, $route, message) {
  			$scope.productId = $route.current.params.id;
  			// get the ONIX message
  			var msg = message.show($scope.productId);

  			// Connection with receive.php is successful
  			msg.success(function(data) {

  				switch(data.http_code) {
  					case 404:
  						$scope.message = "Record reference '"+
  							$scope.productId + "' not found";
  						break;
  					default:
  						$scope.message = data.result;
  						break;
  				}

  			// Connection with receive.php is unsuccessful
  			}).error(function(){
  				$scope.message = 'No data received';
  			});
  		},
  		// It will get from the controller what message it should show
  		template: '<pre class="well">{{message}}</pre>'
  	};
  }])

  ;
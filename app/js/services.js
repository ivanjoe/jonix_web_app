'use strict';

/* Services */


// Demonstrate how to register services
// In this case it is a simple value service.
angular.module('myApp.services', []).
  value('version', '0.1').

  service('message', ['$http', function($http) {

  	this.show = function(id) {
  		return $http.get('./receive.php?rref='+id);
  	}

  }]);


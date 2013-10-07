'use strict';

/* Services */


// Demonstrate how to register services
// In this case it is a simple value service.
angular.module('myApp.services', []).
  value('version', '0.1')
  .service('addFlashMsg', function() {
  	var stringValue = 'test string value';

  	return {
        getString: function() {
            return stringValue;
        },
        setString: function(value) {
            stringValue = value;
        }
    }
  });

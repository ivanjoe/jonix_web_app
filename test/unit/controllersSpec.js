'use strict';

/* jasmine specs for controllers go here */

describe('controllers', function(){
  beforeEach(module('myApp.controllers'));
  beforeEach(function() {
  	module('ui.bootstrap');
  });


  it('should ....', inject(function() {
    //spec body
  }));

  it('should ....', inject(function() {
    //spec body
  }));

  describe('AlertCtrl', function() {

  	it('should should have two alert messages', inject(function($controller) {
  		//spec body
	    var scope = {};
	    //var ac = $controller('AlertCtrl', {$scope: scope});
	    //expect(scope.alerts.lengths).toEqual(2);
	}));

  });

});

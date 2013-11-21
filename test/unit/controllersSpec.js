'use strict';

/* jasmine specs for controllers go here */

describe('controllers', function(){
  var scope, ctrl, $httpBackend;

  beforeEach(module('myApp.controllers'));

  beforeEach(function() {
  	module('ui.bootstrap');
    module('localization');
  });

  it('should ....', inject(function() {
    //spec body
  }));

  it('should ....', inject(function() {
    //spec body
  }));

  describe('AlertCtrl', function() {

  	it('should should have two alert messages',
        inject(function($controller, $rootScope, $httpBackend) {

  		//spec body
	    var scope = $rootScope.$new();
      var ac = $controller('AlertCtrl', {$scope: scope});

	    expect(scope.alerts.length).toBe(0);
	}));

  });

  describe('MessageCtrl', function() {

    beforeEach(inject(function($httpBackend, $controller) {
      $httpBackend.expectGET('i18n/resources-locale_en-US.json').respond(404);
      $httpBackend.expectGET('assets/lists/selects_default.json').respond(200);

      scope = {};
      ctrl = $controller('MessageCtrl', {$scope: scope});
    }));

    it('should have one product in the initial array', function() {
      expect(scope.message.product.length).toBe(1);
    });

    it('should add a new product to the product array', function() {

      scope.addProduct();

      expect(scope.message.product.length).toBe(2);
    });

    it('should remove the product that was just added', function() {
      scope.addProduct();
      scope.removeProduct();

      expect(scope.message.product.length).toBe(2);
    });

  });

  describe('SubjectCtrl', function() {

    beforeEach(inject(function($httpBackend) {

    }));

    it('should add another subject to the initial array',
        inject(function($controller) {

      scope = {
        productItem: {
          descriptiveDetail: {
            subject: []
          }
        }
      };
      ctrl = $controller('SubjectCtrl', {$scope: scope});

      scope.addSubject();

      expect(scope.productItem.descriptiveDetail.subject.length).toBe(1);

      scope.addSubject();

      expect(scope.productItem.descriptiveDetail.subject.length).toBe(2);
    }));

    it('should remove a given subject',
        inject(function($controller) {

      scope = {
        productItem: {
          descriptiveDetail: {
            subject: [
              {
                subjectSchemeIdentifier: "64",
                subjectHeadingText: "koiraat",
                subjectCode: "Y155020"
              },
              {
                subjectSchemeIdentifier: "64",
                subjectHeadingText: "huhut",
                subjectCode: "Y101684"
              },
              {
                subjectSchemeIdentifier: "64",
                subjectHeadingText: "jujutsu",
                subjectCode: "Y101935"
              }
            ]
          }
        }
      };
      ctrl = $controller('SubjectCtrl', {$scope: scope});

      // Remove the second subject
      scope.removeSubject(1);

      expect(scope.productItem.descriptiveDetail.
        subject[1].subjectHeadingText).toBe('jujutsu');

    }));

  });

});

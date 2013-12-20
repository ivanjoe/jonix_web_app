'use strict';

/* Directives */


angular.module('myApp.directives', []).
  directive('appVersion', ['version', function(version) {
    return function(scope, elm, attrs) {
      elm.text(version);
    };
  }]).

  directive('withError', function() {
    return {
      compile: function(element, attrs) {
        var formName = element[0].form.name;
        var errorTxt = '<p>' +
          '<small class="text-error" ng-show="'+formName+'.'+attrs.name+'.$error.pattern" ' +
          'data-i18n="'+attrs.withError+'"></small></p>';
        element.after(errorTxt);
      }
    }
  }).

  directive('btnToday', function() {
    return {
      compile: function(element, attrs) {
        var td = new Date();
        td = td.getTime();
        var btn = ' <button class="btn btn-small btn-inverse" '+
          ' ng-click="'+attrs.ngModel+'='+td+'">{{\'_Today_\' | i18n}}</button>';
        element.after(btn);
      }
    }
  }).

  directive('onix', ['message', function($scope, $route, message) {
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
  		template: '<form class="well form-control">{{message}}</form>'
  	};
  }]).

  directive('productEdit', ['message', function(message) {
    return function(scope, elm, attrs) {
      message.show(scope.product.id).
        success(function(data) {
          switch(data.http_code) {
            case 404:
              alert('Not found');
              break;
            default:
              var sg = json2form(data.result, '', []);
              console.log(sg);
              elm.append(sg);
              break;
          }
        }).
        error(function(data) {

        });
    };
  }])

;

var json2form = function(obj, str, keys) {

  for(var k in obj) {
    if(typeof obj[k] === 'object') {
      //if(Array.isArray(obj[k])) {
      keys.push(k);
      str=json2form(obj[k], str, keys);
      keys.pop();
    } else {
      // TODO: Directives
      str+=(keys.join(',')+'<div class="row"><span class="span'+(keys.length+2)+
        '">'+k+'</span><span class="span5">'+
        '<input type="text" ng-model="Product.'+k+'" value="'+
        obj[k]+'" /></span></div>');
    }
  }

  return str;
};
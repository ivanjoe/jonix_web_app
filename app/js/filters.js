'use strict';

/* Filters */

angular.module('myApp.filters', []).

  filter('interpolate', ['version', function(version) {
    return function(text) {
      return String(text).replace(/\%VERSION\%/mg, version);
    }
  }]).

  filter('onixize', [function() {
  	return function(input) {

  		var x2js = new X2JS();
  		var xmlDoc = x2js.json2xml_str(input);

  		return xmlDoc;
  	};
  }]).

  filter('reverse', [function() {
    return function(arr) {
      return arr.slice().reverse();
    }
  }])

;

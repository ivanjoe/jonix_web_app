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
		/*var start 		= '\n<?xml version="1.0"?>\n<ONIXMessage release="3.0">\n';
  		var header 		= '  <Header>\n  <!-- message header data elements -->\n'+
  		'    <Sender>';
  		//if (input.sender.name !== undefined) {
  		if (input.hasOwnProperty('sender')) {
	  		if (input.sender.hasOwnProperty('name')) {
	  			header += '\n      <SenderName>'+input.sender.name+'</SenderName>\n';
	  		};
	  	};
  		//if (input.sender.idType !== undefined) {
  		if (input.hasOwnProperty('idType')) {
  			header += '<IdType>'+input.sender.name+'</SenderName>\n';
  		};
  		header += '</Sender>\n  </Header>\n';
  		var products 	= '  <Product>\n    <!-- record and product identifiers for product 1 -->\n' +
        '    <!-- block 1 product description -->\n'+
        '    <!-- block 2 marketing collateral detail -->\n'+
        '    <!-- block 3 content detail -->\n'+
        '    <!-- block 4 publishing detail -->\n'+
        '    <!-- block 5 related material -->\n'+
        '    <!-- block 6 product supply --></Product>';
  		var tail 		= '\n</ONIXMessage>';
  		return start+header+products+tail;*/

  		var x2js = new X2JS();
  		var xmlDoc = x2js.json2xml_str(input);

  		return xmlDoc;

  		// TODO: trying to find a way to use Node.js module
  	};
  }]).
  filter('reverse', [function() {
    return function(arr) {
      return arr.slice().reverse();
    }
  }])
;

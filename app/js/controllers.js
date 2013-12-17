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
            if (data.status === 'loggedIn') {
              // Reload the page
              location.reload();
            } else {
              var modalFailedPass = $modal.open({
                templateUrl: 'partials/failedLogin.html',
                controller: 'ModalInstanceCtrl'
              });
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
          // Reload the page
          location.reload();
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

  .controller('MessageCtrl', ['$scope','$http', 'localize', '$filter', '$log',
      function($scope, $http, localize, $filter, $log) {

    $scope.demo = function() {
      $http.post('sessions.php?login=1', {password: 'nodata'})
        .success(function(data) {
          if (data.status === 'loggedIn') {
            // Reload the page
            location.reload();
          }
        })
        .error(function(data){
          alert("Couldn't log you in!");
        });
    }

    // TODO: move to configurational file
    var jonix_proxy = "./send.php";
    var lang = localize.language;
    var availableLanguages = ['default', 'en-UK'];
    // is lang in array?
    if (availableLanguages.indexOf(localize.language) === -1) {
      lang = 'default';
    }

    $scope.times = {
      sentDate: {},
      sentTime: {}
    };

    $scope.master = {
      header: {},
      product: [
        {
          DescriptiveDetail: {
            Subject: [
              {
                SubjectSchemeIdentifier:'',
                SubjectHeadingText:''
              }
            ]
          }
        }
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
      $scope.nameCodeTypeList             = data.list44;
      $scope.publishingRoleList           = data.list45;
      $scope.unpricedCodeList             = data.list57;
      $scope.publishingStatusList         = data.list64;
      $scope.supplierRoleList             = data.list93;
      $scope.productTitleElementLevelList = data.list149;
      $scope.publishingDateRoleList       = data.list163;
      //Save the data for later use
      $scope.lists = data;
    });

    var pattern = function(idType, domain) {
      var regexp = /^(.*)$/;

      switch (domain)
      {
        case 'sender':
        case 'addressee':
          switch (idType)
          {
            //TODO: add the other expressions from List44
            // GLN
            case '06':
              regexp = /^(\d{13})$/;
              break;
            // SAN
            case '07':
              regexp = /^(\d{7})$/;
              break;
            // Y-tunnus
            case '15':
              regexp = /^(\d{7}-\d)$/;
              break;
            // ISNI
            case '16':
              regexp = /^(\d{16})$/;
              break;
            // LCCN
            case '18':
              regexp = /^(\d{2,4}-{0,1}\d{6})$/;
              break;
            default:
              regexp = /^(.*)$/;
              break;
          };
          break;
        case 'productId':
          switch(idType)
          {
            // ISBN-10
            case '02':
              regexp = /^(\d{10})$/;
              break;
            // LCCN
            case '13':
              regexp = /^(\d{2,4}-{0,1}\d{6})$/;
              break;
            // ISBN-13
            case '15':
              regexp = /^(\d{13})$/;
              break;
            default:
              break;
          }
        default:
          break;
      }

      return regexp;
    };

    $scope.senderIDValuePattern = (function() {
      // http://stackoverflow.com/questions/18900308/angularjs-dynamic-ng-pattern-validation
      return {
        test: function(value) {
          var regexp = pattern($scope.message.header.sender.senderIdentifier.senderIDType, 'sender');

          return regexp.test(value);
        }
      };
    })();

    $scope.addresseeIDValuePattern = (function() {
      // http://stackoverflow.com/questions/18900308/angularjs-dynamic-ng-pattern-validation
      return {
        test: function(value) {
          var regexp = pattern($scope.message.header.addressee.addresseeIdentifier.addresseeIDType, 'addressee');

          return regexp.test(value);
        }
      };
    })();

    $scope.productIdValuePattern = (function(index) {
      return {
        test: function(value) {
          var regexp = pattern($scope.message.product[index].ProductIdentifier.ProductIDType, 'productId');

          return regexp.test(value);
        }
      };
    });

    $scope.setupDates = function() {
      var now = $filter('date')(new Date(), 'yyyyMMdd');
      $scope.message.header.sentDateTime = now;
    }

    $scope.updateSentDateTime = function() {
      // If the time value has not been set yet
      if (!angular.isDefined($scope.times.sentTime)) {
        $scope.message.header.sentTime = '';
      }
      // When the time selector is shown, update SentDateTime
      if ($scope.showTime) {
        var sentDate = $filter('date')($scope.times.sentDate, 'yyyyMMdd');
        var sentTime = $filter('date')($scope.times.sentTime, 'HHmm');
      } else {
        var sentDate = $filter('date')($scope.times.sentDate, 'yyyyMMdd');
        var sentTime = '';
      }

      $scope.message.header.sentDateTime = sentDate + sentTime;
    }

    // Add a product
    $scope.addProduct = function() {
        $scope.message.product.push(
        {
          descriptiveDetail: {
            subject: [
              {
                SubjectSchemeIdentifier:'',
                SubjectHeadingText:''
              }
            ]
          }
        }
      );
    };

    // Remove a product
    $scope.removeProduct = function(productItem) {
        var products = $scope.message.product;
        for (var i = 0, ii = products.length; i < ii; i++) {
            if (productItem === products[i]) {
                products.splice(i, 1);
            }
        }
    };

    $scope.update = function(message) {
        $scope.master = angular.copy(message);
    };

    $scope.reset = function () {
        $scope.message = angular.copy($scope.master);
    };

    $scope.load = function (id, index) {
      $http.get('./receive.php?rref='+id).
        success(function(data) {
          $log.log(data.result);
          //TODO: fix up incoming data
          // What should be arrays, what should be empty strings...
          fixIncomingData(data.result);
          $scope.message.product[index] = data.result;
          // Fill in the input fields

          // Price type
          for (var k in $scope.lists.list58) {
            if ($scope.lists.list58[k] == data.result.ProductSupply.SupplyDetail.Price.PriceType) {
              $scope.priceType = k;
            }
          }
          // Product Availability
          // TODO: lists should come from a service
          /*$scope.productAvailabilityList = data.list65;
          $scope.productLanguageCodeList = data.list74;
          $scope.countryList             = data.list91;
          $scope.currencies              = data.list96;*/

          for (var k in $scope.lists.list65) {
            if ($scope.lists.list65[k] == data.result.ProductSupply.SupplyDetail.ProductAvailability) {
              $scope.productAvailability = k;
            }
          }
        }).error(function(data){});
    };

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

  .controller('SubjectCtrl', ['$scope', function($scope) {

    // Add more subject field to the form
    $scope.addSubject = function() {
      $scope.productItem.DescriptiveDetail.Subject.push({});
    };

    // Remove subjects
    $scope.removeSubject =  function(i) {
      $scope.productItem.DescriptiveDetail.Subject.splice(i, 1);
    }

  }])

  .controller('DatepickerCtrl', ['$scope', '$timeout', function($scope, $timeout) {
     $scope.today = function() {
        $scope.times.sentDate = new Date();
     };
     $scope.today();

     $scope.showWeeks = false;

     $scope.clear = function () {
        $scope.times.sentDate = null;
     };

     $scope.clear2 = function() {
      $scope.productItem.PublishingDetail.PublishingDate.Date = null;
     }

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
    $scope.times.sentTime = new Date();
  }])

  .controller('TypeaheadCtrl', ['$scope','$http','localize',
      function($scope, $http, localize) {
    $scope.selected = undefined;

    var lang = localize.language;
    var availableLanguages = ['default', 'en-UK'];
    // is lang in array?
    if (availableLanguages.indexOf(localize.language) === -1) {
      lang = 'default';
    }

    $http.get('assets/lists/typeheads_'+lang+'.json').success(function(data){
      $scope.subjectSchemeIdentifiers= data.list27;
      $scope.priceTypes              = data.list58;
      $scope.productAvailabilityList = data.list65;
      $scope.productLanguageCodeList = data.list74;
      $scope.countryList             = data.list91;
      $scope.currencies              = data.list96;
    });

    $scope.getKeywordsAjax = function(query, schemeIdentifier){
      if (query.length > 1) {

        //TODO: the language code should be sent over
        switch (schemeIdentifier) {
          case 64:
            return $http.get('./query.php?query='+query+'*&lang=fi&schid=64')
              .then(function(response){
                return limitToFilter(response.data, 15);
              });
            break;
          case 86:
            return $http.get('./query.php?query='+query+'*&lang=fi&schid=86')
              .then(function(response){
                return response.data.geonames;
              });
            break;
          default:
            break;
        };

      }
    };

    $scope.availabilityCodeFor = function(item) {
      $scope.productAvailability = item.code;
    };

    var limitToFilter = function(data, limit) {
      return data.results.splice(0,limit);
    };

    $scope.showSubjectSchemeIdentifier = function(data) {
      $scope.subjectItem.SubjectSchemeIdentifier = data.code;
    };

    $scope.showSubjectCode = function(data, type) {
      // Show links for the different subjects
      switch (type) {
        case "YSA":
          $scope.subjectItem.subjCode.url = "http://www.yso.fi/onto/ysa/" + data.localname;

          $scope.subjectItem.SubjectCode = data.localname;
          break;
        case "Geonames":
          $scope.subjectItem.subjCode.url = "http://geonames.org/" + data.geonameId;

          $scope.subjectItem.SubjectCode = data.geonameId;
          break;
      }
    };

    $scope.showLanguageCode = function(data) {
      $scope.productItem.DescriptiveDetail.Language.LanguageCode = data.code;
    };

    $scope.showCountryCode = function(data) {
      $scope.productItem.PublishingDetail.CountryOfPublication = data.code;
    };

    $scope.showAvailabilityCode = function(data) {
      $scope.productItem.ProductSupply.SupplyDetail.ProductAvailability = data.code;
    }

    $scope.showPriceTypeCode = function(data) {
      $scope.productItem.ProductSupply.SupplyDetail.Price.PriceType = data.code;
    }

    $scope.showCurrencyCode = function(data) {
      $scope.productItem.ProductSupply.SupplyDetail.Price.CurrencyCode = data.code;
    }

  }])

  .controller('AlertCtrl', ['$scope','$filter', function($scope, $filter) {
    $scope.alerts = [
    ];

    $scope.$on('answer', function(answer, data) {
      console.log(data);

      var now = $filter('date')(new Date(), 'dd MMMM yyyy h:mm:ss');

      var alert = {};

      // types: success, info, warning, error
      // Connection with proxy (send.php) was succesful
      // TODO: prepare for all the HTTP codes
      if(data[1] == 200) {
        if (data[0].http_code == 406 || data[0].http_code == 404) {
          alert.type = "warning";
          alert.msg = '<strong>Backend responded:</strong><br/>' + data[0].result +
            '<br/>at <small>' + now + '</small>';
        } else if (data[0].http_code == 401) {
          alert.type = "warning";
          alert.msg = 'Failed! Unauthorized message!<br/>at <small>' + now + '</small>';
        } else {
          alert.type = 'success';
          alert.msg = 'I guess everything went fine' +
            '<br/><small>at ' + now + '</small><br/>Edit:<br/>';
          for (var i=0; i < data[0]['view_product'].length; i++) {
            alert.msg += "<a href='"+data[0]['view_product'][i]+"' target='_blank'>Product "+i+"</a>";
          }
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
      $scope.alerts.splice(-(index+1), 1);
    };
  }])

  .controller('ProductCtrl', ['$scope', '$route', function($scope, $route){
    $scope.product =
      {
        id: $route.current.params.id
      };
  }])

;

// This traverses through the JSON and downcases the first letter of the properties
var propDowncase = function(obj, newObj) {

  for(var k in obj) {
    var kNew = k.charAt(0).toLowerCase()+k.slice(1);

    if (typeof obj[k] === 'object') {
      if(Array.isArray(obj[k])) {
        newObj[kNew] = propDowncase(obj[k], []);
      } else {
        newObj[kNew] = propDowncase(obj[k], {});
      }
      //newObj[kNew] = obj[k];
    } else {
      newObj[kNew] = obj[k];
    }

  }

  return newObj;
};

var fixIncomingData = function(product) {
  // Subject should be an Array
  if (!Array.isArray(product.DescriptiveDetail.Subject)) {
    var subject = product.DescriptiveDetail.Subject;
    product.DescriptiveDetail.Subject = [];
    product.DescriptiveDetail.Subject.push(subject);
  }
  // If there is price, unset unpriced item
  if (typeof product.ProductSupply.SupplyDetail.Price.PriceType != 'undefined') {
    if (typeof product.ProductSupply.SupplyDetail.UnpricedItemType == 'object') {
      delete product.ProductSupply.SupplyDetail.UnpricedItemType;
    }
  }
  return product;
};

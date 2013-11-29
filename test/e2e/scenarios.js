'use strict';

/* http://docs.angularjs.org/guide/dev_guide.e2e-testing */

describe('my app', function() {

  beforeEach(function() {
    browser().navigateTo('../../app/index.php');
  });


  it('should automatically redirect to /onix-books when location hash/fragment is empty', function() {
    expect(browser().location().url()).toBe("/onix-books");
  });


  describe('onix-books', function() {

    beforeEach(function() {
      browser().navigateTo('#/onix-books');
    });

    it('should render form when user navigates to /onix-books and logs in', function() {
      sleep(0.5);

      element('button[ng-click="open()"').click();

      expect(element('div.modal div.modal-header h3').text()).
        toMatch(/Kirjaudu sisään/);

      input('input.pass').enter('demo');
      element('button[ng-click="ok()"]').click();

      expect(element('[ng-view] > [ng-controller="MessageCtrl"] > div.span8'));
    });

    it('should not let empty form to be sent', function() {
      expect(element("button[ng-click='send()']").attr('disabled')).toBe('disabled');
    });

    it('the send button should be enabled once the form is filled', function() {
      // Fill in the form
      input('message.header.sender.senderName').enter('Kubinyi');
      input('times.sentDate').enter('2013-12-01');
      input('productItem.recordReference').enter('1234-XYZ-4321');
      select('productItem.notificationType').option('01');
      select('productItem.productIdentifier.productIDType').option('02');
      input('productItem.productIdentifier.IDValue').enter('1234567890');
      select('productItem.descriptiveDetail.composition').option('10');
      select('productItem.descriptiveDetail.productForm').option('BC');
      select('productItem.descriptiveDetail.titleDetail.titleType').option('03');
      select('productItem.descriptiveDetail.titleDetail.titleElement.titleElementLevel')
        .option('03');
      input('productItem.descriptiveDetail.titleDetail.titleElement.titleText')
        .enter('No name');
      select('productItem.descriptiveDetail.language.languageRole')
        .option('01');

      input('language').enter('unkari'); // Typeahead
      sleep(0.3);
      element('#languageTypeahead li a').click();
      expect(input('language').val()).toBe('unkari');


      input('subjectSchemeIdentifier').enter('YSA'); // Typeahead
      sleep(0.3);
      element("#subjectSchemeTypeahead li a").click();
      expect(input('subjectSchemeIdentifier').val()).toBe('YSA');

      select('productItem.publishingDetail.publisher.publishingRole')
        .option('01');
      input('productItem.publishingDetail.publisher.publishingName')
        .enter('Ferenc Joska');

      input('country').enter('Hungary'); // Typehead
      sleep(0.1);
      element("#countryTypeahead li a").click();
      expect(input('language').val()).toBe('unkari');

      select('productItem.publishingDetail.publishingStatus')
        .option('00');
      select('productItem.publishingDetail.publishingDate.publishingDateRole')
        .option('01');

      input('productItem.publishingDetail.publishingDate.date')
        .enter('2012-12-24');
      select('productItem.productSupply.supplyDetail.supplier.supplierRole')
        .option('01');
      input('productItem.productSupply.supplyDetail.supplier.supplierName')
        .enter('Trucker');

      input('productAvailability').enter('Saatavana, varastotuote'); // Typehead
      sleep(0.1);
      element("#availabilityTypeahead li a").click();
      expect(input('productAvailability').val()).toBe('Saatavana, varastotuote');

      input('priced').select('1');

      input('priceType').enter('Fixed retail price excluding tax');
      sleep(0.1);
      element("#priceTypeTypeahead li a").click();
      expect(input('priceType').val()).toBe('Fixed retail price excluding tax');


      input('productItem.productSupply.supplyDetail.price.priceAmount')
        .enter('123');

      input('currencyCode').enter('Euro');
      sleep(0.1);
      element("#currencyTypeahead li a").click();
      expect(input('currencyCode').val()).toBe('Euro');


      input('productItem.productSupply.supplyDetail.price.priceCoded.priceCode')
        .enter('B');

      pause();

      expect(element("button[ng-click='send()']").attr('disabled')).not().toBeDefined();

      //element('button[ng-click="send()"]').click();

    });

    it('should log out', function() {
      element('button[ng-click="logout()"]').click();
      sleep(2);

      expect(element('button[ng-click="open()"]').text()).toBe('Kirjaudu sisään');
    });

  });

  describe('products', function() {

    describe('edit product', function() {
      beforeEach(function() {
        browser().navigateTo('#/products/123456789/edit');
      });

      it('should render edit product when user navigates to /products/123456789/edit',
       function () {
        expect(element('h3:first').text()).
          toMatch(/Edit 123456789 product/);
       });

    })
  });

  /*describe('view2', function() {

    beforeEach(function() {
      browser().navigateTo('#/view2');
    });


    it('should render view2 when user navigates to /view2', function() {
      expect(element('[ng-view] p:first').text()).
        toMatch(/partial for view 2/);
    });

  });*/
});

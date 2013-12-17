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

      if(element('button[ng-click="open()"').count() == 0) {
        element('button[ng-click="open()"').click();

        expect(element('div.modal div.modal-header h3').text()).
          toMatch(/Kirjaudu sisään/);

        input('input.pass').enter('demo');

        element('button[ng-click="ok()"]').click();
      }

      expect(element('[ng-view] > [ng-controller="MessageCtrl"] > div.span8'));
    });

    it('should not let empty form to be sent', function() {
      expect(element("button[ng-click='send()']").attr('disabled')).toBe('disabled');
    });

    it('the send button should be enabled once the form is filled', function() {
      // Fill in the form
      input('message.header.sender.senderName').enter('Kubinyi');
      input('times.sentDate').enter('2013-12-01');
      input('productItem.RecordReference').enter('1234-XYZ-4321');
      select('productItem.NotificationType').option('01');
      select('productItem.ProductIdentifier.productIDType').option('02');
      input('productItem.ProductIdentifier.IDValue').enter('1234567890');
      select('productItem.DescriptiveDetail.Composition').option('10');
      select('productItem.DescriptiveDetail.ProductForm').option('BC');
      select('productItem.DescriptiveDetail.TitleDetail.TitleType').option('03');
      select('productItem.DescriptiveDetail.TitleDetail.TitleElement.TitleElementLevel')
        .option('03');
      input('productItem.DescriptiveDetail.TitleDetail.TitleElement.TitleText')
        .enter('No name');
      select('productItem.DescriptiveDetail.Language.LanguageRole')
        .option('01');

      input('language').enter('unkari'); // Typeahead
      sleep(0.3);
      element('#languageTypeahead li a').click();
      expect(input('language').val()).toBe('unkari');

      input('SubjectSchemeIdentifier').enter('YSA'); // Typeahead
      sleep(0.3);
      element("#subjectSchemeTypeahead li a").click();
      expect(input('SubjectSchemeIdentifier').val()).toBe('YSA');

      select('productItem.PublishingDetail.Publisher.PublishingRole')
        .option('01');
      input('productItem.PublishingDetail.Publisher.PublishingName')
        .enter('Ferenc Joska');

      input('country').enter('Hungary'); // Typehead
      sleep(0.1);
      element("#countryTypeahead li a").click();
      expect(input('language').val()).toBe('unkari');

      select('productItem.PublishingDetail.PublishingStatus')
        .option('00');
      select('productItem.PublishingDetail.PublishingDate.PublishingDateRole')
        .option('01');

      input('productItem.PublishingDetail.PublishingDate.Date')
        .enter('2012-12-24');
      select('productItem.ProductSupply.SupplyDetail.Supplier.SupplierRole')
        .option('01');
      input('productItem.ProductSupply.SupplyDetail.Supplier.SupplierName')
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

      input('productItem.ProductSupply.SupplyDetail.Price.PriceAmount')
        .enter('123');

      input('currencyCode').enter('Euro');
      sleep(0.1);
      element("#currencyTypeahead li a").click();
      expect(input('currencyCode').val()).toBe('Euro');

      input('productItem.ProductSupply.SupplyDetail.Price.PriceCoded.PriceCode')
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
        element('button[ng-click="open()"').click();

        expect(element('div.modal div.modal-header h3').text()).
          toMatch(/Kirjaudu sisään/);

        input('input.pass').enter('demo');

        element('button[ng-click="ok()"]').click();
      });

      it('should render edit product when user navigates to /products/testi-123/edit',
       function () {
        browser().navigateTo('#/products/testi-123/edit');
        sleep(0.5);
        expect(element('h3:first').text()).
          toMatch(/Edit testi-123 product/);
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

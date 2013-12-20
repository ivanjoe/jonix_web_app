<?php
session_start();
  if (isset($_SESSION['demo'])) {
    if($_SESSION['demo'] == md5(date("Ymd").'UserLoggedIn')) { ?>
      <div ng-controller="ModalCtrl">
        <button class="btn" style="position: absolute; top: 8px; right: 10px" ng-click="logout()">{{'_Logout_' | i18n}}</button>
      </div>


<div class="row" ng-controller="MessageCtrl">
  <div class="span8">
    <div class="well">
      <form name="messageForm">
        <fieldset>
          <legend>
            {{'_Header_' | i18n}}
          <?php if ($_SESSION['title'] === 'demo'): ?>
            <span class="pull-right">DEMO</span>
          <?php endif; ?>
          </legend>

          <!-- HEADER information -->
          <div ng-include="'partials/header.html'">
          </div>

      	  <div ng-repeat="productItem in message.product" ng-form="productForm">
      	  	<legend>{{'_Product_' | i18n}}</legend>

      	  	<div class="row">
  	      	  <label for="record-reference" class="span2">{{'_Record_reference_' | i18n}}</label>
  	      	  <div class="span5">
  	      	  	<input id="record-reference" type="text" ng-model="productItem.RecordReference" required/>
  	      	  </div>
  	      	</div>

  	      	<div class="row">
  	      	  <label for="notification-type" class="span2">{{'_Notification_type_' | i18n}}</label>
  	      	  <div class="span5">
  	      	  	<select id="notification-type" ng-model="productItem.NotificationType"
                  ng-options="key as value for (key, value) in productNotificationTypeList"
                   required>
  	      	  	  <option value="">{{'_Select_notification_type_' | i18n}}</option>
  	      	  	</select>
                <code>{{productItem.NotificationType}}</code>
  	      	  </div>
  	      	</div>

  	      	<div class="row">
  	      	  <label for="productIdType" class="span2">{{'_Product_ID_type_' | i18n}}</label>
  	      	  <div class="span5">
  	      	  	<select id="productIdType" name="productIdType" ng-model="productItem.ProductIdentifier.productIDType"
                  ng-options="key as value for (key, value) in productIdTypeList" required
                  ng-change="changeProductForm(productItem.ProductIdentifier.productIDType)" ng-init="productItem.ProductIdentifier.productIDType='02'">
  	      	  	  <option value="">{{'_Select_ID_type_' | i18n}}</option>
  	      	  	</select>
                <code>{{productItem.ProductIdentifier.productIDType}}</code>
                <input name="productIdValue" id="productIdValue" type="text" ng-model="productItem.ProductIdentifier.IDValue"
                  ng-pattern="productIdValuePattern($index)" required
                  tooltip="{{('_PIDType_' + productItem.ProductIdentifier.productIDType + '_') | i18n}}"
                  tooltip-trigger="focus" tooltip-placement="right"/>
                <p>
                  <small class="text-error" ng-show="productForm.productIdValue.$error.pattern">
                    {{'_Tunnus_should_be_' | i18n}}
                  </small>
                </p>
  	      	  </div>
  	      	</div>

  	      	<h4>{{'_Descriptive_details_' | i18n}}</h4>

  	      	<div class="row">
  	      	  <label for="product-composition" class="span2">{{'_Product_composition_' | i18n}}</label>
  	      	  <div class="span5">
  	      	  	<select id="product-composition" ng-model="productItem.DescriptiveDetail.Composition"
                    ng-options="key as value for (key, value) in productCompositionList" required>
                  <option value="">{{'_Select_composition_' | i18n}}</option>
                </select>
                <code>{{productItem.DescriptiveDetail.Composition}}</code>
  	      	  </div>
  	      	</div>

  	      	<div class="row">
  	      	  <label for="product-form" class="span2">{{'_Product_form_' | i18n}}</label>
  	      	  <div class="span5">
  	      	  	<select id="product-form" ng-model="productItem.DescriptiveDetail.ProductForm"
                    ng-options="key as value for (key, value) in productFormList" required>
  	      	  		<option value="">{{'_Select_product_form_' | i18n}}</option>
  	      	  	</select>
                <code>{{productItem.DescriptiveDetail.ProductForm}}</code>
  	      	  </div>
  	      	</div>

            <!-- TODO: make it multiplicable -->
  	      	<div class="row">
  	      	  <label class="span2">{{'_Product_title_' | i18n}}</label>
  	      	  <div class="span5">
  	      	  	<select type="text" ng-model="productItem.DescriptiveDetail.TitleDetail.TitleType" ng-options="key as value for (key, value) in productTitleTypeList" required/>
                  <option value="">{{'_...title_type_' | i18n}}</option>
                </select>
                <code>{{productItem.DescriptiveDetail.TitleDetail.TitleType}}</code>
                <select type="text" ng-model="productItem.DescriptiveDetail.TitleDetail.TitleElement.TitleElementLevel" ng-options="key as value for (key,value) in productTitleElementLevelList" required/>
                  <option value="">{{'_...element_level_' | i18n}}</option>
                </select>
                <code>{{productItem.DescriptiveDetail.TitleDetail.TitleElement.TitleElementLevel}}</code>
                <input type="text" ng-model="productItem.DescriptiveDetail.TitleDetail.TitleElement.TitleText" placeholder="{{'_title_text_' | i18n}}" required/>
                <span>[{{'_more..._' | i18n}}]</span>
  	      	  </div>
  	      	</div>

            <div class="row">
              <label class="span2">{{'_Language_' | i18n}}</label>
              <div class="span5">
                <select ng-model="productItem.DescriptiveDetail.Language.LanguageRole" ng-options="key as value for (key, value) in productLanguageRoleList" required/>
                  <option value="">{{'_...language_role_' | i18n}}</option>
                </select>
                <span ng-controller="TypeaheadCtrl" id="languageTypeahead">
                  <input type="text" class="input-small" ng-model="language"
                    typeahead="lang.name for lang in productLanguageCodeList | filter:$viewValue | limitTo:8"
                    typeahead-editable='false' typeahead-on-select="showLanguageCode($item)" />
                </span>
                <code>{{productItem.DescriptiveDetail.Language.LanguageRole}}</code>
                <code>{{productItem.DescriptiveDetail.Language.LanguageCode}}</code>
                <span>[{{'_more..._' | i18n}}]</span>
              </div>
            </div>

            <!-- SUBJECTS -->
            <div class="row"
              ng-repeat="subjectItem in productItem.DescriptiveDetail.Subject"

              ng-controller="SubjectCtrl" ng-include="'partials/subjects.html'">
            </div>

            <h4>{{'_Publishing_details_' | i18n}}</h4>

            <div class="row">
              <label class="span2">{{'_Publisher_' | i18n}}</label>
              <div class="span5">
                <select ng-model="productItem.PublishingDetail.Publisher.PublishingRole" ng-options="key as value for (key, value) in publishingRoleList" class="input-medium" required/>
                  <option value="">{{'_...publishers_role_' | i18n}}</option>
                </select>
                <input type="text" ng-model="productItem.PublishingDetail.Publisher.PublishingName" placeholder="{{'_Name_' | i18n}}" required/>
                <code>{{ productItem.PublishingDetail.Publisher.PublishingRole }}</code>
              </div>
            </div>

            <div class="row">
              <label class="span2">{{'_Country_of_publication_' | i18n}}</label>
              <div class="span5" ng-controller="TypeaheadCtrl" id="countryTypeahead">
                <input type="text" ng-model="country"
                    typeahead="country.name for country in countryList | filter:$viewValue | limitTo:8"
                    typeahead-editable='false' class="input-medium" typeahead-on-select="showCountryCode($item)" required/>
                <code>{{ productItem.PublishingDetail.CountryOfPublication }}</code>
              </div>
            </div>

            <div class="row">
              <label class="span2">{{'_Publishing_status_' | i18n}}</label>
              <div class="span5">
                <select ng-model="productItem.PublishingDetail.PublishingStatus" ng-options="key as value for (key, value) in publishingStatusList" required />
                  <option value="">{{'_Select_publishing_status_' | i18n}}</option>
                </select>
                <code>{{ productItem.PublishingDetail.PublishingStatus }}</code>
              </div>

            </div>

            <div class="row">
              <label class="span2">{{'_Publishing_date_' | i18n}}</label>
              <div class="span5">
                <select ng-model="productItem.PublishingDetail.PublishingDate.PublishingDateRole" ng-options="key as value for (key, value) in publishingDateRoleList" required/>
                  <option value="">{{'_...status_' | i18n}}</option>
                </select>
                <code>{{ productItem.PublishingDetail.PublishingDate.PublishingDateRole }}</code>

                <div class="form-horizontal">
                    <input type="text" id="date-picker" class="input-small" datepicker-popup="yyyyMMdd"
                     ng-model="productItem.PublishingDetail.PublishingDate.Date" is-open="opened" min="minDate" max="'2015-06-22'"
                     datepicker-options="{'starting-day': '1'}" date-disabled="disabled(date, mode)"
                     ng-required="true" btn-today/>
                </div>

              </div>
            </div>

            <h4>{{'_Product_supply_' | i18n}}</h4>

            <div class="row">
              <label class="span2">{{'_Supplier_' | i18n}}</label>
              <div class="span5">
                <select id="supplier-role" ng-model="productItem.ProductSupply.SupplyDetail.Supplier.SupplierRole" ng-options="key as value for (key, value) in supplierRoleList" required>
                  <option value="">{{'_Select_supplier_role_' | i18n}}</option>
                </select>
                <code>{{productItem.ProductSupply.SupplyDetail.Supplier.SupplierRole}}</code>
                <input type="text" ng-model="productItem.ProductSupply.SupplyDetail.Supplier.SupplierName" placeholder="{{'_Name_' | i18n}}" required/>
              </div>
            </div>

            <div class="row">
              <label class="span2">{{'_Product_availability_' | i18n}}</label>
              <div class="span5" ng-controller="TypeaheadCtrl" id="availabilityTypeahead">
                <input type="text" ng-model="productAvailability"
                    typeahead="availability.name for availability in productAvailabilityList | filter:$viewValue | limitTo:8"
                    typeahead-editable='false' typeahead-on-select="showAvailabilityCode($item)" required/>
                <code>
                  {{ productItem.ProductSupply.SupplyDetail.ProductAvailability }}
                </code>
              </div>
            </div>

            <div class="row">
              <label class="span2"></label>
              <div class="span5" ng-init="priced=0">
                <label class="radio inline"><input type="radio" ng-model="priced" value=1
                  ng-change="productItem.ProductSupply.SupplyDetail.UnpricedItemType=null" />{{'_Priced_' | i18n}}
                </label >
                <label class="radio inline"><input type="radio" ng-model="priced" value=0
                  ng-change="productItem.ProductSupply.SupplyDetail.Price={}" />{{'_Unpriced_' | i18n}}
                </label>
              </div>
            </div>

            <div class="row" ng-hide="priced">
              <label class="span2">{{'_Unpriced_item_type_' | i18n}}</label>
              <div class="span5">
                <select ng-model="productItem.ProductSupply.SupplyDetail.UnpricedItemType" ng-options="key as value for (key, value) in unpricedCodeList">
                  <option value="">{{'_Select_unpriced_item_type_' | i18n}}</option>
                </select>
                <code>{{productItem.ProductSupply.SupplyDetail.UnpricedItemType}}</code>
              </div>
            </div>

            <div class="row" ng-show="priced">
              <label class="span2">{{'_Price_type_' | i18n}}</label>
              <div class="span5" ng-controller="TypeaheadCtrl" id="priceTypeTypeahead">
                <input type="text" ng-model="priceType"
                  typeahead="typ.name for typ in priceTypes | filter:$viewValue | limitTo:8"
                  typeahead-editable='false' required typeahead-on-select="showPriceTypeCode($item)" />
                <code>{{ productItem.ProductSupply.SupplyDetail.Price.PriceType }}</code>
              </div>
            </div>

            <div class="row" ng-show="priced">
              <label class="span2">{{'_Price_amount_' | i18n}}</label>
              <div class="span5">
                <input type="text" name="priceAmount" class="input-small"
                 ng-pattern="/^(\d{1,5}(\.\d{0,3}){0,1})$/" ng-model="productItem.ProductSupply.SupplyDetail.Price.PriceAmount"
                 maxlength="10" required/>
                <span ng-controller="TypeaheadCtrl" id="currencyTypeahead">
                  <input type="text"  class="input-small" ng-model="currencyCode"
                    typeahead="curr.name for curr in currencies | filter:$viewValue | limitTo:8"
                    typeahead-editable='false' placeholder="{{'_...currency_' | i18n}}" required
                    typeahead-on-select="showCurrencyCode($item)"/>
                  <code>
                    {{ productItem.ProductSupply.SupplyDetail.Price.CurrencyCode }}
                  </code>
                </span>
                  <small class="text-error" ng-show="productForm.priceAmount.$error.pattern">
                    {{'_Only_numbers_' | i18n}}
                  </small>

              </div>
            </div>

            <div class="row" ng-show="priced">
              <label class="span2">{{'_Price_code_type_' | i18n}}</label>
              <div class="span5">
                <select type="text" ng-model="productItem.ProductSupply.SupplyDetail.Price.PriceCoded.PriceCodeType"
                  ng-init="productItem.ProductSupply.SupplyDetail.Price.PriceCoded.PriceCodeType='02'" required/>
                  <option value="01" selected="selected">{{'_Proprietary_' | i18n}}</option>
                  <option value="02">{{'_Finnish_price_code_' | i18n}}</option>
                </select>
                <input type="text"
                  ng-model="productItem.ProductSupply.SupplyDetail.Price.PriceCoded.PriceCode"
                  placeholder="{{'_Price_code_' | i18n}}" required/>
                <code>{{productItem.ProductSupply.SupplyDetail.Price.PriceCoded.PriceCodeType}}</code>
              </div>
            </div>
              <button class="btn btn-small btn-info" ng-click="addProduct()">{{'_add_more_products_' | i18n}}</button>

            <?php if ($_SESSION['title'] != 'demo'): ?>
              <input type="text" ng-model="rref" style="vertical-align: initial">
              <button class="btn btn-small btn-success" ng-click="load(rref, $index)">Load</button>
            <?php endif; ?>
              <button class="btn btn-small btn-danger pull-right" ng-click="removeProduct(productItem)" ng-show="message.product.length > 1">
                {{'_Remove_' | i18n}}
              </button>
            </div>

            <hr/>
            <button class="btn btn-small btn-inverse" ng-click="reset()" ng-disabled="isUnchanged(mgsessage)">{{'_Reset_' | i18n}}</button>
         	  <button class="btn btn-small btn-good" ng-click="send()" ng-disabled="messageForm.$invalid">{{'_Send_' | i18n}}</button><br/>

          </fieldset>
        </form>
      </div>
    </div>

    <div class="span4">
    	<h3>{{'_ONIX_msg_' | i18n}}</h3>
        <div ng-controller="AlertCtrl">
          <alert ng-repeat="alert in alerts | reverse" type="alert.type" close="closeAlert($index)"><span ng-bind-html-unsafe="alert.msg"></span></alert>
        </div>
    		<pre>form = &lt;?xml version="1.0" encoding="UTF-8" ?&gt;
&lt;ONIXMessage xmlns="http://ns.editeur.org/onix/3.0/reference" release="3.0"&gt;
{{ message | onixize }}</pre>
        Debug: <input type="checkbox" ng-model="debug" />
        <pre ng-show="debug">{{times}}

          {{ message | json }}</pre>
    </div>

  </div>
  <?php
    } else { ?>
      <div ng-controller="ModalCtrl">
        <button class="btn" style="position: absolute; top: 8px; right: 10px" ng-click="logout()">{{'_Logout_' | i18n}}</button>
      </div>
      <div class="row">
        <alert class="alert-danger span5" data-i18n="_Naughty!!!_"></alert>
      </div>
  <?php
    }
  } else { ?>
      <div ng-controller="ModalCtrl">
        <button class="btn" style="position: absolute; top: 8px; right: 10px" ng-click="open()">{{'_Login_' | i18n}}</button>
      </div>
      <div class="row">
        <div class="span5">
          <alert class="alert-info" data-i18n="_Wanna_login_">as

          </alert>
        </div>
        <div class="span3">
          <button class="btn btn-primary" ng-click="demo()" tooltip="{{'_demo_explanation_' | i18n}}">
            {{'_Demo_' | i18n}}
          </button>
        </div>
      </div>
  <?php } ?>
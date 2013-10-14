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
          <legend>{{'_Header_' | i18n}}</legend>

          <div class="row">
          	<label for="identifier" class="span2">{{'_Identifier_' | i18n}}</label>
          	<div class="span5">
              <!-- <select ng-model="identifier-selection" ng-options="item for item in ['id','name']"></select> -->
          	  <label class="radio inline">
          	  	<input type="radio" ng-model="sender.identifier" value="id" />{{'_id_' | i18n}}
          	  </label>
          	  <label class="radio inline">
          	    <input type="radio" ng-model="sender.identifier" value="name" />{{'_name_' | i18n}}<br />
          	  </label>
            </div>
          </div>

          <!-- Show Sender name field if name radio button is chosen -->
          <div class="row" ng-show="sender.identifier == 'name'">
          	<label for="sender-name" class="span2">{{'_senderName_' | i18n}}</label>
          	<div class="span5">
              <input type="text" ng-model="message.header.sender.senderName" class="form-control"
                name="senderName" id="senderName" placeholder="{{'_senderName_' | i18n}}"
                  maxlength=30 ng-pattern="/^([A-Za-zÖöÄäÅå' ]{0,30})$/">
                <p>
                  <small class="text-error" ng-show="messageForm.senderName.$error.pattern">
                    {{'_just_letters_' | i18n}}
                  </small>
                </p>
            </div>
          </div>

          <!-- otherwise Id -->
          <div class="row" ng-show="sender.identifier == 'id'">
          <!-- <div class="row" ng-switch-when="id"> -->
          	<label for="senderIdType" class="span2">{{'_sender_id_type_' | i18n}}</label>
            <div class="span5">
              <input type="text" ng-model="message.header.sender.idType" class="form-control" id="senderIdType" placeholder="{{'_ID_type_' | i18n}}">
            </div>
          </div>

          <div class="row" ng-show="sender.identifier == 'id'">
          <!-- <div class="row" ng-switch-when="id"> -->
          	<label for="senderIdValue" class="span2">{{'_sender_id_value_' | i18n}}</label>
            <div class="span5">
              <input type="text" ng-model="message.header.sender.idValue" class="form-control" id="sender-id-value" placeholder="{{'_ID_value_' | i18n}}">
            </div>
          </div>
          <!-- </div> -->

          <!-- Id ends -->

          <hr />

          <div class="row">
          	<label for="date-picker" class="span2">{{'_Date_' | i18n}}</label>
          	<div class="span5">

  	          <div ng-controller="DatepickerCtrl">
      			    <div class="form-horizontal">
      			        <input type="text" id="date-picker" class="input-small" datepicker-popup="yyyyMMdd" ng-model="message.header.sentDateTime" is-open="opened" min="minDate" max="'2015-06-22'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" ng-required="true" />
      			        <button class="btn btn-small btn-inverse" ng-click="today()">{{'_Today_' | i18n}}</button>
      			        <button class="btn btn-small btn-danger" ng-click="clear()">{{'_Clear_' | i18n}}</button>
                    <code>{{(message.header.sentDateTime | date:'yyyyMMdd') + (message.header.sentTime | date:'HHmm') }}</code>
      			    </div>
      			  </div>

              <div class="checkbox">
              	<label><input type="checkbox" ng-model="showTime" ng-init="checked=true">{{'_Select_time_' | i18n}}</label>
              </div>
            </div>
          </div>

          <div class="row" ng-show="showTime">
          	<label for="time" class="span2">{{'_Time_' | i18n}}</label>
          	<div class="span5">
              <div ng-controller="TimepickerCtrl" class="ng-scope">
              	<div ng-model="message.header.sentTime" ng-change="changed()" class="well well-small" style="display:inline-block;">
			    	      <timepicker hour-step="1" minute-step="1" show-meridian="false"></timepicker>
			  	      </div>
              </div>
          	</div>
          </div>

      	  <div ng-repeat="product in message.products" ng-form="productForm">
      	  	<legend>{{'_Product_' | i18n}}</legend>

      	  	<div class="row">
  	      	  <label for="record-reference" class="span2">{{'_Record_reference_' | i18n}}</label>
  	      	  <div class="span5">
  	      	  	<input id="record-reference" type="text" ng-model="product.recordReference" required/>
  	      	  </div>
  	      	</div>

  	      	<div class="row">
  	      	  <label for="notification-type" class="span2">{{'_Notification_type_' | i18n}}</label>
  	      	  <div class="span5">
  	      	  	<select id="notification-type" ng-model="product.notificationType" ng-options="key as value for (key, value) in productNotificationTypeList" required>
  	      	  	  <option value="">{{'_Select_notification_type_' | i18n}}</option>
  	      	  	</select>
  	      	  </div>
  	      	</div>

  	      	<div class="row">
  	      	  <label for="product-id-type" class="span2">{{'_Product_ID_type_' | i18n}}</label>
  	      	  <div class="span5">
  	      	  	<select id="product-id-type" ng-model="product.IdType" ng-options="key as value for (key, value) in productIdTypeList" required>
  	      	  	  <option value="">{{'_Select_ID_type_' | i18n}}</option>
  	      	  	</select>
                <input name="productIdValue" id="productIdValue" type="text" ng-model="product.idValue" ng-pattern="/^[0-9]{10,13}$/" required/>
                <p>
                  <small class="text-error" ng-show="productForm.productIdValue.$error.pattern">
                    {{'_Product_id_should_be_' | i18n}}
                  </small>
                </p>
  	      	  </div>
  	      	</div>

  	      	<h4>{{'_Descriptive_details_' | i18n}}</h4>

  	      	<div class="row">
  	      	  <label for="product-composition" class="span2">{{'_Product_composition_' | i18n}}</label>
  	      	  <div class="span5">
  	      	  	<select id="product-composition" ng-model="product.descriptiveDetail.composition" ng-options="key as value for (key, value) in productCompositionList" required>
                  <option value="">{{'_Select_composition_' | i18n}}</option>
                </select>
  	      	  </div>
  	      	</div>

	      	<div class="row">
	      	  <label for="product-form" class="span2">{{'_Product_form_' | i18n}}</label>
	      	  <div class="span5">
	      	  	<select id="product-form" ng-model="product.descriptiveDetail.productForm" ng-options="key as value for (key, value) in productFormList" required>
	      	  		<option value="">{{'_Select_product_form_' | i18n}}</option>
	      	  	</select>
	      	  </div>
	      	</div>

          <!-- TODO: make it multiplicable -->
	      	<div class="row">
	      	  <label class="span2">{{'_Product_title_' | i18n}}</label>
	      	  <div class="span5">
	      	  	<select type="text" ng-model="product.descriptiveDetail.titleDetail.titleType" ng-options="key as value for (key, value) in productTitleTypeList" required/>
                <option value="">{{'_...title_type_' | i18n}}</option>
              </select>
              <select type="text" ng-model="product.descriptiveDetail.titleDetail.titleElement.titleElementLevel" ng-options="key as value for (key,value) in productTitleElementLevelList" required/>
                <option value="">{{'_...element_level_' | i18n}}</option>
              </select>
              <input type="text" ng-model="product.descriptiveDetail.titleDetail.titleElement.titleText" placeholder="{{'_title_text_' | i18n}}" required/>
              <span>[{{'_more..._' | i18n}}]</span>
	      	  </div>

	      	</div>

          <div class="row">
            <label class="span2">{{'_Language_' | i18n}}</label>
            <div class="span5">
              <select ng-model="product.descriptiveDetail.language.languageRole" ng-options="key as value for (key, value) in productLanguageRoleList" required/>
                <option value="">{{'_...language_role_' | i18n}}</option>
              </select>
              <span ng-controller="TypeheadCtrl">
                <input type="text" class="input-small" ng-model="product.descriptiveDetail.language.languageCode" typeahead="lang for lang in productLanguageCodeList | filter:$viewValue | limitTo:8" typeahead-editable='false'/>
              </span>
              <span>[{{'_more..._' | i18n}}]</span>
            </div>
          </div>

          <h4>{{'_Publishing_details_' | i18n}}</h4>

          <div class="row">
            <label class="span2">{{'_Publisher_' | i18n}}</label>
            <div class="span5">
              <select ng-model="product.publishingDetail.publisher.publishingRole" ng-options="key as value for (key, value) in publishingRoleList" class="input-medium" required/>
                <option value="">{{'_...publishers_role_' | i18n}}</option>
              </select>
              <input type="text" ng-model="product.publishingDetail.publisher.publishinName" placeholder="{{'_Name_' | i18n}}" required/>
            </div>
          </div>

          <div class="row">
            <label class="span2">{{'_Country_of_publication_' | i18n}}</label>
            <div class="span5" ng-controller="TypeheadCtrl">
              <input type="text" ng-model="product.publishingDetail.countryOfPublication" typeahead="country for country in countryList | filter:$viewValue | limitTo:8" typehead-editable='false' class="input-medium" required/>
            </div>
          </div>

          <div class="row">
            <label class="span2">{{'_Publishing_status_' | i18n}}</label>
            <div class="span5">
              <select ng-model="product.publishingDetail.publishingStatus" ng-options="key as value for (key, value) in publishingStatusList" required />
                <option value="">{{'_Select_publishing_status_' | i18n}}</option>
              </select>
            </div>
          </div>

          <div class="row">
            <label class="span2">{{'_Publishing_date_' | i18n}}</label>
            <div class="span5">
              <select ng-model="product.publishingDetail.publishingDate.publishingDateRole" ng-options="key as value for (key, value) in publishingDateRoleList" required/>
                <option value="">{{'_...status_' | i18n}}</option>
              </select>

              <div ng-controller="DatepickerCtrl">
                <div class="form-horizontal">
                    <input type="text" id="date-picker" class="input-small" datepicker-popup="yyyyMMdd"
                     ng-model="product.publishingDetail.publishingDate.date" is-open="opened" min="minDate" max="'2015-06-22'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" ng-required="true" />
                    <button class="btn btn-small btn-inverse" ng-click="today()">{{'_Today_' | i18n}}</button>
                    <button class="btn btn-small btn-danger" ng-click="clear()">{{'_Clear_' | i18n}}</button>
                </div>
              </div>
            </div>
          </div>

          <h4>{{'_Product_supply_' | i18n}}</h4>

          <div class="row">
            <label class="span2">{{'_Supplier_' | i18n}}</label>
            <div class="span5">
              <select id="supplier-role" ng-model="product.productSupply.supplyDetail.supplier.supplierRole" ng-options="key as value for (key, value) in supplierRoleList" required>
                <option value="">{{'_Select_supplier_role_' | i18n}}</option>
              </select>
              <input type="text" ng-model="product.productSupply.supplyDetail.supplier.supplierName" placeholder="{{'_Name_' | i18n}}" required/>
            </div>
          </div>

          <div class="row">
            <label class="span2">{{'_Product_availability_' | i18n}}</label>
            <div class="span5" ng-controller="TypeheadCtrl">
              <input type="text" ng-model="product.productSupply.supplyDetail.productAvailability" typeahead="availability for availability in productAvailabilityList | filter:$viewValue | limitTo:8" typehead-editable='false' required/>
              <span>[ {{ product.productSupply.supplyDetail.productAvailability }}]</span>
            </div>
          </div>

          <div class="row">
            <label class="span2">{{'_Unpriced_item_type_' | i18n}}</label>
            <div class="span5">
              <select ng-model="product.productSupply.supplyDetail.unpricedItemType" ng-options="key as value for (key, value) in unpricedCodeList">
                <option value="">{{'_Select_unpriced_item_type_' | i18n}}</option>
              </select>
            </div>
          </div>

          <div class="row">
            <label class="span2">{{'_Price_type_' | i18n}}</label>
            <div class="span5" ng-controller="TypeheadCtrl">
              <input type="text" ng-model="product.productSupply.supplyDetail.price.priceType" typeahead="typ for typ in priceTypes | filter:$viewValue | limitTo:8" typehead-editable='false' required/>
              <span>[{{ product.productSupply.supplyDetail.price.priceType }}]</span>
            </div>
          </div>

          <div class="row">
            <label class="span2">{{'_Price_amount_' | i18n}}</label>
            <div class="span5">
              <input type="text" name="priceAmount" class="input-small"
               ng-pattern="/^(\d{1,5}\.+\d{0,3})$/" ng-model="product.productSupply.supplyDetail.price.priceAmount"
               maxlength="10" required/>
              <span ng-controller="TypeheadCtrl">
                <input type="text"  class="input-small" ng-model="product.productSupply.supplyDetail.price.currencyCode" typeahead="currency for currency in currencies | filter:$viewValue | limitTo:8" typehead-editable='false' placeholder="{{'_...currency_' | i18n}}" required/>
              </span>
                <small class="text-error" ng-show="productForm.priceAmount.$error.pattern">
                  {{'_Only_numbers_' | i18n}}
                </small>

            </div>
          </div>

          <div class="row">
            <label class="span2">{{'_Price_code_type_' | i18n}}</label>
            <div class="span5">
              <select type="text" ng-model="product.productSupply.supplyDetail.price.priceCoded.priceCodeType" required/>
                <option value="01">{{'_Proprietary_' | i18n}}</option>
                <option value="02">{{'_Finnish_price_code_' | i18n}}</option>
              </select>
              <input type="text" ng-model="product.productSupply.supplyDetail.price.priceCoded.priceCode" placeholder="{{'_Price_code_' | i18n}}" required/>
            </div>
          </div>

            [ <a href="" ng-click="removeProduct(product)">X</a> ]
          </div>

          <a href="" class="btn" ng-click="addProduct()">{{'_add_more_products_' | i18n}}</a>
          <br />

          <button ng-click="reset()" ng-disabled="isUnchanged(message)">{{'_Reset_' | i18n}}</button>
     	  <button ng-click="send()" ng-disabled="messageForm.$invalid">{{'_Send_' | i18n}}</button>
        </fieldset>
      </form>
    </div>
  </div>

  <div class="span4">
  	<h3>{{'_ONIX_msg_' | i18n}}</h3>
      <div ng-controller="AlertCtrl">
        <alert ng-repeat="alert in alerts" type="alert.type" close="closeAlert($index)"><span ng-bind-html-unsafe="alert.msg"></span></alert>
      </div>
  		<pre>form = {{ message | onixize }}</pre>
      <pre>form = {{ message | json }}</pre>
  </div>

</div>
  <?php
    } else { ?>
      <div ng-controller="ModalCtrl">
        <button class="btn" style="position: absolute; top: 8px; right: 10px" ng-click="logout()">{{'_Logout_' | i18n}}</button>
      </div>
      <div class="row">
        <alert class="alert-danger span5">{{'_Naughty!!!_' | i18n}}</alert>
      </div>
  <?php
    }
  } else { ?>
      <div ng-controller="ModalCtrl">
        <button class="btn" style="position: absolute; top: 8px; right: 10px" ng-click="open()">{{'_Login_' | i18n}}</button>
      </div>
      <div class="row">
        <div class="span5">
          <alert class="alert-info">{{'_Wanna_login_' | i18n}}</alert>
        </div>
      </div>
  <?php } ?>
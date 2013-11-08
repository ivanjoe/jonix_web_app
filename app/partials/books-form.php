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

          <!-- TODO: get todays -->
          <div class="row" ng-init="setupDates()">
          	<label for="date-picker" class="span2">{{'_Date_' | i18n}}</label>
          	<div class="span5">

  	          <div ng-controller="DatepickerCtrl">
      			    <div class="form-horizontal">
      			        <input type="text" id="date-picker" class="input-small" datepicker-popup="yyyyMMdd"
                      ng-model="times.sentDate" is-open="opened" min="minDate"
                      max="'2015-06-22'" datepicker-options="dateOptions"
                      date-disabled="disabled(date, mode)" ng-required="true"
                      ng-change="updateSentDateTime();"/>
      			        <button class="btn btn-small btn-inverse" ng-click="today()">{{'_Today_' | i18n}}</button>
      			        <button class="btn btn-small btn-danger" ng-click="clear()">{{'_Clear_' | i18n}}</button>
                    <code>{{message.header.sentDateTime }}</code>
      			    </div>
      			  </div>

              <div class="checkbox">
              	<label>
                  <input type="checkbox" ng-model="showTime" ng-init="showTime=false"
                    ng-change="updateSentDateTime()" />{{'_Select_time_' | i18n}}
                </label>
              </div>
            </div>
          </div>

          <div class="row" ng-show="showTime">
          	<label for="time" class="span2">{{'_Time_' | i18n}}</label>
          	<div class="span5">
              <div ng-controller="TimepickerCtrl" class="ng-scope">
              	<div ng-model="times.sentTime" ng-change="updateSentDateTime();"
                  class="well well-small" style="display:inline-block;">
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
  	      	  	<select id="notification-type" ng-model="product.notificationType"
                  ng-options="key as value for (key, value) in productNotificationTypeList"
                   required>
  	      	  	  <option value="">{{'_Select_notification_type_' | i18n}}</option>
  	      	  	</select>
                <code>{{product.notificationType}}</code>
  	      	  </div>
  	      	</div>

  	      	<div class="row">
  	      	  <label for="product-id-type" class="span2">{{'_Product_ID_type_' | i18n}}</label>
  	      	  <div class="span5">
  	      	  	<select id="product-id-type" ng-model="product.IdType"
                  ng-options="key as value for (key, value) in productIdTypeList" required
                  ng-change="changeProductForm(product.IdType)">
  	      	  	  <option value="">{{'_Select_ID_type_' | i18n}}</option>
  	      	  	</select>
                <code>{{product.IdType}}</code>
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
                <code>{{product.descriptiveDetail.composition}}</code>
  	      	  </div>
  	      	</div>

  	      	<div class="row">
  	      	  <label for="product-form" class="span2">{{'_Product_form_' | i18n}}</label>
  	      	  <div class="span5">
  	      	  	<select id="product-form" ng-model="product.descriptiveDetail.productForm" ng-options="key as value for (key, value) in productFormList" required>
  	      	  		<option value="">{{'_Select_product_form_' | i18n}}</option>
  	      	  	</select>
                <code>{{product.descriptiveDetail.productForm}}</code>
  	      	  </div>
  	      	</div>

            <!-- TODO: make it multiplicable -->
  	      	<div class="row">
  	      	  <label class="span2">{{'_Product_title_' | i18n}}</label>
  	      	  <div class="span5">
  	      	  	<select type="text" ng-model="product.descriptiveDetail.titleDetail.titleType" ng-options="key as value for (key, value) in productTitleTypeList" required/>
                  <option value="">{{'_...title_type_' | i18n}}</option>
                </select>
                <code>{{product.descriptiveDetail.titleDetail.titleType}}</code>
                <select type="text" ng-model="product.descriptiveDetail.titleDetail.titleElement.titleElementLevel" ng-options="key as value for (key,value) in productTitleElementLevelList" required/>
                  <option value="">{{'_...element_level_' | i18n}}</option>
                </select>
                <code>{{product.descriptiveDetail.titleDetail.titleElement.titleElementLevel}}</code>
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
                <span ng-controller="TypeaheadCtrl">
                  <input type="text" class="input-small" ng-model="language"
                    typeahead="lang.name for lang in productLanguageCodeList | filter:$viewValue | limitTo:8"
                    typeahead-editable='false' typeahead-on-select="showLanguageCode($item)" />
                </span>
                <code>{{product.descriptiveDetail.language.languageRole}}</code>
                <code ng-init="product.descriptiveDetail.language.languageCode=''">{{product.descriptiveDetail.language.languageCode}}</code>
                <span>[{{'_more..._' | i18n}}]</span>
              </div>
            </div>

            <!-- SUBJECTS -->
            <div class="row"
              ng-repeat="subject in product.descriptiveDetail.subjects"

              ng-controller="SubjectCtrl" ng-include="'partials/subjects.html'">
            </div>

            <h4>{{'_Publishing_details_' | i18n}}</h4>

            <div class="row">
              <label class="span2">{{'_Publisher_' | i18n}}</label>
              <div class="span5">
                <select ng-model="product.publishingDetail.publisher.publishingRole" ng-options="key as value for (key, value) in publishingRoleList" class="input-medium" required/>
                  <option value="">{{'_...publishers_role_' | i18n}}</option>
                </select>
                <input type="text" ng-model="product.publishingDetail.publisher.publishingName" placeholder="{{'_Name_' | i18n}}" required/>
                <code>{{ product.publishingDetail.publisher.publishingRole }}</code>
              </div>
            </div>

            <div class="row">
              <label class="span2">{{'_Country_of_publication_' | i18n}}</label>
              <div class="span5" ng-controller="TypeaheadCtrl">
                <input type="text" ng-model="country"
                    typeahead="country.name for country in countryList | filter:$viewValue | limitTo:8"
                    typeahead-editable='false' class="input-medium" typeahead-on-select="showCountryCode($item)" required/>
                <code ng-init="product.publishingDetail.countryOfPublication=''">{{ product.publishingDetail.countryOfPublication }}</code>
              </div>
            </div>

            <div class="row">
              <label class="span2">{{'_Publishing_status_' | i18n}}</label>
              <div class="span5">
                <select ng-model="product.publishingDetail.publishingStatus" ng-options="key as value for (key, value) in publishingStatusList" required />
                  <option value="">{{'_Select_publishing_status_' | i18n}}</option>
                </select>
                <code>{{ product.publishingDetail.publishingStatus }}</code>
              </div>

            </div>

            <div class="row">
              <label class="span2">{{'_Publishing_date_' | i18n}}</label>
              <div class="span5">
                <select ng-model="product.publishingDetail.publishingDate.publishingDateRole" ng-options="key as value for (key, value) in publishingDateRoleList" required/>
                  <option value="">{{'_...status_' | i18n}}</option>
                </select>
                <code>{{ product.publishingDetail.publishingDate.publishingDateRole }}</code>

                <div ng-controller="DatepickerCtrl">
                  <div class="form-horizontal">
                      <input type="text" id="date-picker" class="input-small" datepicker-popup="yyyyMMdd"
                       ng-model="product.publishingDetail.publishingDate.date" is-open="opened" min="minDate" max="'2015-06-22'"
                       datepicker-options="dateOptions" date-disabled="disabled(date, mode)" ng-required="true" />
                      <button class="btn btn-small btn-danger" ng-click="clear2()">{{'_Clear_' | i18n}}</button>
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
                <code>{{product.productSupply.supplyDetail.supplier.supplierRole}}</code>
                <input type="text" ng-model="product.productSupply.supplyDetail.supplier.supplierName" placeholder="{{'_Name_' | i18n}}" required/>
              </div>
            </div>

            <div class="row">
              <label class="span2">{{'_Product_availability_' | i18n}}</label>
              <div class="span5" ng-controller="TypeaheadCtrl">
                <input type="text" ng-model="productAvailability"
                    typeahead="availability.name for availability in productAvailabilityList | filter:$viewValue | limitTo:8"
                    typeahead-editable='false' typeahead-on-select="showAvailabilityCode($item)" required/>
                <code ng-init="product.productSupply.supplyDetail.productAvailability=''">
                  {{ product.productSupply.supplyDetail.productAvailability }}
                </code>
              </div>
            </div>

            <div class="row">
              <label class="span2"></label>
              <div class="span5" ng-init="priced=0">
                <label class="radio inline"><input type="radio" ng-model="priced" value=1
                  ng-change="product.productSupply.supplyDetail.unpricedItemType=null" />{{'_Priced_' | i18n}}
                </label >
                <label class="radio inline"><input type="radio" ng-model="priced" value=0
                  ng-change="product.productSupply.supplyDetail.price={}" />{{'_Unpriced_' | i18n}}
                </label>
              </div>
            </div>

            <div class="row" ng-hide="priced">
              <label class="span2">{{'_Unpriced_item_type_' | i18n}}</label>
              <div class="span5">
                <select ng-model="product.productSupply.supplyDetail.unpricedItemType" ng-options="key as value for (key, value) in unpricedCodeList">
                  <option value="">{{'_Select_unpriced_item_type_' | i18n}}</option>
                </select>
                <code>{{product.productSupply.supplyDetail.unpricedItemType}}</code>
              </div>
            </div>

            <div class="row" ng-show="priced">
              <label class="span2">{{'_Price_type_' | i18n}}</label>
              <div class="span5" ng-controller="TypeaheadCtrl">
                <input type="text" ng-model="priceType"
                  typeahead="typ.name for typ in priceTypes | filter:$viewValue | limitTo:8"
                  typeahead-editable='false' required typeahead-on-select="showPriceTypeCode($item)" />
                <code ng-init="product.productSupply.supplyDetail.price.priceType=''">{{ product.productSupply.supplyDetail.price.priceType }}</code>
              </div>
            </div>

            <div class="row" ng-show="priced">
              <label class="span2">{{'_Price_amount_' | i18n}}</label>
              <div class="span5">
                <input type="text" name="priceAmount" class="input-small"
                 ng-pattern="/^(\d{1,5}(\.\d{0,3}){0,1})$/" ng-model="product.productSupply.supplyDetail.price.priceAmount"
                 maxlength="10" required/>
                <span ng-controller="TypeaheadCtrl">
                  <input type="text"  class="input-small" ng-model="currencyCode"
                    typeahead="curr.name for curr in currencies | filter:$viewValue | limitTo:8"
                    typeahead-editable='false' placeholder="{{'_...currency_' | i18n}}" required
                    typeahead-on-select="showCurrencyCode($item)"/>
                  <code ng-init="product.productSupply.supplyDetail.price.currencyCode=''">
                    {{ product.productSupply.supplyDetail.price.currencyCode }}
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
                <select type="text" ng-model="product.productSupply.supplyDetail.price.priceCoded.priceCodeType"
                  ng-init="product.productSupply.supplyDetail.price.priceCoded.priceCodeType='02'" required/>
                  <option value="01" selected="selected">{{'_Proprietary_' | i18n}}</option>
                  <option value="02">{{'_Finnish_price_code_' | i18n}}</option>
                </select>
                <input type="text"
                  ng-model="product.productSupply.supplyDetail.price.priceCoded.priceCode"
                  placeholder="{{'_Price_code_' | i18n}}" required/>
                <code>{{product.productSupply.supplyDetail.price.priceCoded.priceCodeType}}</code>
              </div>
            </div>

              [ <a href="" ng-click="removeProduct(product)">X</a> ]
            </div>

            <a href="" class="btn" ng-click="addProduct()">{{'_add_more_products_' | i18n}}</a>
            <br />

            <button ng-click="reset()" ng-disabled="isUnchanged(mgsessage)">{{'_Reset_' | i18n}}</button>
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
          <alert class="alert-info" data-i18n="_Wanna_login_"></alert>
        </div>
      </div>
  <?php } ?>
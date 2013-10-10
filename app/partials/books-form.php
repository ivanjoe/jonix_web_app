<?php
session_start();
  if (isset($_SESSION['demo'])) {
    if($_SESSION['demo'] == md5(date("Ymd").'UserLoggedIn')) { ?>
      <div ng-controller="ModalCtrl">
        <button class="btn" style="position: absolute; top: 8px; right: 10px" ng-click="logout()">Logout</button>
      </div>

<div class="row" ng-controller="MessageCtrl">
  <div class="span8">
    <div class="well">
      <form name="messageForm">
        <fieldset>
          <legend>Header</legend>

          <div class="row">
          	<label for="identifier" class="span2">Identifier</label>
          	<div class="span5">
              <!-- <select ng-model="identifier-selection" ng-options="item for item in ['id','name']"></select> -->
          	  <label class="radio inline">
          	  	<input type="radio" ng-model="sender.identifier" value="id" />id
          	  </label>
          	  <label class="radio inline">
          	    <input type="radio" ng-model="sender.identifier" value="name" />name<br />
          	  </label>
            </div>
          </div>

          <!-- Show Sender name field if name radio button is chosen -->
          <div class="row" ng-show="sender.identifier == 'name'">
          <!-- <div ng-switch class="" on="identifier-selection"> -->
          <!-- <div class="row" ng-switch-when="name"> -->
          	<label for="sender-name" class="span2">Sender's name</label>
          	<div class="span5">
              <input type="text" ng-model="message.header.sender.senderName" class="form-control" name="sender-name" id="sender-name" placeholder="Sender's name">
            </div>
          </div>

          <!-- otherwise Id -->
          <div class="row" ng-show="sender.identifier == 'id'">
          <!-- <div class="row" ng-switch-when="id"> -->
          	<label for="sender-id-type" class="span2">Sender ID type</label>
            <div class="span5">
              <input type="text" ng-model="message.header.sender.idType" class="form-control" id="sender-id-type" placeholder="ID type">
            </div>
          </div>

          <div class="row" ng-show="sender.identifier == 'id'">
          <!-- <div class="row" ng-switch-when="id"> -->
          	<label for="sender-id-value" class="span2">Sender ID value</label>
            <div class="span5">
              <input type="text" ng-model="message.header.sender.idValue" class="form-control" id="sender-id-value" placeholder="ID value">
            </div>
          </div>
          <!-- </div> -->

          <!-- Id ends -->

          <hr />

          <div class="row">
          	<label for="date-picker" class="span2">Date</label>
          	<div class="span5">

  	          <div ng-controller="DatepickerCtrl">
      			    <div class="form-horizontal">
      			        <input type="text" id="date-picker" class="input-small" datepicker-popup="yyyyMMdd" ng-model="message.header.sentDateTime" is-open="opened" min="minDate" max="'2015-06-22'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" ng-required="true" />
      			        <button class="btn btn-small btn-inverse" ng-click="today()">Today</button>
      			        <button class="btn btn-small btn-danger" ng-click="clear()">Clear</button>
                    <code>{{(message.header.sentDateTime | date:'yyyyMMdd') + (message.header.sentTime | date:'HHmm') }}</code>
      			    </div>
      			  </div>

              <div class="checkbox">
              	<label><input type="checkbox" ng-model="showTime" ng-init="checked=true">Select time</label>
              </div>
            </div>
          </div>

          <div class="row" ng-show="showTime">
          	<label for="time" class="span2">Time</label>
          	<div class="span5">
              <div ng-controller="TimepickerCtrl" class="ng-scope">
              	<div ng-model="message.header.sentTime" ng-change="changed()" class="well well-small" style="display:inline-block;">
			    	      <timepicker hour-step="1" minute-step="1" show-meridian="false"></timepicker>
			  	      </div>
              </div>
          	</div>
          </div>

      	  <div ng-repeat="product in message.products">
      	  	<legend>Product</legend>

      	  	<div class="row">
	      	  <label for="record-reference" class="span2">Record reference</label>
	      	  <div class="span5">
	      	  	<input id="record-reference" type="text" ng-model="product.recordReference" required/>
	      	  </div>
	      	</div>

	      	<div class="row">
	      	  <label for="notification-type" class="span2">Notification type</label>
	      	  <div class="span5">
	      	  	<select id="notification-type" ng-model="product.notificationType" ng-options="key as value for (key, value) in productNotificationTypeList" required>
	      	  	  <option value="">Select Notification type</option>
	      	  	</select>
	      	  </div>
	      	</div>

	      	<div class="row">
	      	  <label for="product-id-type" class="span2">Product ID type</label>
	      	  <div class="span5">
	      	  	<select id="product-id-type" ng-model="product.IdType" ng-options="key as value for (key, value) in productIdTypeList" required>
	      	  	  <option value="">Select ID type</option>
	      	  	</select>
              <input id=="product-id-value" type="text" ng-model="product.idValue" required/>
	      	  </div>
	      	</div>

	      	<h4>Descriptive details</h4>

	      	<div class="row">
	      	  <label for="product-composition" class="span2">Product Composition</label>
	      	  <div class="span5">
	      	  	<select id="product-composition" ng-model="product.descriptiveDetail.composition" ng-options="key as value for (key, value) in productCompositionList" required>
                <option value="">Select Composition</option>
              </select>
	      	  </div>
	      	</div>

	      	<div class="row">
	      	  <label for="product-form" class="span2">Product Form</label>
	      	  <div class="span5">
	      	  	<select id="product-form" ng-model="product.descriptiveDetail.productForm" ng-options="key as value for (key, value) in productFormList" required>
	      	  		<option value="">Select Product Form</option>
	      	  	</select>
	      	  </div>
	      	</div>

          <!-- TODO: make it multiplicable -->
	      	<div class="row">
	      	  <label class="span2">Product Title</label>
	      	  <div class="span5">
	      	  	<select type="text" ng-model="product.descriptiveDetail.titleDetail.titleType" ng-options="key as value for (key, value) in productTitleTypeList" required/>
                <option value="">...title type</option>
              </select>
              <select type="text" ng-model="product.descriptiveDetail.titleDetail.titleElement.titleElementLevel" ng-options="key as value for (key,value) in productTitleElementLevelList" required/>
                <option value="">...element level</option>
              </select>
              <input type="text" ng-model="product.descriptiveDetail.titleDetail.titleElement.titleText" placeholder="title text" required/>
              <span>[more...]</span>
	      	  </div>

	      	</div>

          <div class="row">
            <label class="span2">Language Role</label>
            <div class="span5">
              <select ng-model="product.descriptiveDetail.language.languageRole" ng-options="key as value for (key, value) in productLanguageRoleList" required/>
                <option value="">...language role</option>
              </select>
              <span ng-controller="TypeheadCtrl">
                <input type="text" class="input-small" ng-model="product.descriptiveDetail.language.languageCode" typeahead="lang for lang in productLanguageCodeList | filter:$viewValue | limitTo:8" typeahead-editable='false'/>
              </span>
              <span>[more...]</span>
            </div>
          </div>

          <h4>Publishing details</h4>

          <div class="row">
            <label class="span2">Publisher</label>
            <div class="span5">
              <select ng-model="product.publishingDetail.publisher.publishingRole" ng-options="key as value for (key, value) in publishingRoleList" class="input-medium" required/>
                <option value="">...publisher's role</option>
              </select>
              <input type="text" ng-model="product.publishingDetail.publisher.publishinName" placeholder="Name" required/>
            </div>
          </div>

          <div class="row">
            <label class="span2">Country of Publication</label>
            <div class="span5" ng-controller="TypeheadCtrl">
              <input type="text" ng-model="product.publishingDetail.countryOfPublication" typeahead="country for country in countryList | filter:$viewValue | limitTo:8" typehead-editable='false' class="input-medium" required/>
            </div>
          </div>

          <div class="row">
            <label class="span2">Publishing Status</label>
            <div class="span5">
              <select ng-model="product.publishingDetail.publishingStatus" ng-options="key as value for (key, value) in publishingStatusList" required />
                <option value="">Select publishing status</option>
              </select>
            </div>
          </div>

          <div class="row">
            <label class="span2">Publishing Date</label>
            <div class="span5">
              <select ng-model="product.publishingDetail.publishingDate.publishingDateRole" ng-options="key as value for (key, value) in publishingDateRoleList" required/>
                <option value="">...status</option>
              </select>

              <div ng-controller="DatepickerCtrl">
                <div class="form-horizontal">
                    <input type="text" id="date-picker" class="input-small" datepicker-popup="yyyyMMdd" ng-model="product.publishingDetail.publishingDate.date" is-open="opened" min="minDate" max="'2015-06-22'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" ng-required="true" />
                    <button class="btn btn-small btn-inverse" ng-click="today()">Today</button>
                    <button class="btn btn-small btn-danger" ng-click="clear()">Clear</button>
                </div>
              </div>
            </div>
          </div>

          <h4>Product supply</h4>

          <div class="row">
            <label class="span2">Supplier</label>
            <div class="span5">
              <select id="supplier-role" ng-model="product.productSupply.supplyDetail.supplier.supplierRole" ng-options="key as value for (key, value) in supplierRoleList" required>
                <option value="">Select Supplier Role</option>
              </select>
              <input type="text" ng-model="product.productSupply.supplyDetail.supplier.supplierName" placeholder="Name" required/>
            </div>
          </div>

          <div class="row">
            <label class="span2">Product Availability</label>
            <div class="span5" ng-controller="TypeheadCtrl">
              <input type="text" ng-model="product.productSupply.supplyDetail.productAvailability" typeahead="availability for availability in productAvailabilityList | filter:$viewValue | limitTo:8" typehead-editable='false' required/>
              <span>[ {{ product.productSupply.supplyDetail.productAvailability }}]</span>
            </div>
          </div>

          <div class="row">
            <label class="span2">Unpriced Item Type</label>
            <div class="span5">
              <select ng-model="product.productSupply.supplyDetail.unpricedItemType" ng-options="key as value for (key, value) in unpricedCodeList">
                <option value="">...unpriced item type</option>
              </select>
            </div>
          </div>

          <div class="row">
            <label class="span2">Price Type</label>
            <div class="span5" ng-controller="TypeheadCtrl">
              <input type="text" ng-model="product.productSupply.supplyDetail.price.priceType" typeahead="typ for typ in priceTypes | filter:$viewValue | limitTo:8" typehead-editable='false' required/>
              <span>[{{ product.productSupply.supplyDetail.price.priceType }}]</span>
            </div>
          </div>

          <div class="row">
            <label class="span2">Price Amount</label>
            <div class="span5">
              <input type="text" class="input-small" ng-model="product.productSupply.supplyDetail.price.priceAmount" required/>
              <span ng-controller="TypeheadCtrl">
                <input type="text"  class="input-small" ng-model="product.productSupply.supplyDetail.price.currencyCode" typeahead="currency for currency in currencies | filter:$viewValue | limitTo:8" typehead-editable='false' placeholder="...currency..." required/>
              </span>
            </div>
          </div>

          <div class="row">
            <label class="span2">Price Code Type</label>
            <div class="span5">
              <select type="text" ng-model="product.productSupply.supplyDetail.price.priceCoded.priceCodeType" required/>
                <option value="01">Proprietary</option>
                <option value="02">Finnish Pocket Book price code</option>
              </select>
              <input type="text" ng-model="product.productSupply.supplyDetail.price.priceCoded.priceCode" placeholder="...price code..." required/>
            </div>
          </div>

            [ <a href="" ng-click="removeProduct(product)">X</a> ]
          </div>

          <a href="" class="btn" ng-click="addProduct()">add more products</a>
          <br />

          <button ng-click="reset()" ng-disabled="isUnchanged(message)">Reset</button>
     	  <button ng-click="send()" ng-disabled="messageForm.$invalid">Send</button>
        </fieldset>
      </form>
    </div>
  </div>

  <div class="span4">
  	<h3>ONIX Message</h3>
      <div ng-controller="AlertCtrl">
        <alert ng-repeat="alert in alerts" type="alert.type" close="closeAlert($index)"><span ng-bind-html-unsafe="alert.msg"></span></alert>
      </div>
  		<pre>form = {{ message | onixize }}</pre>
      <pre>form = {{ message | json }}</pre>
  </div>

</div>
  <?php
    } else { ?>
      <div class="row">
        <alert class="alert-danger span5">You are trying something!</alert>
      </div>
  <?php
    }
  } else { ?>
      <div ng-controller="ModalCtrl">
        <button class="btn" style="position: absolute; top: 8px; right: 10px" ng-click="open()">Login</button>
      </div>
      <div class="row">
        <div class="span5">
          <alert class="alert-info">If you want to send ONIX messages, please log in.</alert>
        </div>
      </div>
  <?php } ?>
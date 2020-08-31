/**
 * Square Feed Front-end Script.
 *
 * @package   GravityForms
 * @author    Rocketgenius
 * @copyright Copyright (c) 2019, Rocketgenius
 */

window.GFSquare = null;

(function ($) {

	GFSquare = function (args) {

		for (var prop in args) {
			if (args.hasOwnProperty( prop )) {
				this[prop] = args[prop];
			}
		}

		/**
		 * Form object.
		 */
		this.form = null;

		/**
		 * Square active feed.
		 */
		this.activeFeed = null;

		/**
		 * The Square Card Field object.
		 */
		this.GFSCField = null;

		/**
		 * The square payment form object.
		 */
		this.sqForm = null;

		/**
		 * Square card nonce.
		 */
		this.nonce = null;

		this.init = function () {

			var GFSquareObj = this, activeFeed = null, feedActivated = false;

			this.form = $( '#gform_' + this.formId );

			this.GFSCField = $( '#input_' + this.formId + '_' + this.ccFieldId + '_1' );

			// After feeds are evaluated, handle square feed if it exit and active.
			gform.addAction(
				'gform_frontend_feeds_evaluated',
				function (feeds, formId) {

					if (formId !== GFSquareObj.formId) {
						return;
					}

					activeFeed    = null;
					feedActivated = false;

					// Loop through the feeds and Check if square feed is active.
					var feedsCount = Object.keys( feeds ).length;
					for (var i = 0; i < feedsCount; i++) {
						if (feeds[i].addonSlug === 'gravityformssquare' && feeds[i].isActivated) {
							feedActivated = true;
							activeFeed    = GFSquareObj.feeds[ feeds[i].feedId ];
							// Add the active feed object to the square object as it will be needed later.
							GFSquareObj.activeFeed = activeFeed;

							// check if we are in the cc page, if som initiate the Square single element payment form.
							if ( GFSquareObj.isCreditCardOnPage() ) {
								// Reset status and errors.
								GFSquareObj.displaySquareCardError( '' );
								GFSquareObj.resetSquareStatus( this.form, this.formId );

								GFSquareObj.createPaymentForm( GFSquareObj.GFSCField, GFSquareObj.application_id, GFSquareObj.location_id );
							}

							break; // allow only one active feed.
						}
					}
					// If no active feeds found, display error next to Square Card Field.
					if ( ! feedActivated ) {
						// Show error.
						GFSquareObj.displaySquareCardError( gforms_square_frontend_strings.no_active_frontend_feed );
						// remove square fields and form status when Square feed deactivated.
						GFSquareObj.resetSquareStatus( GFSquareObj.form, formId );
						GFSquareObj.resetFormStatus( GFSquareObj.form, formId, GFSquareObj.isLastPage() );

						if ( GFSquareObj.sqForm !== null ) {
							GFSquareObj.sqForm.destroy();
						}

						GFSquareObj.activeFeed = null;
					}
				}
			);

			/* Use this for advanced SCA UI
			// If we have a nonce field loaded, use it so we don't have to generate a new one.
			//GFSquareObj.nonce = $( '#' + this.formId + '_square_nonce' ).length ? $( '#' + this.formId + '_square_nonce' ).val() : null;
			*/

			// bind Square functionality to submit event.
			$( '#gform_' + this.formId ).on(
				'submit',
				function (event) {

					// Get the field object.
					GFSquareObj.GFSCField = $( '#input_' + GFSquareObj.formId + '_' + GFSquareObj.ccFieldId + '_1' );

					// Decide if we should start square logic or not, like if we are in a multi-page form and current page is not the cc page
					// by checking if GFSCField is hidden or not in current page, we can continue to the next or previous page in a multi-page form.
					if ( ! feedActivated || $( this ).data( 'gfsquaresubmitting' ) || $( '#gform_save_' + GFSquareObj.formId ).val() == 1 || gformIsHidden( GFSquareObj.GFSCField ) || ! GFSquareObj.isCreditCardOnPage()) {
						return;
					} else {
						event.preventDefault();
						$( this ).data( 'gfsquaresubmitting', true );
						GFSquareObj.maybeAddSpinner();
					}

					GFSquareObj.form = $( this );

					if (activeFeed.paymentAmount === 'form_total') {
						// Set priority to 51 so it will be triggered after the coupons add-on.
						gform.addFilter(
							'gform_product_total',
							function (total, formId) {
								window['gform_square_amount_' + formId] = total;
								return total;
							},
							51
						);

						gformCalculateTotalPrice( GFSquareObj.formId );
					}

					GFSquareObj.updatePaymentAmount();

					// Skip square logic if clicking on the Previous button, not the right page or if total amount is 0.
					var sourcePage    = parseInt( $( '#gform_source_page_number_' + GFSquareObj.formId ).val(), 10 ),
					targetPage        = parseInt( $( '#gform_target_page_number_' + GFSquareObj.formId ).val(), 10 ),
					skipSqFormHandler = false;

					if ((sourcePage > targetPage && targetPage !== 0) || window['gform_square_amount_' + GFSquareObj.formId] === 0) {
						skipSqFormHandler = true;
					}

					if ((GFSquareObj.isLastPage() && ! GFSquareObj.isCreditCardOnPage()) || gformIsHidden( GFSquareObj.GFSCField ) || skipSqFormHandler) {
						$( this ).submit();
						return;
					}

					if (activeFeed.type === 'product') {
						// if we don't have a nonce, request card nonce from square, nonceReceived handle the response.
						if ( GFSquareObj.nonce === null ) {
							GFSquareObj.sqForm.requestCardNonce();
						} else {
							// If we already have a nonce, start SCA, if SCA Passes, form will be submitted.
							GFSquareObj.startSCA( GFSquareObj.nonce );
						}

					} else {
						// Later when subscriptions are supported this should be implemented.
					}

				}
			);

		};

		/**
		 * Creates a Square Single Element Payment Form
		 *
		 * @param field The field to be replaced with IFrame
		 * @param application_id Gravity Forms application id
		 * @param location_id the merchant's location id that will receive the payment
		 */
		this.createPaymentForm = function (field, application_id, location_id) {
			var GFSquareObj    = this;
			GFSquareObj.sqForm = null;
			// Initialize the payment form element.
			GFSquareObj.sqForm = new SqPaymentForm(
				{
					applicationId: application_id,
					locationId: location_id,

					// Initialize the credit card placeholder.
					card: {
						elementId: field.attr( 'id' ),
						inputStyle: GFSquareObj.cardStyle
					},
					// SqPaymentForm callback functions.
					callbacks: {

						/*
						 * callback function: cardNonceResponseReceived
						 * Triggered when: SqPaymentForm completes a card nonce request
						 */
						cardNonceResponseReceived: function (errors, nonce, cardData, billingContact, shippingContact) {
							GFSquareObj.nonceReceived( errors, nonce, cardData, billingContact, shippingContact )
						},
						/**
						 * Callback function: paymentFormLoaded.
						 * Triggered when: SqPaymentForm build is complete
						 */
						paymentFormLoaded: function () {

						},
						/*
						 * callback function: inputEventReceived
						 * Triggered when: visitors interact with SqPaymentForm iframe elements.
						 */
						inputEventReceived: function(inputEvent) {

							switch (inputEvent.eventType) {
								case 'focusClassAdded':
									GFSquareObj.GFSCField.addClass( 'SqPaymentForm--focus' );
									break;
								case 'focusClassRemoved':
									GFSquareObj.GFSCField.removeClass( 'SqPaymentForm--focus' );
									break;
								case 'errorClassAdded':
									GFSquareObj.GFSCField.addClass( 'SqPaymentForm--invalid' );
									break;
								case 'errorClassRemoved':
									GFSquareObj.GFSCField.removeClass( 'SqPaymentForm--invalid' );
									break;
								case 'cardBrandChanged':
									/* HANDLE AS DESIRED */
									break;
								case 'postalCodeChanged':
									/* HANDLE AS DESIRED */
									break;
							}
						},
					}
				}
			);

			// Build the form.
			GFSquareObj.sqForm.build();
		};

		/**
		 * Fired when the nonce received from Square after calling getCardNonce
		 *
		 * @since 1.0.0
		 *
		 * @param errors
		 * @param nonce
		 * @param cardData
		 * @param billingContact
		 * @param shippingContact
		 *
		 * @return boolean
		 */
		this.nonceReceived = function (errors, nonce, cardData, billingContact, shippingContact) {
			var form        = this.form,
				GFSquareObj = this;
			// Display any errors if any.
			if (errors) {
				var error_html = "";
				for (var i = 0; i < errors.length; i++) {
					error_html += "<li> " + GFSquareObj.getLocalizedErrorMessage( errors[i] ) + " </li>";
				}
				GFSquareObj.displaySquareCardError( error_html );
				GFSquareObj.resetSquareStatus( form, this.formId );
				GFSquareObj.resetFormStatus( form, this.formId, this.isLastPage() );
				return false;
			} else {
				GFSquareObj.GFSCField.next( '.validation_message' ).html( '' );
			}

			// Add card data to hidden inputs so they can be saved with the entry.
			form.append( $( '<input type="hidden" name="square_credit_card_last_four" id="' + this.formId + '_square_credit_card_last_four" />' ).val( cardData.last_4 ) );
			form.append( $( '<input type="hidden" name="square_credit_card_type" id="' + this.formId + '_square_credit_card_type"/>' ).val( cardData.card_brand ) );

			// If we are testing, force SCA.
			GFSquareObj.nonce = GFSquareObj.forceSCA ? 'cnon:card-nonce-requires-verification' : nonce;
			form.append( $( '<input type="hidden" name="square_nonce" id="' + this.formId + '_square_nonce" />' ).val( GFSquareObj.nonce ) );
			// If we already have a nonce, start SCA, if SCA Passes, form will be submitted.
			GFSquareObj.startSCA( GFSquareObj.nonce );
		};

		/**
		 * Starts SCA process.
		 *
		 * @since 1.0.0
		 *
		 * @return boolean
		 */
		this.startSCA = function( nonce ){
			var form        = this.form,
				activeFeed	= this.activeFeed,
				GFSquareObj = this;
			// Get the cardholder first and last name to start SCA.
			var full_name = $( '#input_' + GFSquareObj.formId + '_' + GFSquareObj.ccFieldId + '_3' ).val();
			var names     = full_name.trim().split( ' ' );
			// If we don't have a name show error and stop execution.
			if (names.length < 2) {
				GFSquareObj.displaySquareCardError( gforms_square_frontend_strings.requires_name, true );
				GFSquareObj.resetFormStatus( $( this ), GFSquareObj.formId, GFSquareObj.isLastPage() );
				return false;
			}

			var first_name = names[0];
			var last_name  = names[1];

			// Prepare any given billing information to be provided along with the names for SCA.
			var email        = GFMergeTag.replaceMergeTags( GFSquareObj.formId, GFSquareObj.getBillingAddressMergeTag( activeFeed.email ) );
			var city         = GFMergeTag.replaceMergeTags( GFSquareObj.formId, GFSquareObj.getBillingAddressMergeTag( activeFeed.address_city ) );
			var postalCode   = GFMergeTag.replaceMergeTags( GFSquareObj.formId, GFSquareObj.getBillingAddressMergeTag( activeFeed.address_zip ) );
			var addressLine1 = GFMergeTag.replaceMergeTags( GFSquareObj.formId, GFSquareObj.getBillingAddressMergeTag( activeFeed.address_line1 ) );

			// Collect rest of verification data if we have minimum required details.
			if (first_name !== '' && last_name !== '') {
				var verificationDetails = {
					intent: 'CHARGE',
					amount: window['gform_square_amount_' + GFSquareObj.formId].toString(),
					currencyCode: GFSquareObj.currency,
					billingContact: {
						givenName: first_name,
						familyName: last_name,
						email: email,
						city: city,
						postalCode: postalCode,
						addressLines: [addressLine1]
					}
				};
				// Start SCA.
				GFSquareObj.sqForm.verifyBuyer(
					nonce,
					verificationDetails,
					function (err, result) {
						// Display errors if any ( When challenge is not passed an error is generated ).
						if (err) {
							GFSquareObj.displaySquareCardError( gforms_square_frontend_strings.sca );
							GFSquareObj.resetFormStatus( form, GFSquareObj.formId, GFSquareObj.isLastPage() );
							return false;
						} else { // If challenge passed, finally submit the form.
							GFSquareObj.GFSCField.next( '.validation_message' ).html( '' );
							// Append verification token.
							form.append( $( '<input type="hidden" name="square_verification" id="' + GFSquareObj.formId + '_square_verification" />' ).val( result.token ) );
							// Finally submit form.
							form.submit();
						}
					}
				);
			} else {
				// We don't have enough data to start SCA
				// This part should be implemented later when hiding cardholder name field becomes an option.
				return false;
			}
		},

		this.getLocalizedErrorMessage = function ( error ) {
			var key = '';
			if ( error.type === 'VALIDATION_ERROR' ) {
				key = error.field;
			} else {
				key = error.type
			}
			if ( key in gforms_square_frontend_strings ) {
				return gforms_square_frontend_strings[ key ];
			} else {
				return error.message;
			}
		};
		/**
		 * Gets field values.
		 *
		 * @param field
		 * @returns {string}
		 */
		this.getBillingAddressMergeTag = function (field) {
			if (field === '') {
				return '';
			} else {
				return '{:' + field + ':value}';
			}
		};

		/**
		 * Checks if we are on last page.
		 *
		 * @returns {boolean}
		 */
		this.isLastPage = function () {

			var targetPageInput = $( '#gform_target_page_number_' + this.formId );
			if (targetPageInput.length > 0) {
				return targetPageInput.val() == 0;
			}

			return true;
		};

		/**
		 * Checks if current page has the Square credit card field on it.
		 *
		 * @returns {boolean}
		 */
		this.isCreditCardOnPage = function () {

			var currentPage = this.getCurrentPageNumber();

			// if current page is false or no credit card page number, assume this is not a multi-page form.
			if ( ! this.ccPage || ! currentPage) {
				return true;
			}

			return this.ccPage == currentPage;
		};

		/**
		 * Gets current page number.
		 *
		 * @returns {*}
		 */
		this.getCurrentPageNumber = function () {
			var currentPageInput = $( '#gform_source_page_number_' + this.formId );
			return currentPageInput.length > 0 ? currentPageInput.val() : false;
		};

		/**
		 * Checks if a spinner should be added next to the submit button and adds one if needed.
		 */
		this.maybeAddSpinner = function () {
			if (this.isAjax) {
				return;
			}

			if (typeof gformAddSpinner === 'function') {
				gformAddSpinner( this.formId );
			} else {
				// Can be removed after min Gravity Forms version passes 2.1.3.2.
				var formId = this.formId;

				if (jQuery( '#gform_ajax_spinner_' + formId ).length == 0) {
					var spinnerUrl     = gform.applyFilters( 'gform_spinner_url', gf_global.spinnerUrl, formId ),
						$spinnerTarget = gform.applyFilters( 'gform_spinner_target_elem', jQuery( '#gform_submit_button_' + formId + ', #gform_wrapper_' + formId + ' .gform_next_button, #gform_send_resume_link_button_' + formId ), formId );
					$spinnerTarget.after( '<img id="gform_ajax_spinner_' + formId + '"  class="gform_ajax_spinner" src="' + spinnerUrl + '" alt="" />' );
				}
			}

		};

		/**
		 * Removes Square Card hidden inputs
		 *
		 * @param form form object
		 * @param formId
		 */
		this.resetSquareStatus = function (form, formId) {
			// Remove appended inputs.
			$( '#' + formId + '_square_nonce, #' + formId + '_square_credit_card_last_four, #' + formId + '_square_credit_card_type, #' + formId + '_square_verification' ).remove();
		};

		/**
		 * Resets form status when errors are received after trying to submit.
		 *
		 * @param form form object
		 * @param formId
		 * @param isLastPage
		 */
		this.resetFormStatus = function (form, formId, isLastPage) {
			// Reset form status.
			form.data( 'gfsquaresubmitting', false );
			// Remove spinner.
			$( '#gform_ajax_spinner_' + formId ).remove();
			// must do this or the form cannot be submitted again.
			if (isLastPage) {
				window["gf_submitting_" + formId] = false;
			}
		}

		/**
		 * Displays an error next to the Square Card Field.
		 *
		 * @param error
		 */
		this.displaySquareCardError = function (error, cardholder_field) {
			// Check if it is the card details or cardholder name field.
			var field = null;
			if ( cardholder_field ) {
				field = $( '#input_' + this.formId + '_' + this.ccFieldId + '_3' );
			} else {
				field = $( '#input_' + this.formId + '_' + this.ccFieldId + '_1' )
			}
			// Add the error container if it doesn't exist.
			if ( ! field.next( '.validation_message' ).length) {
				field.after( '<div class="gfield_description validation_message"></div>' );
			}

			var cardErrors = field.next( '.validation_message' );

			if (error) {
				cardErrors.html( error );
				// Hide spinner.
				if ($( '#gform_ajax_spinner_' + this.formId ).length > 0) {
					$( '#gform_ajax_spinner_' + this.formId ).remove();
				}
			} else {
				cardErrors.html( '' );
			}
		};

		/**
		 * Calculates the form total if needed.
		 */
		this.updatePaymentAmount = function () {
			var formId = this.formId, activeFeed = this.activeFeed;

			if (activeFeed.paymentAmount !== 'form_total') {
				var price = GFMergeTag.getMergeTagValue( formId, activeFeed.paymentAmount, ':price' ),
					qty   = GFMergeTag.getMergeTagValue( formId, activeFeed.paymentAmount, ':qty' );

				if (typeof price === 'string') {
					price = GFMergeTag.getMergeTagValue( formId, activeFeed.paymentAmount + '.2', ':price' );
					qty   = GFMergeTag.getMergeTagValue( formId, activeFeed.paymentAmount + '.3', ':qty' );
				}

				window['gform_square_amount_' + formId] = price * qty;
			}

		};

		// Fire it up !
		this.init();

	}

})( jQuery );

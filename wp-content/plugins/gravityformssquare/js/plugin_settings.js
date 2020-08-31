/**
 * Square Settings Script.
 *
 * @package   GravityForms
 * @author    Rocketgenius
 * @copyright Copyright (c) 2019, Rocketgenius
 */

window.GFSquareSettings = null;

(function ($) {
	GFSquareSettings = function () {
		var self = this;

		this.init = function () {
			this.pageURL = gform_square_pluginsettings_strings.settings_url;

			this.deauthActionable = false;

			this.setUpdateButtonDisplay();

			this.bindDeauthorize();

			this.bindCustomAppLinks();

			this.bindModeChange();

		};

		this.bindDeauthorize = function () {
			// De-Authorize Square .
			$( '.deauth_button' ).on(
				'click',
				function (e) {
					e.preventDefault();

					// Get button.
					var deauthButton  = $( '#gform_square_deauth_button' ),
					deauthScope       = $( '#deauth_scope' ),
					disconnectMessage = gform_square_pluginsettings_strings.disconnect;

					if ( ! self.deauthActionable) {
						$( '.deauth_button' ).eq( 0 ).hide();

						deauthScope.show(
							'slow',
							function () {
								self.deauthActionable = true;
							}
						);
					} else {
						var deauthScopeVal = $( '#deauth_scope0' ).is( ':checked' ) ? 'site' : 'account';
						// Confirm deletion.
						if ( ! confirm( disconnectMessage[deauthScopeVal] )) {
							return false;
						}

						// Set disabled state.
						deauthButton.attr( 'disabled', 'disabled' );

						// De-Authorize.
						$.ajax(
							{
								async: false,
								url: ajaxurl,
								dataType: 'json',
								method: 'POST',
								data: {
									action: 'gfsquare_deauthorize',
									scope: deauthScopeVal,
									nonce: gform_square_pluginsettings_strings.deauth_nonce
								},
								success: function (response) {
									if (response.success) {
										window.location.href = self.pageURL;
									} else {
										alert( response.data.message );
									}

									deauthButton.removeAttr( 'disabled' );
								}
							}
						).fail(
							function (jqXHR, textStatus, error) {
								alert( error );
								deauthButton.removeAttr( 'disabled' );
							}
						);
					}

				}
			);
		};

		this.setUpdateButtonDisplay = function () {
			if ( ! $( '.deauth_button' ).length && $( 'input#custom_app_' + gform_square_pluginsettings_strings.mode  ).val() != '1' ) {
				$( '#tab_gravityformssquare table tr:last-child' ).css( 'display', 'none' );
			}
		};

		this.bindCustomAppLinks = function() {

			$( '#gform_square_enable_custom_app' ).on(
				'click',
				function( e ) {

					// Prevent default event.
					e.preventDefault();

					// Set custom app value.
					$( 'input#custom_app_' + gform_square_pluginsettings_strings.mode ).val( '1' );

					// Submit form.
					$( '#gform-settings-save' ).trigger( 'click' );

				}
			);

			$( '#gform_square_disable_custom_app' ).on(
				'click',
				function( e ) {

					// Prevent default event.
					e.preventDefault();

					// Set custom app value.
					$( 'input#custom_app_' + gform_square_pluginsettings_strings.mode ).val( '' );

					// Submit form.
					$( '#gform-settings-save' ).trigger( 'click' );

				}
			)

		};

		this.bindModeChange = function(){
			$( '.square_mode' ).change(
				function() {
					$( '#gform-settings-save' ).trigger( 'click' );
				}
			);
		};

		this.init();
	};

	$( document ).ready( GFSquareSettings );
})( jQuery );

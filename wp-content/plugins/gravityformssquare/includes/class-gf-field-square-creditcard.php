<?php
/**
 * Gravity Forms Square Card Custom File.
 *
 * @package   GravityForms
 * @author    Rocketgenius
 * @copyright Copyright (c) 2019, Rocketgenius
 */

if ( ! class_exists( 'GFForms' ) ) {
	die();
}

/**
 * The Square Card field is a credit card field used specifically by the Square Add-On.
 *
 * @since 1.0.0
 *
 * Class GF_Field_Square_CreditCard
 */
class GF_Field_Square_CreditCard extends GF_Field {

	/**
	 * Field Type
	 *
	 * @since 1.0.0
	 * @var $type string Field type.
	 */
	public $type = 'square_creditcard';

	/**
	 * Returns the scripts to be included for this field type in the form editor.
	 *
	 * @since  1.0.0
	 *
	 * @return string
	 */
	public function get_form_editor_inline_script_on_page_render() {

		// Set Default values.
		$card_details_label = json_encode(
			gf_apply_filters(
				array(
					'gform_card_details',
					rgget( 'id' ),
				),
				esc_html__( 'Card Details', 'gravityformsquare' ),
				rgget( 'id' )
			)
		);
		$card_type_label    = json_encode(
			gf_apply_filters(
				array(
					'gform_card_type',
					rgget( 'id' ),
				),
				esc_html__( 'Card Type', 'gravityformsquare' ),
				rgget( 'id' )
			)
		);
		$cardholder_label   = json_encode(
			gf_apply_filters(
				array(
					'gform_card_name',
					rgget( 'id' ),
				),
				esc_html__( 'Cardholder Name', 'gravityformsquare' ),
				rgget( 'id' )
			)
		);

		$js = sprintf(
			"function SetDefaultValues_%s(field) {
		field.label = '%s';
		field.inputs = [new Input(field.id + '.1', %s), new Input(field.id + '.2', %s), new Input(field.id + '.3', %s )];
		}",
			$this->type,
			esc_html__( 'Credit Card', 'gravityformssquare' ),
			$card_details_label,
			$card_type_label,
			$cardholder_label
		);

		// Make sure only one Square card field is added to the form.
		$js .= "gform.addFilter('gform_form_editor_can_field_be_added', function(result, type) {
            if (type === 'square_creditcard') {
                if (GetFieldsByType(['square_creditcard']).length > 0) {" .
			   sprintf( 'alert(%s);', json_encode( esc_html__( 'Only one Square credit card field can be added to the form', 'gravityformssquare' ) ) )
			   . ' result = false;
				}
            }
            
            return result;
        });';

		// Remove placeholder option for card details.
		$js .= "jQuery(document).bind('gform_load_field_settings', function(event, field, form) {
					if (field['type']==='square_creditcard') {
						jQuery('.input_placeholders tr:eq(1)').remove();
					}
				});";

		return $js;
	}

	/**
	 * Get field settings in the form editor.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_form_editor_field_settings() {
		return array(
			'conditional_logic_field_setting',
			'error_message_setting',
			'label_setting',
			'label_placement_setting',
			'admin_label_setting',
			'rules_setting',
			'description_setting',
			'css_class_setting',
			'sub_labels_setting',
			'sub_label_placement_setting',
			'input_placeholders_setting',
		);
	}

	/**
	 * Get form editor button.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_form_editor_button() {
		return array(
			'group' => 'pricing_fields',
			'text'  => $this->get_form_editor_field_title(),
		);
	}

	/**
	 * Get field button title.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_form_editor_field_title() {
		return esc_attr__( 'Square', 'gravityformssquare' );
	}

	/**
	 * Returns the field's form editor description.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_form_editor_field_description() {
		return esc_attr__( 'Allows accepting credit card information to make payments via Square payment gateway.' );
	}

	/**
	 * Get entry inputs.
	 *
	 * @since 1.0.0
	 *
	 * @return array|null
	 */
	public function get_entry_inputs() {
		$inputs = array();
		if ( ! is_array( $this->inputs ) ) {
			return array();
		}
		foreach ( $this->inputs as $input ) {
			if ( in_array( $input['id'], array( $this->id . '.1', $this->id . '.2', $this->id . '.3' ), true ) ) {
				$inputs[] = $input;
			}
		}

		return $inputs;
	}

	/**
	 * Get the value in entry details.
	 *
	 * @since 1.0.0
	 *
	 * @param string|array $value The field value.
	 * @param string       $currency The entry currency code.
	 * @param bool|false   $use_text When processing choice based fields should the choice text be returned instead of
	 *       the value.
	 * @param string       $format The format requested for the location the merge is being used. Possible values: html, text
	 *           or url.
	 * @param string       $media The location where the value will be displayed. Possible values: screen or email.
	 *
	 * @return string
	 */
	public function get_value_entry_detail( $value, $currency = '', $use_text = false, $format = 'html', $media = 'screen' ) {

		if ( is_array( $value ) ) {
			$card_number     = trim( rgget( $this->id . '.1', $value ) );
			$card_type       = trim( rgget( $this->id . '.2', $value ) );
			$cardholder_name = trim( rgget( $this->id . '.3', $value ) );
			$separator       = $format === 'html' ? '<br/>' : "\n";

			$value = empty( $card_number ) ? '' : $card_type . $separator . $card_number . $separator . $cardholder_name;

			return $value;
		} else {
			return '';
		}
	}

	/**
	 * Used to determine the required validation result.
	 *
	 * @since 1.0.0
	 *
	 * @param int $form_id The ID of the form currently being processed.
	 *
	 * @return bool
	 */
	public function is_value_submission_empty( $form_id ) {
		// check only the cardholder name.
		$cardholder_name_input = GFFormsModel::get_input( $this, $this->id . '.3' );
		$hide_cardholder_name  = rgar( $cardholder_name_input, 'isHidden' );
		$cardholder_name       = sanitize_text_field( rgpost( 'input_' . $this->id . '_3' ) );

		if ( ! $hide_cardholder_name && empty( $cardholder_name ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Get submission value.
	 *
	 * @since 1.0.0
	 *
	 * @param array $field_values Field values.
	 * @param bool  $get_from_post_global_var True if get from global $_POST.
	 *
	 * @return array|string
	 */
	public function get_value_submission( $field_values, $get_from_post_global_var = true ) {

		if ( $get_from_post_global_var ) {
			$value[ $this->id . '.1' ] = $this->get_input_value_submission( 'input_' . $this->id . '_1', rgar( $this->inputs[0], 'name' ), $field_values, true );
			$value[ $this->id . '.2' ] = $this->get_input_value_submission( 'input_' . $this->id . '_2', rgar( $this->inputs[1], 'name' ), $field_values, true );
			$value[ $this->id . '.3' ] = $this->get_input_value_submission( 'input_' . $this->id . '_3', rgar( $this->inputs[2], 'name' ), $field_values, true );
		} else {
			$value = $this->get_input_value_submission( 'input_' . $this->id, $this->inputName, $field_values, $get_from_post_global_var );
		}

		return $value;
	}


	/**
	 * Get field input.
	 *
	 * @since 1.0.0
	 *
	 * @param array      $form The Form Object currently being processed.
	 * @param array      $value The field value. From default/dynamic population, $_POST, or a resumed incomplete submission.
	 * @param null|array $entry Null or the Entry Object currently being edited.
	 *
	 * @return string
	 */
	public function get_field_input( $form, $value = array(), $entry = null ) {
		// Decide where are we.
		$is_entry_detail = $this->is_entry_detail();
		$is_form_editor  = $this->is_form_editor();
		$is_admin        = $is_entry_detail || $is_form_editor;

		$form_id  = $form['id'];
		$id       = intval( $this->id );
		$field_id = $is_entry_detail || $is_form_editor || $form_id === 0 ? "input_$id" : 'input_' . $form_id . "_$id";

		$disabled_text = $is_form_editor ? "disabled='disabled'" : '';
		$class_suffix  = $is_entry_detail ? '_admin' : '';

		$form_sub_label_placement  = rgar( $form, 'subLabelPlacement' );
		$field_sub_label_placement = $this->subLabelPlacement;
		$is_sub_label_above        = $field_sub_label_placement === 'above' || ( empty( $field_sub_label_placement ) && $form_sub_label_placement === 'above' );
		$sub_label_class_attribute = $field_sub_label_placement === 'hidden_label' ? "class='hidden_sub_label screen-reader-text'" : '';

		$card_details_input     = GFFormsModel::get_input( $this, $this->id . '.1' );
		$card_details_sub_label = rgar( $card_details_input, 'customLabel' ) !== '' ? $card_details_input['customLabel'] : esc_html__( 'Card Details', 'gravityformssquare' );
		$card_details_sub_label = gf_apply_filters(
			array(
				'gform_card_details',
				$form_id,
				$this->id,
			),
			$card_details_sub_label,
			$form_id
		);

		$cardholder_name_input = GFFormsModel::get_input( $this, $this->id . '.3' );
		$cardholder_name_sub_label  = rgar( $cardholder_name_input, 'customLabel' ) !== '' ? $cardholder_name_input['customLabel'] : esc_html__( 'Cardholder Name', 'gravityformssquare' );
		$cardholder_name_sub_label  = gf_apply_filters(
			array(
				'gform_card_name',
				$form_id,
				$this->id,
			),
			$cardholder_name_sub_label,
			$form_id
		);
		$cardholder_name_placehoder = $this->get_input_placeholder_attribute( $cardholder_name_input );

		if ( $is_admin ) {
			// If we are in the form editor, display a placeholder field.
			$cc_input = '
				<style type="text/css">
					.cc-cardnumber { width:410px; padding:7px;}
					.cc-group { position: relative; }
					.cc-group:before {
					  content: ""; position: absolute; left: 10px; top: 0; bottom: 0; width: 20px; 
					  background: url("data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz4KPHN2ZyB3aWR0aD0iMjJweCIgaGVpZ2h0PSIxNHB4IiB2aWV3Qm94PSIwIDAgMjIgMTQiIHZlcnNpb249IjEuMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayI+CiAgICA8IS0tIEdlbmVyYXRvcjogU2tldGNoIDUyLjIgKDY3MTQ1KSAtIGh0dHA6Ly93d3cuYm9oZW1pYW5jb2RpbmcuY29tL3NrZXRjaCAtLT4KICAgIDx0aXRsZT5Hcm91cDwvdGl0bGU+CiAgICA8ZGVzYz5DcmVhdGVkIHdpdGggU2tldGNoLjwvZGVzYz4KICAgIDxnIGlkPSJQYWdlLTEiIHN0cm9rZT0ibm9uZSIgc3Ryb2tlLXdpZHRoPSIxIiBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPgogICAgICAgIDxnIGlkPSJHcm91cCI+CiAgICAgICAgICAgIDxyZWN0IGlkPSJSZWN0YW5nbGUiIGZpbGw9IiNEQ0RGRTYiIHg9IjAiIHk9IjAiIHdpZHRoPSIyMiIgaGVpZ2h0PSIxNCIgcng9IjIiPjwvcmVjdD4KICAgICAgICAgICAgPHJlY3QgaWQ9IlJlY3RhbmdsZSIgZmlsbD0iI0IyQjhDNiIgeD0iMyIgeT0iMTAiIHdpZHRoPSIzIiBoZWlnaHQ9IjEiPjwvcmVjdD4KICAgICAgICAgICAgPHJlY3QgaWQ9IlJlY3RhbmdsZS1Db3B5IiBmaWxsPSIjQjJCOEM2IiB4PSI3IiB5PSIxMCIgd2lkdGg9IjMiIGhlaWdodD0iMSI+PC9yZWN0PgogICAgICAgICAgICA8cmVjdCBpZD0iUmVjdGFuZ2xlLUNvcHktMiIgZmlsbD0iI0IyQjhDNiIgeD0iMTEiIHk9IjEwIiB3aWR0aD0iMyIgaGVpZ2h0PSIxIj48L3JlY3Q+CiAgICAgICAgICAgIDxyZWN0IGlkPSJSZWN0YW5nbGUtQ29weS0zIiBmaWxsPSIjQjJCOEM2IiB4PSIxNSIgeT0iMTAiIHdpZHRoPSIzIiBoZWlnaHQ9IjEiPjwvcmVjdD4KICAgICAgICAgICAgPHJlY3QgaWQ9IlJlY3RhbmdsZSIgZmlsbD0iI0ZGRkZGRiIgeD0iMyIgeT0iNCIgd2lkdGg9IjUiIGhlaWdodD0iMyI+PC9yZWN0PgogICAgICAgIDwvZz4KICAgIDwvZz4KPC9zdmc+") center / contain no-repeat;
					}
				</style>
				<div class="ginput_complex' . $class_suffix . ' ginput_container ginput_container_creditcard">
				';

			$details_label = '
							<label for="' . $field_id . '_1" id="' . $field_id . '_1_label" ' . $sub_label_class_attribute . '>' . $card_details_sub_label . '</label>	';

			$details_input = '
					<div class="cc-group">				
						<input id="' . $field_id . '_1"' . $disabled_text . ' type="text"
						placeholder="        Card Number                                                                MM/YY    CVC     ZIP" class="cc-cardnumber">
					</div>';

			$holder_name_label = '<label for="' . $field_id . '_3" id="' . $field_id . '_3_label" ' . $sub_label_class_attribute . '>' . $cardholder_name_sub_label . '</label>';
			$holder_name_input = '<input type="text" class="ginput_full " name="input_' . $id . '.3" id="' . $field_id . '_3" value="" style="padding:8px;" ' . $disabled_text . ' ' . $cardholder_name_placehoder . '>';

			// Decide where to show labels ( above or below input ).
			if ( $is_sub_label_above ) {
				$cc_input .= $details_label . $details_input . $holder_name_label . $holder_name_input;
			} else {
				$cc_input .= $details_input . $details_label . $holder_name_input . $holder_name_label;
			}

			$cc_input .= '</div>';

			return $cc_input;
		} else {
			// If in the frontend, display Square single element inputTarget div.

			// Make sure Square is connected before showing the field.
			$square_connected = gf_square()->square_api_ready();
			// Make sure there is a feed configured.
			$has_feed = gf_square()->has_feed( $form_id );

			// Display an error if square is not connected.
			if ( ! $square_connected ) {
				// Translators: 1.error div opening, 2. error div closing.
				$card_error = sprintf( esc_html__( '%1$sPlease check your Square settings.%2$s', 'gravityformssquare' ), '<div class="gfield_description validation_message">', '</div>' );
				return $card_error;
			} elseif ( ! $has_feed ) {
				// Translators: 1.error div opening, 2. error div closing.
				$card_error = sprintf( esc_html__( '%1$sPlease create a Square feed.%2$s', 'gravityformssquare' ), '<div class="gfield_description validation_message">', '</div>' );
				return $card_error;
			} else {
				// Generate field markup.
				$cardholder_name = '';
				if ( ! empty( $value ) ) {
					$cardholder_name = esc_attr( rgget( $this->id . '.3', $value ) );
				}

				$square_input = "<div id='{$field_id}_1' class='SqPaymentForm'></div>";

				$square_input_label = "<label for='{$field_id}_1' id='{$field_id}_1_label' {$sub_label_class_attribute}>" . $card_details_sub_label . '</label>';

				$holder_input = "<input type='text' name='input_{$id}.3' id='{$field_id}_3' value='{$cardholder_name}' {$cardholder_name_placehoder}>";
				$holder_label = "<label for='{$field_id}_3' id='{$field_id}_3_label' {$sub_label_class_attribute}>" . $cardholder_name_sub_label . '</label>';

				if ( $is_sub_label_above ) {
					$details_field    = $square_input_label . $square_input;
					$cardholder_field = $holder_label . $holder_input;
				} else {
					$details_field    = $square_input . $square_input_label;
					$cardholder_field = $holder_input . $holder_label;
				}
				$cc_input = sprintf(
					"
						<div class='ginput_complex{$class_suffix} ginput_container ginput_container_square_card' id='{$field_id}' >
							<div class='ginput_full' id='{$field_id}_1_container'>
							%s			
							</div>
							<div class='ginput_full' id='{$field_id}_3_container'>
							%s
							</div>
						</div>										
						",
					$details_field,
					$cardholder_field
				);

				return $cc_input;
			}
		}
	}

	/**
	 * Returns the field markup; including field label, description, validation, and the form editor admin buttons.
	 *
	 * The {FIELD} placeholder will be replaced in GFFormDisplay::get_field_content with the markup returned by
	 * GF_Field::get_field_input().
	 *
	 * @since 1.0.0
	 *
	 * @param string|array $value The field value. From default/dynamic population, $_POST, or a resumed incomplete
	 *     submission.
	 * @param bool         $force_frontend_label Should the frontend label be displayed in the admin even if an admin label is
	 *             configured.
	 * @param array        $form The Form Object currently being processed.
	 *
	 * @return string
	 */
	public function get_field_content( $value, $force_frontend_label, $form ) {
		$is_entry_detail = $this->is_entry_detail();
		$is_form_editor  = $this->is_form_editor();
		$is_admin        = $is_entry_detail || $is_form_editor;

		$field_content = parent::get_field_content( $value, $force_frontend_label, $form );

		if ( ! GFCommon::is_ssl() && ! $is_admin ) {
			$field_content = "<div class='gfield_creditcard_warning_message'><span>" . esc_html__( 'This page is unsecured. Do not enter a real credit card number! Use this field only for testing purposes. ', 'gravityformssquare' ) . '</span></div>' . $field_content;
		}

		return $field_content;
	}

	/**
	 * Get field label class.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_field_label_class() {
		return 'gfield_label gfield_label_before_complex';
	}

}

GF_Fields::register( new GF_Field_Square_CreditCard() );

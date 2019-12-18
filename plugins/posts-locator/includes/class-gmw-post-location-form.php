<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'GMW_Location_Form' ) ) {
	return;
}

/**
 * GMW_Posts_Location_Form Class extends GMW_Location_Form class
 *
 * Location form for Post types in "Edit post" page.
 *
 * @since 3.0
 *
 */
class GMW_Post_Location_Form extends GMW_Location_Form {

	/**
	 * Addon
	 *
	 * @var string
	 */
	public $slug = 'posts_locator';

	/**
	 * Object type
	 *
	 * @var string
	 */
	public $object_type = 'post';

	/**
	 * Run the form class
	 * @param array $attr [description]
	 */
	public function __construct( $attr = array() ) {

		parent::__construct( $attr );

		// add custom tab panels
		add_action( 'gmw_lf_content_end', array( $this, 'create_tabs_panels' ) );
	}

	/**
	 * Additional custom form tabs
	 *
	 * @return array
	 */
	public function form_tabs() {

		$tabs = parent::form_tabs();

		$tabs['contact']    = array(
			'label'    => __( 'Contact', 'geo-my-wp' ),
			'icon'     => 'gmw-icon-phone',
			'priority' => 20,
		);
		/*$tabs['days_hours'] = array(
			'label'    => __( 'Days & Hours', 'geo-my-wp' ),
			'icon'     => 'gmw-icon-clock',
			'priority' => 25,
		);*/

		$tabs['room_info'] = array(
			'label'    => __( 'Room Info', 'geo-my-wp' ),
			'icon'     => 'gmw-icon-clock',
			'priority' => 25,
		);

		// filter tabs
		$tabs = apply_filters( 'gmw_post_location_form_tabs', $tabs, $this );

		return $tabs;
	}

	/**
	 * Additional form fields
	 *
	 * @return array
	 */
	function form_fields() {

		// retreive parent fields
		$fields = parent::form_fields();

		// contact meta fields
		$fields['contact_info'] = array(
			'label'  => __( 'Contact Information', 'geo-my-wp' ),
			'fields' => array(
				'phone'   => array(
					'name'        => 'gmw_pt_phone',
					'label'       => __( 'Phone Number', 'geo-my-wp' ),
					'desc'        => '',
					'id'          => 'gmw-phone',
					'type'        => 'text',
					'default'     => '',
					'placeholder' => '',
					'attributes'  => '',
					'priority'    => 5,
					'meta_key'    => 'phone',
				),
				/*'fax'     => array(
					'name'        => 'gmw_pt_fax',
					'label'       => __( 'Fax Number', 'geo-my-wp' ),
					'desc'        => '',
					'id'          => 'gmw-fax',
					'type'        => 'text',
					'default'     => '',
					'placeholder' => '',
					'attributes'  => '',
					'priority'    => 10,
					'meta_key'    => 'fax',
				),*/
				'email'   => array(
					'name'        => 'gmw_pt_email',
					'label'       => __( 'Email Address', 'geo-my-wp' ),
					'desc'        => '',
					'id'          => 'gmw-email',
					'type'        => 'text',
					'default'     => '',
					'placeholder' => '',
					'attributes'  => '',
					'priority'    => 15,
					'meta_key'    => 'email',
				),
				/*'website' => array(
					'name'        => 'gmw_pt_website',
					'label'       => __( 'Website', 'geo-my-wp' ),
					'desc'        => 'Ex: www.website.com',
					'id'          => 'gmw-website',
					'type'        => 'text',
					'default'     => '',
					'placeholder' => '',
					'attributes'  => '',
					'priority'    => 20,
					'meta_key'    => 'website',
				),*/
			),
		);

		// days and hours
		$fields['days_hours'] = array(
			'label'  => __( 'Days & Hours', 'geo-my-wp' ),
			'fields' => array(
				'days_hours' => array(
					'name'        => 'gmw_pt_days_hours',
					'label'       => __( 'Days & Hours', 'geo-my-wp' ),
					'desc'        => '',
					'id'          => 'gmw-days-hours',
					'type'        => 'text',
					'default'     => '',
					'placeholder' => '',
					'attributes'  => '',
					'priority'    => 5,
				),
			),
		);

		// room_info
		$fields['room_info'] = array(
			'label'  => __( 'Room Info', 'geo-my-wp' ),
			'fields' => array(
				'room_info' => array(
					'name'        => 'gmw_pt_days_hours',
					'label'       => __( 'Room Info', 'geo-my-wp' ),
					'desc'        => '',
					'id'          => 'gmw-days-hours',
					'type'        => 'text',
					'default'     => '',
					'placeholder' => '',
					'attributes'  => '',
					'priority'    => 5,
				),
			),
		);

		$fields = apply_filters( 'gmw_post_location_form_fields', $fields, $this );

		return $fields;
	}

	/**
	 * Generate custom tabs panels
	 *
	 * @return void
	 */
	public function create_tabs_panels() {

		do_action( 'gmw_post_location_form_before_panels', $this );
		?>
		<!-- contact info tab -->
		<div id="contact-tab-panel" class="section-wrapper contact">

			<?php do_action( 'gmw_lf_pt_contact_section_start', $this ); ?>

			<?php $this->display_form_fields_group( 'contact_info' ); ?>

			<?php do_action( 'gmw_lf_pt_contact_section_end', $this ); ?>

		</div>

		<!-- contact info tab -->
		<div id="days_hours-tab-panel" class="section-wrapper days-hours">

			<?php do_action( 'gmw_lf_post_days_hours_section_start', $this ); ?>

			<h3><?php _e( 'Days & Hours', 'geo-my-wp' ); ?></h3>

			<?php
				//get the location's days_hours from database
				$days_hours = gmw_get_location_meta( $this->location_id, 'days_hours' );

			if ( empty( $days_hours ) ) {
				$days_hours = array();
			}
			?>
			<table class="form-table">
				<?php for ( $i = 0; $i <= 6; $i++ ) { ?>

					<tr>
						<th style="width:30px">
							<label for=""><?php _e( 'Days', 'geo-my-wp' ); ?></label>
						</th>
						<td style="width:150px">
							<input type="text" class="gmw-lf-field group_days_hours" name="gmw_location_form[location_meta][days_hours][<?php echo $i; ?>][days]" id="gmw-pt-days-<?php echo $i; ?>" value="<?php if ( ! empty( $days_hours[$i]['days'] ) ) echo esc_attr( $days_hours[$i]['days'] ); ?>" />
						</td>

						<th style="width:30px">
							<label for=""><?php _e( 'Hours', 'geo-my-wp' ); ?></label>
						</th>

						<td>
							<input type="text" class="gmw-pt-field group_days_hours" name="gmw_location_form[location_meta][days_hours][<?php echo $i; ?>][hours]" id="gmw-pt-hours-<?php echo $i; ?>" value="<?php if ( ! empty( $days_hours[$i]['hours'] ) ) echo esc_attr( $days_hours[$i]['hours'] ); ?>" />
						</td>
					</tr>

				<?php } ?>

			</table>

			<?php do_action( 'gmw_lf_post_days_hours_section_end', $this ); ?>

		</div>

		<!-- room info -->
		<div id="room_info-tab-panel" class="section-wrapper room-info">
			<?php do_action( 'gmw_lf_post_room_info_section_start', $this ); ?>
			<div style="display:flex; justify-content: space-between;">
				<span><h3><?php _e( 'Room info', 'geo-my-wp' ); ?></h3></span>
				<span><input type="button" onClick="addNewRoom();" value="<?php _e( 'Add new stair', 'geo-my-wp' ); ?>" /></span>
			</div>
			<?php
				//get the location's days_hours from database
				$rooms = $this->get_saved_rooms();
				$existedRoomCount  = $rooms !== null ? count($rooms) : 0;
			if (!$rooms) {
				$rooms = array();
				$existedRoomCount = 0;
			}
			?>
			<script>
				var maxRoom = <?php echo $existedRoomCount; ?>;
				function addNewRoom() {
					var eles = '<tr id="gmw-pt-room_info_button-'+(maxRoom+1)+'">'+
						'<td class="room_index" style="width:85px; text-align: center;">'+
							'<label for="">'+(maxRoom +1)+'</label>'+
						'</td>'+
						'<td>'+
							'<input type="text" class="gmw-lf-field group_days_hours" name="gmw_location_form[room_info]['+maxRoom+'][total]" id="gmw-pt-days-'+maxRoom+'" value="" />'+
						'</td>'+
			

						'<td>'+
							'<input type="text" class="gmw-pt-field group_days_hours" name="gmw_location_form[room_info]['+maxRoom+'][available]" id="gmw-pt-hours-'+maxRoom+'" value="" />'+
						'</td>'+

						'<td>'+
							'<input type="text" class="gmw-pt-field group_days_hours" name="gmw_location_form[room_info]['+maxRoom+'][price]" id="gmw-pt-hours-'+maxRoom+'" value="" />'+
						'</td>'+
						'<td>'+
							'<input type="button" value="remove" onClick="removeRoom('+(maxRoom+1)+')" />'+
						'</td>'+
					'</tr>';
					var roomInfoContainer = jQuery('#room_info');
					roomInfoContainer.append(eles);
					maxRoom += 1;
					updateIndex();
				}

				function removeRoom(index) {
					jQuery('#gmw-pt-room_info_button-'+index).remove();
					updateIndex();
				}

				function updateIndex() {
					var roomIndexColumns = jQuery('#room_info').find('.room_index');
					roomIndexColumns.each(function(index, item) {
						jQuery(item).text(index +1);
					});
				}
				
			</script>

			<table class="form-table" id="room_info">
				<tr>
					<th style="width:85px; text-align: center;"><?php _e( 'Stair number ', 'geo-my-wp' ); ?></th>
					<th style="width:150px; text-align: center;"><?php _e( 'Total rooms', 'geo-my-wp' ); ?></th>
					<th style="width:150px; text-align: center;"><?php _e( 'Available rooms', 'geo-my-wp' ); ?></th>
					<th style="width:150px; text-align: center;"><?php _e( 'Price', 'geo-my-wp' ); ?></th>
				</tr>
				<?php for ( $i = $existedRoomCount -1; $i >= 0; $i-- ) { ?>

					<tr id="gmw-pt-room_info_button-<?php echo $existedRoomCount - $i; ?>">
						<td class="room_index" style="width:85px; text-align: center;">
							<label for=""><?php echo ($existedRoomCount - $i); ?></label>
						</td>
						<td>
							<input type="text" class="gmw-lf-field group_days_hours" name="gmw_location_form[room_info][<?php echo $i; ?>][total]" id="gmw-pt-days-<?php echo $i; ?>" value="<?php if ( ! empty( $rooms[$i]->number_room ) ) echo esc_attr( $rooms[$i]->number_room ); ?>" />
						</td>
			

						<td>
							<input type="text" class="gmw-pt-field group_days_hours" name="gmw_location_form[room_info][<?php echo $i; ?>][available]" id="gmw-pt-hours-<?php echo $i; ?>" value="<?php if ( ! empty( $rooms[$i]->avalible_room ) ) echo esc_attr( $rooms[$i]->avalible_room); ?>" />
						</td>

						<td>
							<input type="text" class="gmw-pt-field group_days_hours" name="gmw_location_form[room_info][<?php echo $i; ?>][price]" id="gmw-pt-hours-<?php echo $i; ?>" value="<?php if ( ! empty( $rooms[$i]->price ) ) echo esc_attr( $rooms[$i]->price ); ?>" />
						</td>
						<td>
							<input type="button" value="remove" onClick="removeRoom(<?php echo $existedRoomCount - $i; ?>)" />
						</td>
					</tr>

				<?php } ?>
				

			</table>

			<?php do_action( 'gmw_lf_post_room_info_section_end', $this ); ?>

		</div>

		<?php
		do_action( 'gmw_post_location_form_after_panels', $this );
	}
}

<?php
// The widget class
class CMI_State extends WP_Widget {

	// Main constructor
	public function __construct() {
		parent::__construct(
		'corona_meter_india_state',
		__( 'Corona Meter States', 'corona-meter-india' ),
		array(
			'customize_selective_refresh' => true,
		)
	);
	}

	// The widget form (for the backend )
	public function form( $instance ) {	
		
	// Set widget defaults
	$defaults = array(
		'title'    => '',
		'select'   => '', 
		
	);
	
	// Parse current settings with defaults
	extract( wp_parse_args( ( array ) $instance, $defaults ) ); ?>

	<?php // Widget Title ?>
	<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title', 'corona-meter-india' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
	</p>
	
	<p>
		<label for="<?php echo $this->get_field_id( 'select' ); ?>"><?php _e( 'Select State', 'corona-meter-india' ); ?></label>
		<select name="<?php echo $this->get_field_name( 'select' ); ?>" id="<?php echo $this->get_field_id( 'select' ); ?>" class="widefat">
		<?php
		// Your options array
		$options = array(
			''        => __( 'Select a State', 'corona-meter-india' ),
			'Andhra Pradesh' => __( 'Andhra Pradesh', 'corona-meter-india' ),
			'Andaman and Nicobar' => __( 'Andaman Nicobar', 'corona-meter-india' ),
			'Arunachal Pradesh' => __( 'Arunachal Pradesh', 'corona-meter-india' ),
			'Assam' => __( 'Assam', 'corona-meter-india' ),
			'Bihar' => __( 'Bihar', 'corona-meter-india' ),
			'Chandigarh' => __( 'Chandigarh', 'corona-meter-india' ),
			'Chhattisgarh' => __( 'Chhattisgarh', 'corona-meter-india' ),
			'Dadra and Nagar Haveli and Daman and Diu' => __( 'Dadra and Nagar Haveli and Daman and Diu', 'corona-meter-india' ),
			'Delhi' => __( 'Delhi', 'corona-meter-india' ),
			'Goa' => __( 'Goa', 'corona-meter-india' ),
			'Gujarat' => __( 'Gujarat', 'corona-meter-india' ),
			'Haryana' => __( 'Haryana', 'corona-meter-india' ),
			'Himachal Pradesh' => __( 'Himachal Pradesh', 'corona-meter-india' ),
			'Jammu and Kashmir' => __( 'Jammu and Kashmir', 'corona-meter-india' ),
			'Jharkhand ' => __( 'Jharkhand ', 'corona-meter-india' ),
			'Karnataka' => __( 'Karnataka', 'corona-meter-india' ),
			'Kerala' => __( 'Kerala', 'corona-meter-india' ),
			'Ladakh' => __( 'Ladakh', 'corona-meter-india' ),
			'Lakshadweep' => __( 'Lakshadweep ', 'corona-meter-india' ),
			'Madhya Pradesh' => __( 'Madhya Pradesh', 'corona-meter-india' ),
			'Maharashtra' => __( 'Maharashtra', 'corona-meter-india' ),
			'Manipur' => __( 'Manipur', 'corona-meter-india' ),
			'Meghalaya' => __( 'Meghalaya', 'corona-meter-india' ),
			'Mizoram' => __( 'Mizoram', 'corona-meter-india' ),
			'Nagaland' => __( 'Nagaland', 'corona-meter-india' ),
			'Odisha' => __( 'Odisha', 'corona-meter-india' ),
			'Puducherry' => __( 'Puducherry', 'corona-meter-india' ),
			'Punjab' => __( 'Punjab', 'corona-meter-india' ),
			'Rajasthan' => __( 'Rajasthan', 'corona-meter-india' ),
			'Sikkim' => __( 'Sikkim', 'corona-meter-india' ),
			'Tamil Nadu' => __( 'Tamil Nadu', 'corona-meter-india' ),
			'Telengana' => __( 'Telengana', 'corona-meter-india' ),
			'Tripura' => __( 'Tripura', 'corona-meter-india' ),
			'Uttarakhand' => __( 'Uttarakhand', 'corona-meter-india' ),
			'Uttar Pradesh' => __( 'UttarPradesh', 'corona-meter-india' ),
			'West Bengal' => __( 'West Bengal', 'corona-meter-india' ),
					
		);

		// Loop through options and add each one to the select dropdown
		foreach ( $options as $key => $name ) {
			echo '<option value="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '" '. selected( $select, $key, false ) . '>'. $name . '</option>';

		} ?>
		</select>
	</p>
	
	
<?php

	}

	// Update widget settings
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
	$instance['title']    = isset( $new_instance['title'] ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
	
	$instance['select']   = isset( $new_instance['select'] ) ? wp_strip_all_tags( $new_instance['select'] ) : '';
	
	return $instance;
	}

	// Display the widget
	public function widget( $args, $instance ) {
		
	extract( $args );

	// Check the widget options
	$title    = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : '';
	$select   = isset( $instance['select'] ) ? $instance['select'] : '';

	// WordPress core before_widget hook (always include )
	echo $before_widget;
	
	//Using HTTP Api
	$responsea = wp_remote_get( 'https://covid-19india-api.herokuapp.com/v2.0/state_data');
	$responsea = json_decode( wp_remote_retrieve_body($responsea), true );
	?>
	 <div class="widget-text wp_widget_cmi_box">
		<?php			
		// Display widget title if defined
		if ( $select ) 
		{
			echo $before_title . $title . $after_title."<br />";
			
		if( is_wp_error( $responsea )) 
		{
			?>
			<div class="cmi_blk">
			<span class="cmi_title"><?php _e('Server Issue', 'corona-meter-india'); ?></span>
			<span class="cmi_count"><?php _e('Please Try Later', 'corona-meter-india'); ?></span>
			</div>
			<?php
					
			
		}//if error
		else
		{
			
			$responsea=$responsea[1]['state_data'];
			
			if($responsea)
			{
				foreach($responsea as $alldata)
			{
				if($alldata['state']==$select)
				{
					$state_state=$alldata['state'];
					$state_active=$alldata['active'];
					$state_activerate=$alldata['active_rate'];
					$state_confirmed=$alldata['confirmed'];
					$state_deathrate=$alldata['death_rate'];
					$state_deaths=$alldata['deaths'];
					$state_recovered=$alldata['recovered'];
					$state_recoveredrate=$alldata['recovered_rate'];
					
				}
			}
			?>
			<div class="cmi_blk">
			<span class="cmi_title"><?php _e('State', 'corona-meter-india'); ?></span>
			<span class="cmi_count"><?php echo $state_state; ?></span>
			</div>
						
			<div class="cmi_blk activecases">
			<span class="cmi_title"><?php _e('Active Cases', 'corona-meter-india'); ?></span>
			<span class="cmi_count"><?php echo $state_active; ?></span>
			</div>
			
			<div class="cmi_blk">
			<span class="cmi_title"><?php _e('Active Rate', 'corona-meter-india'); ?></span>
			<span class="cmi_count"><?php echo $state_activerate; ?></span>
			</div>
			
			<div class="cmi_blk confirmedcases">
			<span class="cmi_title"><?php _e('Confirmed Cases', 'corona-meter-india'); ?></span>
			<span class="cmi_count"><?php echo $state_confirmed; ?></span>
			</div>
			
			<div class="cmi_blk">
			<span class="cmi_title"><?php _e('Death Rate', 'corona-meter-india'); ?></span>
			<span class="cmi_count"><?php echo $state_deathrate; ?></span>
			</div>
			
			<div class="cmi_blk deathcases">
			<span class="cmi_title"><?php _e('Deaths', 'corona-meter-india'); ?></span>
			<span class="cmi_count"><?php echo $state_deaths; ?></span>
			</div>
			
			<div class="cmi_blk recoveredcases">
			<span class="cmi_title"><?php _e('Recovered Cases', 'corona-meter-india'); ?></span>
			<span class="cmi_count"><?php echo $state_recovered; ?></span>
			</div>
			
			<div class="cmi_blk">
			<span class="cmi_title"><?php _e('Recovery Rate', 'corona-meter-india'); ?></span>
			<span class="cmi_count"><?php echo $state_recoveredrate; ?></span>
			</div>
			<?php
			}
			else
			{
				?>
			<div class="cmi_blk">
			<span class="cmi_title"><?php _e('Server Issue', 'corona-meter-india'); ?></span>
			<span class="cmi_count"><?php _e('Please Try Later', 'corona-meter-india'); ?></span>
			</div>
			<?php
			}
					 
		}//no error
		}//is select
	
		echo '</div>';

	// WordPress core after_widget hook (always include )
	echo $after_widget;
	}

}
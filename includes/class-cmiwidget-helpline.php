<?php
// The widget class
class CMI_Helpline extends WP_Widget {

	// Main constructor
	public function __construct() {
		parent::__construct(
		'corona_meter_india_helpline',
		__( 'Corona Meter Helpline', 'corona-meter-india' ),
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
		
		$options = array(
			''        => __( 'Select a State', 'corona-meter-india' ),
			'Andhra Pradesh' => __( 'Andhra Pradesh', 'corona-meter-india' ),
			'Arunachal Pradesh' => __( 'Arunachal Pradesh', 'corona-meter-india' ),
			'Assam' => __( 'Assam', 'corona-meter-india' ),
			'Bihar' => __( 'Bihar', 'corona-meter-india' ),
			'Chhattisgarh' => __( 'Chhattisgarh', 'corona-meter-india' ),
			'Goa' => __( 'Goa', 'corona-meter-india' ),
			'Gujarat' => __( 'Gujarat', 'corona-meter-india' ),
			'Haryana' => __( 'Haryana', 'corona-meter-india' ),
			'Himachal Pradesh' => __( 'Himachal Pradesh', 'corona-meter-india' ),
			'Jharkhand ' => __( 'Jharkhand ', 'corona-meter-india' ),
			'Karnataka' => __( 'Karnataka', 'corona-meter-india' ),
			'Kerala' => __( 'Kerala', 'corona-meter-india' ),
			'Madhya Pradesh' => __( 'Madhya Pradesh', 'corona-meter-india' ),
			'Maharashtra' => __( 'Maharashtra', 'corona-meter-india' ),
			'Manipur' => __( 'Manipur', 'corona-meter-india' ),
			'Meghalaya' => __( 'Meghalaya', 'corona-meter-india' ),
			'Mizoram' => __( 'Mizoram', 'corona-meter-india' ),
			'Nagaland' => __( 'Nagaland', 'corona-meter-india' ),
			'Odisha' => __( 'Odisha', 'corona-meter-india' ),
			'Punjab' => __( 'Punjab', 'corona-meter-india' ),
			'Rajasthan' => __( 'Rajasthan', 'corona-meter-india' ),
			'Sikkim' => __( 'Sikkim', 'corona-meter-india' ),
			'Tamil Nadu' => __( 'Tamil Nadu', 'corona-meter-india' ),
			'Telangana' => __( 'Telangana', 'corona-meter-india' ),
			'Tripura' => __( 'Tripura', 'corona-meter-india' ),
			'Uttarakhand' => __( 'Uttarakhand', 'corona-meter-india' ),
			'Uttar Pradesh' => __( 'Uttar Pradesh', 'corona-meter-india' ),
			'West Bengal' => __( 'West Bengal', 'corona-meter-india' ),
			'Andaman and Nicobar Islands' => __( 'Andaman and Nicobar Islands', 'corona-meter-india' ),
			'Chandigarh' => __( 'Chandigarh', 'corona-meter-india' ),
			'Dadra and Nagar Haveli and Daman & Diu' => __( 'Dadra and Nagar Haveli and Daman & Diu', 'corona-meter-india' ),
			'Delhi' => __( 'Delhi', 'corona-meter-india' ),
			'Jammu & Kashmir' => __( 'Jammu & Kashmir', 'corona-meter-india' ),
			'Ladakh' => __( 'Ladakh', 'corona-meter-india' ),
			'Lakshadweep' => __( 'Lakshadweep ', 'corona-meter-india' ),
			'Puducherry' => __( 'Puducherry', 'corona-meter-india' ),
						
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
	
	// This is where you run the code and display the output
			
		//Using HTTP Api
		$responsea = wp_remote_get( 'https://covid-19india-api.herokuapp.com/v2.0/helpline_numbers');
			   
   // Display the widget
   
   ?>	
   <div class="widget-text wp_widget_cmi_box">
		<?php			
		// Display widget title if defined
		if ( $select ) 
		{
			echo $before_title . $title . $after_title."<br />";
			
		if( is_wp_error( $responsea ) ) 
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
		$responsea = json_decode( wp_remote_retrieve_body($responsea), true );
		
		 $responsea=$responsea[1]['contact_details'];
							
			if($responsea)
			{
				foreach($responsea as $alldata)
			{
				
				if($alldata['state_or_UT']==$select)
				{
					$state_state=$alldata['state_or_UT'];
					$state_helpline=$alldata['helpline_number'];
				}
			}
			
			?>
			
			<div class="cmi_blk">
			<span class="cmi_title"><?php _e('State', 'corona-meter-india'); ?></span>
			<span class="cmi_count"><?php echo $state_state; ?></span>
			</div>
						
			<div class="cmi_blk">
			<span class="cmi_title"><?php _e('Helpline Number', 'corona-meter-india'); ?></span>
			<span class="cmi_count"><a href="tel:<?php echo $state_helpline; ?>"><?php echo $state_helpline; ?></a></span>
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
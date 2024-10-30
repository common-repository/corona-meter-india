<?php
if(! class_exists('coronameterindia'))
{
	class Coronameterindia
	{
		function __construct()
		{
						
			//widget
			add_action( 'widgets_init', 'register_cmi_widget' );
			
			function register_cmi_widget()
		{
			register_widget( 'CMI_Country' );
			register_widget( 'CMI_State' );
			register_widget( 'CMI_Helpline' );
		}
							
			
		}//function construct
			
		
	}//class end
	
}
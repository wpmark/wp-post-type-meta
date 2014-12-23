<?php
/**
 * Function wpptm_manage_description()
 * Adds the content of the admin page to edit the description
 */
function wpptm_metainfo_content() {

	/* if we don't have a post type go no further */
	if ( empty( $_GET[ 'post_type' ] ) )
		return;

	/* get the post type object - we have one! */
	$post_type = get_post_type_object( $_GET[ 'post_type' ] );

	?>
	<div class="wrap">
		
		<h2><?php echo esc_html( $post_type->labels->name ); ?> Meta Information</h2>
	
		<?php if ( isset( $_GET[ 'updated' ] ) && $_GET[ 'updated' ] ) { ?>
	
			<div id="message" class="updated">
				<p>Meta Updated.</p>
			</div>
	
		<?php } ?>
	
		<form class="wpptm_form" method="POST" style="width: 95%; margin-top: 30px;">
			
			<?php
				
				/**
				 * build an array of wpptm options to output
				 * $hooked wpptm_add_description_setting - 10
				 */
				$wpptm_settings = apply_filters(
					'wpptm_settings',
					array(),
					$post_type
				);
				
				/* check we have settings to output */
				if( ! empty( $wpptm_settings ) ) {
					
					?>
	
					<table class="form-table">
						
						<?php
						
						/* loop through each setting */
						foreach( $wpptm_settings as $setting ) {
							
							/* get the setting post type */
							$setting_post_type = $setting[ 'post_types' ];
							
							/* check this setting should be shown on this post type */
							if( ! in_array( $post_type->name, $setting_post_type ) )
								continue;
							
							?>
					    	<tr class="wpptm-setting wpptm-setting-<?php echo esc_attr( $post_type->name . '_' . $setting[ 'id' ] ); ?>">
					    		<th>
						    		<label for="<?php echo esc_attr( $post_type->name . '_' . $setting[ 'id' ] ); ?>" style="font-weight: bold;"><?php echo esc_html( $setting[ 'label' ] ); ?></label>
						    	</th>
						    	
						    	<td>
							    	
							    	<?php
									
									/**
									 * get the current saved setting
									 * setting name is stored as an array element in the option named wpptm_meta
									 * the array element is prefixed with the post type name e.g. wpptm_meta[ 'page_description' ]
									*/
									$current_setting = get_option( 'wpptm_meta' );
									$current_setting = $current_setting[ $post_type->name . '_' . $setting[ 'id' ] ];
									
									/* setup a swith statement to output based on setting type */
									switch( $setting[ 'type' ] ) {
										
										/* if this is a wysiwyg setting */
										case 'wysiwyg':
											
											/* get the textarea rows setting field */
											$textarea_rows = $setting[ 'textarea_rows' ];
											
											/* check if we have textarea rows */
											if( empty( $setting[ 'textarea_rows' ] ) )
												$textarea_rows = 5;
											
											/* get the textarea rows setting field */
											$media_buttons = $setting[ 'media_buttons' ];
											
											/* check if we have textarea rows */
											if( empty( $setting[ 'media_buttons' ] ) )
												$media_buttons = false;
												
											/* set some settings args for the editor */
									    	$editor_settings = array(
									    		'textarea_rows' => $textarea_rows,
									    		'media_buttons' => $media_buttons,
									    	);
									    						    	
									    	/* display the wysiwyg editor */
									    	wp_editor(
									    		$current_setting, // default content
									    		$post_type->name . '_' . $setting[ 'id' ], // id to give the editor element
									    		$editor_settings // edit settings from above
									    	);
										
											break;
										
										/* if this should be rendered as a select input */
										case 'select':
																	
											?>
									    	<select name="<?php echo $post_type->name . '_' . $setting[ 'id' ]; ?>" id="<?php echo $setting[ 'id' ]; ?>">
									    	
									    	<?php
									    	/* get the setting options */
									    	$options = $setting[ 'options' ];
									    	
									        /* loop through each option */
									        foreach( $options as $option ) {
										        ?>
										        <option value="<?php echo esc_attr( $option[ 'value' ] ); ?>" <?php selected( $current_setting, $option[ 'value' ] ); ?>><?php echo $option[ 'name' ]; ?></option>
												<?php
									        }
									        ?>
									    	</select>
									        <?php
											
											break;
										
										/* if the type is set to a textarea input */  
									    case 'textarea':
									    	
									    	?>
									    	
									        <textarea name="<?php echo $post_type->name . '_' . $setting[ 'id' ]; ?>" rows="<?php echo esc_attr( $setting[ 'textarea_rows' ] ); ?>" cols="50" id="<?php echo esc_attr( $setting[ 'id' ] ); ?>" class="regular-text"><?php echo $current_setting; ?></textarea>
									        
									        <?php
										        
									        /* break out of the switch statement */
									        break;
									       
									    /* if the type is set to a textarea input */  
									    case 'checkbox':
									    
									    	?>
											<input type="checkbox" name="<?php echo $post_type->name . '_' . $setting[ 'id' ]; ?>" id="<?php echo esc_attr( $setting[ 'id' ] ); ?>" value="1" <?php checked( $current_setting, '1' ); ?> />
											<?php
									    	
									    	/* break out of the switch statement */
									        break;
											
										/* any other type of input - treat as text input */ 
										default:
										
											?>
											<input type="text" name="<?php echo $post_type->name . '_' . $setting[ 'id' ]; ?>" id="<?php echo esc_attr( $setting[ 'id' ] ); ?>" class="regular-text" value="<?php echo $current_setting ?>" />
											<?php
										
									} // end switch statement
									
									?>
								
						    	</td>
						    	
							</tr><!-- // wpptm-setting -->
							
							<?php
							
						} // end loop through settings
						
					?>
				
					</table>
				
				<?php
				} // end if have options
				
			?>
					
			<input type="hidden" name="wpptm_post_type" value="<?php echo esc_attr( $post_type->name ); ?>" />
			
			<p class="submit">
				<input class="button-primary" type="submit" name="wpptm_update_metainfo" value="Save"/>
			</p>
	
		</form>
	
	</div><!-- // wrap -->

<?php }
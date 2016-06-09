<?php 
$args = array(
		'role' => 'city_manager'
	);

$users = get_users( $args );
 
$args = array(
		'post_type' => 'city',
		'orderby' => 'name',
		'order' => 'ASC',
		'showposts' => -1
	);

$cities = new WP_Query( $args );

?>
<div class="wrap">
	<form method="post" action="" >
		<table class="wp-list-table widefat fixed striped users">
			<thead>
				<tr>
					<th>login</th>
					<th>email</th>
					<th>city</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php 
					foreach( $users as $user ){
						$uCities = get_user_meta($user->ID, 'manage_city', true);
						
						?>
					<tr>
						<td><?=$user->user_login ?> </td>
						<td><?=$user->user_email ?> </td>
						<td>
						<?php 
						if(is_array($uCities)):

							foreach($uCities as $uCity):
								$uCity = (int) $uCity;
							
						?>
							<select data-user="<?=$user->ID ?>" name="city" class="city-select">
								<option value="0">--------REMOVE CITY----------</option>
								<?php 
									
									if($cities->have_posts()){
										while($cities->have_posts()){
											$cities->the_post();
											$cityId =  get_the_id();

											?>
											<option value="<?php the_ID(); ?>" <?php if( $cityId == $uCity ){ echo "selected='selected'"; } ?> ><?php the_title(); ?></option>
											<?php
										}
									}
									wp_reset_query();
								?>
							</select>
						<?php endforeach; ?>
						<?php else: ?>
							<select data-user="<?=$user->ID ?>" name="city" class="city-select">
								<option value="0">--------REMOVE CITY----------</option>
								<?php 
									$args = array(
											'post_type' => 'city',
											'showposts' => -1
										);

									$cities = new WP_Query( $args );
									if($cities->have_posts()){
										while($cities->have_posts()){
											$cities->the_post();
											$cityId =  get_the_id();
											?>
											<option value="<?php the_ID(); ?>" <?php if( $cityId == $uCity ){ echo "selected='selected'"; } ?> ><?php the_title(); ?></option>
											<?php
										}
									}
									wp_reset_query();
								?>
							</select>
						<?php endif; ?>
						</td>
						</td>
						<td><span class="button add-city">Add city</span></td>
					</tr>
						<?php
					}
				?>
			</tbody>
			<tfoot>
				<tr>
					
				</tr>
			</tfoot>
		</table>
		<input type="submit" value="Save Changes" class="button button-primary city-managment" />
	</form>
</div>
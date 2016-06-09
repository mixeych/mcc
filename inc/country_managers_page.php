<?php 
$args = array(
		'role' => 'country_manager'
	);

$users = get_users( $args );
$countries = get_terms( 'countries', array('hide_empty' => false ));
?>
<div class="wrap">
	<form method="post" action="" >
		<table class="wp-list-table widefat fixed striped users">
			<thead>
				<tr>
					<th>login</th>
					<th>email</th>
					<th>country</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					foreach( $users as $user ){
						$uCountry = get_user_meta($user->ID, 'manage_country', true);
						?>
					<tr>
						<td><?=$user->user_login ?> </td>
						<td><?=$user->user_email ?> </td>
						<td>
							<select data-user="<?=$user->ID ?>" name="country" class="coutry-select">
								<?php
									foreach ($countries as $country) {
										?>
										<option value="<?=$country->slug ?>" <?php if( $country->slug == $uCountry ){ echo "selected"; } ?> ><?=$country->name ?></option>
										<?php
									}
								 ?>
							</select>
						</td>
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
		<input type="submit" value="Save Changes" class="button button-primary country-managment" />
	</form>
</div>
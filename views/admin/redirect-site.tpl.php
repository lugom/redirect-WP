<?php
// don't load directly
if ( !defined( 'ABSPATH' ) ) {
	die( '-1' );
}
?>
<div class='wrap'>
	<h2><?php echo $this->_name; ?></h2>
	<?php if( isset( $msg ) ) { 
		$tpl_msg = BEA_Redirect_Plugin::get_template( 'redirect-msg' );
		require( $tpl_msg );
	} ?>
	<div class="wrap">
		<h3><?php echo _e( 'Paramètre de redirection de blog' , $this->_domain ); ?></h3>
		<p><?php echo _e( 'Permet de choisir les blogs qui ne seront accessibles que les administrateurs et rediriger vers un blog choisi pour les utilisateurs' , $this->_domain ); ?></p>
		<form method="POST" >
			<input type="hidden" name="action" value="<?php echo $this->_domain; ?>" />
				<table class="form-table">
					
					<tr class="form-required">
						<th scope='row'><?php echo _e( 'Choisir les blogs à rediriger' , $this->_domain ); ?> </th>
						<td>
							<table>
								<?php foreach( $blogs as $blog ) { ?>
									<?php
										$checked = '';
										if( in_array( $blog->blog_id , $redirected_blog ) ){
											$checked = 'checked="checked"';
										}
									?>
									<tr>
										<td><input type="checkbox" name="blog[id][]" <?php echo $checked; ?> value='<?php  echo $blog->blog_id; ?>'/></td><td><?php echo substr( $blog->domain_path, 0, -1 ); ?></td>
									</tr>
								<?php } ?>
							</table>
						</td>
					</tr>
					
					<tr class="form-required">
						<th scope='row'><?php echo _e( 'Rediriger vers le blog' , $this->_domain ); ?> </th>
						<td>
							<select name="source_blog">
							<?php foreach( $blogs as $blog ) { ?>
								<?php
									$selected = '';
									if( $blog->blog_id == $redirected_blog_to ){
										$selected = 'selected="selected"';
									}
								?>
								<option value="<?php echo $blog->blog_id; ?>" <?php echo $selected; ?>><?php echo substr( $blog->domain_path, 0, -1 ); ?></option>
							<?php } ?>
							</select>
						</td>
					</tr>
				</table>
				<?php wp_nonce_field( $this->_domain ); ?>
			<p class="submit"><input class='button' type='submit' name="save" value='<?php echo _e( 'Enregistrer' , $this->_domain ); ?>' /></p>
			<p class="submit"><input class='button' type='submit' name="delete" value='<?php echo _e( 'Désactiver la redirection' , $this->_domain ); ?>' /></p>
		</form>
	</div>
</div>
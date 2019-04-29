<!doctype html>
<!--[if lt IE 7 ]><html lang="en" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html lang="en" class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html lang="en" class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html lang="en" class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="en" class="no-js"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title><?php echo lang("update_user_group_demo"); ?> | Flexi Auth | <?php echo lang("a_user_authentication_library"); ?></title>
	<meta name="description" content="Flexi Auth, the user authentication library designed for developers."/> 
	<meta name="keywords" content="demo, flexi auth, user authentication, Codeigniter"/>
	<?php $this->load->view('includes/head'); ?> 
</head>

<body id="update_user_group">

<div id="body_wrap">
	<!-- Header -->  
	<?php $this->load->view('includes/header'); ?> 

	<!-- Demo Navigation -->
	<?php $this->load->view('includes/demo_header'); ?> 
	
	<!-- Intro Content -->
	<div class="content_wrap intro_bg">
		<div class="content clearfix">
			<div class="col100">
				<h2><?php echo lang("admin_update_user_group"); ?></h2>
				<p>The Flexi Auth library allows for unlimited custom user groups to be defined. Each user can then be assigned to a specific user group.</p>
				<p>Once user groups have been defined, access to specific pages or even specific sections of pages can be controlled by checking whether a user has permission to access a requested page.</p>
				<p>The default setup of this demo uses user groups and privileges to restrict the example public user from accessing the Admin area, and the example moderator user from inserting, updating and deleting specific data within the Admin area.</p>
			</div>		
		</div>
	</div>
	
	<!-- Main Content -->
	<div class="content_wrap main_content_bg">
		<div class="content clearfix">
			<div class="col100">
				<h2><?php echo lang("update_user_group"); ?></h2>
				<a href="<?php echo $base_url;?>auth_admin/manage_user_groups"><?php echo lang("manage_user_groups"); ?></a>

			<?php if (! empty($message)) { ?>
				<div id="message">
					<?php echo $message; ?>
				</div>
			<?php } ?>
				
				<?php echo form_open(current_url());	?>  	
					<fieldset>
						<legend><?php echo lang("group_details"); ?></legend>
						<ul>
							<li class="info_req">
								<label for="group"><?php echo lang("group_name"); ?>:</label>
								<input type="text" id="group" name="update_group_name" value="<?php echo set_value('update_group_name', $group[$this->flexi_auth->db_column('user_group', 'name')]);?>" class="tooltip_trigger"
									title="The name of the user group."/>
							</li>
							<li>
								<label for="description"><?php echo lang("group_description"); ?>:</label>
								<textarea id="description" name="update_group_description" class="width_400 tooltip_trigger"
									title="A short description of the purpose of the user group."><?php echo set_value('update_group_description', $group[$this->flexi_auth->db_column('user_group', 'description')]);?></textarea>
							</li>
							<li>
								<?php $ugrp_admin = ($group[$this->flexi_auth->db_column('user_group', 'admin')] == 1) ;?>
								<label for="admin">Is Admin Group:</label>
								<input type="checkbox" id="admin" name="update_group_admin" value="1" <?php echo set_checkbox('update_group_admin', 1, $ugrp_admin);?> class="tooltip_trigger"
									title="If checked, the user group is set as an 'Admin' group."/>
							</li>
							<li>
								<label for="admin"><?php echo lang("user_group_privileges"); ?>:</label>
								<a href="<?php echo $base_url;?>auth_admin/update_group_privileges/<?php echo $group['ugrp_id']; ?>"><?php echo lang("manage_privileges_for_this_user_group"); ?></a>
							</li>
						</ul>
					</fieldset>
									
					<fieldset>
						<legend><?php echo lang("update_group_details"); ?></legend>
						<ul>
							<li>
								<label for="submit"><?php echo lang("update_group"); ?>:</label>
								<input type="submit" name="update_user_group" id="submit" value="<?php echo lang("submit"); ?>" class="link_button large"/>
							</li>
						</ul>
					</fieldset>
				<?php echo form_close();?>
			</div>
		</div>
	</div>	
	
	<!-- Footer -->  
	<?php $this->load->view('includes/footer'); ?> 
</div>

<!-- Scripts -->  
<?php $this->load->view('includes/scripts'); ?> 

</body>
</html>
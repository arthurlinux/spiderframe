<table id="user_roles_list" class="table_list">	<tr>		<th colspan="5"><?php echo Functions::__Translate("User roles List") ?></th>	</tr>	<tr>		<th><?php echo Functions::__Translate("Rol ID") ?></th>		<th><?php echo Functions::__Translate("Rol") ?></th>		<th><?php echo Functions::__Translate("Description") ?></th>		<th><?php echo Functions::__Translate("Status") ?></th>		<th><?php echo Functions::__Translate("Actions") ?></th>	</tr>		<?php if($__rows) 		  { 		  	foreach ($__rows AS $__row)			{ 				$Row = (object)$__row;				$class_row = ($class_row == "" || $class_row == "odd_row") ? "even_row" : "odd_row" ;				$inactive_item = ($Row->active == "0") ? "inactive_item" : "";				?>					<tr class="<?php echo $class_row . " " . $inactive_item ?>" id="container-cat_user_rol-<?php echo $Row->cat_user_rol_id ?>">												<td class="left"><?php echo $Row->cat_user_rol_id ?></td>												<td class="left"><a href="<?php echo TO_ROOT ?>/apps/admin/user_rol.php?cat_user_rol_id=<?php echo $Row->cat_user_rol_id ?>">							<?php echo $Row->rol ?> 							</a> 						</td>												<td class="left"><?php echo $Row->description ?></td>												<td class="center"><?php echo ($Row->active == "0") ? Functions::__Translate("Inactive") : Functions::__Translate("Active") ?></td>												<td class="active_actions">							<a href="<?php echo TO_ROOT ?>/apps/admin/edit_user_rol.php?cat_user_rol_id=<?php echo $Row->cat_user_rol_id ?>"><?php echo Functions::__Translate("Edit") ?></a>							<a class="active_action" id="cat_user_rol_id-active-<?php echo $Row->cat_user_rol_id ?>-<?php echo $Row->active ?>"><?php echo ($Row->active == "1") ? Functions::__Translate("Inactive") : Functions::__Translate("Active") ?></a>						</td>					</tr>		<?php } //end principal foreach $__rows ?>	<?php } //end principal if ?></table>
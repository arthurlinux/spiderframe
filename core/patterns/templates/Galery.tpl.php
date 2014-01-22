<?php
if($Data->__container_properties)
{ 
	$container_properties = "";
	foreach($Data->__container_properties AS $property => $value)
	{
		$container_properties .= "{$property}=\"{$value}\" ";
	}
}
//Display structure --->>>>> Functions::__displayVariable($Data->__rows);
?>

<div class="galery_list">
	<?php if($Data->__view == "list"){ ?>
		
			<ul class="galery">
				<?php 
				if($Data->__rows)
				{ 
					foreach ($Data->__rows AS $__rows => $__row)	
					{ 
						?>
						<li id="item_<?php echo $__row["image_id"]["Properties"]["value"] ?>">
							
							<div id="item_container_<?php echo $__row["image_id"]["Properties"]["value"] ?>" class="item_container">
								
								<div id="image_container_<?php echo $__row["image_id"]["Properties"]["value"] ?>" class="image_container">
									<a class="fancybox" rel="group" href="<?php echo TO_ROOT . $__row["image"]["Properties"]["value"] ?>" title="<?php echo $__row["title"]["Properties"]["value"] ?>">
									<img id="item_image_<?php echo $__row["image_id"]["Properties"]["value"] ?>" src="<?php echo TO_ROOT . $__row["image"]["Properties"]["value"] ?>" />
									</a>
								</div>
								
								<div class="details">
									<?php 
									foreach ($__row AS $_row => $_values)
									{
										if($_values["Properties"]["hide"] == false)
										{
											?>
											<label class="<?php echo $_values["Properties"]["class"] ?>"><?php echo $_values["Properties"]["value"] ?></label>
											<?php 
										} 
									} ?>
								</div>
							</div>
							
							<label class="link"><a href="<?php echo TO_ROOT . $__row["image"]["Properties"]["href"] ?>"><?php echo Functions::__Translate("View details") ?></a></label>
						</li>
						<?php
					} 
				} ?>
			</ul>
	<?php } else if($Data->__view == "table") { ?>
			<table class="galery">
				<tr>
					<th><?php echo Functions::__Translate("Image") ?></th>
					<th><?php echo Functions::__Translate("Title") ?></th>
					<th><?php echo Functions::__Translate("Details") ?></th>
					<th><?php echo Functions::__Translate("Actions") ?></th>
				</tr>
				<?php 
				if($Data->__rows)
				{ 
					foreach ($Data->__rows AS $__rows => $__row)	
					{ 
						$Image = (object)$__row["Image"]["Properties"];
						?>
							<tr id="item_<?php echo $Image->image_id  ?>">
								<td>
									<a class="fancybox" rel="group" href="<?php echo TO_ROOT . $Image->image ?>" title="<?php echo $Image->title ?>">
									<img id="item_image_<?php echo $Image->image_id ?>" src="<?php echo TO_ROOT . $Image->image ?>" />
									</a>
								</td>
									
								<td class="title"><?php echo $Image->title ?></td>
								<td class="detail"><?php echo $Image->detail ?></td>
								<td class="link">
									<a href="<?php echo TO_ROOT . $Image->href ?>"><?php echo Functions::__Translate("View details") ?></a>
								</td>
							</tr>
						<?php
					} 
				} ?>
			</table>
	<?php } else if($Data->__view == "image_galery") { ?>
		
	<?php } ?>
</div>
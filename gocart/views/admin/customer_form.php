<?php include('header.php'); ?>

<?php echo form_open($this->config->item('admin_folder').'/customers/form/'.$id); ?>
<div class="button_set">
	<input type="submit" value="<?php echo lang('save');?>" />
</div>

<div id="gc_tabs">
	<ul>
		<li><a href="#gc_customer_attributes"><?php echo lang('customer_information');?></a></li>
		<li><a href="#gc_customer_category"><?php echo lang('customer_category');?></a></li>
	</ul>
<div id="gc_customer_attributes">
<div>
<table>
	<tr>
		<td style="padding-right:30px;" rowspan="2">

				<table>
					<tr>
						<td><?php echo lang('company');?></td>
						<td>
							<?php
							$data	= array('id'=>'company', 'name'=>'company', 'value'=>set_value('company', $company), 'class'=>'gc_tf1');
							echo form_input($data);
							?>
						</td>
					</tr>
					<tr>
						<td><?php echo lang('firstname');?></td>
						<td><?php
						$data	= array('id'=>'firstname', 'name'=>'firstname', 'value'=>set_value('firstname', $firstname), 'class'=>'gc_tf1');
						echo form_input($data);
						?></td>
					</tr>
					<tr>
						<td><?php echo lang('lastname');?></td>
						<td>
							<?php
							$data	= array('id'=>'lastname', 'name'=>'lastname', 'value'=>set_value('lastname', $lastname), 'class'=>'gc_tf1');
							echo form_input($data);
							?>
						</td>
					</tr>
					<tr>
						<td><?php echo lang('email');?></td>
						<td>
							<?php
							$data	= array('id'=>'email', 'name'=>'email', 'value'=>set_value('email', $email), 'class'=>'gc_tf1');
							echo form_input($data);
							?>
						</td>
					</tr>
					<tr>
						<td><?php echo lang('phone');?></td>
						<td>
							<?php
							$data	= array('id'=>'phone', 'name'=>'phone', 'value'=>set_value('phone', $phone), 'class'=>'gc_tf1');
							echo form_input($data);
							?>
						</td>
					</tr>
					<tr>
						<td><?php echo lang('password');?></td>
						<td>
							<?php
							$data	= array('id'=>'password', 'name'=>'password', 'class'=>'gc_tf1');
							echo form_password($data);
							?>
						</td>
					</tr>
					<tr>
						<td><?php echo lang('confirm');?></td>
						<td>
							<?php
							$data	= array('id'=>'confirm', 'name'=>'confirm', 'class'=>'gc_tf1');
							echo form_password($data);
							?>
						</td>
					</tr>
					<tr>
						<td><?php echo lang('email_subscribed');?></td>
						<td><input type="checkbox" name="email_subscribe" value="1" <?php if((bool)$email_subscribe) { ?> checked="checked" <?php } ?>/></td>
					</tr>
					<tr>
						<td><?php echo lang('active');?></td>
						<td>
							<?php
							$data	= array('id'=>'active', 'name'=>'active', 'value'=>1, 'checked'=>$active);
							echo form_checkbox($data);
							?>
						</td>
					</tr>
					<tr>
					  <td><?php echo lang('group');?></td>
					  <td><?php echo form_dropdown('group_id', $group_list, set_value('group_id',$group_id)); ?></td>
				  </tr>
				</table>
		  </td>

	</tr>
</table>
</div>

</div>
<div id="gc_customer_category">
		<table class="gc_table" cellspacing="0" cellpadding="0">
		    <thead>
				<tr>
					<th class="gc_cell_left" style="text-align:left"><?php echo lang('name');?></th>
					<th class="gc_cell_right"></th>
				</tr>
			</thead>
			<tbody>
				<?php
				define('ADMIN_FOLDER', $this->config->item('admin_folder'));
				function list_categories($cats, $product_categories, $sub='') {

					foreach ($cats as $cat):?>
					<tr class="gc_row">
						<td><?php echo  $sub.$cat['category']->name; ?></td>
						<td style="text-align:right">
							<input type="checkbox" name="categories[]" value="<?php echo $cat['category']->id;?>" <?php echo (in_array($cat['category']->id, $product_categories))?'checked="checked"':'';?>/>
						</td>
					</tr>
					<?php
					if (sizeof($cat['children']) > 0)
					{
						$sub2 = str_replace('&rarr;&nbsp;', '&nbsp;', $sub);
							$sub2 .=  '&nbsp;&nbsp;&nbsp;&rarr;&nbsp;';
						list_categories($cat['children'], $product_categories, $sub2);
					}
					endforeach;
				}

				list_categories($categories, $customer_categories);
				?>
			</tbody>
		</table>
</div>
</form>

<?php include('footer.php');
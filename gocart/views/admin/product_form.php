<?php include('header.php'); ?>
<style type="text/css">
	.sortable { list-style-type: none; margin: 0; padding: 0; width: 100%; }
	.sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; height: 18px; }
	.sortable li>span { position: absolute; margin-left: -1.3em; margin-top:.4em; }
</style>

		<style type="text/css">
			body,img,p,h1,h2,h3,h4,h5,h6,form,table,td,ul,li,dl,dt,dd,pre,blockquote,fieldset,label{
				margin:0;
				padding:0;
				border:0;
			}

			//body{ font: 90% Arial, Helvetica, sans-serif; padding: 20px; }
			//h1{ margin: 10px 0;	color: rgb(255, 191, 85); }
			//h2{ margin: 10px 0;	color: #99C3FF;}
			//h4{ margin: 10px 0;	color: red; }
			//p{ margin: 10px 0; }

			.stripeTable{ width: 100%; border: solid 1px #aaaaaa; }
			.stripeTable th{ padding: 5px; text-align: center; }
			.stripeTable td{ padding: 5px; text-align: left; }
			.stripeTable thead tr th{ background-color: #ffffff; border-bottom: solid 1px #aaaaaa; }
			.stripeTable tbody tr.bg0{ background-color: rgb(244,244,244); background-color: rgba(244,244,244, .7); }
			.stripeTable tbody tr.bg1{ background-color: rgb(255,255,255); background-color: rgba(255,255,255, .7); }
			.stripeTable tbody tr.bg0:hover{ background-color: rgb(255, 191, 85); background-color: rgba(255, 191, 85, .7); }
			.stripeTable tbody tr.bg1:hover{ background-color: rgb(255, 191, 85); background-color: rgba(255, 191, 85, .7); }
			.stripeTable .col0{ background-color: #cfcfcf; }
			.stripeTable .col1{ background-color: #ffffff; }
			.stripeTable .colQtyRounded{ background-color: black; }
			.stripeTable col:first-child{ background-color: #FfBf55; }
			.stripeTable col:nth-child(6){ background-color: #aaffaa; }
			.stripeTable col:nth-child(7){ background-color: #aaaaff; }
			.textEdit{
				margin-top:8px;
				font-size:18px;
				color:#545454;
				-moz-border-radius: 2px;
				-webkit-border-radius: 2px;
				-border-radius: 2px;
				display:none;
				width:60px;
				height:15px;
				text-align:center;
			}
		</style>
		<link href="<?php echo base_url('css/jquery.selectBox.css');?>" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url('css/jquery-ui-themes/smoothness/jquery-ui-1.8.15.custom.css');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="<?php echo base_url('js/jquery/jquery.selectBox.js');?>"></script>
		<script type="text/javascript" src="<?php echo base_url('js/jquery/easy-editable-text.js');?>"></script>



<script type="text/javascript">
//<![CDATA[

			var arrDropdownStrings=new Array();
			arrDropdownStrings[0]="Select a Profile...";
			arrDropdownStrings[1]="A demo Profile";

			var arrProfiles=new Array();
			arrProfiles[0]="";
			arrProfiles[1]="B-1_2|C-2_3|";

$(document).ready(function() {

	var optionString={'0':'Select a Profile...','1':arrDropdownStrings[1]};
	$("SELECT").selectBox('options', optionString);

	$(".sortable").sortable();
	$(".sortable > span").disableSelection();
	//if the image already exists (phpcheck) enable the selector

	<?php if($id) : ?>
	//options related
	var ct	= $('#option_list').children().size();
	//create_sortable();
	set_accordion();

	// set initial count
	option_count = <?php echo count($product_options); ?>;

	<?php endif; ?>

	$( ".add_option" ).button().click(function(){
		add_option($(this).attr('rel'));
	});
	$( "#add_buttons" ).buttonset();

	photos_sortable();
});

function add_product_image(data)
{
	p	= data.split('.');

	var photo = '<?php add_image("'+p[0]+'", "'+p[0]+'.'+p[1]+'", '', '');?>';
	$('#gc_photos').append(photo);
	$('#gc_photos').sortable('destroy');
	photos_sortable();

	$('.button').button();
}

function remove_image(img)
{
	if(confirm('<?php echo lang('confirm_remove_image');?>'))
	{
		var id	= img.attr('rel')
		$('#gc_photo_'+id).remove();
	}
}

function photos_sortable()
{
	$('#gc_photos').sortable({
		handle : '.gc_thumbnail',
		items: '.gc_photo',
		axis: 'y',
		scroll: true
	});
}

function add_option(type)
{

	if(jQuery.trim($('#option_name').val()) != '')
	{
		//increase option_count by 1
		option_count++;

		$('#options_accordion').append('<?php add_option("'+$('#option_name').val()+'", "'+option_count+'", "'+type+'");?>');


		//eliminate the add button if this is a text based option
		if(type == 'textarea' || type == 'textfield')
		{
			$('#add_item_'+option_count).remove();

		}

		add_item(type, option_count);

		//reset the option_name field
		$('#option_name').val('');
		reset_accordion();

	}
	else
	{
		alert('<?php echo lang('alert_must_name_option');?>');
	}

}

function add_item(type, id)
{

	var count = $('#option_items_'+id+'>li').size()+1;

	append_html = '';

	if(type!='textfield' && type != 'textarea')
	{
		append_html = append_html + '<li id="value-'+id+'-'+count+'"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><a onclick="if(confirm(\'<?php echo lang('confirm_remove_value');?>\')) $(\'#value-'+id+'-'+count+'\').remove()" class="ui-state-default ui-corner-all" style="float:right;"><span class="ui-icon ui-icon-circle-minus"></span></a>';
	}

	append_html += '<div style="margin:2px"><span><?php echo lang('name');?>: </span> <input class="req gc_tf2" type="text" name="option['+id+'][values]['+count+'][name]" value="" /> '+
	'<span><?php echo lang('value');?>: </span> <input class="req gc_tf2" type="text" name="option['+id+'][values]['+count+'][value]" value="" /> '+
	'<span><?php echo lang('weight');?>: </span> <input class="req gc_tf2" type="text" name="option['+id+'][values]['+count+'][weight]" value="" /> '+
	'<span><?php echo lang('price');?>: </span> <input class="req gc_tf2" type="text" name="option['+id+'][values]['+count+'][price]" value="" />';

	if(type == 'textfield')
	{
		append_html += ' <span><?php echo lang('limit');?>: </span> <input class="req gc_tf2" type="text" name="option['+id+'][values]['+count+'][limit]" value="" />';
	}

	append_html += '</div> ';

	if(type!='textfield' && type != 'textarea')
	{
		append_html += '</li>';
	}


	$('#option_items_'+id).append(append_html);

	$(".sortable").sortable();
	$(".sortable > span").disableSelection();


}

function remove_option(id)
{
	if(confirm('<?php echo lang('confirm_remove_option');?>'))
	{
		$('#option-'+id).remove();

		option_count --;

		reset_accordion();
	}
}

function reset_accordion()
{
	$( "#options_accordion" ).accordion('destroy');
	$('.option_item_form').sortable('destroy');
	set_accordion();
}

function set_accordion(){

	var stop = false;
	$( "#options_accordion h3" ).click(function( event ) {
		if ( stop ) {
			event.stopImmediatePropagation();
			event.preventDefault();
			stop = false;
		}
	});

	$( "#options_accordion" ).accordion({
		autoHeight: false,
		active: option_count-1,
		header: "> div > h3"
	}).sortable({
		axis: "y",
		handle: "h3",
		stop: function() {
			stop = true;
		}
	});


	$('.option_item_form').sortable({
		axis: 'y',
		handle: 'span',
		stop: function() {
			stop = true;
		}
	});


}
function delete_product_option(id)
{
	//remove the option if it exists. this function is also called by the lightbox when an option is deleted
	$('#options-'+id).remove();
}
//]]>
</script>


<?php echo form_open($this->config->item('admin_folder').'/products/form/'.$id, 'id="product_form"'); ?>
<div class="button_set">
	<input name="submit" type="submit" value="Save Product" />
</div>

<div id="gc_tabs">
	<ul>
		<li><a href="#gc_product_info"><?php echo lang('description');?></a></li>
		<li><a href="#gc_product_attributes"><?php echo lang('attributes');?></a></li>
		<li><a href="#gc_product_categories"><?php echo lang('categories');?></a></li>
		<li><a href="#gc_product_downloads"><?php echo lang('digital_content');?></a></li>
		<li><a href="#gc_product_seo"><?php echo lang('seo');?></a></li>
		<li><a href="#gc_product_options"><?php echo lang('options');?></a></li>
		<li><a href="#gc_product_related"><?php echo lang('related_products');?></a></li>
		<li><a href="#gc_product_photos"><?php echo lang('images');?></a></li>
		<li><a href="#gc_product_distribution"><?php echo lang('distribution');?></a></li>
	</ul>

	<div id="gc_product_info">
		<div class="gc_field">
		<?php
		$data	= array('id'=>'name', 'name'=>'name', 'value'=>set_value('name', $name), 'class'=>'gc_tf1');
		echo form_input($data);
		?>
		</div>

		<div class="gc_field gc_tinymce">
		<?php
		$data	= array('id'=>'description', 'name'=>'description', 'class'=>'tinyMCE', 'value'=>set_value('description', $description));
		echo form_textarea($data);
		?>
		</div>
		<div class="button_set">
			<input type="button" onclick="toggleEditor('description'); return false;" value="Toggle WYSIWYG" />
		</div>
	</div>

	<div id="gc_product_attributes">
		<div class="gc_field2">
		<label for="sku"><?php echo lang('sku');?> </label>
		<?php
		$data	= array('id'=>'sku', 'name'=>'sku', 'value'=>set_value('sku', $sku), 'class'=>'gc_tf1');
		echo form_input($data);
		?>
		</div>
		<div class="gc_field2">
		<label for="price"><?php echo lang('price');?> </label>
		<?php
		$data	= array('id'=>'price', 'name'=>'price', 'value'=>set_value('price', $price), 'class'=>'gc_tf1');
		echo form_input($data);
		?>
		</div>
		<div class="gc_field2">
		<label for="price"><?php echo lang('saleprice');?> </label>
		<?php
		$data	= array('id'=>'saleprice', 'name'=>'saleprice', 'value'=>set_value('saleprice', $saleprice), 'class'=>'gc_tf1');
		echo form_input($data);
		?>
		</div>
		<div class="gc_field2">
		<label for="weight"><?php echo lang('weight');?> </label>
		<?php
		$data	= array('id'=>'weight', 'name'=>'weight', 'value'=>set_value('weight', $weight), 'class'=>'gc_tf1');
		echo form_input($data);
		?>
		</div>
		<div class="gc_field2">
		<label for="slug"><?php echo lang('slug');?> </label>
		<?php
		$data	= array('id'=>'slug', 'name'=>'slug', 'value'=>set_value('slug', $slug), 'class'=>'gc_tf1');
		echo form_input($data);
		?>
		</div>
        <div class="gc_field2">
		<label for="slug"><?php echo lang('track_stock');?> </label>
		<?php
		 	$options = array(	 '1'	=> lang('track_stock')
								,'0'	=> lang('do_not_track_stock')
								);
			echo form_dropdown('track_stock', $options, set_value('track_stock',$track_stock), 'id="track_stock"');
		?>
		</div>
		<div class="gc_field2">
		<label for="quantity"><?php echo lang('quantity');?> </label>
		<?php
		$data	= array('id'=>'quantity', 'name'=>'quantity', 'value'=>set_value('quantity', $quantity), 'class'=>'gc_tf1');
		echo form_input($data);
		?><small><?php echo lang('quantity_in_stock_note');?></small>
		</div>
		<div class="gc_field2">
		<label for="slug"><?php echo lang('shippable');?> </label>
		<?php
		$options = array(	 '1'	=> lang('yes')
							,'0'	=> lang('no')
							);
			echo form_dropdown('shippable', $options, set_value('shippable',$shippable));
		?>
		</div>
		<div class="gc_field2">
		<label for="slug"><?php echo lang('fixed_quantity');?> </label>
		<?php
		 	$options = array(	 '1'	=> lang('yes')
								,'0'	=> lang('no')
								);
			echo form_dropdown('fixed_quantity', $options, set_value('fixed_quantity',$fixed_quantity));
		?> <small><?php echo lang('fixed_quantity_note');?></small>
		</div>
		<div class="gc_field2">
		<label for="slug"><?php echo lang('taxable');?> </label>
		<?php
		$options = array(	 '1'	=> lang('yes')
							,'0'	=> lang('no')
							);
			echo form_dropdown('taxable', $options, set_value('taxable',$taxable));
		?>
		</div>
		<div class="gc_field2">
		<label for="slug"><?php echo lang('enabled');?> </label>
		<?php
		 	$options = array(	 '1'	=> lang('yes')
								,'0'	=> lang('no')
								);
			echo form_dropdown('enabled', $options, set_value('enabled',$enabled));
		?>
		</div>
		<div class="gc_field">
		<label><?php echo lang('excerpt');?></label>
		<?php
		$data	= array('id'=>'excerpt', 'name'=>'excerpt', 'value'=>set_value('excerpt', $excerpt), 'class'=>'gc_tf1');
		echo form_textarea($data);
		?>


		</div>
	</div>

	<div id="gc_product_categories">
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

				list_categories($categories, $product_categories);
				?>
			</tbody>
		</table>
	</div>

	<div id="gc_product_downloads">
		<?php echo lang('digital_products_desc') ?>
		<table class="gc_table" cellspacing="0" cellpadding="0">
				<thead>
					<tr>
						<th class="gc_cell_left"><?php echo lang('filename');?></th>
						<th><?php echo lang('title');?></th>
						<th style="width:70px;"><?php echo lang('size');?></th>

						<th class="gc_cell_right"></th>
					</tr>
				</thead>
				<tbody>
				<?php echo (count($file_list) < 1)?'<tr><td style="text-align:center;" colspan="6">'.lang('no_files').'</td></tr>':''?>
				<?php foreach ($file_list as $file):?>
					<tr>
						<td class="gc_cell_left"><?php echo $file->filename ?></td>
						<td><?php echo $file->title ?></td>
						<td><?php echo $file->size ?></td>
						<td><?php echo form_checkbox('downloads[]', $file->id, in_array($file->id, $product_files)); ?></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
		</table>

	</div>

	<div id="gc_product_seo">
		<div class="gc_field2">
		<label for="seo_title"><?php echo lang('seo_title');?> </label>
		<?php
		$data	= array('id'=>'seo_title', 'name'=>'seo_title', 'value'=>set_value('seo_title', $seo_title), 'class'=>'gc_tf1');
		echo form_input($data);
		?>
		</div>

		<div class="gc_field">
		<label><?php echo lang('meta');?></label> <small><?php echo lang('meta_example');?></small>
		<?php
		$data	= array('id'=>'meta', 'name'=>'meta', 'value'=>set_value('meta', html_entity_decode($meta)), 'class'=>'gc_tf1');
		echo form_textarea($data);
		?>
		</div>
	</div>

	<div id="gc_product_options">


		<div id="selected_options" class="option_form">

				<span id="add_buttons" style="float:right;">
					<input class="gc_tf2" id="option_name" style="width:200px;" type="text" name="option_name" />
					<button type="button" class="add_option" rel="checklist"><?php echo lang('checklist');?></button>
					<button type="button" class="add_option" rel="radiolist"><?php echo lang('radiolist');?></button>
					<button type="button" class="add_option" rel="droplist"><?php echo lang('droplist');?></button>
					<button type="button" class="add_option" rel="textfield"><?php echo lang('textfield');?></button>
					<button type="button" class="add_option" rel="textarea"><?php echo lang('textarea');?></button>
				</span>

			<br style="clear:both;"/>
			<div id="options_accordion">
			<?php
				$count	= 0;
				if(!empty($product_options)):
					//print_r($product_options);
					foreach($product_options as $option):
						//print_r($option);
						$option	= (object)$option;

						if(empty($option->required))
						{
							$option->required = false;
						}
					?>
						<div id="option-<?php echo $count;?>">
							<h3><a href="#"><?php echo $option->type.' > '.$option->name; ?> </a></h3>

							<div style="text-align: left">
								<?php echo lang('option_name');?>

									<a style="float:right" onclick="remove_option(<?php echo $count ?>)" class="ui-state-default ui-corner-all" ><span class="ui-icon ui-icon-circle-minus"></span></a>

								<input class="input gc_tf2" type="text" name="option[<?php echo $count;?>][name]" value="<?php echo $option->name;?>"/>

								<input type="hidden" name="option[<?php echo $count;?>][type]" value="<?php echo $option->type;?>" />
								<input class="checkbox" type="checkbox" name="option[<?php echo $count;?>][required]" value="1" <?php echo ($option->required)?'checked="checked"':'';?>/> <?php echo lang('required');?>

								<?php if($option->type!='textarea' && $option->type!='textfield') { ?>
								<button id="add_item_<?php echo $count;?>" type="button" rel="<?php echo $option->type;?>"onclick="add_item($(this).attr('rel'), <?php echo $count;?>);"><?php echo lang('add_item');?></button>
								<?php } ?>


								<div class="option_item_form">
								<?php if($option->type!='textarea' && $option->type!='textfield') { ?><ul class="sortable" id="option_items_<?php echo $count;?>"><?php } ?>
								<?php if(!empty($option->values))
											$valcount = 0;
											foreach($option->values as $value) :
												$value = (object)$value;?>

										<?php if($option->type!='textarea' && $option->type!='textfield') { ?><li id="value-<?php echo $count;?>-<?php echo $valcount;?>"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><?php } ?>
										<div  style="margin:2px"><span><?php echo lang('name');?> </span><input class="req gc_tf2" type="text" name="option[<?php echo $count;?>][values][<?php echo $valcount ?>][name]" value="<?php echo $value->name ?>" />

										<span><?php echo lang('value');?> </span><input class="req gc_tf2" type="text" name="option[<?php echo $count;?>][values][<?php echo $valcount ?>][value]" value="<?php echo $value->value ?>" />
										<span><?php echo lang('weight');?> </span><input class="req gc_tf2" type="text" name="option[<?php echo $count;?>][values][<?php echo $valcount ?>][weight]" value="<?php echo $value->weight ?>" />
										<span><?php echo lang('price');?> </span><input class="req gc_tf2" type="text" name="option[<?php echo $count;?>][values][<?php echo $valcount ?>][price]" value="<?php echo $value->price ?>" />
										<?php if($option->type == 'textfield'):?>

										<span><?php echo lang('limit');?> </span><input class="req gc_tf2" type="text" name="option[<?php echo $count;?>][values][<?php echo $valcount ?>][limit]" value="<?php echo $value->limit ?>" />

										<?php endif;?>
										<?php if($option->type!='textarea' && $option->type!='textfield') { ?>
										<a onclick="if(confirm('<?php echo lang('confirm_remove_value');?>')) $('#value-<?php echo $count;?>-<?php echo $valcount;?>').remove()" class="ui-state-default ui-corner-all" style="float:right;"><span class="ui-icon ui-icon-circle-minus"></span></a>
										<?php } ?>
										</div>
										<?php if($option->type!='textarea' && $option->type!='textfield') { ?>
										</li>
										<?php } ?>


								<?php	$valcount++;
								 		endforeach;  ?>
								 <?php if($option->type!='textarea' && $option->type!='textfield') { ?></ul><?php } ?>
								</div>


							</div>
						</div>

					<?php


					$count++;
					endforeach;
				endif;
				?>

				</div>
		</div>
	</div>
	<div id="gc_product_related">
		<div class="gc_field">
			<label><?php echo lang('select_a_product')?>: </label>
			<select id="product_list">
			<?php foreach($product_list as $p): if(!empty($p) && $id != $p->id):?>
				<option id="product_item_<?php echo $p->id;?>" value="<?php echo $p->id; ?>"><?php echo $p->name;?></option>
			<?php endif; endforeach;?>
			</select>

			<a href="#" onclick="add_related_product();return false;" class="button" title="Add Related Product"><?php echo lang('add_related_product');?></a>
		</div>
		<?php

		$products = array();
		foreach($product_list as $p)
		{
			$products[$p->id] = $p->name;
		}

		?>
		<table class="gc_table" cellspacing="0" cellpadding="0">
			<thead>
				<tr>
					<th class="gc_cell_left"><?php echo lang('product_name');?></th>
					<th class="gc_cell_right"></th>
				</tr>
			</thead>
			<tbody id="product_items_container">
			<?php if(!empty($related_products)):foreach($related_products as $rel): if(!empty($rel)) :?>
				<?php
					if(array_key_exists($rel, $products))
					{
						echo related_items($rel, $products[$rel]);
					}
				?>
			<?php endif; endforeach; endif;?>
			</tbody>
		</table>
	</div>
	<div id="gc_product_photos">
		<div class="gc_segment_content">
			<iframe src="<?php echo site_url($this->config->item('admin_folder').'/products/product_image_form');?>" style="height:75px; border:0px;">
			</iframe>
			<div id="gc_photos">
			<?php

			foreach($images as $photo_id=>$photo_obj)
			{
				if(!empty($photo_obj))
				{
					$photo = (array)$photo_obj;
					add_image($photo_id, $photo['filename'], $photo['alt'], $photo['caption'], isset($photo['primary']));
				}

			}
			?>
			</div>
		</div>
	</div>
	<!-- Distribution Tab -->
	<div id="gc_product_distribution">
 <table cellpadding="0" cellspacing="0" width="50%" >
 		<tr style="height:30px;">
 			<td>Product Quantity:</td>
 			<td><input type="text" value=1000 id="prodQty" style="text-align: right;">&nbsp;on hand</td>
		</tr>
		<tr style="height:30px;">
			<td>Distribution Period:</td>
			<td><input type="text" value=3 id="distPeriod" style="text-align: right;">&nbsp;months</td>
        </tr>
 		<tr style="height:30px;">
 			<td></td>
 			<td><span style="color:red; text-align: right;	font-weight:bold;" id="prodPerMonth"></span>&nbsp;Products to be distributed per month.</td>
        </tr>
 </table>

		<table cellpadding="0" cellspacing="0" class="stripeTable" width="100%">
			<col class="col0">
			<col class="col0">
			<col class="col1">
			<col class="col0">
			<col class="col1">
			<col class="col0">
			<col class="col1">
			<col class="col0">
			<col class="col1">
			<col class="colQtyRounded">
			<col class="col1">
			<thead>
				<tr>
					<th style="width:6%;"></th>
					<th style="width:12%;">Categories</th>
					<th style="width:10%;"># of Customers</th>
					<th style="width:25%;" colspan="3">Relative Weight Factor</th>
					<th style="width:10%;">Ext #</th>
					<th style="width:10%;">% Weight</th>
					<th style="width:9%;">Qty</th>
					<th style="width:9%;">Qty Rounded</th>
					<th style="width:9%;">Qty Total</th>
				</tr>
				<tr>
					<th style="width:17%;" colspan="2">
						<select id="standard-dropdown" name="standard-dropdown" class="custom-class1 custom-class2" style="width: 190px;">
							<option value="0" class="test-class-1" selected="selected">Select a Profile...</option>
						</select>
					</th>
					<th style="width:10%;"></th>
					<th><input type="checkbox" id="fact-Global">Global</th>
					<th><input type="checkbox" id="fact-Specific">Specific</th>
					<th><input type="checkbox" id="fact-Custom">Custom</th>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<tr class="CheckBox-B">
					<td><input type="checkbox" id="Cat-A">A</td>
				</tr>
				<tr class="bg0 stripeRow">
					<td class="chk"></td>
					<td class="year"><input type="checkbox" class="SubCat-A SubCat-Check"  id="A-1">A-1</td>
					<td class="qtr-1" style="text-align: right;"> <div contenteditable onblur="recalculate();">20</div></td>
					<td class="factor-global" style=" text-align: center;">1</td>
					<td class="factor-specific" style=" text-align: center;">1</td>
					<td class="factor-custom" style=" text-align: center;" > <div class="factorEdit"  id="factor-custom-A-1">12</div><input type="text" value="" class="textEdit"/></td>
					<td class="ext" style="text-align: right;"></td>
					<td class="pct" style=" text-align: right;"></td>
					<td class="qty" style=" text-align: right;"></td>
					<td class="qty-round" style=" text-align: right;"></td>
					<td class="qty-ext" style=" text-align: right;"></td>
				</tr>
				<tr class="bg1 stripeRow">
					<td class="chk"></td>
					<td class="year"><input type="checkbox" class="SubCat-A SubCat-Check"  id="A-2">A-2</td>
					<td class="qtr-1" style=" text-align: right;"><div contenteditable onblur="recalculate();">80</div></td>
					<td class="factor-global" style=" text-align: center;">1</td>
					<td class="factor-specific" style=" text-align: center;">1</td>
					<td class="factor-custom" style=" text-align: center;" > <div  class="factorEdit" id="factor-custom-A-2">3.8</div><input type="text" value="" class="textEdit"/></td>
					<td class="ext" style="text-align: right;"></td>
					<td class="pct" style=" text-align: right;"></td>
					<td class="qty" style=" text-align: right;"></td>
					<td class="qty-round" style=" text-align: right;"></td>
					<td class="qty-ext" style=" text-align: right;"></td>
				</tr>
				<tr class="CheckBox-B">
					<td><input type="checkbox" id="Cat-B">B</td>
				</tr>
				<tr class="bg0 stripeRow">
					<td class="chk"></td>
					<td class="year"><input type="checkbox" class="SubCat-B SubCat-Check"  id="B-1">B-1</td>
					<td class="qtr-1" style=" text-align: right;"> <div contenteditable onblur="recalculate();">263</div></td>
					<td class="factor-global" style=" text-align: center;">1</td>
					<td class="factor-specific" style=" text-align: center;">1</td>
					<td class="factor-custom" style=" text-align: center;"  id="factor-custom-B-1"> <div class="factorEdit">1</div><input type="text" value="" class="textEdit"/></td>
					<td class="ext" style="text-align: right;"></td>
					<td class="pct" style=" text-align: right;"></td>
					<td class="qty" style=" text-align: right;"></td>
					<td class="qty-round" style=" text-align: right;"></td>
					<td class="qty-ext" style=" text-align: right;"></td>
				</tr>
				<tr class="bg1 stripeRow">
					<td class="chk"></td>
					<td class="year"><input type="checkbox" class="SubCat-B SubCat-Check"  id="B-2">B-2</td>
					<td class="qtr-1" style=" text-align: right;"><div contenteditable onblur="recalculate();">287</div></td>
					<td class="factor-global"style=" text-align: center;" >1</td>
					<td class="factor-specific" style=" text-align: center;">1</td>
					<td class="factor-custom" style=" text-align: center;" id="factor-custom-B-2" > <div class="factorEdit">1</div><input type="text" value="" class="textEdit"/></td>
					<td class="ext" style="text-align: right;"></td>
					<td class="pct" style=" text-align: right;"></td>
					<td class="qty" style=" text-align: right;"></td>
					<td class="qty-round" style=" text-align: right;"></td>
					<td class="qty-ext" style=" text-align: right;"></td>
				</tr>
				<tr class="bg0 stripeRow">
					<td class="chk"></td>
					<td class="year"><input type="checkbox" class="SubCat-B SubCat-Check" id="B-3">B-3</td>
					<td class="qtr-1" style=" text-align: right;"  contenteditable="true" onblur="recalculate();">62</td>
					<td class="factor-global" style=" text-align: center;">1.5</td>
					<td class="factor-specific" style=" text-align: center;">1</td>
					<td class="factor-custom" style=" text-align: center;"  id="factor-custom-B-3"> <div class="factorEdit">1</div><input type="text" value="" class="textEdit"/></td>
					<td class="ext" style="text-align: right;"></td>
					<td class="pct" style=" text-align: right;"></td>
					<td class="qty" style=" text-align: right;"></td>
					<td class="qty-round" style=" text-align: right;"></td>
					<td class="qty-ext" style=" text-align: right;"></td>
				</tr>
				<tr class="bg1 stripeRow">
					<td class="chk"></td>
					<td class="year"><input type="checkbox" class="SubCat-B SubCat-Check" id="B-4">B-4</td>
					<td class="qtr-1"  style=" text-align: right;"  contenteditable="true" onblur="recalculate();">33</td>
					<td class="factor-global" style=" text-align: center;">2</td>
					<td class="factor-specific" style=" text-align: center;">1</td>
					<td class="factor-custom" style=" text-align: center;"  id="factor-custom-B-4"> <div class="factorEdit">1</div><input type="text" value="" class="textEdit"/></td>
					<td class="ext" style="text-align: right;"></td>
					<td class="pct" style=" text-align: right;"></td>
					<td class="qty" style=" text-align: right;"></td>
					<td class="qty-round" style=" text-align: right;"></td>
					<td class="qty-ext" style=" text-align: right;"></td>
				</tr>
				<tr class="CheckBox-C">
					<td><input type="checkbox" id="Cat-C">C</td>
				</tr>
				<tr class="bg1 stripeRow">
					<td class="chk"></td>
					<td class="year"><input type="checkbox" class="SubCat-C SubCat-Check"  id="C-1">C-1</td>
					<td class="qtr-1" style=" text-align: right;"  contenteditable="true" onblur="recalculate();">5</td>
					<td class="factor-global" style=" text-align: center;">2</td>
					<td class="factor-specific" style=" text-align: center;">1</td>
					<td class="factor-custom" style=" text-align: center;"  id="factor-custom-C-1"> <div class="factorEdit">1</div><input type="text" value="" class="textEdit"/></td>
					<td class="ext" style="text-align: right;"></td>
					<td class="pct" style=" text-align: right;"></td>
					<td class="qty" style=" text-align: right;"></td>
					<td class="qty-round" style=" text-align: right;"></td>
					<td class="qty-ext" style=" text-align: right;"></td>
				</tr>
				<tr class="bg0 stripeRow">
					<td class="chk"></td>
					<td class="year"><input type="checkbox" class="SubCat-C SubCat-Check" id="C-2">C-2</td>
					<td class="qtr-1"  style=" text-align: right;"  contenteditable="true" onblur="recalculate();">8</td>
					<td class="factor-global" style=" text-align: center;">2.5</td>
					<td class="factor-specific" style=" text-align: center;">1</td>
					<td class="factor-custom" style=" text-align: center;"  id="factor-custom-C-2"> <div class="factorEdit">1</div><input type="text" value="" class="textEdit"/></td>
					<td class="ext" style="text-align: right;"></td>
					<td class="pct" style=" text-align: right;"></td>
					<td class="qty" style=" text-align: right;"></td>
					<td class="qty-round" style=" text-align: right;"></td>
					<td class="qty-ext" style=" text-align: right;"></td>
				</tr>
				<tr class="bg1 stripeRow">
					<td class="chk"></td>
					<td class="year"><input type="checkbox" class="SubCat-C SubCat-Check" id="C-3">C-3</td>
					<td class="qtr-1"  style=" text-align: right;"  contenteditable="true" onblur="recalculate();">5</td>
					<td class="factor-global" style=" text-align: center;">3</td>
					<td class="factor-specific" style=" text-align: center;">1</td>
					<td class="factor-custom" style=" text-align: center;"  id="factor-custom-C-3"> <div class="factorEdit">1</div><input type="text" value="" class="textEdit"/></td>
					<td class="ext" style="text-align: right;"></td>
					<td class="pct" style=" text-align: right;"></td>
					<td class="qty" style=" text-align: right;"></td>
					<td class="qty-round" style=" text-align: right;"></td>
					<td class="qty-ext" style=" text-align: right;"></td>
				</tr>
				<tr class="bg0 stripeRow">
					<td class="chk"></td>
					<td class="year"><input type="checkbox" class="SubCat-C SubCat-Check" id="C-4">C-4</td>
					<td class="qtr-1"  style=" text-align: right;"  contenteditable="true" onblur="recalculate();">5</td>
					<td class="factor-global" style=" text-align: center;">3.5</td>
					<td class="factor-specific" style=" text-align: center;">1</td>
					<td class="factor-custom" style=" text-align: center;"  id="factor-custom-C-4"> <div class="factorEdit">1</div><input type="text" value="" class="textEdit"/></td>
					<td class="ext" style="text-align: right;"></td>
					<td class="pct" style=" text-align: right;"></td>
					<td class="qty" style=" text-align: right;"></td>
					<td class="qty-round" style=" text-align: right;"></td>
					<td class="qty-ext" style=" text-align: right;"></td>
				</tr>
			</tbody>
		</table>
		<table cellpadding="0" cellspacing="0" class="stripeTable" width="100%">
			<thead>
				<tr>
					<th style="width:18%;" colspan="2"></th>
					<th style="width:10%;"><div id="div-CustTot" style="text-align: right;"></div></th>
					<th style="width:25%;" colspan="3">Relative Weight Factor</th>
					<th style="width:10%;"><div id="div-extTot" style="text-align: right;"></div></th>
					<th style="width:10%;"><div id="div-pctTot" style="text-align: right;"></div></th>
					<th style="width:9%;" style=" text-align: right;"></th>
					<th style="width:9%;"><div style="color:red; text-align: right;	font-weight:bold;" id="prodPerMonthDisplay">123</div></th>
					<th style="width:9%;"><div id="div-qtyTot" style="text-align: right;"></div></th>
				</tr>
			</thead>
		</table>


	</div>
	<!-- Distribution Tab End -->
</div>

</form>

<?php
function add_image($photo_id, $filename, $alt, $caption, $primary=false)
{	ob_start();
	?>
	<div class="gc_photo" id="gc_photo_<?php echo $photo_id;?>">
		<table cellspacing="0" cellpadding="0">
			<tr>
				<td style="width:81px;padding-right:10px;" rowspan="2">
					<input type="hidden" name="images[<?php echo $photo_id;?>][filename]" value="<?php echo $filename;?>"/>
					<img class="gc_thumbnail" src="<?php echo base_url('uploads/images/thumbnails/'.$filename);?>"/>
				</td>
				<td>
					<input type="radio" name="primary_image" value="<?php echo $photo_id;?>" <?php if($primary) echo 'checked="checked"';?>/> <?php echo lang('primary');?>

					<a onclick="return remove_image($(this));" rel="<?php echo $photo_id;?>" class="button" style="float:right; font-size:9px;"><?php echo lang('remove');?></a>
				</td>
			</tr>
			<tr>
				<td>
					<table>
						<tr>
							<td><?php echo lang('alt_tag');?></td>
							<td><input name="images[<?php echo $photo_id;?>][alt]" value="<?php echo $alt;?>" class="gc_tf2"/></td>
						</tr>
						<tr>
							<td><?php echo lang('caption');?></td>
							<td><textarea name="images[<?php echo $photo_id;?>][caption]"><?php echo $caption;?></textarea></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
	<?php
	$stuff = ob_get_contents();

	ob_end_clean();

	echo replace_newline($stuff);
}

function add_option($name, $option_id, $type)
{
	ob_start();
	?>
	<div id="option-<?php echo $option_id;?>">
		<h3><a href="#"><?php echo $type.' > '.$name; ?></a></h3>
		<div style="text-align: left">
			<?php echo lang('option_name');?>
			<span style="float:right">

			<a onclick="remove_option(<?php echo $option_id ?>)" class="ui-state-default ui-corner-all" style="float:right;"><span class="ui-icon ui-icon-circle-minus"></span></a></span>
			<input class="input gc_tf1" type="text" name="option[<?php echo $option_id;?>][name]" value="<?php echo $name;?>"/>
			<input type="hidden" name="option[<?php echo $option_id;?>][type]" value="<?php echo $type;?>" />
			<input class="checkbox" type="checkbox" name="option[<?php echo $option_id;?>][required]" value="1"/> <?php echo lang('required');?>


			<button id="add_item_<?php echo $option_id;?>" type="button" rel="<?php echo $type;?>"onclick="add_item($(this).attr(\'rel\'), <?php echo $option_id;?>);"><?php echo lang('add_item');?></button>

			<div class="option_item_form" >
				<ul class="sortable" id="option_items_<?php echo $option_id;?>">

				</ul>
			</div>
		</div>
	</div>
	<?php
	$stuff = ob_get_contents();

	ob_end_clean();

	echo replace_newline($stuff);
}
//this makes it easy to use the same code for initial generation of the form as well as javascript additions
function replace_newline($string) {
  return (string)str_replace(array("\r", "\r\n", "\n", "\t"), ' ', $string);
}
?>
<script type="text/javascript">
//<![CDATA[

var option_count	= $('#options_accordion>h3').size();

var count = <?php echo $count;?>;

function add_related_product()
{

	//if the related product is not already a related product, add it
	if($('#related_product_'+$('#product_list').val()).length == 0 && $('#product_list').val() != null)
	{
		<?php $new_item	 = str_replace(array("\n", "\t", "\r"),'',related_items("'+$('#product_list').val()+'", "'+$('#product_item_'+$('#product_list').val()).html()+'"));?>
		var related_product = '<?php echo $new_item;?>';
		$('#product_items_container').append(related_product);
		$('.list_buttons').buttonset();
	}
	else
	{
		if($('#product_list').val() == null)
		{
			alert('<?php echo lang('alert_select_product');?>');
		}
		else
		{
			alert('<?php echo lang('alert_product_related');?>');
		}
	}
}

function remove_related_product(id)
{
	if(confirm('<?php echo lang('confirm_remove_related');?>?'))
	{
		$('#related_product_'+id).remove();
	}
}

function photos_sortable()
{
	$('#gc_photos').sortable({
		handle : '.gc_thumbnail',
		items: '.gc_photo',
		axis: 'y',
		scroll: true
	});
}

//]]>
</script>


<?php
function related_items($id, $name) {
	return '
			<tr id="related_product_'.$id.'" class="gc_row">
				<td class="gc_cell_left" >
					<input type="hidden" name="related_products[]" value="'.$id.'"/>
					'.$name.'</td>
				<td class="gc_cell_right list_buttons">
					<a href="#" onclick="remove_related_product('.$id.'); return false;">'.lang('remove').'</a>
				</td>
			</tr>
		';
 } ?>
<?php include('footer.php'); ?>
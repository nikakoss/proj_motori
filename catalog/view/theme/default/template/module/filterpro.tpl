<?php if($tags || $categories || $options || $manufacturers || $attributes || $price_slider) { ?>
<div class="blockSidebar">
            <div class="blockSidebarTitle">
			<div class="clear_filter"><a><?php echo $clear_filter?></a></div>
                <h3>Фильтры</h3>
			 </div>
<div class="blockSidebarContent">
<form id="filterpro">
<div <?php if(!$instock_visible) echo 'style="display:none"'; ?> >
	<input <?php if(!$instock_visible) echo 'style="display:none"'; ?> type="checkbox" class="filtered" name="instock" id="instock" <?php if($instock_checked) echo 'checked="checked"'; ?>><label for="instock"><?php echo $text_instock?></label>
</div>


	<?php if($manufacturers) { ?>
	<?php foreach($manufacturers as $manufacturer) { ?>
	<input type="hidden" class="m_name" id="m_<?php echo $manufacturer['manufacturer_id']?>" value="<?php echo $manufacturer['name']?>">
		<?php } ?>
	<?php } ?>

	<?php if($options) { ?>
	<?php foreach($options as $option) { ?>
		<?php foreach($option['option_values'] as $option_value) { ?>
		<input type="hidden" class="o_name" id="o_<?php echo $option_value['option_value_id']?>" value="<?php echo $option_value['name']?>">
			<?php } ?>
		<?php } ?>
	<?php } ?>
	<?php if($category_id !== false) { ?>
		<input type="hidden" name="category_id" value="<?php echo $category_id ?>">
	<?php } ?>
	<?php if(isset($manufacturer_id)) { ?>
		<input type="hidden" name="manufacturer_id" value="<?php echo $manufacturer_id ?>">
	<?php }?>
<input type="hidden" name="page" id="filterpro_page" value="0">
<input type="hidden" name="path" value="<?php echo $path ?>">
<input type="hidden" name="sort" id="filterpro_sort" value="">
<input type="hidden" name="order" id="filterpro_order" value="">
<input type="hidden" name="limit" id="filterpro_limit" value="">

<div class="price_slider" <?php if(!$price_slider) { echo 'style="display:none"';}?>>
		<div id="slider-range"></div>

  <div class="filterPrice">

                        <div class="limitedValue clearfix"><div class="valueMin">&nbsp; </div><div class="valueMax">&nbsp; </div></div>
                        <label><span>от </span><input class="textInputs" type="text" name="min_price" value="-1" id="min_price"/></label>
                        <label><span>до </span><input class="textInputs" type="text" name="max_price" value="-1" id="max_price"/></label>
                    </div>
	
	
	
	
	
	
	
	
</div>

	<?php if($categories) { ?>

<div class="inputForm">

	<div class="inputFormTitle"><?php echo $text_categories; ?></div>
			<?php foreach($categories as $category) { ?>
	
	<input id="cat_<?php echo $category['category_id']; ?>" class="filtered"  type="checkbox" name="categories[]"
						   value="<?php echo $category['category_id']; ?>">
	<label for="cat_<?php echo $category['category_id']; ?>" class="labelCheckbox"><?php echo $category['name']; ?> </label>

                        
	
			<?php } ?>
                     
	</div>

	<?php } ?>

	<?php if($manufacturers) { ?>
	<div class="inputForm">
	<div class="inputFormTitle"><?php echo $text_manufacturers; ?></div>
		<?php if($display_manufacturer == 'select') { ?>
		<div>
			<select name="manufacturer[]" class="filtered">
				<option value=""><?php echo $text_all?></option>
				<?php foreach($manufacturers as $manufacturer) { ?>
				<option id="manufacturer_<?php echo $manufacturer['manufacturer_id']?>" class="manufacturer_value"
						value="<?php echo $manufacturer['manufacturer_id']?>"><?php echo $manufacturer['name']?></option>
				<?php } ?>
			</select>
		</div>
		<?php } elseif($display_manufacturer == 'checkbox') { ?>
	
			<?php foreach($manufacturers as $manufacturer) { ?>
			
					<input id="manufacturer_<?php echo $manufacturer['manufacturer_id']?>" class="manufacturer_value filtered"
						   type="checkbox" name="manufacturer[]"
						   value="<?php echo $manufacturer['manufacturer_id']?>">
				
					<label class="labelCheckbox" for="manufacturer_<?php echo $manufacturer['manufacturer_id']?>"><?php echo $manufacturer['name']?></label>
				
			<?php } ?>
		<?php } elseif($display_manufacturer == 'radio') { ?>
	
			<?php foreach($manufacturers as $manufacturer) { ?>
			
					<input id="manufacturer_<?php echo $manufacturer['manufacturer_id']?>" class="manufacturer_value filtered"
						   type="radio" name="manufacturer[]"
						   value="<?php echo $manufacturer['manufacturer_id']?>">
				
					<label class="labelRadio" for="manufacturer_<?php echo $manufacturer['manufacturer_id']?>"><?php echo $manufacturer['name']?></label>
		
			<?php } ?>
		
		<?php }?>
	</div>
	<?php } ?>
	
	<?php if($attributes) { ?>
	<?php foreach($attributes as $attribute_group_id => $attribute) { ?>


		<?php foreach($attribute['attribute_values'] as $attribute_value_id => $attribute_value) { ?>
	<div class="inputForm">

			<div class="inputFormTitle"><?php echo $attribute_value['name']; ?></div>
		
				<?php if($attribute_value['display'] == 'select') { ?>
				<div>
					<select class="filtered" name="attribute_value[<?php echo $attribute_value_id?>][]">
						<option value=""><?php echo $text_all?></option>
						<?php foreach($attribute_value['values'] as $i => $value) { ?>
						<option class="a_name"
								at_v_i="<?php echo $attribute_value_id . '_' . $value ?>"
								at_v_t="<?php echo $attribute_value_id . '_' . htmlspecialchars(preg_replace('/\s+|\n|\r|\s+$/m', '_', $value)) ?>"
								data-value="<?php echo $value ?>"
								value="<?php echo $value ?>"><?php echo $value ?></option>
						<?php }?>
					</select>
				</div>
				<?php } elseif($attribute_value['display'] == 'checkbox') { ?>
				
					<?php foreach($attribute_value['values'] as $i => $value) { ?>
					
							<input class="filtered a_name"
								   id="attribute_value_<?php echo $attribute_value_id . $i; ?>"
								   type="checkbox" name="attribute_value[<?php echo $attribute_value_id?>][]"
								   at_v_i="<?php echo $attribute_value_id . '_' . htmlspecialchars($value); ?>"
								   value="<?php echo $value ?>">
					
							<label class="labelCheckbox" for="attribute_value_<?php echo $attribute_value_id . $i; ?>"
								   at_v_t="<?php echo $attribute_value_id . '_' . htmlspecialchars(preg_replace('/\s+|\n|\r|\s+$/m', '_', $value)); ?>"
								   data-value="<?php echo $value; ?>"
								   value="<?php echo $value ?>"><?php echo $value?></label>
				
					<?php } ?>
				
				<?php } elseif($attribute_value['display'] == 'radio') { ?>
			
					<?php foreach($attribute_value['values'] as $i => $value) { ?>
					
							<input class="filtered a_name"
								   id="attribute_value_<?php echo $attribute_value_id . $i; ?>"
								   type="radio" name="attribute_value[<?php echo $attribute_value_id?>][]"
								   at_v_i="<?php echo $attribute_value_id . '_' . $value ?>"
								   value="<?php echo $value ?>">
						
							<label class="labelRadio" for="attribute_value_<?php echo $attribute_value_id . $i; ?>"
								   at_v_t="<?php echo $attribute_value_id . '_' . htmlspecialchars(preg_replace('/\s+|\n|\r|\s+$/m', '_', $value)) ?>"
								   data-value="<?php echo $value ?>"
								   value="<?php echo $value ?>"><?php echo $value?></label>
					
					<?php } ?>
				
				<?php } ?>

	
		</div>
		<?php } ?>

		<?php } ?>
	<?php } ?>

	<?php if($options) { ?>
	
	<?php foreach($options as $option) { ?>
<div class="inputForm">
		<div class="inputFormTitle"><?php echo $option['name']; ?></div>
		<?php if($option['display'] == 'select') { ?>
		
			<select class="filtered" name="option_value[<?php echo $option['option_id']?>][]">
				<option value=""><?php echo $text_all?></option>
				<?php foreach($option['option_values'] as $option_value) { ?>
				<option class="option_value" id="option_value_<?php echo $option_value['option_value_id']?>"
						value="<?php echo $option_value['option_value_id'] ?>"><?php echo $option_value['name']?></option>
				<?php }?>
			</select>
		
		<?php } elseif($option['display'] == 'checkbox') { ?>
	
			<?php foreach($option['option_values'] as $option_value) { ?>
		
					<input class="filtered option_value" id="option_value_<?php echo $option_value['option_value_id']?>"
						   type="checkbox" name="option_value[<?php echo $option['option_id']?>][]"
						   value="<?php echo $option_value['option_value_id']?>">
			
					<label class="labelCheckbox" for="option_value_<?php echo $option_value['option_value_id']?>"><?php echo $option_value['name']?></label>
		
			<?php } ?>
	
		<?php } elseif($option['display'] == 'radio') { ?>
		
			<?php foreach($option['option_values'] as $option_value) { ?>
	
					<input class="filtered option_value" id="option_value_<?php echo $option_value['option_value_id']?>"
						   type="radio" name="option_value[<?php echo $option['option_id']?>][]"
						   value="<?php echo $option_value['option_value_id']?>">
				
					<label class="labelRadio" for="option_value_<?php echo $option_value['option_value_id']?>"><?php echo $option_value['name']?></label>
		
			<?php } ?>

		<?php } elseif($option['display'] == 'image') { ?>
		<div class="collapsible" <?php if(!$option['expanded']) { echo 'style="display:none"'; }?>>
			<?php foreach($option['option_values'] as $option_value) { ?>

					<input style="display: none;" class="filtered option_value" id="option_value_<?php echo $option_value['option_value_id']?>"
						   type="checkbox" name="option_value[<?php echo $option['option_id']?>][]"
						   value="<?php echo $option_value['option_value_id']?>">
					<img src="<?php echo $option_value['thumb'];?>"/>

			<?php } ?>
		</div>
		<?php }?>
</div>
		<?php } ?>

	<?php } ?>


</form>

</div>

</div>
<?php } ?>
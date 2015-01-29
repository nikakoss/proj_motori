<?php 

print_r($this->request->post);
//print_r($this->config->get('price_product'));
echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>

  <div class="box">
    <div class="heading">
      <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">

        <table id="module" class="list">
          <thead>
            <tr>
              <td class="left">название</td>
              <td class="left">ссылка</td>
			 <td class="left"></td>
            </tr>
          </thead>
          <?php $module_row = 0; ?>
		   <?php if($modules) { ?>
          <?php foreach ($modules as $module) { ?>
          <tbody id="module-row<?php echo $module_row; ?>">
            <tr>
              <td class="left"><input type="text" name="price_product[<?php echo $module_row; ?>][name]" value="<?php echo $module['name']; ?>" size="50" /></td>
				<td class="left"><input type="text" name="price_product[<?php echo $module_row; ?>][link]" value="<?php echo $module['link']; ?>" size="50" /></td>

              <td class="left"><a onclick="$('#module-row<?php echo $module_row; ?>').remove();" class="button"><?php echo $button_remove; ?></a></td>
            </tr>
          </tbody>
          <?php $module_row++; ?>
          <?php } ?>
		   <?php } ?>
          <tfoot>
            <tr>
              <td colspan="2"></td>
              <td class="left"><a onclick="addModule();" class="button"><?php echo $button_add_module; ?></a></td>
            </tr>
          </tfoot>
        </table>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
var module_row = <?php echo $module_row; ?>;

function addModule() {	
	html  = '<tbody id="module-row' + module_row + '">';
	html += '  <tr>';
	html += '    <td class="left"><input type="text" name="price_product[' + module_row + '][name]" value="5" size="50" /></td>';
	html += '    <td class="left"><input type="text" name="price_product[' + module_row + '][link]" value="5" size="50" /></td>';
	html += '    <td class="left"><a onclick="$(\'#module-row' + module_row + '\').remove();" class="button"><?php echo $button_remove; ?></a></td>';
	html += '  </tr>';
	html += '</tbody>';
	
	$('#module tfoot').before(html);
	
	module_row++;
}
//--></script> 
<?php echo $footer; ?>
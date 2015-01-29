<?php 
class ControllerInformationPrice extends Controller {
	public function index() {  
    	$this->language->load('information/price'); 

      	$this->data['heading_title'] = $this->language->get('heading_title');
        $this->document->setTitle($this->language->get('heading_title'));
		
		$this->data['button_cart'] = $this->language->get('button_cart');
        $this->data['text_download'] = $this->language->get('text_download');
        
        $this->data['breadcrumbs'] = array();
		
      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
        	'separator' => false
      	);
        $this->data['breadcrumbs'][] = array(
    		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('information/price'),      		
    		'separator' => $this->language->get('text_separator')
      		);
		
		$this->load->model('catalog/product'); 
		
		$this->load->model('tool/image');

		$this->data['products'] = array();

		//$products = explode(',', $this->config->get('price_product'));		
$products = $this->config->get('price_product');		
		$setting = $this->config->get('price_module');
        $setting = $setting[0];
		
		$products = array_slice($products, 0);
		$this->data['products']=$this->config->get('price_product');
		foreach ($products as $product_id) {
			$product_info = $this->model_catalog_product->getProduct($product_id);
			
			if ($product_info) {
				if ($product_info['image']) {
					$image = $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
				} else {
					$image = false;
				}

				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$price = false;
				}
						
				if ((float)$product_info['special']) {
					$special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$special = false;
				}
				
				if ($this->config->get('config_review_status')) {
					$rating = $product_info['rating'];
				} else {
					$rating = false;
				}
					
				/*$this->data['products'][] = array(
					'product_id' => $product_info['product_id'],
					'thumb'   	 => $image,
					'name'    	 => $product_info['name'],
					'price'   	 => $price,
					'special' 	 => $special,
                    'description' => utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, 250) . '..',
					'rating'     => $rating,
					'reviews'    => sprintf($this->language->get('text_reviews'), (int)$product_info['reviews']),
					'href'    	 => $this->url->link('product/product', 'product_id=' . $product_info['product_id']),
				); */
			}
		}
        
        $this->data['link_to_price'] = $this->url->link('information/price/download');
			
            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/price.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/information/price.tpl';
			} else {
				$this->template = 'default/template/information/price.tpl';
			}
            
			$this->children = array(
				'common/column_left',
				'common/column_right',
				'common/content_top',
				'common/content_bottom',
				'common/footer',
				'common/header'
			);
						
	  		$this->response->setOutput($this->render());
    	
  	}
    
    public function download() {
            $file = DIR_DOWNLOAD . $this->config->get('price_filename');
			$mask = basename($this->config->get('price_mask'));

			if (!headers_sent()) {
				if (file_exists($file)) {
					header('Content-Type: application/octet-stream');
					header('Content-Description: File Transfer');
					header('Content-Disposition: attachment; filename="' . ($mask ? $mask : basename($file)) . '"');
					header('Content-Transfer-Encoding: binary');
					header('Expires: 0');
					header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					header('Pragma: public');
					header('Content-Length: ' . filesize($file));
					
					readfile($file, 'rb');
					
					exit;
				} else {
					exit('Error: Could not find file ' . $file . '!');
				}
			} else {
				exit('Error: Headers already sent out!');
			}
		
	}
	
	
}
?>
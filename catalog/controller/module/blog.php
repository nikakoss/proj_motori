<?php
/* All rights reserved belong to the module, the module developers http://opencartadmin.com */
// http://opencartadmin.com � 2011-2013 All Rights Reserved
// Distribution, without the author's consent is prohibited
// Commercial license
class ControllerModuleBlog extends Controller
{
	protected function router() {

		if ($this->registry->get("fseoblog") != 1) {
			$this->getChild('common/seoblog');
			$this->registry->set("fseoblog", 1);

			if ($this->flag == 'search' || $this->flag == 'record' || $this->flag == 'blog') {
				if ($this->registry->get("fblogwork") != 1) {
					$this->registry->set("fblogwork", 1);
					$this->response->setOutput($this->getChild('record/'.$this->flag));
					$this->response->output();
					$this->registry->set("fblogwork", 0);
					exit();
				}
			}
		}
	}

	protected function fixed() {
      // error in opencart (Hey, Daniel, really had a hard paste the code below in the index.php ;) ) with constant HTTP_SERVER and request www and without www, ajax requests do not work correctly
		if (isset($_SERVER["HTTP_HOST"]) && $_SERVER["HTTP_HOST"]!="") {
			$host = $_SERVER["HTTP_HOST"];
			if (substr($host, -1)!='/') $host.="/";

  			if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
				if (HTTPS_SERVER!=$host) {

					if (substr($host, 0, 5)!='https') $host = "https://".$host;

					$this->config->set('config_ssl', $host);
				}
			}
			else {
				if (substr($host, 0, 4)!='http') $host = "http://".$host;
				if (HTTP_SERVER!=$host) {
					$this->config->set('config_url', HTTP_SERVER);
				}
			}

        }

	}

	protected function index($arg)
	{

      	$this->fixed();


		if ($this->config->get("loader_old")) {
         // $this->registry->set('load', $this->config->get("loader_old"));
		}

		$loader_old = $this->registry->get('load');
		//$this->config->set("loader_old", $loader_old );
		$this->load->library('agoo/loader');
		$agooloader = new agooLoader($this->registry);
		$this->registry->set('load', $agooloader);

		$cacher_old = $this->registry->get('cache');
		$this->load->library('agoo/cache');
		$cacher = new agooCache($this->registry);
		$this->registry->set('cache', $cacher);

		$this->load->library('agoo/image');

        $this->router();

		$this->config->set("blog_work", true );
        $html = "";


		if ($this->config->get('generallist') != '') {
			$this->data['settings_general'] = $this->config->get('generallist');
		} //$this->config->get('generallist') != ''
		else {
			$this->data['settings_general'] = Array();
		}
		if (!isset($this->data['settings_general']['colorbox_theme'])) {
			$this->data['settings_general']['colorbox_theme'] = 0;
		} //!isset($this->data['settings_general']['colorbox_theme'])

        if (isset($this->data['settings_general']['get_pagination']))
        $get_pagination = $this->data['settings_general']['get_pagination'];
        else
        $get_pagination = 'tracking';

		$this->data['imagebox'] = $this->ColorboxLoader($this->data['settings_general']['colorbox_theme']);


		$this->load->model('setting/setting');
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$settings_admin = $this->model_setting_setting->getSetting('blogadmin', 'https_admin_path');
		} //isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))
		else {
			$settings_admin = $this->model_setting_setting->getSetting('blogadmin', 'http_admin_path');
		}
		foreach ($settings_admin as $key => $value) {
			$this->data['admin_path'] = $value;
		} //$settings_admin as $key => $value

		$position_block = $arg['position'];

		$this->language->load('module/blog');
		$this->data['button_continue'] = $this->language->get('button_continue');
		$template                      = '/template/agoodonut/widgets/blogs/blog.tpl';
		if (isset($this->request->get['blog_id'])) {
			$parts                   = explode('_', (string) $this->request->get['blog_id']);
			$this->data['blog_path'] = $this->request->get['blog_id'];
		} //isset($this->request->get['blog_id'])
		else {
			$parts                   = array();
			$this->data['blog_path'] = 0;
		}
		if (isset($parts[0])) {
			$this->data['blog_id'] = $parts[0];
		} //isset($parts[0])
		else {
			$this->data['blog_id'] = 0;
		}


		if (isset($parts[1])) {
			$this->data['child_id'] = $parts[1];
		} //isset($parts[1])
		else {
			$this->data['child_id'] = 0;
		}
		if (isset($this->request->get['route'])) {
			$route = $this->request->get['route'];
		} //isset($this->request->get['route'])
		else {
			$route = 'common/home';
		}
		$this->load->model('catalog/category');
		$this->load->model('catalog/product');
		$this->load->model('catalog/information');
		$this->load->model('design/bloglayout');
		$layout_id = false;
		if ($route == 'product/category' && isset($this->request->get['path'])) {
			$path      = explode('_', (string) $this->request->get['path']);
			$layout_id = $this->model_catalog_category->getCategoryLayoutId(end($path));
		} //$route == 'product/category' && isset($this->request->get['path'])
		if ($route == 'product/product' && isset($this->request->get['product_id'])) {
			$layout_id = $this->model_catalog_product->getProductLayoutId($this->request->get['product_id']);
		} //$route == 'product/product' && isset($this->request->get['product_id'])
		if ($route == 'information/information' && isset($this->request->get['information_id'])) {
			$layout_id = $this->model_catalog_information->getInformationLayoutId($this->request->get['information_id']);
		} //$route == 'information/information' && isset($this->request->get['information_id'])
		if ($route == 'record/blog' && isset($this->request->get['blog_id'])) {
			$path      = explode('_', (string) $this->request->get['blog_id']);
			$layout_id = $this->model_design_bloglayout->getBlogLayoutId(end($path));
		} //$route == 'record/blog' && isset($this->request->get['blog_id'])
		if ($route == 'record/record' && isset($this->request->get['record_id'])) {
			$layout_id = $this->model_design_bloglayout->getRecordLayoutId($this->request->get['record_id']);
		} //$route == 'record/record' && isset($this->request->get['record_id'])
		if (!$layout_id) {
			$layout_id = $this->model_design_layout->getLayout($route);
		} //!$layout_id
		if (!$layout_id) {
			$layout_id = $this->config->get('config_layout_id');
		} //!$layout_id

        $this->data['lang_code']=$this->config->get('config_language');

		if (!$this->registry->has('blog_position_' . $position_block)) {
			$this->registry->set('blog_position_' . $position_block, 0);
		} //!$this->registry->has('blog_position_' . $position_block)
		else {
			$pos = $this->registry->get('blog_position_' . $position_block);
			$this->registry->set('blog_position_' . $position_block, $pos + 1);
		}

		$position                = $this->registry->get('blog_position_' . $position_block);

		$this->data['position']  = $position;
		$this->data['layout_id'] = $layout_id;
		$module_data             = array();
		$this->load->model('setting/extension');
		$extensions = $this->model_setting_extension->getExtensions('module');
		foreach ($extensions as $extension) {
			$modules = $this->config->get($extension['code'] . '_module');
			if ($modules) {
				foreach ($modules as $num => $module) {
					if ($module['layout_id'] == $layout_id && $extension['code'] == 'blog' && $module['position'] == $position_block && $module['status']) {
						if ($extension['code'] != '') {
							$module_data[] = array(
								'code' => $extension['code'],
								'setting' => $module,
								'sort_order' => $module['sort_order']
							);
						} //$extension['code'] != ''
					} //$module['layout_id'] == $layout_id && $extension['code'] == 'blog' && $module['position'] == $position_block && $module['status']
				} //$modules as $num => $module
			} //$modules
		} //$extensions as $extension
		if (!function_exists('commd')) {
			function commd($a, $b)
			{
				if ($a['sort_order'] == '')
					$a['sort_order'] = 1000;
				if ($b['sort_order'] == '')
					$b['sort_order'] = 1000;
				if ($a['sort_order'] > $b['sort_order'])
					return 1;
				else
					return -1;
			}
		} //!function_exists('commd')
		if (isset($module_data) && is_array($module_data)) {
			usort($module_data, 'commd');
		} //isset($module_data) && is_array($module_data)
		$type                        = "none";
		$this->data['heading_title'] = '';
		$this->data['myblogs']       = Array();
		$this->data['mylist']        = $this->config->get('mylist');
		if (!class_exists('User')) {
			require_once(DIR_SYSTEM . 'library/user.php');
			$this->registry->set('user', new User($this->registry));
		} //!class_exists('User')



		if ($this->user->isLogged()) {
			$this->data['userLogged'] = true;
		} //$this->user->isLogged()
		else {
			$this->data['userLogged'] = false;
		}
		if (!isset($module_data[$position])) {
			$this->registry->set('blog_position_' . $position_block, 0);
			$position = 0;
		} //!isset($module_data[$position])


		if (isset($module_data[$position]['setting']['what']) && $module_data[$position]['setting']['what'] != 'what_hook') {
			$type = $this->data['mylist'][$module_data[$position]['setting']['what']]['type'];
		} //isset($module_data[$position]['setting']['what']) && $module_data[$position]['setting']['what'] != 'what_hook'


		if (isset($module_data[$position]['setting']['what']) && $module_data[$position]['setting']['what'] == 'what_hook') {
			$type = "hook";
		} //isset($module_data[$position]['setting']['what']) && $module_data[$position]['setting']['what'] == 'what_hook'



		//echo $type.$position;

		if (isset($module_data[$position]['setting']['what']) && isset($this->data['mylist'][$module_data[$position]['setting']['what']]))
			$thislist = $this->data['mylist'][$module_data[$position]['setting']['what']];
		else
			$thislist = null;

		$this->data['thislist'] = $thislist;
		$this->data['settings_widget'] = $this->data['thislist'];
		$this->registry->set('thislist', serialize($thislist));
		if (isset($module_data[$position])) {
			$this->registry->set('mylist_position', $module_data[$position]['setting']['what']);
		} //isset($module_data[$position])
		if (((isset($this->data['thislist']['visual_editor']) && isset($this->data['thislist']['comment_must']) && $this->data['thislist']['comment_must'] && $this->data['thislist']['visual_editor'])) || !isset($this->data['thislist']['visual_editor'])) {
			$this->data['visual_editor'] = true;
			$this->document->addScript('catalog/view/javascript/wysibb/jquery.wysibb.js');

			if ($this->config->get('config_language')=="en") {
				$this->document->addScript('catalog/view/javascript/wysibb/lang/en.js');
			} else {
                $scriptfile = 'view/javascript/wysibb/lang/'.$this->config->get('config_language').'.js';
				if (file_exists(DIR_APPLICATION . $scriptfile)) {
					$this->document->addScript('catalog/'.$scriptfile);
				}
			}


			$this->document->addStyle('catalog/view/javascript/wysibb/theme/default/wbbtheme.css');
			$this->document->addScript('catalog/view/javascript/blog/blog.bbimage.js');
			require_once(DIR_SYSTEM . 'library/bbcode.class.php');
			//$this->document->addScript('catalog/view/javascript/blog/rating/jquery.MetaData.js');
			$this->document->addScript('catalog/view/javascript/blog/rating/jquery.rating.js');
			$this->document->addStyle('catalog/view/javascript/blog/rating/jquery.rating.css');
		} //((isset($this->data['thislist']['visual_editor']) && $this->data['thislist']['visual_editor'])) || !isset($this->data['thislist']['visual_editor'])
		else {
			$this->data['visual_editor'] = false;
		}
		if ($this->customer->isLogged()) {
			$this->data['customer_id'] = $this->customer->getId();
		} //$this->customer->isLogged()
		else {
			$this->data['customer_id'] = '_';
		}
		if (isset($this->data['settings_general']['cache_widgets']) && $this->data['settings_general']['cache_widgets']) {
			$hash_cache        = md5(serialize($this->data['thislist']) . serialize($arg) . serialize($this->data['mylist']) . serialize($layout_id) . serialize($this->data['userLogged']) . serialize($this->data['settings_general']) . serialize($this->config->get('config_language_id')) . serialize($this->config->get('config_store_id')) . serialize($this->request->get) . serialize($this->request->post));
			$cache_name        = 'blog.module.view.' . (int) $this->config->get('config_store_id') . '.' . (int) $this->config->get('config_language_id') . $this->data['customer_id'];
			$module_view_cache = $this->cache->get($cache_name);
		} //isset($this->data['settings_general']['cache_widgets']) && $this->data['settings_general']['cache_widgets']
		else {
			$hash_cache = 0;
		}

        if (!empty($module_data) && ($type == 'treecomments')) {
         $this->document->addScript('catalog/view/javascript/blog/blog.comment.js');
        }


                $this->data['prefix'] = false;

                $prefix_str = str_replace("_","",md5(serialize($this->data['thislist'])));
                $prefix_array = preg_split('//', $prefix_str, -1, PREG_SPLIT_NO_EMPTY);
                shuffle($prefix_array);
                $this->data['prefix'] =  substr(implode($prefix_array), 0, 7);


	//   echo serialize($this->request->get) ."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$hash_cache."&nbsp;&nbsp;&nbsp;&nbsp;";


		if (!isset($module_view_cache[$hash_cache]) || (isset($thislist['cached']) && $thislist['cached']==0 )) {
           $this->data['type'] = false;

    // echo $type."-".$thislist['cached']."=".isset($module_view_cache[$hash_cache])."&nbsp;&nbsp;&nbsp;<br>";


			if (!empty($module_data) && $type == 'html') {
			$this->data['type'] = $type;


				$this->data['html']          = html_entity_decode($this->data['mylist'][$module_data[$position]['setting']['what']]['html'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');

				$html_name ="html.".md5(serialize($this->data['mylist'][$module_data[$position]['setting']['what']])).".".$this->config->get('config_language_id').".php";

		        $file = DIR_CACHE . $html_name;

		        if (!file_exists($file)) {
					$handle = fopen($file, 'w');
			    	fwrite($handle, $this->data['html'] );
			    	fclose($handle);
	            }

	            if (file_exists($file)) {
					extract($this->data);

		      		ob_start();

			  		require($file);

			  		$this->output = ob_get_contents();

		      		ob_end_clean();
		    	}

	            $this->data['html'] = $this->output;


                if (isset( $this->data['mylist'][$module_data[$position]['setting']['what']]['title_list_latest'][$this->config->get('config_language_id')]))
				$this->data['heading_title'] = $this->data['mylist'][$module_data[$position]['setting']['what']]['title_list_latest'][$this->config->get('config_language_id')];
				else
				$this->data['heading_title'] = '';


				if (isset($thislist['template']) && $thislist['template'] != '') {
					$template = '/template/agoodonut/widgets/html/' . $thislist['template'];
				} //isset($thislist['template']) && $thislist['template'] != ''
				else {
					$template = '/template/agoodonut/widgets/html/html.tpl';
				}
			} //!empty($module_data) && $type == 'html'




			if (!empty($module_data) && ($type == 'blogsall' || $type == 'blogs')) {
			$this->data['type'] = $type;
				if (isset($thislist['title_list_latest'][$this->config->get('config_language_id')])) {
					$this->data['heading_title'] = $thislist['title_list_latest'][$this->config->get('config_language_id')];
				} //isset($thislist['title_list_latest'][$this->config->get('config_language_id')])
				$this->load->model('catalog/blog');
				$this->load->model('catalog/record');
				$this->data['blogies'] = array();


				if ($type == 'blogs' || $type == 'blogsall') {
					$this->data['type'] = $type;
					$this->data['blog_link'] = $this->url->link('record/blog', 'blog_id=' . $this->data['blog_path']);
					if ($type == 'blogs' && isset($thislist['blogs'])) {




						foreach ($thislist['blogs'] as $num => $blog_id) {
							$blogies[] = $this->model_catalog_blog->getBlog($blog_id);
						} //$thislist['blogs'] as $num => $blog_id
					} //$type == 'blogs' && isset($thislist['blogs'])
					if ($type == 'blogsall') {
						$blogies = $this->model_catalog_blog->getBlogs();
					} //$type == 'blogsall'
					if (isset($blogies) && count($blogies) > 0) {
						foreach ($blogies as $blog) {
							if (isset($blog['blog_id'])) {
								$blog_info = $this->model_catalog_blog->getBlog($blog['blog_id']);
								$this->load->model('tool/image');
								if ($blog_info) {
									if ($blog_info['image']) {
										if (isset($thislist['avatar']['width']) && isset($thislist['avatar']['height']) && $thislist['avatar']['width'] != "" && $thislist['avatar']['height'] != "") {
											$thumb = $this->model_tool_image->resize($blog_info['image'], $thislist['avatar']['width'], $thislist['avatar']['height']);
										} //isset($thislist['avatar']['width']) && isset($thislist['avatar']['height']) && $thislist['avatar']['width'] != "" && $thislist['avatar']['height'] != ""
										else {
											$thumb = $this->model_tool_image->resize($blog_info['image'], 150, 150);
										}
									} //$blog_info['image']
									else {
										$thumb = '';
									}
								} //$blog_info
								else {
									$thumb = '';
								}
								$data                  = array(
									'filter_blog_id' => $blog['blog_id'],
									'filter_sub_blog' => false
								);
								$record_total          = $this->model_catalog_record->getTotalRecords($data);
								$blog_href             = $this->model_catalog_blog->getPathByblog($blog['blog_id']);





								$this->data['blogs'][] = array(
									'blog_id' => $blog['blog_id'],
									'parent_id' => $blog['parent_id'],
									'sort' => $blog['sort_order'],
									'name' => $blog['name'],
									'count' => $record_total,
									'meta' => $blog['meta_description'],
									'thumb' => $thumb,
									'href' => $this->url->link('record/blog', 'blog_id=' . $blog_href['path']),
									'path' => $blog_href['path'],
									'display' => true,
									'active' => 'none'
								);



							} //isset($blog['blog_id'])
						} //$blogies as $blog
					} //isset($blogies) && count($blogies) > 0
					if (!function_exists('compareblogs')) {
						function compareblogs($a, $b)
						{
							if ($a['sort'] > $b['sort'])
								return 1;
							if ($b['sort'] > $a['sort'])
								return -1;
							return 0;
						}
					} //!function_exists('compareblogs')
					if (!function_exists('my_sort_div_blogs')) {
						function my_sort_div_blogs($data, $parent = 0, $lev = -1)
						{
							$arr = $data[$parent];
							usort($arr, 'compareblogs');
							$lev = $lev + 1;
							for ($i = 0; $i < count($arr); $i++) {
								$arr[$i]['level']               = $lev;
								$z[]                            = $arr[$i];
								$z[count($z) - 1]['flag_start'] = 1;
								$z[count($z) - 1]['flag_end']   = 0;
								if (isset($data[$arr[$i]['blog_id']])) {
									$m = my_sort_div_blogs($data, $arr[$i]['blog_id'], $lev);
									$z = array_merge($z, $m);
								} //isset($data[$arr[$i]['blog_id']])
								if (isset($z[count($z) - 1]['flag_end']))
									$z[count($z) - 1]['flag_end']++;
								else
									$z[count($z) - 1]['flag_end'] = 1;
							} //$i = 0; $i < count($arr); $i++
							return $z;
						}
					} //!function_exists('my_sort_div_blogs')






					if (isset($this->data['blogs']) && count($this->data['blogs']) > 0) {
						$aparent = Array();
						$ablog   = Array();
						foreach ($this->data['blogs'] as $num => $data) {
							$aparent[$data['parent_id']] = true;
							$ablog[$data['blog_id']]     = true;
						} //$this->data['blogs'] as $num => $data
						reset($this->data['blogs']);
						foreach ($this->data['blogs'] as $num => $data) {
							if (!isset($ablog[$data['parent_id']])) {
								$this->data['blogs'][$num]['parent_id'] = 0;
							} //!isset($ablog[$data['parent_id']])
						} //$this->data['blogs'] as $num => $data
						reset($this->data['blogs']);
						for ($i = 0, $c = count($this->data['blogs']); $i < $c; $i++) {
							$new_arr[$this->data['blogs'][$i]['parent_id']][] = $this->data['blogs'][$i];
						} //$i = 0, $c = count($this->data['blogs']); $i < $c; $i++
						$this->data['new_arr'] = $new_arr;
						$this->data['myblogs'] = my_sort_div_blogs($new_arr, 0);
						$lv                    = 0;
						$alv                   = 0;


						foreach ($this->data['myblogs'] as $num => $mblogs) {
							$path_parts = explode('_', (string) $this->data['blog_path']);
							$blog_parts = explode('_', (string) $mblogs['path']);
							$iarr       = array_intersect($path_parts, $blog_parts);
							$active     = 'none';
							$display    = false;
							if (count($iarr) == 0) {
								$active = 'none';
								if ($mblogs['level'] == 0) {
									$display = true;
								} //$mblogs['level'] == 0
							} //count($iarr) == 0
							if ($mblogs['level'] == $alv) {
								$display = true;
							} //$mblogs['level'] == $alv
							else {
								$alv = 0;
							}
							if (count($iarr) == count($path_parts) && count($iarr) == count($blog_parts)) {
								$display = true;
								$active  = 'active';
								$alv     = $mblogs['level'] + 1;
							} //count($iarr) == count($path_parts) && count($iarr) == count($blog_parts)
							if ((count($iarr) > 0) && ($mblogs['level'] <= count($iarr)) && $active != 'active') {
								$display = true;
								if ($mblogs['level'] != count($iarr)) {
									$active = 'pass';
									$lv     = $mblogs['level'] + 1;
								} //$mblogs['level'] != count($iarr)
							} //(count($iarr) > 0) && ($mblogs['level'] <= count($iarr)) && $active != 'active'
							if ($display) {
								$display = true;
							} //$display
							else {
								if ($mblogs['level'] > $lv) {
									$lv      = 0;
									$display = false;
								} //$mblogs['level'] > $lv
							}
							$this->data['myblogs'][$num]['active']  = $active;
							$this->data['myblogs'][$num]['display'] = $display;
						} //$this->data['myblogs'] as $num => $mblogs
					} //isset($this->data['blogs']) && count($this->data['blogs']) > 0
					$this->data['thislist'] = $thislist;
					if (isset($thislist['template']) && $thislist['template'] != '') {
						$template = '/template/agoodonut/widgets/blogs/' . $thislist['template'];
					} //isset($thislist['template']) && $thislist['template'] != ''
					else {
						$template = '/template/agoodonut/widgets/blogs/blog.tpl';
					}
				} //$type == 'blogs' || $type == 'blogsall'
			} //!empty($module_data) && ($type == 'blogsall' || $type == 'blogs')

/* ************************************************************************************************** */
			if (!empty($module_data) && ($type == 'latest' || $type == 'records')) {
				$this->data['type'] = $type;
				$this->data = $this->getBlogsRecords($thislist, $type);




				if (isset($thislist['template']) && $thislist['template'] != '') {
					$template = '/template/agoodonut/widgets/records/' . $thislist['template'];
				} //isset($thislist['template']) && $thislist['template'] != ''
				else {
					if ($type == 'latest') {
						$template = '/template/agoodonut/widgets/records/blog_latest.tpl';
					} //$type == 'latest'
					if ($type == 'records') {
						$template = '/template/agoodonut/widgets/records/blog_records.tpl';
					} //$type == 'records'
				}
			} //!empty($module_data) && ($type == 'latest' || $type == 'records')
/* ************************************************************************************************** */

			if (!empty($module_data) && ($type == 'related')) {
				$this->data['type'] = $type;

				$this->data = $this->getBlogsRecords($thislist, $type);

				if (isset($thislist['template']) && $thislist['template'] != '') {
					$template = '/template/agoodonut/widgets/records/' . $thislist['template'];
				} //isset($thislist['template']) && $thislist['template'] != ''
				else {
					if ($type == 'related') {
						$template = '/template/agoodonut/widgets/records/blog_latest.tpl';
					} //$type == 'latest'
				}
			} //!empty($module_data) && ($type == 'latest' || $type == 'records')

/* ************************************************************************************************** */
			if (!empty($module_data) && ($type == 'reviews')) {
				$this->data['type'] = $type;


			if (isset($this->request->get[$get_pagination])) {
				$tracking = $this->request->get[$get_pagination];
			} else {
				$tracking = '';
			}
			if ($tracking != '') {
				$parts = explode('_', trim(utf8_strtolower($tracking)));
				foreach ($parts as $num => $val) {
					list($getquery, $getpar) = explode("-", $val);
					$this->request->get[$getquery] = $getpar;
				}
			}

            $cmswidget = $module_data[$position]['setting']['what'];

			if (isset($this->request->get['wpage']) && isset($this->request->get['cmswidget']) && $this->request->get['cmswidget']==$module_data[$position]['setting']['what']) {
				$page = $this->request->get['wpage'];
			} else {
				$page = 1;
			}

			$this->data['wpage']    = $page;

            if ($thislist['number_per_widget']=='') {
             $thislist['number_per_widget'] = 20;
            }

			$thislist['paging']    = array(
				'start' => ($page - 1) * $thislist['number_per_widget']
			);

				$data_reviews           = $this->getBlogsReviews($thislist, $type);

				$this->data             = array_merge($this->data, $data_reviews);
				$this->data['position'] = $position_block;




            //print_r($this->request->get);
             $url_end ="";
             foreach ($this->request->get as $get_key => $get_val) {
              if ($get_key!='route' && $get_key!='prefix' && $get_key!='_route_' && $get_key!='wpage' &&  $get_key!='cmswidget' &&  $get_key!=$get_pagination) {
              	$url_end.= "&".(string)$get_key."=". (string)$get_val;
              }
             }

             $this->data['cmswidget']=$cmswidget;

            $link_url = $this->url->link($route, $url_end.'&'.$get_pagination.'=cmswidget-'.$cmswidget.'_wpage-{page}'.'#cmswidget-'.$cmswidget);


             if (!isset($this->data['comment_total'])) $this->data['comment_total']=0;
			$pagination             = new Pagination();
			$pagination->total      = $this->data['comment_total'];
			$pagination->page       = $page;
			$pagination->limit      = $thislist['number_per_widget'];
			$pagination->text       = $this->language->get('text_pagination');

			$pagination->url = $link_url;

			$this->data['pagination'] = $pagination->render();


				if (isset($thislist['template']) && $thislist['template'] != '') {
					$template = '/template/agoodonut/widgets/reviews/' . $thislist['template'];
				} //isset($thislist['template']) && $thislist['template'] != ''
				else {
					if ($type == 'reviews') {
						$template = '/template/agoodonut/widgets/reviews/reviews_adaptive.tpl';
					} //$type == 'reviews'
				}

			}
/* ************************************************************************************************** */

			if (!empty($module_data) && ($type == 'treecomments')) {



                $this->data['mark'] = false;

                $this->load->model('catalog/record');
                $this->load->model('catalog/blog');
                $this->load->model('catalog/treecomments');
                $this->load->model('catalog/product');

				if (isset($this->request->get['product_id'])) {
					$thislist['product_id'] = $this->request->get['product_id'];
					$this->data['mark_id'] = $this->request->get['product_id'];
					$this->data['mark'] = 'product_id';
					$route = 'product/product';
					$mark_info = $this->model_catalog_product->getProduct($this->data['mark_id']);
					$b_path    = $this->model_catalog_treecomments->getPathByProduct($this->data['mark_id']);
					$this->data['mark_info'] = $mark_info;

				} //isset($this->request->get['product_id'])
				else {
					$thislist['product_id'] = false;
				}

				if (isset($this->request->get['record_id'])) {
					$thislist['record_id'] = $this->request->get['record_id'];
                    $this->data['mark_id'] = $this->request->get['record_id'];
					$this->data['mark'] = 'record_id';
					$route = 'record/record';

					$mark_info = $this->model_catalog_record->getRecord($this->data['mark_id']);
					$this->load->model('catalog/blog');
					$b_path = $this->model_catalog_blog->getPathByRecord($this->data['mark_id']);
					$record_info    = $this->model_catalog_record->getRecord($this->data['mark_id']);
				    $this->data['mark_info'] = $record_info;

				} //isset($this->request->get['product_id'])
				else {
					$thislist['record_id'] = false;
				}

                 if (isset($this->data['thislist']['recordid']) && $this->data['thislist']['recordid']!='') {
					$thislist['record_id'] = $this->data['thislist']['recordid'];
                    $this->data['mark_id'] = $this->data['thislist']['recordid'];
					$this->data['mark'] = 'record_id';
					$route = 'record/record';

					$mark_info = $this->model_catalog_record->getRecord($this->data['mark_id']);
					$this->load->model('catalog/blog');
					$b_path = $this->model_catalog_blog->getPathByRecord($this->data['mark_id']);
					$record_info    = $this->model_catalog_record->getRecord($this->data['mark_id']);
				    $this->data['mark_info'] = $record_info;


                 }

                 $this->language->load('account/login');
                 $this->language->load('agoo/signer/signer');
                 if (isset($this->data['thislist']['langfile']) && $this->data['thislist']['langfile']!='') {
                   $this->language->load($this->data['thislist']['langfile']);

                 }



                $this->data['prefix'] = false;

                $prefix_str = str_replace("_","",$this->data['mark']);
                $prefix_array = preg_split('//', $prefix_str, -1, PREG_SPLIT_NO_EMPTY);
                shuffle($prefix_array);
                $this->data['prefix'] = implode($prefix_array)."_";
                //$this->request->get['prefix']=$this->data['prefix'];

				$this->registry->set("prefix", $this->data['prefix']);




              if  ($this->data['mark']) {

                $this->data['type'] = $type;

				$this->data['href'] = $this->url->link($route, $this->data['mark'].'=' . $thislist[$this->data['mark']]);

				if ($this->customer->isLogged()) {
					$this->data['text_login']     = $this->customer->getFirstName() . " " . $this->customer->getLastName();
					$this->data['captcha_status'] = false;
					$this->data['customer_id']    = $this->customer->getId();
				} //$this->customer->isLogged()
				else {
					$this->data['text_login']     = $this->language->get('text_anonymus');
					$this->data['captcha_status'] = true;
					$this->data['customer_id']    = false;
					$this->data['signer_code']    = 'customer_id';

					$this->data['text_new_customer']            = $this->language->get('text_new_customer');
					$this->data['text_register']                = $this->language->get('text_register');
					$this->data['text_register_account']        = $this->language->get('text_register_account');
					$this->data['text_returning_customer']      = $this->language->get('text_returning_customer');
					$this->data['text_i_am_returning_customer'] = $this->language->get('text_i_am_returning_customer');
					$this->data['text_forgotten']               = $this->language->get('text_forgotten');
					$this->data['entry_email']                  = $this->language->get('entry_email');
					$this->data['entry_password']               = $this->language->get('entry_password');
					$this->data['button_continue']              = $this->language->get('button_continue');
					$this->data['button_login']                 = $this->language->get('button_login');
					if (isset($this->error['warning'])) {
						$this->data['error_warning'] = $this->error['warning'];
					} //isset($this->error['warning'])
					else {
						$this->data['error_warning'] = '';
					}
					if (isset($this->session->data['success'])) {
						$this->data['success'] = $this->session->data['success'];
						unset($this->session->data['success']);
					} //isset($this->session->data['success'])
					else {
						$this->data['success'] = '';
					}
					if (isset($this->request->post['email'])) {
						$this->data['email'] = $this->request->post['email'];
					} //isset($this->request->post['email'])
					else {
						$this->data['email'] = '';
					}
					if (isset($this->request->post['password'])) {
						$this->data['password'] = $this->request->post['password'];
					} //isset($this->request->post['password'])
					else {
						$this->data['password'] = '';
					}
					$this->data['action']    = $this->url->link('account/login', '', 'SSL');
					$this->data['register']  = $this->url->link('account/register', '', 'SSL');
					$this->data['forgotten'] = $this->url->link('account/forgotten', '', 'SSL');
					if (isset($this->request->post['redirect']) && (strpos($this->request->post['redirect'], $this->config->get('config_url')) !== false || strpos($this->request->post['redirect'], $this->config->get('config_ssl')) !== false)) {
						$this->data['redirect'] = $this->request->post['redirect'];
					} //isset($this->request->post['redirect']) && (strpos($this->request->post['redirect'], $this->config->get('config_url')) !== false || strpos($this->request->post['redirect'], $this->config->get('config_ssl')) !== false)
					elseif (isset($this->session->data['redirect'])) {
						$this->data['redirect'] = $this->session->data['redirect'];
						unset($this->session->data['redirect']);
					} //isset($this->session->data['redirect'])
					else {
						$this->data['redirect'] = $this->data['href'];
					}
				}



				if ($thislist[$this->data['mark']] && isset($this->data['customer_id'])) {
					$this->load->model('agoo/signer/signer');
					$this->data['signer_status'] = $this->model_agoo_signer_signer->getStatus($thislist[$this->data['mark']], $this->data['customer_id'], $this->data['mark']);
				} //$thislist['product_id'] && isset($this->data['customer_id'])

				$this->data['text_welcome'] = sprintf($this->language->get('text_welcome'), $this->url->link('account/register', '', 'SSL'));

		 		$this->data['text_wait']    = $this->language->get('text_wait');

				$this->cont('record/treecomments');

				$this->request->post['thislist'] = base64_encode(serialize($thislist));

                $mark = $this->data['mark'];
				$this->data                      = $this->getMarkReviews($thislist, $type, $this->data['mark']);
                $this->data['mark'] = $mark;


				$this->data['html_comment']      = $this->controller_record_treecomments->comment($this->data['thislist']);



				if (isset($thislist['view_captcha']) && $thislist['view_captcha'] == 0) {
					$this->data['captcha_status'] = false;
				} //isset($thislist['view_captcha']) && $thislist['view_captcha'] == 0
				if (((isset($this->data['thislist']['visual_editor']) && isset($this->data['thislist']['comment_must']) && $this->data['thislist']['comment_must'] && $this->data['thislist']['visual_editor'])) || !isset($this->data['thislist']['visual_editor'])) {
					$this->data['visual_editor'] = true;
				} //((isset($this->data['thislist']['visual_editor']) && $this->data['thislist']['visual_editor'])) || !isset($this->data['thislist']['visual_editor'])
				else {
					$this->data['visual_editor'] = false;
				}


 				if (!function_exists('comp_field')) {
					function comp_field($a, $b)
					{
						if (!isset($a['field_order']) || $a['field_order']=='') $a['field_order']='9999999';
						if (!isset($b['field_order']) || $b['field_order']=='') $b['field_order']='9999999';

						$a['field_order'] = (int)$a['field_order'];
						$b['field_order'] = (int)$b['field_order'];

						if ($a['field_order'] > $b['field_order'])
							return 1;
						if ($b['field_order'] > $a['field_order'])
							return -1;
						return 0;
					}
				}

				if (isset($thislist['fields_view']))
					$this->data['fields_view'] = $thislist['fields_view'];
				else
					$this->data['fields_view'] = 0;

				if (isset($thislist['addfields'])) {
					usort($thislist['addfields'], 'comp_field');
					$this->data['fields'] = $thislist['addfields'];
				} else {
					$this->data['fields'] = array();
				}


 		$this->load->model('catalog/fields');
		$fields_db = $this->model_catalog_fields->getFieldsDBlang();





			foreach ($this->data['fields'] as $num => $field) {
				foreach ($fields_db as $num_db => $field_db) {
					if ($field['field_name']==$field_db['field_name']) {

			         foreach ($field_db as $num_1=>$field_1) {

			         	if (!isset($this->data['fields'][$num][$num_1]) || $field_db[$num_1] == '') {
			               $this->data['fields'][$num][$num_1] = $field_1;
			         	} else {

			         	}

			         }
					}
				}
			}
/*
print_r("<PRE>");
print_r($fields_db);
print_r($this->data['fields']);
print_r("</PRE>");
*/


				$this->data['settings_widget'] = $this->data['thislist'];
				if (isset($thislist['template']) && $thislist['template'] != '') {
					$template = '/template/agoodonut/widgets/treecomments/treecomments/' . $thislist['template'];
				} //isset($thislist['template']) && $thislist['template'] != ''
				else {
					if ($type == 'treecomments') {
						$template = '/template/agoodonut/widgets/treecomments/treecomments/treecomments.tpl';
					} //$type == 'treecomments'
				}
			  }
			}
/* ************************************************************************************************** */


			if (!empty($module_data) && $type == 'hook') {
				$this->data['type'] = $type;
				if (isset($thislist['template']) && $thislist['template'] != '') {
					$template = '/template/agoodonut/widgets/hook/' . $thislist['template'];
				} //isset($thislist['template']) && $thislist['template'] != ''
				else {
					$template = '/template/agoodonut/widgets/hook/hook.tpl';
				}
			} //!empty($module_data) && $type == 'hook'
			if (!empty($module_data) && $type == 'loader') {
				$this->data['type'] = $type;
				$loader = new agooLoader($this->registry);
				$this->registry->set('load', $loader);
				if (isset($thislist['template']) && $thislist['template'] != '') {
					$template = '/template/agoodonut/widgets/loader/' . $thislist['template'];
				} //isset($thislist['template']) && $thislist['template'] != ''
				else {
					$template = '/template/agoodonut/widgets/loader/blog_loader.tpl';
				}
			} //!empty($module_data) && $type == 'loader'
			if (!empty($module_data) && $type != '') {

               if ($this->data['type'])  {

					if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . $template)) {
						$this->template = $this->config->get('config_template') . $template;
					} //file_exists(DIR_TEMPLATE . $this->config->get('config_template') . $template)
					else {
						$this->template = 'default' . $template;
					}

					$this->data['theme'] = $this->config->get('config_template');
					$html                = $this->render();

					if (isset($this->data['settings_general']['cache_widgets']) && $this->data['settings_general']['cache_widgets']) {
						$module_view_cache[$hash_cache] = base64_encode($html);
						$this->cache->set($cache_name, $module_view_cache);
					} //isset($this->data['settings_general']['cache_widgets']) && $this->data['settings_general']['cache_widgets']
				} //!empty($module_data) && $type != ''
			}
		} //!isset($module_view_cache[$hash_cache])
		else {
			$html = base64_decode($module_view_cache[$hash_cache]);
		}

		$this->registry->set('load', $loader_old);
		$this->registry->set('cache', $cacher_old);
		$this->output = $html;
		$this->config->set("blog_work", false );

		return $this->response->setOutput($html);
	}

		private function ColorboxLoader($theme)
		{
		$this->data['imagebox'] = '';
		$scripts       = $this->document->getScripts();
		$colorbox_flag = false;
		foreach ($scripts as $num => $val) {
			if (utf8_strpos($val, 'colorbox.js') !== FALSE) {
				$colorbox_flag = true;
			} //utf8_strpos($val, 'colorbox') !== FALSE
		} //$scripts as $num => $val
		if (!$colorbox_flag) {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/header.tpl')) {
				$product_file = file_get_contents(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/header.tpl');
			} //file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/header.tpl')
			else {
				if (file_exists(DIR_TEMPLATE . 'default/template/common/header.tpl')) {
					$product_file = file_get_contents(DIR_TEMPLATE . 'default/template/common/header.tpl');
				} //file_exists(DIR_TEMPLATE . 'default/template/common/header.tpl')
				else {
					$product_file = "";
				}
			}
			$findme = 'colorbox.js';
			$pos    = strpos($product_file, $findme);
			if ($pos !== false) {
				$colorbox_flag = true;
			} //$pos !== false
		} //!$colorbox_flag

		if (!$colorbox_flag) {
			$this->document->addScript('catalog/view/javascript/blog/colorbox/jquery.colorbox.js');
			$this->document->addScript('catalog/view/javascript/blog/colorbox/lang/jquery.colorbox-' . $this->config->get('config_language') . '.js');
			$this->document->addStyle('catalog/view/javascript/blog/colorbox/css/' . $theme . '/colorbox.css');
		} //!$colorbox_flag
		$this->data['imagebox'] = 'colorbox';
		if ($this->data['imagebox'] == 'colorbox') {
			$this->document->addScript('catalog/view/javascript/blog/blog.color.js');
		} //$this->data['imagebox'] == 'colorbox'
		if (file_exists('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/blog.css')) {
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/blog.css');
		} //file_exists('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/blog.css')
		else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/blog.css');
		}
	    return $this->data['imagebox'];
	    }


	public function cont($cont)
	{
		$file  = DIR_APPLICATION . 'controller/' . $cont . '.php';
		$class = 'Controller' . preg_replace('/[^a-zA-Z0-9]/', '', $cont);
		if (file_exists($file)) {
			include_once($file);
			$this->registry->set('controller_' . str_replace('/', '_', $cont), new $class($this->registry));
		} //file_exists($file)
		else {
			trigger_error('Error: Could not load controller ' . $cont . '!');
			exit();
		}
	}
	private function getBlogsReviews($thislist, $type = 'reviews')
	{

		$this->data['settings']      = $thislist;
		$hash                        = md5(serialize($thislist));
		$this->data['settings_hash'] = $hash;
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} //$this->customer->isLogged()
		else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}
		$rate = array();
		$this->language->load('record/blog');

		$this->load->model('catalog/comment');
		$this->load->model('catalog/blog');

		$this->load->model('tool/image');
		$this->load->library('agoo/image');

		if (isset($thislist['title_list_latest'][$this->config->get('config_language_id')])) {
			$this->data['heading_title'] = $thislist['title_list_latest'][$this->config->get('config_language_id')];
		} //isset($thislist['title_list_latest'][$this->config->get('config_language_id')])
		else {
			$this->data['heading_title'] = "";
		}
		$this->data['text_comments'] = $this->language->get('text_comments');
		$this->data['text_viewed']   = $this->language->get('text_viewed');
		$row                         = $this->cache->get('product.blog.reviews.' . (int) $this->config->get('config_language_id') . '.' . (int) $this->config->get('config_store_id') . '.' . (int) $customer_group_id . '.' . $hash);

		if (0 == 0 || empty($row)) {
//print_r("<PRE>");
//print_r($thislist);
//print_r("</PRE>");

			$comments = $this->model_catalog_comment->getCommentsByBlogsIN($thislist, 3);

            //echo "*******************<br>";
			if (isset($comments) && count($comments) > 0) {
				foreach ($comments as $comment) {


					if ($comment['type'] == 'blogs') {
						$blog_href                   = $this->model_catalog_blog->getPathByBlog($comment['blog_id']);
						$blog_link                   = $this->url->link('record/blog', 'blog_id=' . $blog_href['path']);
						$record_link                 = $this->url->link('record/record', 'record_id=' . $comment['record_id'] . "&blog_id=" . $blog_href['path']);
						$rate                        = $this->model_catalog_comment->getRatesByCommentId($comment['comment_id']);
						$this->data['text_category'] = $this->language->get('text_blog');
						$this->data['text_record']   = $this->language->get('text_record');
					} //$comment['type'] == 'blogs'
					if ($comment['type'] == 'categories') {
						if (isset($comment['review_id']))
							$comment['comment_id'] = $comment['review_id'];
						else
							$comment['comment_id'] = '';
						if (isset($comment['commentid']))
							$comment['comment_id'] = $comment['commentid'];
						else
							$comment['comment_id'] = '';
						if (isset($comment['product_id'])) {
							$comment['record_id'] = $comment['product_id'];
						} //isset($comment['product_id'])
						else {
							if (!isset($comment['record_id']))
								$comment['record_id'] = '';
						}
					} //$comment['type'] == 'categories'
					if ($comment['type'] == 'categories') {
						$blog_href                   = $this->model_catalog_blog->getPathByCategory($comment['blog_id']);
						$blog_link                   = $this->url->link('product/category', 'path=' . $blog_href['path']);
						$record_link                 = $this->url->link('product/product', 'product_id=' . $comment['record_id'] . "&path=" . $blog_href['path']);
						$rate                        = array();
						$this->data['text_category'] = $this->language->get('text_category');
						$this->data['text_record']   = $this->language->get('text_product');
					} //$comment['type'] == 'categories'

					$comment_total = $comment['total'];


					//echo $comment['type']."->".$comment['record_id']."->".$comment['record_comments']."<br>";


					$rate_count       = 0;
					$rate_delta       = 0;
					$rate_delta_blog_plus  = 0;
					$rate_delta_blog_minus = 0;
					foreach ($rate as $r) {
						$rate_count       = $r['rate_count'];
						$rate_delta       = $r['rate_delta'];
						$rate_delta_blog_plus  = $r['rate_delta_blog_plus'];
						$rate_delta_blog_minus = $r['rate_delta_blog_minus'];
					} //$rate as $r

					$this->load->model('tool/image');
					$this->load->library('agoo/image');

					if ($comment) {
						if ($comment['image']) {
							if (isset($thislist['avatar']['width']) && isset($thislist['avatar']['height']) && $thislist['avatar']['width'] != "" && $thislist['avatar']['height'] != "") {
								$thumb = $this->model_tool_image->resize($comment['image'], $thislist['avatar']['width'], $thislist['avatar']['height']);
							} //isset($thislist['avatar']['width']) && isset($thislist['avatar']['height']) && $thislist['avatar']['width'] != "" && $thislist['avatar']['height'] != ""
							else {
								$thumb = $this->model_tool_image->resize($comment['image'], 150, 150);
							}
						} //$comment['image']
						else {
							$thumb = '';
						}
					} //$comment
					else {
						$thumb = '';
					}

					if (!isset($comment['text'])) {
						$comment['text'] = '';
					} //!isset($comment['text'])
					$text ='';
					if ($comment['text'] != '') {
						$flag_desc = 'none';
						if ($thislist['desc_symbols'] != '') {
							$amount    = $thislist['desc_symbols'];
							$flag_desc = 'symbols';
						} //$thislist['desc_symbols'] != ''
						if ($thislist['desc_words'] != '') {
							$amount    = $thislist['desc_words'];
							$flag_desc = 'words';
						} //$thislist['desc_words'] != ''
						if ($thislist['desc_pred'] != '') {
							$amount    = $thislist['desc_pred'];
							$flag_desc = 'pred';
						} //$thislist['desc_pred'] != ''

						if ($flag_desc!='none') $comment['text'] = preg_replace('/\[(.*?)\]/','',$comment['text']);

						switch ($flag_desc) {
							case 'symbols':
								$pattern = ('/((.*?)\S){0,' . $amount . '}/isu');
								preg_match_all($pattern, strip_tags(html_entity_decode($comment['text'], ENT_QUOTES, 'UTF-8')), $out);
								$text = $out[0][0];
								break;
							case 'words':
								$pattern = ('/((.*?)\x20){0,' . $amount . '}/isu');
								preg_match_all($pattern, strip_tags(html_entity_decode($comment['text'], ENT_QUOTES, 'UTF-8')), $out);
								$text = $out[0][0];
								break;
							case 'pred':
								$pattern = ('/((.*?)\.){0,' . $amount . '}/isu');
								preg_match_all($pattern, strip_tags(html_entity_decode($comment['text'], ENT_QUOTES, 'UTF-8')), $out);
								$text = $out[0][0];
								break;
							case 'none':
								$text = html_entity_decode($comment['text'], ENT_QUOTES, 'UTF-8');
								break;
						} //$flag_desc
					} //$comment['text'] != ''



					if ($text == '') {
						$text = html_entity_decode($comment['text'], ENT_QUOTES, 'UTF-8');
					} //$text == ''
					if ($this->rdate($this->language->get('text_date')) == $this->rdate($this->language->get('text_date'), strtotime($comment['date_added']))) {
						$date_str = $this->language->get('text_today');
					} //$this->rdate($this->language->get('text_date')) == $this->rdate($this->language->get('text_date'), strtotime($comment['date_added']))
					else {
						$date_str = $this->language->get('text_date');
					}
					$date_available = $this->rdate($date_str . $this->language->get('text_hours'), strtotime($comment['date_added']));
					require_once(DIR_SYSTEM . 'library/bbcode.class.php');
					$text                     = strip_tags($text);
					$text                     = BBCode::parse($text);
					$this->data['comments'][] = array(
						'comment_id' => $comment['comment_id'],
						'parent_id' => $comment['parent_id'],
						'blog_id' => $comment['blog_id'],
						'blog_name' => $comment['blog_name'],
						'blog_href' => $blog_link,
						'blog_path' => $blog_href['path'],
						'record_id' => $comment['record_id'],
						'record_comments' => $comment['record_comments'],
						'record_viewed' => $comment['record_viewed'],
						'record_name' => $comment['record_name'],
						'record_rating' => (int) $comment['rating_avg'],
						'record_href' => $record_link,
						'customer_id' => $comment['customer_id'],
						'author' => $comment['author'],
						'text' => $text,
						'rating' => (int) $comment['rating'],
						'rate_count' => $rate_count,
						'rate_delta' => $rate_delta,
						'rate_delta_blog_plus' => $rate_delta_blog_plus,
						'rate_delta_blog_minus' => $rate_delta_blog_minus,
						'date' => $date_available,
						'image' => $comment['image'],
						'thumb' => $thumb,
						'text_category' => $this->data['text_category'],
						'text_record' => $this->data['text_record']
					);
				} //$comments as $comment
                $this->data['comment_total'] = $comment_total;
                //echo $comment_total."<br>";

			} //isset($comments) && count($comments) > 0



			$this->cache->set('product.blog.reviews.' . (int) $this->config->get('config_language_id') . '.' . (int) $this->config->get('config_store_id') . '.' . (int) $customer_group_id . '.' . $hash, $this->data);
		} //0 == 0 || empty($row)
		else {
			$this->data = $row;
		}
		return $this->data;
	}
	public function rdate($param, $time = 0)
	{
		$this->language->load('record/blog');
		if (intval($time) == 0)
			$time = time();
		$MonthNames = array(
			$this->language->get('text_january'),
			$this->language->get('text_february'),
			$this->language->get('text_march'),
			$this->language->get('text_april'),
			$this->language->get('text_may'),
			$this->language->get('text_june'),
			$this->language->get('text_july'),
			$this->language->get('text_august'),
			$this->language->get('text_september'),
			$this->language->get('text_october'),
			$this->language->get('text_november'),
			$this->language->get('text_december')
		);
		if (strpos($param, 'M') === false)
			return date($param, $time);
		else {
			$str_begin  = date(utf8_substr($param, 0, utf8_strpos($param, 'M')), $time);
			$str_middle = $MonthNames[date('n', $time) - 1];
			$str_end    = date(utf8_substr($param, utf8_strpos($param, 'M') + 1, utf8_strlen($param)), $time);
			$str_date   = $str_begin . $str_middle . $str_end;
			return $str_date;
		}
	}



private function getRecordImages($record_id, $settings) {
					$images = array();

					if (!isset($settings['width']) || $settings['width']=='' )    $settings['width']=$this->config->get('config_image_additional_width');;
					if (!isset($settings['height']) || $settings['height']=='' )  $settings['height']=$this->config->get('config_image_additional_height');

					$width = $settings['width'];
					$height = $settings['height'];

					$results              = $this->model_catalog_record->getRecordImages($record_id);
					foreach ($results as $res) {

					    $image_options = unserialize(base64_decode($res['options']));

					    if (isset($image_options['title'][$this->config->get('config_language_id')])) {
					    $image_title = html_entity_decode($image_options['title'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8'); ;
					    } else {
					     $image_title = $this->getHttpImage() . $res['image'];
					    }

					    if (isset($image_options['description'][$this->config->get('config_language_id')])) {
					    	$image_description = html_entity_decode($image_options['description'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8'); ;
					    } else {
					     	$image_description ="";
					    }

					    if (isset($image_options['url'])) {
						    $image_url = $image_options['url'];
					    } else {
						    $image_url = "";
					    }


						$images[] = array(
							'popup' => $this->getHttpImage() . $res['image'],
							'title' => $image_title,
							'description' => $image_description,
							'url'=> $image_url,
							'options' => $image_options,
							'thumb' => $this->model_tool_image->resize($res['image'], $width , $height)
						);
					}
					return $images;
	}

	private function getHttpImage()
	{
		$array_dir_image = str_split(DIR_IMAGE);
		$array_dir_app   = str_split(DIR_APPLICATION);
		$i               = 0;
		$dir_root        = '';
		while ($array_dir_image[$i] == $array_dir_app[$i]) {
			$dir_root .= $array_dir_image[$i];
			$i++;
		} //$array_dir_image[$i] == $array_dir_app[$i]
		$dir_image = str_replace($dir_root, '', DIR_IMAGE);
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$http_image = HTTPS_SERVER . $dir_image;
		} //isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))
		else {
			$http_image = HTTP_SERVER . $dir_image;
		}
	 return $http_image;
	}

	private function getBlogsRecords($thislist, $type = 'latest')
	{




		$this->language->load('record/blog');
		$this->load->model('catalog/record');

		$this->load->model('tool/image');
        $this->load->library('agoo/image');

		$this->data['text_comments'] = $this->language->get('text_comments');
		$this->data['text_viewed']   = $this->language->get('text_viewed');
		if (isset($thislist['title_list_latest'][$this->config->get('config_language_id')]) && $thislist['title_list_latest'][$this->config->get('config_language_id')] != '') {
			$this->data['heading_title'] = $thislist['title_list_latest'][$this->config->get('config_language_id')];
		} //isset($thislist['title_list_latest'][$this->config->get('config_language_id')]) && $thislist['title_list_latest'][$this->config->get('config_language_id')] != ''
		else {
			$this->data['heading_title'] = '';
		}
		if (isset($thislist['number_per_blog']) && $thislist['number_per_blog'] != '') {
			$limit = $thislist['number_per_blog'];
		} //isset($thislist['number_per_blog']) && $thislist['number_per_blog'] != ''
		else {
			$limit = 5;
		}
		if (isset($thislist['order']) && $thislist['order'] != '') {
			$sort = $thislist['order'];
		} //isset($thislist['order']) && $thislist['order'] != ''
		else {
			$sort = 'latest';
		}
		if (isset($thislist['blogs'])) {
			$this->data['blogs'] = $thislist['blogs'];
		} //isset($thislist['blogs'])
		else {
			$this->data['blogs'] = 0;
		}
		if (isset($thislist['related'])) {
			$this->data['related'] = $thislist['related'];
		} //isset($thislist['related'])
		else {
			$this->data['related'] = Array();
		}
		if (isset($thislist['order_ad'])) {
			$this->data['order_ad'] = $thislist['order_ad'];
		} //isset($thislist['order_ad'])
		else {
			$this->data['order_ad'] = 'DESC';
		}

		if (!isset($thislist['images'])) {
			$thislist['images'] = array();
		} //isset($thislist['order_ad'])


		if (isset($thislist['pointer']) && $thislist['pointer'] != '') {
			$pointer = $thislist['pointer'];
		} //isset($thislist['order']) && $thislist['order'] != ''
		else {
			$pointer = 'product_id';
		}


		$amount                = 0;
		$order                 = $this->data['order_ad'];
		$this->data['records'] = array();
		$data                  = array(
			'settings' => $thislist,
			'filter_blogs' => $this->data['blogs'],
			'sort' => $sort,
			'order' => $order,
			'start' => 0,
			'limit' => $limit
		);
		$results               = false;
		if ($type == 'latest') {
			$results = $this->model_catalog_record->getBlogsRecords($data);

		} //$type == 'latest'

		if ($type == 'records') {
			if (isset($this->data['related']) && !empty($this->data['related'])) {
				foreach ($this->data['related'] as $related_id) {
					$results[$related_id] = $this->model_catalog_record->getRecord($related_id);
				} //$this->data['related'] as $related_id
			} //isset($this->data['related']) && !empty($this->data['related'])
		} //$type == 'records'


		if ($type == 'related') {
			$pointer_id = false;
			$blog_id = false;
			$category_id = false;
			$related_id = false;

			if (isset($this->request->get['product_id']) && $pointer=='product_id') {
				$pointer_id = $this->request->get['product_id'];

			}

			if (isset($this->request->get['blog_id']) && $pointer=='blog_id') {
				$parts                   = array();
                $path='';
				if (isset($this->request->get['blog_id'])) {
					$parts                   = explode('_', (string) $this->request->get['blog_id']);
  				}
			    foreach ($parts as $path_id) {
				if (!$path) {
					$pointer_id = (int)$path_id;
				}
               }
			}

			if (isset($this->request->get['path']) && $pointer=='category_id') {
				$parts                   = array();
                $path='';
				if (isset($this->request->get['path'])) {
					$parts                   = explode('_', (string) $this->request->get['path']);
  				}

			    foreach ($parts as $path_id) {
				if (!$path) {
					$pointer_id = (int)$path_id;
				}
               }
			}

            if ($pointer_id) {
            	$this->data['related'] = $this->model_catalog_record->getRelatedRecords($pointer_id, $data, $pointer);

				if (isset($this->data['related']) && !empty($this->data['related'])) {
					foreach ($this->data['related'] as $num => $related) {
						$related_id = $related['record_id'];
						$results[$related_id] = $this->model_catalog_record->getRecord($related_id);
					}
				}
			}




		}


		if ($results) {

				$array_dir_image = str_split(DIR_IMAGE);
				$array_dir_app   = str_split(DIR_APPLICATION);
				$i               = 0;
				$dir_root        = '';
				while ($array_dir_image[$i] == $array_dir_app[$i]) {
					$dir_root .= $array_dir_image[$i];
					$i++;
				}
				$dir_image = str_replace($dir_root, '', DIR_IMAGE);
				if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
					$http_image = HTTPS_SERVER . $dir_image;
				}  	else {
					$http_image = HTTP_SERVER . $dir_image;
				}


			foreach ($results as $result) {
				if ($result != '') {


					if ($result['image']) {
						$dimensions = $thislist['avatar'];
						if ($dimensions['width'] == '')
							$dimensions['width'] = 200;
						if ($dimensions['height'] == '')
							$dimensions['height'] = 100;
						$image = $this->model_tool_image->resize($result['image'], $dimensions['width'], $dimensions['height']);
						$popup = $http_image . $result['image'];

					} //$result['image']
					else {
						$image = false;
						$popup = false;
					}



					if ($this->config->get('config_comment_status')) {
						$rating = (int) $result['rating'];
					} //$this->config->get('config_comment_status')
					else {
						$rating = false;
					}
					if (!isset($result['sdescription'])) {
						$result['sdescription'] = '';
					} //!isset($result['sdescription'])
					$description = false;
					if (isset($result['sdescription']) && $result['sdescription'] != '') {
						$description = html_entity_decode($result['sdescription'], ENT_QUOTES, 'UTF-8');
					} //isset($result['sdescription']) && $result['sdescription'] != ''
					if ($result['description'] && $result['sdescription'] == '') {
						$flag_desc                   = 'pred';
						$this->data['blog_num_desc'] = $thislist['desc_symbols'];
						if ($this->data['blog_num_desc'] == '') {
							$this->data['blog_num_desc'] = 50;
						} //$this->data['blog_num_desc'] == ''
						else {
							$amount    = $this->data['blog_num_desc'];
							$flag_desc = 'symbols';
						}
						$this->data['blog_num_desc_words'] = $thislist['desc_words'];
						if ($this->data['blog_num_desc_words'] == '') {
							$this->data['blog_num_desc_words'] = 10;
						} //$this->data['blog_num_desc_words'] == ''
						else {
							$amount    = $this->data['blog_num_desc_words'];
							$flag_desc = 'words';
						}
						$this->data['blog_num_desc_pred'] = $thislist['desc_pred'];
						if ($this->data['blog_num_desc_pred'] == '') {
							$this->data['blog_num_desc_pred'] = 3;
						} //$this->data['blog_num_desc_pred'] == ''
						else {
							$amount    = $this->data['blog_num_desc_pred'];
							$flag_desc = 'pred';
						}
						switch ($flag_desc) {
							case 'symbols':
								$pattern = ('/((.*?)\S){0,' . $amount . '}/isu');
								preg_match_all($pattern, strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), $out);
								$description = $out[0][0];
								break;
							case 'words':
								$pattern = ('/((.*?)\x20){0,' . $amount . '}/isu');
								preg_match_all($pattern, strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), $out);
								$description = $out[0][0];
								break;
							case 'pred':
								$pattern = ('/((.*?)\.){0,' . $amount . '}/isu');
								preg_match_all($pattern, strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), $out);
								$description = $out[0][0];
								break;
						} //$flag_desc
					} //$result['description'] && $result['sdescription'] == ''
					if ($this->rdate($this->language->get('text_date')) == $this->rdate($this->language->get('text_date'), strtotime($result['date_available']))) {
						$date_str = $this->language->get('text_today');
					} //$this->rdate($this->language->get('text_date')) == $this->rdate($this->language->get('text_date'), strtotime($result['date_available']))
					else {
						$date_str = $this->language->get('text_date');
					}
					$date_available = $this->rdate($date_str . $this->language->get('text_hours'), strtotime($result['date_available']));
					$this->load->model('catalog/blog');
					$blog_href = $this->model_catalog_blog->getPathByrecord($result['record_id']);
					if (strpos($blog_href['path'], '_') !== false) {
						$abid    = explode('_', $blog_href['path']);
						$blog_id = $abid[count($abid) - 1];
					} //strpos($blog_href['path'], '_') !== false
					else {
						$blog_id = (int) $blog_href['path'];
					}
					$blog_id   = (int) $blog_id;
					$blog_info = $this->model_catalog_blog->getBlog($blog_id);
					$this->data['blog_design'] = Array();
					if ($blog_info) {
						if ($blog_info['design'] != '') {
							$this->data['blog_design'] = unserialize($blog_info['design']);
						} //$blog_info['design'] != ''
						else {
							$this->data['blog_design'] = Array();
						}
					} //$blog_info

					//print_r($thislist);

					$this->data['records'][] = array(
						'record_id' => $result['record_id'],
						'thumb' => $image,
						'popup' => $popup,
						'images' => $this->getRecordImages($result['record_id'], $thislist['images']),
						'name' => $result['name'],
						'description' => $description,
						'rating' => $result['rating'],
						'date_added' => $result['date_added'],
						'date_available' => $date_available,
						'date_available_data' => $this->rdate("d", strtotime($result['date_available'])),
						'date_available_mes' => $this->rdate("M", strtotime($result['date_available'])),
						'date_available_god' => $this->rdate("Y", strtotime($result['date_available'])),
						'date_end' => $result['date_end'],
						'viewed' => $result['viewed'],
						'comments' => (int) $result['comments'],
						'href' => $this->url->link('record/record', 'record_id=' . $result['record_id']),
						'blog_id' => $blog_id,
						'blog_href' => $this->url->link('record/blog', 'blog_id=' . $blog_href['path']),
						'blog_name' => $blog_href['name'],
						'settings' => $thislist,
						'settings_blog' => $this->data['blog_design'],
						'settings_comment' => unserialize($result['comment'])
					);
				} //$result != ''
			} //$results as $result
		} //$results
		return $this->data;
	}

	private function getMarkReviews($thislist, $type = 'treecomments', $mark = 'product_id')
	{
		$this->language->load('record/blog');

		         if (isset($thislist['langfile']) && $thislist['langfile']!='') {
                   $this->language->load($thislist['langfile']);

                 }



		$this->load->model('catalog/treecomments');
		$this->data['text_comments'] = $this->language->get('text_comments');
		$this->data['text_viewed']   = $this->language->get('text_viewed');


		if (isset($thislist) && !empty($thislist)) {
			$this->data['thislist'] = $thislist;
		} //isset($thislist) && !empty($thislist)
		else {
			$this->data['thislist'] = Array();
		}

		if (isset($thislist['title_list_latest'][$this->config->get('config_language_id')]) && $thislist['title_list_latest'][$this->config->get('config_language_id')] != '') {
			$this->data['heading_title'] = $thislist['title_list_latest'][$this->config->get('config_language_id')];
		} //isset($thislist['title_list_latest'][$this->config->get('config_language_id')]) && $thislist['title_list_latest'][$this->config->get('config_language_id')] != ''
		else {
			$this->data['heading_title'] = '';
		}

		if (isset($thislist[$mark])) {
			$this->data[$mark] = $thislist[$mark];
		}
		else {
			$this->data[$mark] = false;
		}

		if (isset($thislist['number_comments']) && $thislist['number_comments'] != '') {
			$limit = $thislist['number_comments'];
		} //isset($thislist['number_comments']) && $thislist['number_comments'] != ''
		else {
			$limit = 10;
		}
		if (isset($thislist['status_now']) && $thislist['status_now'] != '') {
			$this->data['status_now'] = $thislist['status_now'];
		} //isset($thislist['status_now']) && $thislist['status_now'] != ''
		else {
			$this->data['status_now'] = 0;
		}
		if (isset($thislist['status_reg']) && $thislist['status_reg'] != '') {
			$this->data['status_reg'] = $thislist['status_reg'];
		} //isset($thislist['status_reg']) && $thislist['status_reg'] != ''
		else {
			$this->data['status_reg'] = 0;
		}
		if (isset($thislist['rating']) && $thislist['rating'] != '') {
			$this->data['rating'] = $thislist['rating'];
		} //isset($thislist['rating']) && $thislist['rating'] != ''
		else {
			$this->data['rating'] = 1;
		}
		if (isset($thislist['rating_num']) && $thislist['rating_num'] != '') {
			$this->data['rating_num'] = $thislist['rating_num'];
		} //isset($thislist['rating_num']) && $thislist['rating_num'] != ''
		else {
			$this->data['rating_num'] = '';
		}

		if (isset($thislist['order_ad'])) {
			$this->data['order_ad'] = $thislist['order_ad'];
		} //isset($thislist['order_ad'])
		else {
			$this->data['order_ad'] = 'DESC';
		}
		$this->data['comment_status'] = $this->config->get('config_review_status');
		if ($this->customer->isLogged()) {
			$this->data['customer_group_id'] = $this->customer->getCustomerGroupId();
			$this->data['captcha_status']    = false;
		} //$this->customer->isLogged()
		else {
			$this->data['customer_group_id'] = $this->config->get('config_customer_group_id');
			$this->data['captcha_status']    = true;
		}

		$order   = $this->data['order_ad'];
		$data    = array(
			 $mark => $this->data[$mark],
			'order' => $order,
			'start' => 0,
			'limit' => $limit
		);

		$results = false;
		if ($type == 'treecomments') {




			$results = $this->model_catalog_treecomments->getCommentsByMarkId($data, $mark);
		}


		if ($results) {
			foreach ($results as $result) {
				if ($result != '') {

				if ($mark =="record_id") {
					$result['review_id'] = $result['comment_id'];
				}

					$this->data['reviews'][] = array(
						 $mark => $result[$mark],
						'review_id' => $result['review_id'],
						'parent_id' => $result['parent_id'],
						'date_added' => $result['date_added']
					);
				} //$result != ''
			} //$results as $result
		} //$results
		return $this->data;
	}



	public function browser()
	{
		$bra = 'ie';
		if (isset($_SERVER['HTTP_USER_AGENT'])) {
			if (stristr($_SERVER['HTTP_USER_AGENT'], 'Firefox'))
				$bra = 'firefox';
			elseif (stristr($_SERVER['HTTP_USER_AGENT'], 'Chrome'))
				$bra = 'chrome';
			elseif (stristr($_SERVER['HTTP_USER_AGENT'], 'Safari'))
				$bra = 'safari';
			elseif (stristr($_SERVER['HTTP_USER_AGENT'], 'Opera'))
				$bra = 'opera';
			elseif (stristr($_SERVER['HTTP_USER_AGENT'], 'MSIE 6.0'))
				$bra = 'ieO';
			elseif (stristr($_SERVER['HTTP_USER_AGENT'], 'MSIE 7.0'))
				$bra = 'ieO';
			elseif (stristr($_SERVER['HTTP_USER_AGENT'], 'MSIE 8.0'))
				$bra = 'ieO';
		} //isset($_SERVER['HTTP_USER_AGENT'])
		return $bra;
	}
	public function signer()
	{
		$this->language->load('agoo/signer/signer');

		         /*
		         if (isset($this->data['thislist']['langfile']) && $this->data['thislist']['langfile']!='') {
                   $this->language->load($this->data['thislist']['langfile']);

                 }
                   */
		$this->getChild('common/seoblog');
		$html                      = "<script>var sdata = new Array();
					sdata['code'] 	 = 'error';
					sdata['error'] 	 = 'customer_id';
				 </script>";
		$this->data['signer_code'] = false;
		$this->data['href']        = "#";
		if (isset($this->request->get['id'])) {
			$this->data['id'] = $this->request->get['id'];
		} //isset($this->request->get['id'])
		else {
			$this->data['id'] = false;
		}
		if (isset($this->request->get['pointer'])) {
			$this->data['pointer'] = $this->request->get['pointer'];
		} //isset($this->request->get['pointer'])
		else {
			$this->data['pointer'] = false;
		}
		$allow_pointers = array(
			'record_id',
			'product_id',
			'blog_id'
		);
		if (!in_array($this->data['pointer'], $allow_pointers))
			$this->data['pointer'] = false;
		if ($this->data['pointer'] == 'product_id') {
			$this->data['href'] = $this->url->link('product/product', 'product_id=' . $this->data['id']);
		} //$this->data['pointer'] == 'product_id'
		if ($this->data['pointer'] == 'record_id') {
			$this->data['href'] = $this->url->link('record/record', 'record_id=' . $this->data['id']);
		} //$this->data['pointer'] == 'record_id'
		if ($this->customer->isLogged() && $this->data['id'] && $this->data['pointer']) {
			if ($this->data['pointer'] == 'record_id') {
				$this->load->model('catalog/record');
				$record_info        = $this->model_catalog_record->getRecord($this->data['id']);
				$this->data['href'] = $this->url->link('record/record', 'record_id=' . $this->data['id']);
				if (isset($record_info['comment'])) {
					$record_comment = unserialize($record_info['comment']);
				} //isset($record_info['comment'])
				else {
					$record_comment = false;
				}
			} //$this->data['pointer'] == 'record_id'
			else {
			}
			if ($this->data['pointer'] == 'product_id') {
				$record_info              = true;
				$record_comment['signer'] = true;
				$this->data['href']       = $this->url->link('product/product', 'product_id=' . $this->data['id']);
			} //$this->data['pointer'] == 'product_id'
			if ($record_info) {
				if (isset($record_comment['signer']) && $record_comment['signer']) {
					$this->data['customer_id'] = $this->customer->getId();
					if ($this->data['id']) {
						$this->load->model('agoo/signer/signer');
						$signer_status = $this->model_agoo_signer_signer->getStatus($this->data['id'], $this->data['customer_id'], $this->data['pointer']);
						if (!$signer_status) {
							$this->model_agoo_signer_signer->setStatus($this->data['id'], $this->data['customer_id'], $this->data['pointer']);
							$html                      = "<script>var sdata = new Array();
									sdata['code'] 	 = 'success';
									sdata['success'] = 'set';
						  		</script>";
							$this->data['signer_code'] = 'set';
						} //!$signer_status
						else {
							$this->model_agoo_signer_signer->removeStatus($this->data['id'], $this->data['customer_id'], $this->data['pointer']);
							$html                      = "<script>var sdata = new Array();
									sdata['code'] 	 = 'success';
									sdata['success'] 	 = 'remove';
						  		</script>";
							$this->data['signer_code'] = 'remove';
						}
					} //$this->data['id']
					else {
						$html                      = "<script>var sdata = new Array();
								sdata['code'] 	 = 'error';
								sdata['error'] 	 = 'record_id';
						  </script>";
						$this->data['signer_code'] = 'record_id';
					}
				} //isset($record_comment['signer']) && $record_comment['signer']
				else {
					$html                      = "<script>var sdata = new Array();
								sdata['code'] 	 = 'error';
								sdata['error'] 	 = 'no_signer';
						  </script>";
					$this->data['signer_code'] = 'no_signer';
				}
			} //$record_info
		} //$this->customer->isLogged() && $this->data['id'] && $this->data['pointer']
		else {
			$html                      = "<script>var sdata = new Array();
							sdata['code'] 	 = 'error';
							sdata['error'] 	 = 'customer_id';
					  </script>";
			$this->data['signer_code'] = 'customer_id';
			$this->language->load('account/login');
			$this->data['text_new_customer']            = $this->language->get('text_new_customer');
			$this->data['text_register']                = $this->language->get('text_register');
			$this->data['text_register_account']        = $this->language->get('text_register_account');
			$this->data['text_returning_customer']      = $this->language->get('text_returning_customer');
			$this->data['text_i_am_returning_customer'] = $this->language->get('text_i_am_returning_customer');
			$this->data['text_forgotten']               = $this->language->get('text_forgotten');
			$this->data['entry_email']                  = $this->language->get('entry_email');
			$this->data['entry_password']               = $this->language->get('entry_password');
			$this->data['button_continue']              = $this->language->get('button_continue');
			$this->data['button_login']                 = $this->language->get('button_login');
			if (isset($this->error['warning'])) {
				$this->data['error_warning'] = $this->error['warning'];
			} //isset($this->error['warning'])
			else {
				$this->data['error_warning'] = '';
			}
			if (isset($this->session->data['success'])) {
				$this->data['success'] = $this->session->data['success'];
				unset($this->session->data['success']);
			} //isset($this->session->data['success'])
			else {
				$this->data['success'] = '';
			}
			if (isset($this->request->post['email'])) {
				$this->data['email'] = $this->request->post['email'];
			} //isset($this->request->post['email'])
			else {
				$this->data['email'] = '';
			}
			if (isset($this->request->post['password'])) {
				$this->data['password'] = $this->request->post['password'];
			} //isset($this->request->post['password'])
			else {
				$this->data['password'] = '';
			}
			$this->data['action']    = $this->url->link('account/login', '', 'SSL');
			$this->data['register']  = $this->url->link('account/register', '', 'SSL');
			$this->data['forgotten'] = $this->url->link('account/forgotten', '', 'SSL');
			if (isset($this->request->post['redirect']) && (strpos($this->request->post['redirect'], $this->config->get('config_url')) !== false || strpos($this->request->post['redirect'], $this->config->get('config_ssl')) !== false)) {
				$this->data['redirect'] = $this->request->post['redirect'];
			} //isset($this->request->post['redirect']) && (strpos($this->request->post['redirect'], $this->config->get('config_url')) !== false || strpos($this->request->post['redirect'], $this->config->get('config_ssl')) !== false)
			elseif (isset($this->session->data['redirect'])) {
				$this->data['redirect'] = $this->session->data['redirect'];
				unset($this->session->data['redirect']);
			} //isset($this->session->data['redirect'])
			else {
				$this->data['redirect'] = $this->data['href'];
			}
		}
		$template = '/template/agoodonut/module/blog_signer.tpl';
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . $template)) {
			$this->template = $this->config->get('config_template') . $template;
		} //file_exists(DIR_TEMPLATE . $this->config->get('config_template') . $template)
		else {
			$this->template = 'default' . $template;
		}
		$this->data['theme'] = $this->config->get('config_template');
		$html .= $this->render();
		return $this->response->setOutput($html);
	}
	public function blogadmin()
	{
		$this->data['common'] = false;
		$this->load->model('setting/setting');
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$settings_admin = $this->model_setting_setting->getSetting('blogadmin', 'https_admin_path');
		} //isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))
		else {
			$settings_admin = $this->model_setting_setting->getSetting('blogadmin', 'http_admin_path');
		}
		foreach ($settings_admin as $key => $value) {
			$this->data['admin_path'] = $value;
		} //$settings_admin as $key => $value
		if (isset($this->session->data['token'])) {
			$this->data['token'] = $this->session->data['token'];
		} //isset($this->session->data['token'])
		else {
			$this->data['token'] = "";
		}
		if (!class_exists('User')) {
			require_once(DIR_SYSTEM . 'library/user.php');
			$this->registry->set('user', new User($this->registry));
		} //!class_exists('User')
		if (isset($this->request->post['post'])) {
			$post  = base64_decode($this->request->post['post']);
			$_POST = unserialize($post);
		} //isset($this->request->post['post'])
		else {
			$_POST = array();
		}
		if (isset($this->request->post['get'])) {
			$get  = base64_decode($this->request->post['get']);
			$_GET = unserialize($get);
		} //isset($this->request->post['get'])
		else {
			$_GET = array();
		}
		$this->request->get  = $_GET;
		$this->request->post = $_POST;
		if ($this->user->hasPermission('access', 'module/blog')) {
			$this->data['common'] = true;
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/agoodonut/module/blogadminmenu.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/agoodonut/module/blogadminmenu.tpl';
			} //file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/blogadminmenu.tpl')
			else {
				$this->template = 'default/template/agoodonut/module/blogadminmenu.tpl';
			}
			$this->data['theme'] = $this->config->get('config_template');
			$this->response->setOutput($this->render());
		} //$this->user->hasPermission('access', 'module/blog')
		else {
			$this->data['common'] = false;
		}
	}
    public function getThemeFile($file) {
     		$themefile = false;
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/'.$file)) {
				$themefile = $this->config->get('config_template') . '/'.$file;
			} //file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')
			else {
				if (file_exists(DIR_TEMPLATE . 'default/'.$file)) {
					$themefile = 'default/'.$file;
				}
			}
      return $themefile;
    }
}
?>
<!-- Sidebar ================================================== -->
<style type="text/css">
	ul, ol{
		margin: 0px;
	}
</style>

<div id="sidebar" class="span3">
    <ul id="sideManu" class="nav nav-tabs nav-stacked">
	 	<?php
    	foreach ($tree_list as $list_key => $list_value) 
        {
        	$category_name = $list_value['category_name'];

        	if (isset($_GET['category'])) 
        	{
        		$selected_category_id = $_GET['category'];
	            $is_found_category = false;

	            if ($selected_category_id == $list_value['category_id']) 
	            	$is_found_category = true;
	            else if ($list_value['child_category']) 
	            {
	            	foreach ($list_value['child_category'] as $child_cat_value) 
					{
						if ($selected_category_id == $child_cat_value['category_id']) 
						{
							$is_found_category = true;
							break;
						}
			        }	
	            }

		        $default_open = ($is_found_category) ? 'open' : '';
	        	$default_ul_css = (!$is_found_category) ? 'style="display:none"' : '';
	        	$default_li_class = ($is_found_category) ? 'class="active"' : '';   
        	}
        	else
        	{
        		$default_open = ($list_key == 0) ? 'open' : '';
	        	$default_ul_css = ($list_key != 0) ? 'style="display:none"' : '';
	        	$default_li_class = ($list_key == 0) ? 'class="active"' : '';
        	}

        	if (!$list_value['child_category']) 
        		echo '<li><a href="'.base_url('categories/'.url_title($category_name, '-', true).'?category=').$list_value['category_id'].'">'.$category_name.'</a></li>';
        	else
	        {
	        	echo '<li class="subMenu '.$default_open.'"><a> '.$category_name.'</a>
						<ul '.$default_ul_css.'>
							<li><a '.$default_li_class.' href="'.base_url('categories/'.url_title($category_name, '-', true).'?category=').$list_value['category_id'].'"><i class="icon-chevron-right"></i>All in '.$category_name.' </a></li>';
		        	
				        	foreach ($list_value['child_category'] as $child_cat_value) 
				        	{
				        		$child_cat_name = $child_cat_value['category_name'];

				        		echo '<li><a href="'.base_url('categories/'.url_title($child_cat_name, '-', true).'?category=').$child_cat_value['category_id'].'"><i class="icon-chevron-right"></i>'.$child_cat_name.' </a></li>';
				        	}

		        echo "</ul>
					</li>";
			}
        }
        ?>
	</ul>
</div>
<!-- Sidebar end=============================================== -->

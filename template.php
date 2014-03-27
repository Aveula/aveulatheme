<?php

function aveulatheme_preprocess_html(&$variables) {
  $options = array(
    'group' => JS_THEME,
  );
  drupal_add_js('http://code.jquery.com/jquery-1.10.1.min.js', $options);
  drupal_add_js('http://code.jquery.com/jquery-migrate-1.2.1.min.js', $options);
  //drupal_add_js(drupal_get_path('theme', 'aveulatheme') . '/js/jquery.easing.1.3.js', $options);
  //drupal_add_js(drupal_get_path('theme', 'aveulatheme') . '/js/jquery.jcarousel.pack.js', $options);
  drupal_add_js(drupal_get_path('theme', 'aveulatheme') . '/javascripts/topButton.js', $options);
  //drupal_add_js('http://html5shiv.googlecode.com/svn/trunk/html5.js', 
//	  array(
//		  'group' => JS_THEME,
//		  'browsers' =>
//		  array(
//			  'IE' => 'lt IE 9',
//			  '!IE' => FALSE
//		  ),
//		  'preprocess' => FALSE
//	  )
 // );
}


function aveulatheme_process_html(&$variables) {
  $variables['head'] = '<meta charshet="utf-8" />';
  $variables['head'] .= '<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />';
  $variables['head'] .= '<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />';
  $variables['head'] .= '<meta name="description" content="Aveula Redes SL es una compañia dedicada a cración de redes comerciales, servicios inmobiliarios, productos financieros y outsourcing." />';
  $variables['head'] .= '<meta name="keywords" content="Productos financieros de alta rentabilidad, compra y/o alquiler de inmuebles de todo tipo, creación de redes comerciales y outsourcing." />';
  $variables['head'] .= '<meta name="Author" content="Txorua" />';

  // Web Fonts
  $variables['head'] .= '<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet" type="text/css">';
  $variables['head'] .= '<link href="http://fonts.googleapis.com/css?family=Droid+Serif" type="text/css">';

  // http://www.milesjcarter.co.uk/blog/web-design-development/drupal-7-seo-controlling-page-titles-theme-layer/
  //$variables['head_title'] = implode(' | ', array(drupal_get_title(), variable_get('site_name', ''), ));
  $variables['head'] .= '<link rel="apple-touch-icon" href="' . drupal_get_path('theme', 'aveulatheme') .'/images/apple-touch-icon.png" />';
  $variables['head'] .= '<link rel="apple-touch-icon" sizes="57x57" href="' . drupal_get_path('theme', 'aveulatheme') . '/images/apple-touch-icon-57x57.png" />';
  $variables['head'] .= '<link rel="apple-touch-icon" sizes="72x72" href="' . drupal_get_path('theme', 'aveulatheme') . '/images/apple-touch-icon-72x72.png" />';
  $variables['head'] .= '<link rel="apple-touch-icon" sizes="76x76" href="' . drupal_get_path('theme', 'aveulatheme') . '/images/apple-touch-icon-76x76.png" />';
  $variables['head'] .= '<link rel="apple-touch-icon" sizes="114x114" href="' . drupal_get_path('theme', 'aveulatheme') . '/images/apple-touch-icon-114x114.png" />';
  $variables['head'] .= '<link rel="apple-touch-icon" sizes="120x120" href="' . drupal_get_path('theme', 'aveulatheme') . '/images/apple-touch-icon-120x120.png" />';
  $variables['head'] .= '<link rel="apple-touch-icon" sizes="144x144" href="' . drupal_get_path('theme', 'aveulatheme') . '/images/apple-touch-icon-144x144.png" />';
  $variables['head'] .= '<link rel="apple-touch-icon" sizes="152x152" href="' . drupal_get_path('theme', 'aveulatheme') . '/images/apple-touch-icon-152x152.png" /> ';
}

function aveulatheme_css_alter(&$css) {
    unset($css[drupal_get_path('module','system').'/system.theme.css']);
    //unset($css[drupal_get_path('module','system').'/system.menus.css']);
    //unset($css[drupal_get_path('module','system').'/system.base.css']);
}

function aveulatheme_preprocess_page(&$variables, $hook) {
  if (isset($variables['node'])) {
    // If the node type is "blog_madness" the template suggestion will be "page--blog-madness.tpl.php".
    $variables['theme_hook_suggestions'][] = 'page__'. str_replace('_', '--', $variables['node']->type);
  }
}
function aveulatheme_preprocess_node(&$variables, $hook) {
}


function aveulatheme_item_list($variables) {
  $items = $variables['items'];
  $title = $variables['title'];
  $type = $variables['type'];
  $attributes = $variables['attributes'];

  // Only output the list container and title, if there are any list items.
  // Check to see whether the block title exists before adding a header.
  // Empty headers are not semantic and present accessibility challenges.
  $output = '';
  if (isset($title) && $title !== '') {
    $output .= '<h3>' . $title . '</h3>';
  }

  if (!empty($items)) {
    $output .= "<$type" . drupal_attributes($attributes) . '>';
    $num_items = count($items);
    $i = 0;
    foreach ($items as $item) {
      $attributes = array();
      $children = array();
      $data = '';
      $i++;
      if (is_array($item)) {
        foreach ($item as $key => $value) {
          if ($key == 'data') {
            $data = $value;
          }
          elseif ($key == 'children') {
            $children = $value;
          }
          else {
            $attributes[$key] = $value;
          }
        }
      }
      else {
        $data = $item;
      }
      if (count($children) > 0) {
        // Render nested list.
        $data .= theme_item_list(array('items' => $children, 'title' => NULL, 'type' => $type, 'attributes' => $attributes));
      }
      if ($i == 1) {
        $attributes['class'][] = 'first';
      }
      if ($i == $num_items) {
        $attributes['class'][] = 'last';
      }
      $output .= '<li' . drupal_attributes($attributes) . '>' . $data . "</li>\n";
    }
    $output .= "</$type>";
  }
  $output .= '';
  return $output;
}

function aveulatheme_links__locale_block(&$variables) {
  // the global $language variable tells you what the current language is
  global $language;
  // an array of list items
  $items = array();
  foreach($variables['links'] as $lang => $info) {
      $name     = $info['language']->native;
      $href     = isset($info['href']) ? $info['href'] : '';
      $li_classes   = array('list-item-class');
      // if the global language is that of this item's language, add the active class
      if($lang === $language->language){
            $li_classes[] = 'active';
      }
      $link_classes = array();
      $options = array('attributes' => array('class'    => $link_classes),
                                             'language' => $info['language'],
                                             'html'     => true
                                             );
      $link = l($name, $href, $options);
      // display only translated links
      if ($href) $items[] = array('data' => $link, 'class' => $li_classes);
   }
  // output
  $attributes = array('class' => array(''));
  $output = theme_item_list(array('items' => $items,
                                  'title' => '',
                                  'type'  => 'ul',
                                  'attributes' => $attributes
  			  ));
  return $output;
}

/*
 * Menu principal con un solo nivel
 */

function aveulatheme_links($variables) {
  if (array_key_exists('id', $variables['attributes']) && $variables['attributes']['id'] == 'main-menu') {
    $pid = variable_get('menu_main_links_source', 'main-menu');
    $tree = menu_tree_output(menu_build_tree($pid, array('max_depth' => 2)));
    //dsm($tree);
    return drupal_render($tree);
  }
  return theme_links($variables);
}

/*
 * Catálogo View Theme Functions
 */

function aveulatheme_views_view_fields__catalogo__page($variables) {
	//kpr($variables);
	$enlace = $variables['fields']['name_field']->content;
	$nombre = $variables['fields']['name_field_1']->content;
	$foto   = $variables['fields']['field_catalogo_foto']->content;

	$output  = '<div class="box">';
	//$output .= $variables['fields']['name_field']->content;
	//$output .= substr($variables['fields']['name_field']->content, 0, -4);
	$output .= str_replace($nombre .'</a>', '', $enlace);
	$output .= '<div class="slide catalogo">';
	$output .= $foto;
	$output .= '<div class="scontent">';
	$output .= '<h2>'. $nombre . '</h2>';
	$output .= '</div></div>';
	$output .= '</a>';
	$output .= '</div>';
	return $output;
}

function aveulatheme_views_view_fields__catalogo__block_1($variables) {
	//dsm($variables);
	$enlace = $variables['fields']['name_field']->content;
	$nombre = $variables['fields']['name_field_1']->content;
	$foto   = $variables['fields']['field_catalogo_foto']->content;

	$output  = '<div class="box">';
	//$output .= $variables['fields']['name_field']->content;
	//$output .= substr($variables['fields']['name_field']->content, 0, -4);
	$output .= str_replace($nombre .'</a>', '', $enlace);
	$output .= '<div class="slide catalogo">';
	$output .= $foto;
	$output .= '<div class="scontent">';
	$output .= '<h2>'. $nombre . '</h2>';
	$output .= '</div></div>';
	$output .= '</a>';
	$output .= '</div>';
	return $output;
}

/*
 * Productos por serie View Theme Functions
 */

function aveulatheme_views_view_fields__productos_por_serie__page($variables) {
	$enlace = $variables['fields']['title_field']->content;
	$nombre = $variables['fields']['title_field_1']->content;
	$foto   = $variables['fields']['field_miniatura_producto']->content;
	$desc   = $variables['fields']['field_miniatura_producto_desc']->content;

	$output  = '<div class="box">';
	$output .= str_replace($nombre .'</a>', '', $enlace);
	$output .= '<div class="slide">';
	$output .= $foto;
	$output .= '<div class="scontent">';
	$output .= '<h2>'. $nombre . '</h2>';
	$output .= '<p>'. $desc . '</p>';
	$output .= '</div></div>';
	$output .= '</a>';
	$output .= '</div>';
	return $output;
}

/*
 * Producto theme functions
 */
function aveulatheme_field__field_fichero_man_instalacion__producto($variables) {
  $output = '';

  // Render the label, if it's not hidden.
  if (!$variables['label_hidden']) {
    $output .= '<div class="field-label"' . $variables['title_attributes'] . '>' . $variables['label'] . ':&nbsp;</div>';
  }

  // Render the items.
  $output .= '<div class="field-items"' . $variables['content_attributes'] . '>';
  foreach ($variables['items'] as $delta => $item) {
    $classes = 'field-item ' . ($delta % 2 ? 'odd' : 'even');
    $output .= '<div class="' . $classes . '"' . $variables['item_attributes'][$delta] . '>' . drupal_render($item) . '</div>';
  }
  $output .= '</div>';

  // Render the top-level DIV.
  $output = '<div class="' . $variables['classes'] . '"' . $variables['attributes'] . '>' . $output . '</div>';

  return $output;
}

/*
 * Navegación entre productos
 *
 * Visto en: https://drupal.org/comment/4238936#comment-4238936
 */
function producto_sibling($dir = 'next', $node, $next_node_text=NULL, $prepend_text=NULL, $append_text=NULL, $tid = FALSE){
  global $language;
  if($tid){
    $query = 'SELECT n.nid, n.title FROM {node} n INNER JOIN {taxonomy_index} tn ON n.nid=tn.nid WHERE '
           . 'n.nid ' . ($dir == 'previous' ? '<' : '>') . ' :nid AND n.type = :type AND n.status=1 '
           . 'AND tn.tid = :tid AND n.language = :language ORDER BY n.nid ' . ($dir == 'previous' ? 'DESC' : 'ASC');
    //use fetchObject to fetch a single row
    $row = db_query($query, array(':nid' => $node->nid, ':type' => $node->type, ':tid' => $tid, ':language' => $language->language))->fetchObject();
  }else{
    $query = 'SELECT n.nid, n.title FROM {node} n WHERE '
           . 'n.nid ' . ($dir == 'previous' ? '<' : '>') . ' :nid AND n.type = :type AND n.status=1 AND n.language = :language '
           . 'ORDER BY n.nid ' . ($dir == 'previous' ? 'DESC' : 'ASC');
    //use fetchObject to fetch a single row
    $row = db_query($query, array(':nid' => $node->nid, ':type' => $node->type, ':language' => $language->language))->fetchObject();
  }
  if($row) {
    $text = $next_node_text ? $next_node_text : $row->title;
    return $prepend_text . l($text, 'node/'.$row->nid, array('rel' => $dir)) . $append_text;
  } else {
      return FALSE;
  }
}

/*
 * https://api.drupal.org/api/drupal/modules!taxonomy!taxonomy.module/function/taxonomy_get_parents_all/7
 */
function catalogo_top_parent($tid=NULL) {
  if ($tid) {
    $top_parent_term = null;
    $parent_terms = taxonomy_get_parents_all($tid);
    foreach($parent_terms as $parent) {
      $parent_parents = taxonomy_get_parents_all($parent->tid);
      if ($parent_parents != false) {
        //this is top parent term
        $top_parent_term = $parent;
      }
    }
    return $top_parent_term;
  }
}

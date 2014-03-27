<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * - $title : The title of this group of rows.  May be empty.
 * - $options['type'] will either be ul or ol.
 * @ingroup views_templates
 */
?>
  <?php print $list_type_prefix; ?>
    <?php $i = 1; ?>
    <?php foreach ($rows as $id => $row): ?>
      <li id="s<?php print $i; ?>" class="<?php print $classes_array[$id]; ?>"><?php print $row; ?></li>
      <?php $i++; ?>
    <?php endforeach; ?>
  <?php print $list_type_suffix; ?>

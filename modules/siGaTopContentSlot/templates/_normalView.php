<?php use_helper('a') ?>

<?php if ($editable): ?>
  <?php include_partial('a/simpleEditWithVariants', array('pageid' => $pageid, 'name' => $name, 'permid' => $permid, 'slot' => $slot)) ?>
<?php endif ?>

<?php $report = $sf_data->getRaw('report'); ?>
  <ol>
    <?php $arrRows = array(); ?>
    <?php if(isset($report->rows) AND is_array($report->rows)): ?>
      <?Php $arrRows = $report->rows; ?>
    <?php else: ?>
      <?php echo __('No response from Google Analytics, please try again later'); ?>
    <?php endif; ?>
    
    <?php foreach($arrRows as $key=>$value): ?>
      <li>
        <a href="<?php echo $value[1] ?>"><?php echo $value[0] ?></a>: <?php echo $value[2] ?>
      </li>
    <?php endforeach; ?>
  </ol>
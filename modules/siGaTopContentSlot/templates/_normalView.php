<?php use_helper('a') ?>

<?php if ($editable): ?>
  <?php include_partial('a/simpleEditWithVariants', array('pageid' => $pageid, 'name' => $name, 'permid' => $permid, 'slot' => $slot)) ?>
<?php endif ?>

  <div class="clearfix" style="clear:both; width:100%">
  
    <?php 
    $report = $sf_data->getRaw('report');
    //echo '<pre>'.print_r($report->rows, true).'</pre>'; 
    ?>
  <ol>
    <?php 
    
    $arrRows = array();
    if(isset($report->rows) AND is_array($report->rows)){
      $arrRows = $report->rows;
    }else{
      echo "No response from Google Analytics, please try again later";
      echo '<br /><br />Error: <pre>'.print_r($report, 1).'</pre>';
    }
    foreach($arrRows as $key=>$value): ?>
    <li>
      <a href="http://www.robertspeer.com<?php echo $value[1] ?>"><?php echo $value[0] ?></a>: <?php echo $value[2] ?>
    </li>
      
    <?php endforeach; ?>
  </ol>
  
  
</div>

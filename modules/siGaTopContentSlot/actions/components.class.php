<?php
class siGaTopContentSlotComponents extends aSlotComponents
{
  public function executeEditView()
  {
    // Must be at the start of both view components
    $this->setup();
    
    // Careful, don't clobber a form object provided to us with validation errors
    // from an earlier pass
    if (!isset($this->form))
    {
      $this->form = new siGaTopContentSlotEditForm($this->id, $this->slot->getArrayValue());
    }
  }
  public function executeNormalView()
  {
    $this->setup();
    $this->values = $this->slot->getArrayValue();
    
    $limit = 10;
    if(isset($this->values['limit'])){
      $limit = $this->values['limit'];
    }
    
    //$this->report = $this->getTopContent(array('limit'=>$limit));
    // use the report type + limit value as a key, and only update once a day
    $this->report = $this->fetchCached('topContent'.$limit, $options=array('limit'=>$limit), $interval=86400);
    
    
  }
  
  private function getTopContent($options){
    
    if(!isset($options['limit']) OR !is_numeric($options['limit'])){
      throw new sfException('A limit of type integer is required');
    }
    
    $arrGaReportsSettings = sfConfig::get('app_a_gareports', false);
    
    if(!isset($arrGaReportsSettings['username'])){
      die('Google Analytics username is missing');
    }
    if(!isset($arrGaReportsSettings['password'])){
      die('Google Analytics password is missing ');
    }
    if(!isset($arrGaReportsSettings['profile'])){
      die('Google Analytics profile is missing ');
    }
    if(!isset($arrGaReportsSettings['key'])){
      die('Google Analytics API Key is missing ');
    }
    
    
    try {
      // create an instance of the GoogleAnalytics class using your own Google {email} and {password}
      // todo pull all config data from app.yml
      $ga = new GoogleAnalytics($arrGaReportsSettings['username'],$arrGaReportsSettings['password']);

      // set the Google Analytics profile you want to access - format is 'ga:123456';
      $ga->setProfile($arrGaReportsSettings['profile']);
      $ga->setKey($arrGaReportsSettings['key']);

      // set the date range we want for the report - format is YYYY-MM-DD
      // todo: have this adjustable from the slot edit view
      $dateFormat = 'Y-m-d';
      $startDate = date($dateFormat, strtotime('-1 month'));
      $endDate = date($dateFormat, time());
      $ga->setDateRange($startDate,$endDate);

      // get the report for date and country filtered by Australia, showing pageviews and visits
      $report = $ga->getReport(
        array('dimensions'=>urlencode('ga:pagetitle,ga:pagePath'),
          'metrics'=>urlencode('ga:pageviews'),
          'sort'=>'-ga:pageviews',
          'max-results' => $options['limit']
          ), 
          $returnJson = TRUE
        );

      
    } catch (Exception $e) { 
      $report = 'Error: ' . $e->getMessage(); 
    }
    
    return $report;
  }
  
  
  /**
   * Lovingly ripped off from P'unk Ave's aFeed plugin, and moved from model controller
   * @param mixed $url
   * @param mixed $interval
   * @return mixed
   */
  private function fetchCached($key, $options, $interval = 300)
  {
    $cache = aCacheTools::get('feed');
    $feed = $cache->get($key, false);
    if ($feed === 'invalid')
    {
      return false;
    }
    else
    {
      if ($feed !== false)
      {
        // sfFeed is designed to serialize well
        $feed = unserialize($feed);
      }
    }
    if (!$feed)
    {
      try
      {
        // We now always use the fopen adapter and specify a time limit, which is configurable.
        // Francois' comments about fopen being slow are probably dated, the stream wrappers are 
        // quite good in modern PHP and in any case Apostrophe uses them consistently elsewhere
       // $options = array('adapter' => 'sfFopenAdapter', 'adapter_options' => array('timeout' => sfConfig::get('app_a_feed_timeout', 30)));
       // $feed = sfFeedPeer::createFromWeb($url, $options);    
        $feed = $this->getTopContent($options);
        $cache->set($key, serialize($feed), $interval);
      }
      catch (Exception $e)
      {
        // Cache the fact that the feed is invalid for 60 seconds so we don't
        // beat the daylights out of a dead feed
        $cache->set($key, 'invalid', 60);
        return false;
      }
    }
    return $feed;
  }
}

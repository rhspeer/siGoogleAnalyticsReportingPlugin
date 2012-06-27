siGoogleAnalyticsReportingPlugin
================================

Used to display web stats from an associated Google Analytics account, in the [Apostrophe CMS](http://apostrophenow.org)

All reports are cached, and updated daily.

Available Report Slots
----------------------
* siGaTopContentSlots -- displays the top _n_ hits on the site, and the hit count in an ordered list

Installation
------------
#  download to plugins directory or preferably use svn externals (I think this is possible with gitHub)
#  add your google analytics credential to app.yml, they should look something like this:
    a:
      gareports:
        username: username@gmail.com
        password: yourpassword
        profile: profile_id_starts_with_ga:
        key: looong_api_key 
# rebuild your classes from the command line:
    ./symfony doctrine:build --classes
# add plugin to config/ProjectConfiguration.class.php
# add module(s) to settings.yml to enable them
# add slot to app.yml under "slot_types:"
# optionally add slot to standard area
# clear cache: ./symfony cc
# make sure the slot is included in an area
# try it out

Finding your google info:
-------------------------
* username & password: you can use your administrator login, however it would be better to create a subordinate account that has read only access so you don't share your admin account with everyone with code access
* profileId:  
  # log into your analytics account, and choose the site you need stats for
  # the profile id is the 6 digit integer after the p 
  # add it to the app.yml starting with "ga:", for example ga:123456
* Api Key: login to google, and goto https://code.google.com/apis/console this will allow you to get your full quota from the API and for google to contact you if there are any problems


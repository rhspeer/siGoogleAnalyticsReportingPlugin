siGoogleAnalyticsReportingPlugin
================================
Screencast on how it works: http://www.youtube.com/watch?v=KOVSGft26yg
Done with screenr.com, a wonderful online screencast tool


Used to display web stats from an associated Google Analytics account, in the [Apostrophe CMS](http://apostrophenow.org)

All reports are cached, and updated daily.

Available Report Slots
----------------------
* siGaTopContentSlots -- displays the top _n_ hits on the site, and the hit count in an ordered list

Installation
------------
1.  download to plugins directory or preferably use svn externals (I think this is possible with gitHub)
2.  add your google analytics credential to app.yml, they should look something like this:
    <pre><code>
        a:
          gareports:
            username: username@gmail.com
            password: yourpassword
            profile: profile_id_starts_with_ga:
            key: looong_api_key 
    </code></pre>
3. rebuild your classes from the command line:
    ./symfony doctrine:build --classes
4. add plugin to config/ProjectConfiguration.class.php
5. add module(s) to settings.yml to enable them
6. add slot to app.yml under "slot_types:"
7. optionally add slot to standard area
8. clear cache: ./symfony cc
9. make sure the slot is included in an area
10. try it out

Finding your google info:
-------------------------
* username & password: you can use your administrator login, however it would be better to create a subordinate account that has read only access so you don't share your admin account with everyone with code access
* profileId:  
  1. log into your analytics account, and choose the site you need stats for
  2. the profile id is the 6 digit integer after the p 
  3. add it to the app.yml starting with "ga:", for example ga:123456
* Api Key: login to google, and goto https://code.google.com/apis/console this will allow you to get your full quota from the API and for google to contact you if there are any problems


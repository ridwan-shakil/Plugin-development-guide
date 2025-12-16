### ------------- Prepare Plugin for wordpress.org ---------------

## Standards
  1. plugin name must be unique
  2. correct readme.txt file
  3. generate .pot file by this command :  wp i18n make-pot .
  4. translation function is not required
  5. Create 2 banner image & 1 icon


## Check coding standards : 
don't run for js files,  eg: phpcs ./includes/
```
    phpcbf .
    phpcs .

# Fix issues

    phpcbf --standard=WordPress .
    phpcs --standard=WordPress . 
```


## Test your plugin with this wp plugin: Plugin Check (PCP)
   tests if a plugin meets WordPress.org standards, flags violations, and helps speed up approval, even if not for the directory.




### ------------- Submit plugin for review ---------------

## If any issue arrise
  1) solve all issues carefully
  2) resubmit the solved plugin
  3) reply to the wp email telling them what you changed 
  



### ------------ After plugin haave approved -------------

## Upload plugin via SVN ( using GUI, it can be done via command line also )
  1) Download SVN if not yeat
  2) Create a folder inside D drive , create another folder with your plugin name
  3) right click on that folder > click "svn checkout"> pest SVN url here which you will get in your email from wp.> click OK   (it grabs the online version of this plugin to local)
  4) indide asset/ folder put : banner, icon, screenshots
  5) inside trunks/ folder put all your codes that lives inside your main plugin file.   don't pest with main folder, just pest it's inner file,folders
  6) again right click > click "svn commit"> click ALL > write a commit messege> click OK
  7) now pest wp.orgs username ( ridwan25 ) it's case sensitive
  8) SVN password : that you can genarate from "wp.org > accounts & security > svn"  (or use previously saved svn password)
  9) 

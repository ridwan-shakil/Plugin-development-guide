## common rules for all files:
        1) file documentation
        2) namespacing
        3) if not ABSPATH exit
        4) Class

      Note
        * Single responsiblity for each class


## main-plugin-file.php
      1) Plugin header
      2) load all the files
      3) create single tone  instense of "class-plugin.php" class. eg: NameSpacing\Plugin::get_instance()

    Not to do :
        1) don't add namespacing in this main file
        2) don't add any plugin logic in this file

  ## includes/core/class-plugin.php
      1) Class Plugin to create single tone instance ( an Archituctural design pattern )
      2) inside init function load : loader class

      


      

Your work is only to create a .pot file 

<!-- Just run this command inside your plugin -->
wp i18n make-pot .


There are 3 type of files 
one .pot file 
one .po file for every language 
one .mo file for every language 

There are wordpress won team to translate the theme & plugins , they are called translators . 
Those Translators work is to crate .po & .mo files for every languages 

there are many ways to crate an .pot file   |  see the documentation https://developer.wordpress.org/plugins/internationalization/localization/
You can use poedit software to create this 3 types of files 

-------------------------
Create .pot file 
-------------------------
open Poedit software 
File --> New from pot/po files --> select  "bulk-wordrpess " file --> click "Extract from source --> click + & add the plugin main folder -->
add functions that you used to translate --> generate .po & .mo file -- Save files

[ After generating the PO file you can rename the file to POT. If a MO was generated then you can delete that file as it is not needed.
If you don’t have the pro version you can easily get the Blank POT and use that as the base of your POT file. ]

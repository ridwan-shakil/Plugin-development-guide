<?php




//=================================================
phpcs      // it is for finding the errord 
phpcbf     // it is for auto fixing the errors 

    
// ----------------------
// see errors & warnings ( uses phpcs )
// ----------------------
// it runs for all the files 
    phpcs --standard=WordPress .
or
// It runs for a specific file
    phpcs --standard=WordPress path/to/your/code        //e;g :   phpcs --standard=WordPress  admin/partials/add_team_section.php

  
// ----------------------
// Auto fix most of the errors ( uses phpcbf )
// ----------------------
// it runs for all the files 
      phpcbf --standard=WordPress .
or 
// it runs for a specific file
      phpcbf --standard=WordPress path/to/your/code

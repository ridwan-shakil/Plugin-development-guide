<?php



// ----------------------
// see errors & warnings ( uses phpcs )
// ----------------------
// it runs for all the files 
    phpcs --standard=WordPress .
or
// It runs for a specific file
    phpcs --standard=WordPress /path/to/your/code

  
// ----------------------
// Auto fix most of the errors ( uses phpcbf )
// ----------------------
// it runs for all the files 
      phpcbf --standard=WordPress .
or 
// it runs for a specific file
      phpcbf --standard=WordPress /path/to/your/code

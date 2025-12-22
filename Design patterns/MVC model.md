# MVC = Model View Controller, to manage code for large projects
    view -> shows date
    Controller -> logics
    Model -> database interactions

## The golden separation rule (remember this 🔑), Ask this question for every line of code:

    ❓ Is this WordPress hook logic? → Controller  ( If it uses add_action or add_filter → it’s a Controller )
    ❓ Is this data / rule / DB? → Model
    ❓ Is this HTML? → View
    
    If one file answers more than one → refactor.


##  Controller
    add_action, add_filter
    AJAX handlers
    Capability + nonce checks
    Calls Models
    Loads Views

## Model
      $wpdb queries
      Validation & rules
      Calculations
      CRUD operations
      
## View
      HTML only
      Escaping output
      Receives data (never fetches)


## Request (hook / AJAX / page load)
             
                ↓
    Controller
          - add_action / add_filter
          - permissions, nonces
          - collect input
          - call Models
          - load Views
                ↓
    Model
          - DB
          - business rules
          - validation
                ↓
    View
          - HTML
          - esc_html / esc_attr

      

### One rule that will save you years
    If you delete your View files and the plugin still “works”, your architecture is correct.
    Views are replaceable.
    Models and Controllers are not.

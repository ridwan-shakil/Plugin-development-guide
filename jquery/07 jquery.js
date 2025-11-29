;(function($){
    
//  Alloways Write jquery inside this code to avoid conflicts with other files
  
})(jQuery);


// If code is not working 
    1) try by changing the code location
    2) If code is loading from server try this methos :  $(document).on('click', '#yourid', function() { alert("hello"); });
    3) check if the code is dependent on other code such as jQuery 
    4)

// ==========================================
// Ajax
// ==========================================
$.ajax({
            type: "post",
            url: "right_sidebar.php",
            data: ',
            success: function (response) {
             $('.result').text(response);
                }
          });

----------------------//Easy way of using Ajax-------------------
//jqpost
    $.post("url", data,
    function (data, textStatus, jqXHR) {
        
    },
    "dataType"
);
//jqget
$.get("url", data,
    function (data, textStatus, jqXHR) {
        
    },
    "dataType"
);

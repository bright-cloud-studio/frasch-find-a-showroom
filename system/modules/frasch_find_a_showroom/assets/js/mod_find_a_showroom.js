
// When the page is loaded
$( document ).ready(function() {
    
    
    // When our 'select_your_state' select changes
    $( ".select_your_state" ).on( "change", function() {
        
         var entry_found = false;
        
        $('#state_heading').html($(this).find('option:selected').text());

        // store our selected state
        var selectedState = this.value;

        
        // Loop through each listing
        $( ".showroom_list .showroom" ).each(function() {
            
            // If this rep has our selected state in it's class list, show the rep
            if($(this).hasClass(selectedState)) {
                
                // Get our product line filter value
                var selectedProductLine = $( ".product_line option:selected" ).val();
                
                if(selectedProductLine == '') {
                    // if there is nothing selected then show our rep
                    $(this).show();
                    entry_found = true;
                }
                else {
                    // if there is something selected see if it matches our listing
                    if($(this).data('product-line') == selectedProductLine) {
                        $(this).show();
                        entry_found = true;
                    }
                    else
                        $(this).hide();
                }
            } else {
                $(this).hide();
            }
        });
        
        if(!entry_found)
            $('#empty').show();
        else
            $('#empty').hide();
        
    });
    
    
    // When our 'select_your_state' select changes
    $( ".product_line" ).on( "change", function() {
        
         var entry_found = false;
        
        // store our selected product line
        var selectedProductLine = this.value;
        
        // Loop through each listing
        $( ".showroom_list .showroom" ).each(function() {

            // If this rep has our selected state in it's class list, show the rep
            if($(this).data('product-line') == selectedProductLine) {
                
                // Get our selected state
                var selectedState = $( ".select_your_state option:selected" ).val();
                
                if(selectedState == '') {
                    // if our selected state is empty show our listing
                    $(this).show();
                    entry_found = true;
                } else {
                    // if we selected a state, make sure the state is in the class list
                    if($(this).hasClass(selectedState)) {
                        $(this).show();
                        entry_found = true;
                    }
                    else
                        $(this).hide();
                }

            } else {
                $(this).hide();
            }
        });
        
        if(!entry_found)
            $('#empty').show();
        else
            $('#empty').hide();

    });
    
    
    
});

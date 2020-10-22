$(document).ready(function(){
   
    $("#divPendingComplaints").delegate( "tbody > tr","click", function(){
        
        var comp_code = $.trim($(this).attr("alt"));

        $("#divComplaintDetails").addClass("styled-opacity");
        
        $("#divPendingComplaints table tbody tr").each(function(){
            
            if( $(this).attr("alt") === comp_code ){ $(this).find('td').addClass("bg-info"); }
            
            else{ $(this).find('td').removeClass("bg-info"); }
        });
        
        makeAjaxCall(comp_code, "P");
    });
    
    $("#divResolvedComplaints").delegate( "tbody > tr","click", function(){
        
        var comp_code = $.trim($(this).attr("alt"));

        $("#divComplaintDetails").addClass("styled-opacity");
        
        $("#divResolvedComplaints table tbody tr").each(function(){
            
            if( $(this).attr("alt") === comp_code ){ $(this).find('td').addClass("bg-info"); }
            
            else{ $(this).find('td').removeClass("bg-info"); }
        });
        
        makeAjaxCall(comp_code, "R");
    });
});

function makeAjaxCall(comp_code, comp_type){
    
    $.ajax({
           
        url: BASE_URL + "ajax-load-complaint-details",
        data: { complaint_code : comp_code, complaint_type: comp_type },
        method: "POST",
        dataType: "html",
        success: function( reponse_html ){

            $("#divComplaintDetails").html( reponse_html );
            $("#divComplaintDetails").removeClass("styled-opacity");
        }
    });
}
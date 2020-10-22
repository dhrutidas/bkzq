$(document).ready(function () {
    //this will trigger to load the chapter in subject load
    //$('#bronze, #silver').hide();
    $("#inputPackage").change(function(){
        var subjectId = $("#inputPackage").val();
        if(subjectId == 'B'){
            $('#bronze').show();
            $('#silver').hide();
            $('#gold').hide();
        }else if(subjectId == 'S'){
            $('#bronze').show();
            $('#silver').show();
            $('#gold').hide();
        }else if(subjectId == 'G'){
            $('#bronze').show();
            $('#silver').show();
            $('#gold').show();
        }else{
           $('#bronze, #silver').hide(); 
        }
    });
    $("#inputPackageAffiliate").change(function(){ 
    var subjectId = $("#inputPackageAffiliate").val();
    if(subjectId == 'B'){
        $('#bronzeAfflt').show();
        $('#silverAfflt').hide();
        $('#goldAfflt').hide();
    }else if(subjectId == 'S'){
        $('#bronzeAfflt').show();
        $('#silverAfflt').show();
        $('#goldAfflt').hide();
    }else if(subjectId == 'G'){
        $('#bronzeAfflt').show();
        $('#silverAfflt').show();
        $('#goldAfflt').show();
    }else{
       $('#bronzeAfflt, #silverAfflt').hide(); 
    }

});
    jQuery('#inputClass').on('change', function(){
        str='<option value="">----Select----</option>';
        stdid=jQuery(this).val();
        jQuery.ajax({
            type:'POST',
            data:{stdid},
            url:'signup/getsubjectbystds'
        }).done(function(data){
            rawdata=jQuery.parseJSON(data);
            if(rawdata.error===false){
                for(i=0; i<rawdata.data.length; i++){
                    str+='<option value="'+rawdata.data[i].subjectID+'">'+rawdata.data[i].subjectName+'</option>';
                }
                jQuery('#inputSubject1, #inputSubject2, #inputSubject3, #inputSubject4, #inputSubject5, #inputSubject6').html(str);
            }
        })
    });

    $('#affiliateOptIn').change(function(){
        $('#affiliateUser').toggle();
        $('#nonAffiliateUser').toggle();
    });

    $('#inputRegisterStudent').change(function(){
        $('#affiliateStudentDetails').toggle();
        if($('#affiliateStudentDetails').is(':hidden')){
            $('#addSignupformAffiliate #inputFirstName').attr('required', false);
            $('#addSignupformAffiliate #inputEmail').attr('required', false);
            $('#addSignupformAffiliate #inputBoard').attr('required', false);
            $('#addSignupformAffiliate #inputSchool').attr('required', false);
            $('#addSignupformAffiliate #inputClass').attr('required', false);
        }else{
            $('#addSignupformAffiliate #inputFirstName').attr('required', true);
            $('#addSignupformAffiliate #inputEmail').attr('required', true);
            $('#addSignupformAffiliate #inputBoard').attr('required', true);
            $('#addSignupformAffiliate #inputSchool').attr('required', true);
            $('#addSignupformAffiliate #inputClass').attr('required', true);
        }
        
    });       
     
});

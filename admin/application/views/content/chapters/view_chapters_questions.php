<script type="text/javascript" src="<?php echo base_url("assets/dist/js/bootstrap-select.js"); ?>" ></script>
<link rel="stylesheet" href="<?php echo base_url("assets/dist/css/bootstrap-select.css"); ?>" type="text/css"/>
<div class="row">
    <div class="col-md-12">
       
        <div class="panel panel-default">
            <div class="panel-heading text-left">
                <strong>Select Chapter</strong>
            </div>
            <div class="panel-collapse">
                <br/>
                <div class="row">
                  <div class="col-sm-offset-2 col-sm-7">
                    <div class="input-group">
                    <form action="chapter-questions" method="POST">                   
                   <div class="row"> 
                   <select data-live-search="true"  name="chapterID" required class="selectpicker">
                   <option value="">Select</option>
                      <?php                 
                      foreach($allChapters as $val){
                          ?>
                          <option value="<?php echo $val['chapterID']; ?>" <?php echo ($chapterID === $val['chapterID']) ? 'selected':''; ?>> <?php echo $val['chapterName'].'-'.word_limiter($val['chapterDesc'],10); ?></option>
                          <?php
                      }
                      ?>
                      </select>
                      </div>
                      <br>
                      <div class="row" >                      
                        <button type="submit"  id="searchques" class="btn btn-primary btn-md">Search Question</button>
                    
                    </div>
                    </form>
                    </div>
                  </div>
                </div>
                <br/>
                <div class="col-sm-offset-2 col-sm-7" id="results">
             <?php 
             $questionCnt = count($questionsData);
             if($questionCnt > 0){ ?>
            <div class="panel-heading text-left">
            Total questions found: <b><?php echo $questionCnt; ?></b>
            </div>
            <?php
            foreach ($questionsData AS $key => $value) {    ?>           
               <br/><div qsID="<?php echo $value['qbID'];?>" class="btn btn-info questionText" data-toggle="collapse" data-target="#<?php echo $value['qbID'];?>">'<?php echo $value['questionText'];?>'</div>
                <br/><div id="<?php echo $value['qbID'];?>" class="collapse">     
                     
               </div>
               <?php    }	
        }else{ ?>   
            <div class="panel-heading text-left">
            No results found
          </div>
            <?php    } ?>   
                </div>
            </div>

         
    </div>
</div>
<script>
$(document).ready(function () {

$('.questionText').click(function(){
let qbid = this.getAttribute('qsid');
if( jQuery.trim($('#'+qbid).html()) === ''){
    $.ajax({
                method: 'post', 
                url: "ajax-get-answer", 
                data: {questionID: qbid}, 
                success: function (result)
                {                              
                   result = JSON.parse(result);
                    let str = '';
                   $.each(result,function(index, val){
                    str += '<div>'+(index + 1)+'.'+val['optionValue']+'</div>';
                    qbid = val['qbID'];
                   });
                   $('#'+qbid).html(str);
                                      
                },
                failure:function(error)
                {
                    console.log(error);
                }
    }); 
}

});

});
</script>
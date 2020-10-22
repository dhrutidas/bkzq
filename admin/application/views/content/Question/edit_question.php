
<script type="text/javascript" src="<?php echo base_url("assets/dist/js/bootstrap-multiselect.js"); ?>" ></script>
<link rel="stylesheet" href="<?php echo base_url("assets/dist/css/bootstrap-multiselect.css"); ?>" type="text/css"/>
<div class="row">
    <div class="col-md-12">
    <?php if( $this->session->flashdata('message')): ?>
            <div class="alert alert-success fade in">
                <a href="#" class="close" data-dismiss="alert" aria-label="close"><span class="glyphicon glyphicon-remove-sign"></span></a>
                <?php echo $this->session->flashdata('message'); ?></strong>
            </div>
        <?php endif; ?>
    <?php if( $this->session->flashdata('warning')): ?>
            <div class="alert alert-danger fade in">
                <a href="#" class="close" data-dismiss="alert" aria-label="close"><span class="glyphicon glyphicon-remove-sign"></span></a>
                <?php echo $this->session->flashdata('warning'); ?></strong>
            </div>
        <?php endif; ?>
        <div class="panel panel-default">
            <div class="panel-heading text-left">
                <strong>Search Question</strong>
                <div class="panel-collapse">
                <br/>                
                <div  id="results">
                <form action="edit-question" method="post">
               <input type="text" name="questiontext" value="<?php echo isset($question['questiontext']) ? $question['questiontext'] : ''; ?>" placeholder="Search question" style="width:30%" required />
                <select class="selectpicker" name="inputBoard" id="inputBoard" required>
						  <optgroup label="Boards">
						  <?php foreach ($allBoard AS $value) { ?>
								<option value="<?php echo $value['boardID']; ?>" <?php echo (isset($question['inputBoard']) && $value['boardID'] === $question['inputBoard']) ? 'selected': '';?>><?php echo $value['boardName']; ?></option>
						  <?php } ?>
						  </optgroup>
						</select>	<select class="selectpicker" name="inputLevel" id="inputLevel" required>
						<?php foreach ($allLevel AS $value) {
								echo '<optgroup label="'.$value['levelName'].'">';
									$stageIDData=explode(',',$value['catStageID']);
									$stageNameData=explode(',',$value['catStageName']);
									$counter=0;
									foreach ($stageIDData AS $stageID) {
                                        if($question['inputLevel'] === $value['levelID'].'-'.$stageID){
                                            echo '<option value="'.$value['levelID'].'-'.$stageID.'" selected>'.$stageNameData[$counter++].'</option>';
                                        }else{
                                            echo '<option value="'.$value['levelID'].'-'.$stageID.'">'.$stageNameData[$counter++].'</option>';
                                        }
										
									}
								echo '</optgroup>';
								}
						?>
						</select>
                        <button type="submit"  id="searchques" class="btn btn-primary btn-md">Search Question</button>
                        </form>
                </div>
            </div>
           
                <div id="results" style="display:<?php echo (isset($questionDetails) && count($questionDetails)) ? 'block': 'block';?>" >
                <table class="table table-hover">
                <th class="bg-primary">Question id</th>
            <th class="bg-primary">Subject</th>
            <th class="bg-primary">Chapter</th>
            <th class="bg-primary">Standard</th>         
                <?php 
                if(isset($questionDetails) && is_array($questionDetails)){                
                foreach($questionDetails as $val){ 
                    $subjects[]=$val['subjectID'].'-'.$val['chapterID'];
                    $standards[]=$val['stdID'];
                    $questions[]=$val['qbID'];
                    $levels[]=$val['levelID'].'-'.$val['stageID'];
                    ?>
<tr>
<td><?php echo $val['qbID']; ?></td>
<td><?php echo $val['subjectName']; ?></td>
<td><?php echo $val['chapterName']; ?></td>
<td><?php echo $val['stdName']; ?></td>
</tr>
               <?php }
                }
                
               $questions = (isset($questions)) ? array_unique($questions) : array();
               ?>
               </table>
               <div class="panel panel-default">
               <div class="panel-heading text-left">
               Update details here
               </div>
               </div>
               <div style="text-align:center">
               <form method="post" action="update-question">
               <select name="qbid" required>
               <option value="">Select Question id</option>
               <?php
                foreach ($questions AS $value) {?>
<option value="<?php echo $value;?>"><?php echo $value;?></option>
                <?php }
               ?>
               </select>
               <select class="selectpicker" name="updateLevel" id="updateLevel" >               
               <option value="">Select</option>
						<?php foreach ($allLevel AS $value) {

								echo '<optgroup label="'.$value['levelName'].'">';
									$stageIDData=explode(',',$value['catStageID']);
									$stageNameData=explode(',',$value['catStageName']);
                                    $counter=0; 
                                    $lvlID= ($value['levelID']);
									foreach ($stageIDData AS $stageID) {
                                        if(in_array($lvlID.'-'.$stageID, $levels) ){
                                           $counter++;
                                        }else{
                                            echo '<option value="'.$value['levelID'].'-'.$stageID.'">'.$stageNameData[$counter++].'</option>';
                                        }
									}
								echo '</optgroup>';
								}
						?>
						</select>
               <select class="selectpicker" name="inputSub"  id="inputSubject" >
               <option value="">Select</option>
                        <?php 
                        foreach ($allsubject AS $value) {
								echo '<optgroup label="'.$value['subjectName'].'">';
									$chapIDData=explode('|~|',$value['catChapterID']);
									$chapNameData=explode('|~|',$value['catChapterName']);
									$counter=0;
									foreach ($chapIDData AS $chapID) {
                                        if(in_array($value['subjectID'].'-'.$chapID, $subjects) ){
                                           // echo '<option value="'.$value['subjectID'].'-'.$chapID.'" selected disabled>'.$chapNameData[$counter++].'</option>';
                                           $counter++;
                                        }else{
                                            echo '<option value="'.$value['subjectID'].'-'.$chapID.'" >'.$chapNameData[$counter++].'</option>';
                                        }
										
									}
								echo '</optgroup>';
								}
						?>
						</select>

						<select class="selectpicker" name="inputStd" multiple id="inputStandard" >
                        <option value="">Select</option>
						  <optgroup label="Standard">

						  <?php foreach ($allStd AS $value) {
                             if(in_array($value['stdID'], $standards) ){
                              ?>
								<!-- <option value="<?php echo $value['stdID']; ?>" selected disabled><?php echo $value['stdName']; ?></option> -->
                                
                                <?php }else{ ?>
                                    <option value="<?php echo $value['stdID']; ?>" ><?php echo $value['stdName']; ?></option>
                          <?php }
                          
                                }

                                $level_stage = explode('-', $question['inputLevel']);
                                ?>
						  </optgroup>
						</select>
                        <input type="hidden" name="boardid" value="<?php echo isset($question['inputBoard']) ? $question['inputBoard']: ''; ?>"/>
                        <input type="hidden" name="levelid" value="<?php echo isset($level_stage[0]) ? $level_stage[0]: ''; ?>"/>
                        <input type="hidden" name="stageid" value="<?php echo isset($level_stage[1]) ? $level_stage[1]: ''; ?>"/>
                        <input type="hidden" name="inputStandard" />
                        <input type="hidden" name="inputSubject" />                        
                        <button type="submit" id="updateQuestion" class="btn btn-primary btn-md">Update</button>
                        </form>
               </div>
               </div>
            </div>
            
         
    </div>
  
</div>

<script>
$(document).ready(function () {    

$("select[name=inputStd]").each(function () {
                     $(this).multiselect({ includeSelectAllOption: false,enableFiltering:true,numberDisplayed:1   });
            });
            $("select[name=inputSub]").each(function () {
                     $(this).multiselect({ includeSelectAllOption: false,enableFiltering:true,numberDisplayed:1   });
            });
            $("select[name=updateLevel]").each(function () {
                     $(this).multiselect({ includeSelectAllOption: false,enableFiltering:true,numberDisplayed:1   });
            });
});

$("#updateQuestion").click(function(){
    var subjectArr, standardArr;
    if($("#inputSubject").val()){
        subjectArr = $("#inputSubject").val();
    }
    if($("#inputStandard").val() && $("#inputStandard").val().length > 0){
        standardArr = $("#inputStandard").val();
    }
    
                        if(!subjectArr || !standardArr ){
                            alert('Subject or Standard not selected fails');
                            return false;
                        }else{
                            $("input[name='inputSubject']").val(subjectArr);
                            $("input[name='inputStandard']").val(standardArr);
                        }


});

</script>
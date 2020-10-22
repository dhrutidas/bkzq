<script type="text/javascript" src="<?php echo base_url("assets/js/student.js"); ?>"></script>

<div class="row" style="padding-top:1%;">
    <div class="col-sm-6 col-md-8 col-md-offset-2">
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
    </div>
</div>
<?php if(!$affiliateStudentMapping) { ?>

    
<?php echo form_open_multipart('process-register-student','class="form-horizontal" id="addSignupform"'); ?>

<div class="scrollable-body">
   
   <div class="form-group">
       <label for="inputFirstName" class="col-sm-4 control-label mandatory">First Name </label>
       <div class="col-sm-7">
           <input type="text" class="form-control" id="inputFirstName" name="inputFirstName" required="true" maxlength="30" value="<?php echo set_value('inputFirstName'); ?>"  placeholder="Maximum 30 characters" >
       </div>
   </div>
   <div class="form-group">
       <label for="inputLastName" class="col-sm-4 control-label mandatory">Last Name</label>
       <div class="col-sm-7">
           <input type="text" class="form-control" id="inputLastName" name="inputLastName" required="true" maxlength="30" placeholder="Maximum 30 characters">
       </div>
   </div>
   <div class="form-group">
       <label for="inputEmail" class="col-sm-4 control-label mandatory">Email</label>
       <div class="col-sm-7">
           <input type="email" class="form-control" id="inputEmail" placeholder = "Password will be sent on given email id" name="inputEmail" required="true" maxlength="75">
       </div>
   </div>
   <div class="form-group">
       <label for="inputContact" class="col-sm-4 control-label mandatory">Mobile Number</label>       
       <div class="col-sm-5">
           <input type="tel" maxlength=10 pattern="^\d{10}$" class="form-control" id="inputContact" placeholder = "Password will be sent on given mobile number" name="inputContact" required="true" >
       </div>
   </div>  

   <div class="form-group">
       <label for="inputBoard" class="col-sm-4 control-label mandatory">Select Board</label>
       <div class="col-sm-7">
           <select class="form-control" id="inputBoard" name="inputBoard" required>
               <option value="">----Select----</option>
               <?php foreach( $boardArr as $bValues ): ?>
                   <option value="<?php echo $bValues['boardID']; ?>"><?php echo $bValues['boardName']; ?></option>
               <?php endforeach; ?>
           </select>
       </div>
   </div>
   <div class="form-group">
       <label for="inputSchool" class="col-sm-4 control-label mandatory">Select School</label>
       <div class="col-sm-7">
           <select class="form-control" id="inputSchool" name="inputSchool" required>
               <option value="">----Select----</option>
               <?php foreach( $schoolArr as $dValues ): ?>
                   <option value="<?php echo $dValues['schoolID']; ?>"><?php echo $dValues['schoolName']; ?></option>
               <?php endforeach; ?>
           </select>
       </div>
   </div>
   <div class="form-group">
       <label for="inputClass" class="col-sm-4 control-label mandatory">Select Statndard</label>
       <div class="col-sm-7">
           <select class="form-control" id="inputClass" name="inputClass" required>
               <option value="">----Select----</option>
               <?php foreach( $classArr as $dValues ): ?>
                   <option value="<?php echo $dValues['stdID']; ?>"><?php echo $dValues['stdName']; ?></option>
               <?php endforeach; ?>
           </select>
       </div>
   </div>
   
   </div>
   <input type="hidden" id="inputPackage" name="inputPackage" value="<?php echo $parentArr['user_type']; ?>" />

   
<input name="aff_student_mapping" type="hidden" value="<?php echo $parentArr['user_id']; ?>" />
   <div id="bronze">
       <div class="form-group">
           <label for="inputSubject1" class="col-sm-4 control-label">Select Subject 1</label>
           <div class="col-sm-7">
               <select class="form-control" id="inputSubject1" name="inputSubject1" >
                   <option value="">----Select----</option>
                   <?php foreach( $subjectArr as $dValues ): ?>
                       <option value="<?php echo $dValues['subjectID']; ?>"><?php echo $dValues['subjectName']; ?></option>
                   <?php endforeach; ?>
               </select>
           </div>
       </div>
   </div>

   <div id="silver" style="<?php echo $parentArr['user_type'] === 'S' || $parentArr['user_type'] === 'G' ? '':'display:none;'?>">
   <div class="form-group">
       <label for="inputSubject2" class="col-sm-4 control-label">Select Subject 2</label>
       <div class="col-sm-7">
           <select class="form-control" id="inputSubject2" name="inputSubject2">
               <option value="">----Select----</option>
               <?php foreach( $subjectArr as $dValues ): ?>
                   <option value="<?php echo $dValues['subjectID']; ?>"><?php echo $dValues['subjectName']; ?></option>
               <?php endforeach; ?>
           </select>
       </div>
   </div>
   <div class="form-group">
       <label for="inputSubject3" class="col-sm-4 control-label">Select Subject 3</label>
       <div class="col-sm-7">
           <select class="form-control" id="inputSubject3" name="inputSubject3">
               <option value="">----Select----</option>
               <?php foreach( $subjectArr as $dValues ): ?>
                   <option value="<?php echo $dValues['subjectID']; ?>"><?php echo $dValues['subjectName']; ?></option>
               <?php endforeach; ?>
           </select>
       </div>
   </div>
   </div>

   <div id="gold" style="<?php echo $parentArr['user_type'] === 'G' ? '':'display:none;'?>">
   <div class="form-group">
       <label for="inputSubject4" class="col-sm-4 control-label">Select Subject 4</label>
       <div class="col-sm-7">
           <select class="form-control" id="inputSubject4" name="inputSubject4">
               <option value="">----Select----</option>
               <?php foreach( $subjectArr as $dValues ): ?>
                   <option value="<?php echo $dValues['subjectID']; ?>"><?php echo $dValues['subjectName']; ?></option>
               <?php endforeach; ?>
           </select>
       </div>
   </div>
   <div class="form-group">
       <label for="inputSubject5" class="col-sm-4 control-label">Select Subject 5</label>
       <div class="col-sm-7">
           <select class="form-control" id="inputSubject5" name="inputSubject5">
               <option value="">----Select----</option>
               <?php foreach( $subjectArr as $dValues ): ?>
                   <option value="<?php echo $dValues['subjectID']; ?>"><?php echo $dValues['subjectName']; ?></option>
               <?php endforeach; ?>
           </select>
       </div>
   </div>
   <div class="form-group">
       <label for="inputSubject6" class="col-sm-4 control-label">Select Subject 6</label>
       <div class="col-sm-7">
           <select class="form-control" id="inputSubject6" name="inputSubject6">
               <option value="">----Select----</option>
               <?php foreach( $subjectArr as $dValues ): ?>
                   <option value="<?php echo $dValues['subjectID']; ?>"><?php echo $dValues['subjectName']; ?></option>
               <?php endforeach; ?>
           </select>
       </div>
   </div>
   </div>

   <div class="form-group">
       <div class="col-sm-offset-4 col-sm-8">
           <button type="submit" class="btn btn-default" >Submit</button>&nbsp; <!--onclick="return mobile_validation(this)"-->
           <button type="button" class="btn btn-default" onclick="window.location='<?php echo base_url(''); ?>'">Cancel</button>
           
       </div>
   </div>
   <div class = "form-group">
       <div class = "col-md-6 col-md-offset-4">
       <p style = "color:grey">(Please provide correct information or else account won't be activated*)</p>
       </div>
   </div>
</div>
</form>
<?php } ?>
</div>
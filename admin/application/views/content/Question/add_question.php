<script type="text/javascript" src="<?php echo base_url("assets/js/question.js"); ?>"></script>

<!-- Include the plugin's CSS and JS: -->
<script type="text/javascript" src="<?php echo base_url("assets/dist/js/bootstrap-multiselect.js"); ?>"></script>
<link rel="stylesheet" href="<?php echo base_url("assets/dist/css/bootstrap-multiselect.css"); ?>" type="text/css" />
<script type="text/javascript">
	$(document).ready(function () {
		$('#inputStandard').multiselect({ numberDisplayed: 0 });
	});
	$(document).ready(function () {
		$('#inputLevel').multiselect({
			enableFiltering: true, numberDisplayed: 0
		});
	});
	$(document).ready(function () {
		$('#inputBoard').multiselect({ numberDisplayed: 0 });
	});
	$(document).ready(function () {
		$('#inputSubject').multiselect({
			enableFiltering: true,
			numberDisplayed: 0
		});
	});
	function openTab(obj) {
		var alertD = window.open('./upload-images/' + obj.id);
	}
</script>

<div class="row">
	<div class="col-md-12">
		<?php if( $this->session->flashdata('message')): ?>
		<div class="alert alert-success fade in">
			<a href="#" class="close" data-dismiss="alert" aria-label="close"><span
					class="glyphicon glyphicon-remove-sign"></span></a>
			<?php echo $this->session->flashdata('message'); ?></strong>
		</div>
		<?php endif; ?>
		<?php if( $this->session->flashdata('warning')): ?>
		<div class="alert alert-danger fade in">
			<a href="#" class="close" data-dismiss="alert" aria-label="close"><span
					class="glyphicon glyphicon-remove-sign"></span></a>
			<?php echo $this->session->flashdata('warning'); ?></strong>
		</div>
		<?php endif; ?>
		<div class="panel panel-default">
			<div class="panel-heading text-left">
				<strong>Add Question</strong>
			</div>
			<div class="panel-collapse" hidden>
				<br />
				<div class="row">
					<div class="col-sm-offset-2 col-sm-7">
						<div class="input-group">
							<input type="text" class="form-control SearchBar" name="QueTxt" id="QueTxt"
								placeholder="Search for question ...">
							<span class="input-group-btn">
								<button type="button" id="addques" class="btn btn-primary btn-md">Skip Search/ Add
									Question</button>
							</span>
						</div>
					</div>
				</div>
				<br />
				<div class="col-sm-offset-2 col-sm-7" id="results"></div>
			</div>

			<!-- Modal -->
			<div id="AnsModal" class="modal" role="dialog">
				<div class="modal-dialog" style="width: 90%;">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"><span
									class="glyphicon glyphicon-remove-sign"></span></button>
							<h4 class="modal-title text-primary">Add Options</h4>
						</div>
						<div id="mbobomb" class="modal-body"></div>
						<div class="modal-footer" style="text-align: left;">
							<div id="question_tag"></div>
							<div class="col-md-12" style="padding-bottom:10px;padding-top:10px;">
								<button type="button" id="addButtonTag" class="btn btn-md btn-success">+Add
									Board</button>
								<input type="hidden" name="rowCount" id="rowCount" value="1" />
								<input type="hidden" name="rowCount_tag" id="rowCount_tag" value="1" />
								<input type="button" id="QnAsubmit" class="btn btn-primary btn-md" value='Submit Q&A'>
							</div>
						</div>
					</div>
				</div>
			</div>


			<div class="newSteppingWrap">
				<div class="row">
					<div class="input-group qstnBtn">
						<button type="button" class="btn btn-primary btn-md" id="addQstnBtn">Skip Search/ Add Question</button>
					</div>
				</div>

				<div class="stepping" id="step1" data-id="step1">
					<h3>Add Question</h3>

					<div class="row">
						<div class="form-group">
							<div class="col-sm-12">
								<label for="inputFirstName" class="control-label">Add Question *</label>
								<textarea class="form-control textarea" id="inputFirstName" name="inputFirstName" id="" cols="30" rows="3"></textarea>
								<span id="first_name_error" class="text-danger"></span>
							</div>
						</div>
						<div class="form-group">
							<div class="align-center-row">
								<div class="col-sm-10" id="increasingFeilds_Wrap">
									<label for="inputFirstName" class="control-label">Options *</label>
									<div class="row align-center-row marb10" id="increasingFeilds">
										<div class="col-sm-10">
											<input type="text" class="form-control" id="inputFirstName" name="inputFirstName">
											<span id="first_name_error" class="text-danger"></span>
										</div>

										<div class="col-sm-2">
											<input type="checkbox" name="">
										</div>
									</div>
								</div>

								<div class="col-sm-2">
									<div class="btn btn-default pull-right" onclick="duplicate()" id="increaseOptionBtn">Add More +</div>
								</div>
							</div>
						</div>
					</div>

					<div class="stepbtnWrap">
						<button class="btn btn-primary steppingbtn" data-name="next" data-step="step1" data-num="1"
							data-id="next_step1">Next</button>
					</div>
				</div>

				<div class="stepping" id="step2" data-id="step2">
					<h3>Category (Board Name)</h3>

					<!-- Add Level start -->
					<section class="dropdownAreaSec">
						<div class="form-group">
							<label for="">Add Level</label>
							<select id="dates-field2" class="multiselect-ui mainStageDropDown form-control" multiple="multiple">
								<option value="level_1">Level 1</option>
								<option value="level_2">Level 2</option>
								<option value="level_3">Level 3</option>
							</select>
						</div>

						<div class="stageWrap">
							<div class="form-group toogleStageSec" id="level_1">
								<div class="">
									<label for="Level 1">Level 1</label>
									<select id="dates-field2" class="multiselect-ui form-control" multiple="multiple">
										<option value="Stage 1">Stage 1</option>
										<option value="Stage 2">Stage 2</option>
										<option value="Stage 3">Stage 3</option>
									</select>
								</div>
							</div>
							<div class="form-group toogleStageSec" id="level_2">
								<div class="">
									<label for="Level 1">Level 2</label>
									<select id="dates-field2" class="multiselect-ui form-control" multiple="multiple">
										<option value="Stage 1">Stage 1</option>
										<option value="Stage 2">Stage 2</option>
										<option value="Stage 3">Stage 3</option>
									</select>
								</div>
							</div>
							<div class="form-group toogleStageSec" id="level_3">
								<div class="">
									<label for="Level 1">Level 3</label>
									<select id="dates-field2" class="multiselect-ui form-control" multiple="multiple">
										<option value="Stage 1">Stage 1</option>
										<option value="Stage 2">Stage 2</option>
										<option value="Stage 3">Stage 3</option>
									</select>
								</div>
							</div>
						</div>
					</section>
					<!-- Add Level end -->

					<!-- Add Subject start -->
					<section class="dropdownAreaSec">
						<div class="form-group">
							<label for="">Add Subject</label>
							<select id="dates-field2" class="multiselect-ui mainStageDropDown form-control" multiple="multiple">
								<option value="level_1">Level 1</option>
								<option value="level_2">Level 2</option>
								<option value="level_3">Level 3</option>
							</select>
						</div>

						<div class="stageWrap">
							<div class="form-group toogleStageSec" id="level_1">
								<div class="">
									<label for="Level 1">Level 1</label>
									<select id="dates-field2" class="multiselect-ui form-control" multiple="multiple">
										<option value="Stage 1">Stage 1</option>
										<option value="Stage 2">Stage 2</option>
										<option value="Stage 3">Stage 3</option>
									</select>
								</div>
							</div>
							<div class="form-group toogleStageSec" id="level_2">
								<div class="">
									<label for="Level 1">Level 2</label>
									<select id="dates-field2" class="multiselect-ui form-control" multiple="multiple">
										<option value="Stage 1">Stage 1</option>
										<option value="Stage 2">Stage 2</option>
										<option value="Stage 3">Stage 3</option>
									</select>
								</div>
							</div>
							<div class="form-group toogleStageSec" id="level_3">
								<div class="">
									<label for="Level 1">Level 3</label>
									<select id="dates-field2" class="multiselect-ui form-control" multiple="multiple">
										<option value="Stage 1">Stage 1</option>
										<option value="Stage 2">Stage 2</option>
										<option value="Stage 3">Stage 3</option>
									</select>
								</div>
							</div>
						</div>
					</section>
					<!-- Add Subject end -->

					<!-- Add Standard start -->
					<section class="dropdownAreaSec">
						<div class="form-group">
							<label for="">Add Standard</label>
							<select id="dates-field2" class="multiselect-ui mainStageDropDown form-control" multiple="multiple">
								<option value="level_1">Level 1</option>
								<option value="level_2">Level 2</option>
								<option value="level_3">Level 3</option>
							</select>
						</div>

						<div class="stageWrap">
							<div class="form-group toogleStageSec" id="level_1">
								<div class="">
									<label for="Level 1">Level 1</label>
									<select id="dates-field2" class="multiselect-ui form-control" multiple="multiple">
										<option value="Stage 1">Stage 1</option>
										<option value="Stage 2">Stage 2</option>
										<option value="Stage 3">Stage 3</option>
									</select>
								</div>
							</div>
							<div class="form-group toogleStageSec" id="level_2">
								<div class="">
									<label for="Level 1">Level 2</label>
									<select id="dates-field2" class="multiselect-ui form-control" multiple="multiple">
										<option value="Stage 1">Stage 1</option>
										<option value="Stage 2">Stage 2</option>
										<option value="Stage 3">Stage 3</option>
									</select>
								</div>
							</div>
							<div class="form-group toogleStageSec" id="level_3">
								<div class="">
									<label for="Level 1">Level 3</label>
									<select id="dates-field2" class="multiselect-ui form-control" multiple="multiple">
										<option value="Stage 1">Stage 1</option>
										<option value="Stage 2">Stage 2</option>
										<option value="Stage 3">Stage 3</option>
									</select>
								</div>
							</div>
						</div>
						
						<div class="stepbtnWrap">
							<button class="btn btn-default steppingbtn" data-name="prev" data-step="step2" data-num="2"
								data-id="prev_step2">Prev</button>
							<button class="btn btn-primary steppingbtn" data-name="next" data-step="step2" data-num="2"
								data-id="next_step2">Next</button>
							<button class="btn btn-secondary steppingbtn" data-name="skip" data-step="step2" data-num="2"
								data-id="skip_step2">Skip</button>
						</div>
					</section>
					<!-- Add Standard end -->


				<div class="stepping" id="step3" data-id="step3">
					<h3>Step 3</h3>
					<div class="form-group">
						<label for="inputFirstName" class="col-sm-4 control-label">First Name</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="inputFirstName" name="inputFirstName">
							<span id="first_name_error" class="text-danger"></span>
						</div>

						<div class="stepbtnWrap">
							<button class="btn steppingbtn" data-name="prev" data-step="step3" data-num="3"
								data-id="prev_step3">Prev</button>
							<button class="btn steppingbtn" data-name="submit" data-step="step3" data-num="3"
								data-id="submit_step3">Submit</button>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>


	<script>
        $(function() {
            $('.multiselect-ui').multiselect({
                includeSelectAllOption: true
            });
        });

        $('#dates-field2').change(function() {
            var getDropdown_levelID = $(this).val();
            var getDropdown_levelID_array = $.map(getDropdown_levelID, function(i){
                return `#${i}`;
            });

            var getDropdown_levelID_array_toString = getDropdown_levelID_array.toString();

            $(".toogleStageSec").removeClass("toogleStageSec_show");
            $(getDropdown_levelID_array_toString).addClass("toogleStageSec_show");
        });
        
        
        $("#addQstnBtn").click(function(){
            $("#step1").addClass("active");
        })

		// for increasing option feilds
		var i = 0;
		var original = document.getElementById('increasingFeilds');

		function duplicate() {
			var clone = original.cloneNode(true); // "deep" clone
			clone.id = "increasingFeilds" + ++i; // there can only be one element with an ID
			original.parentNode.appendChild(clone);
		}

		$(".steppingbtn").click(function () {
			var data_id = $(this).attr('data-id');
			var data_step = $(this).attr('data-step');
			var data_num = $(this).attr('data-num');
			var data_name = $(this).attr('data-name');

			$(".stepping").removeClass("active");

			if (data_name == 'prev') {
				$(`#step${parseInt(data_num) - 1}`).addClass("active");
			}
			else if (data_name == 'next' || data_name == 'skip') {
				$(`#step${parseInt(data_num) + 1}`).addClass("active");
			}
			else {
				alert("submit")
			}
		})
	</script>
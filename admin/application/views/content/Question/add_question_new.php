<script type="text/javascript" src="<?php echo base_url("assets/js/question_new.js"); ?>"></script>

<!-- Include the plugin's CSS and JS: -->
<script type="text/javascript" src="<?php echo base_url("assets/dist/js/bootstrap-multiselect.js"); ?>"></script>
<link rel="stylesheet" href="<?php echo base_url("assets/dist/css/bootstrap-multiselect.css"); ?>" type="text/css" />
<script type="text/javascript">
	$(document).ready(function() {
		$('#inputStandard').multiselect({
			numberDisplayed: 0
		});
	});
	$(document).ready(function() {
		$('#inputLevel').multiselect({
			enableFiltering: true,
			numberDisplayed: 0
		});
	});
	$(document).ready(function() {
		$('#inputBoard').multiselect({
			numberDisplayed: 0
		});
	});
	$(document).ready(function() {
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
		<?php if ($this->session->flashdata('message')) : ?>
			<div class="alert alert-success fade in">
				<a href="#" class="close" data-dismiss="alert" aria-label="close"><span class="glyphicon glyphicon-remove-sign"></span></a>
				<?php echo $this->session->flashdata('message'); ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('warning')) : ?>
			<div class="alert alert-danger fade in">
				<a href="#" class="close" data-dismiss="alert" aria-label="close"><span class="glyphicon glyphicon-remove-sign"></span></a>
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
							<input type="text" class="form-control SearchBar" name="QueTxt" id="QueTxt" placeholder="Search for question ...">
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



			<div class="newSteppingWrap">
				<input type="hidden" name="optionsrowCount" id="optionsrowCount" value="2" />

				<?php echo form_open('add-question-basic', 'id="question_basic"'); ?>
				<div class="stepping active" id="step1" data-id="step1">
					<h3>Add Question</h3>
					<div class="row">
						<div class="form-group">
							<div class="col-sm-12">
								<label for="inputFirstName" class="control-label">Add Question *</label>
								<textarea class="form-control textarea" id="question_text" name="question_text" id="" cols="30" rows="3"></textarea>
								<span id="question_text_error" class="text-danger"></span>
							</div>
						</div>
						<div class="form-group">
							<div class="align-center-row">
								<div class="col-sm-10" id="increasingFeilds_Wrap">
									<label for="inputFirstName" class="control-label">Options *</label>
									<div class="row align-center-row marb10">
										<div class="col-sm-10">
											<input type="text" class="form-control" id="options_0" name="options[0]">
										</div>
										<div class="col-sm-2">
											<input class="answer_check" type="checkbox" name="answer[0]" id="answer_0">
										</div>
									</div>
									<div class="row align-center-row marb10">
										<div class="col-sm-10">
											<input type="text" class="form-control" id="options_1" name="options[1]">
										</div>
										<div class="col-sm-2">
											<input class="answer_check" type="checkbox" name="answer[1]" id="answer_1">
										</div>
									</div>
								</div>
								<div class="col-sm-10">
									<span id="options_error" class="text-danger"></span>
									<span id="answer_error" class="text-danger"></span>
								</div>
								
								<div class="col-sm-2">
									<div class="btn btn-default pull-right" id="increaseOptionBtn">Add More +</div>
								</div>
							</div>
						</div>
					</div>

					<div class="stepbtnWrap">
						<button class="btn btn-primary steppingbtn" data-name="next" data-step="step1" data-num="1" data-id="next_step1" id="question_next">Next</button>
					</div>
				</div>
				<div class="stepping" id="step2" data-id="step2">
					<!-- Add Level start -->
					<section class="dropdownAreaSec">
						<div class="form-group">
							<label for="">Add Level</label>
							<select id="level-select" class="multiselect-ui mainStageDropDown form-control" multiple="multiple" name="input_level[]">
								<?php foreach ($levels as $level) : ?>
									<option value="<?php echo $level['levelID']; ?>"><?php echo $level['levelName']; ?></option>
								<?php endforeach; ?>
							</select>
							<span id="error_level" class="text-danger"></span>
						</div>

						<div class="stageWrap" id="section-level">
							
						</div>
					</section>
					<!-- Add Level end -->

					<!-- Add Subject start -->
					<section class="dropdownAreaSec">
						<div class="form-group">
							<label for="">Add Subject</label>
							<select id="select-subject" class="multiselect-ui mainStageDropDown form-control" multiple="multiple" name="input_subject[]">
								<?php foreach ($allsubjects as $subject) : ?>
									<option value="<?php echo $subject['subjectID']; ?>"><?php echo $subject['subjectName']; ?></option>
								<?php endforeach; ?>
							</select>
							<span id="error_subject" class="text-danger"></span>
						</div>

						<div class="stageWrap" id="chapter-level">

						</div>
					</section>
					<!-- Add Subject end -->

					<!-- Add Standard start -->
					<section class="dropdownAreaSec">
						<div class="form-group">
							<label for="">Add Standard</label>
							<select id="dates-field2" class="multiselect-ui mainStageDropDown form-control" name="input_standard[]" multiple="multiple">
								<?php foreach ($allStd as $std) : ?>
									<option value="<?php echo $std['stdID']; ?>"><?php echo $std['stdName']; ?></option>
								<?php endforeach; ?>
							</select>
							<span id="error_standard" class="text-danger"></span>
						</div>
						<div class="stepbtnWrap">
							<button class="btn btn-default steppingbtn" id="prev-btn">Prev</button>
							<button class="btn btn-primary steppingbtn" id="submit-btn">Submit</button>
						</div>
					</section>
					<!-- Add Standard end -->



				</div>
				</form>
			</div>
		</div>


		<script>
			$(function() {
				$('.multiselect-ui').multiselect({
					includeSelectAllOption: true
				});
			});

			// $('#level-select').change(function() {
			//     var getDropdown_levelID = $(this).val();
			//     var getDropdown_levelID_array = $.map(getDropdown_levelID, function(i){
			//         return `#${i}`;
			//     });

			//     var getDropdown_levelID_array_toString = getDropdown_levelID_array.toString();

			//     $(".toogleStageSec").removeClass("toogleStageSec_show");
			//     $(getDropdown_levelID_array_toString).addClass("toogleStageSec_show");
			// });


			$("#addQstnBtn").click(function() {
				$("#step1").addClass("active");
			})

			// for increasing option feilds
			var i = 0;
			var original = document.getElementById('increasingFeilds');

			// function duplicate() {
			// 	var clone = original.cloneNode(true); // "deep" clone
			// 	clone.id = "increasingFeilds" + ++i; // there can only be one element with an ID
			// 	original.parentNode.appendChild(clone);
			// }

			// $(".steppingbtn").click(function () {
			// 	var data_id = $(this).attr('data-id');
			// 	var data_step = $(this).attr('data-step');
			// 	var data_num = $(this).attr('data-num');
			// 	var data_name = $(this).attr('data-name');

			// 	$(".stepping").removeClass("active");

			// 	if (data_name == 'prev') {
			// 		$(`#step${parseInt(data_num) - 1}`).addClass("active");
			// 	}
			// 	else if (data_name == 'next' || data_name == 'skip') {
			// 		$(`#step${parseInt(data_num) + 1}`).addClass("active");
			// 	}
			// 	else {
			// 		alert("submit")
			// 	}
			// })
		</script>
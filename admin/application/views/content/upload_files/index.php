<style>

hr.soften {
  height: 1px;
  background-image: -webkit-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,.8), rgba(0,0,0,0));
  background-image:    -moz-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,.8), rgba(0,0,0,0));
  background-image:     -ms-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,.8), rgba(0,0,0,0));
  background-image:      -o-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,.8), rgba(0,0,0,0));
  border: 0;
}
ul.gallery {
    clear: both;
    float: left;
    margin-bottom: -10px;
    padding-left: 3px;
}
ul.gallery li.item {
    height: 215px;
    display: block;
    float: left;
    margin: 0px 15px 15px 0px;
    font-size: 12px;
    font-weight: normal;
    background-color: d3d3d3;
    padding: 10px;
    box-shadow: 10px 10px 5px #888888;
}

.item img{width: 188px; height: 184px;}

.item p {
    color: #6c6c6c;
    letter-spacing: 1px;
    text-align: center;
    position: relative;
    margin: 5px 0px 0px 0px;
}
</style>
<script>
function saveImagePath(imgPath){
		divNameForImage=document.getElementById('divName').value;
		window.onunload = function (e) {
			opener.document.getElementById(divNameForImage).value = imgPath;
		};
		window.close();
}
function searchImage()
{
	var searchtext=document.getElementById('searchBoxImage').value;
    if(searchtext==''){
        alert('Search field can not be empty');
        return false;
    }
	$.ajax({

				url: '../Upload_files/searchImage/',
				data:{'search':searchtext},
				type: 'POST',
				success: function (data) {
				$('#gallery').html(data);
				}
			});
}
</script>
    <div class="row">
        <div class="col-md-12">
            <?php if( $this->session->flashdata('statusMsg')): ?>
            <div class="alert alert-success fade in">
                <a href="#" class="close" data-dismiss="alert" aria-label="close"><span class="glyphicon glyphicon-remove-sign"></span></a>
                <?php echo $this->session->flashdata('statusMsg'); ?></strong>
            </div>
            <?php endif; ?>
            <?php if( $this->session->flashdata('warning')): ?>
            <div class="alert alert-danger fade in">
                <a href="#" class="close" data-dismiss="alert" aria-label="close"><span class="glyphicon glyphicon-remove-sign"></span></a>
                <?php echo $this->session->flashdata('warning'); ?></strong>
            </div>
            <?php endif; ?>
            <div class="panel-collapse">
            <form enctype="multipart/form-data" action="" method="post">
			<fieldset>
				<legend>Upload:</legend>
				<div class="form-group">
                    <p>(Image Upload Resolution Min - 300 X 300 and Max - 800 X 600)</p>
    <p>(Image Upload Size Max - 50 KB)</p>
					<label for="userFiles" class="col-sm-3 control-label">Choose Files</label>
					<div class="col-sm-9">
						<input type="file" class="form-control" name="userFiles[]"/>
					</div>
					<label for="userFilesDesc" class="col-sm-3 control-label">Description</label>
					<div class="col-sm-9">
						<textarea class="form-control" name="description" rows=4></textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-3 col-sm-5">
						<input class="form-control" type="submit" name="fileSubmit" value="UPLOAD"/>
					</div>
				</div>
			</fieldset>
            </form>
			</div>

			<div class="form-group"  style="padding-top: 5px;">
					<div class="col-sm-offset-2 col-sm-8">
						<input class="form-control" type="search" name="searchBoxImage" id="searchBoxImage"/>
					</div>
					<div class="col-sm-2">
						<button type="submit" class="btn btn-primary" onclick="searchImage();"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
					</div>
			</div>
        <div class="col-lg-12">
            <div class="row">
			<div id="gallery">
                <ul class="gallery">
                    <?php if(!empty($files)): foreach($files as $file): ?>
                    <li class="item">
                        <img src="<?php echo base_url('uploads/files/'.$file['file_name']); ?>" alt="<?php echo base_url('uploads/files/'.$file['file_name']); ?>" onclick="saveImagePath('<?php echo base_url('uploads/files/'.$file['file_name']); ?>');">
                        <p>Uploaded On <?php echo date("j M Y",strtotime($file['created'])); ?></p>
                    </li>
                    <?php endforeach; else: ?>
                    <p>File(s) not found.....</p>
                    <?php endif; ?>
                </ul>
			</div>
				<input type='hidden' value="<?php echo $divName; ?>" id="divName" name='divName'>
            </div>
        </div>
        <div class="col-md-12 text-right" id="paginationid">
            <?php echo $pagination; ?>
        </div>
    </div>

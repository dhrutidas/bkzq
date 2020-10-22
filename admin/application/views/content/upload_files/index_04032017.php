<style>
ul.gallery {
    clear: both;
    float: left;
    width: 100%;
    margin-bottom: -10px;
    padding-left: 3px;
}
ul.gallery li.item {
    width: 25%;
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

.item img{width: 100%; height: 184px;}

.item p {
    color: #6c6c6c;
    letter-spacing: 1px;
    text-align: center;
    position: relative;
    margin: 5px 0px 0px 0px;
}
</style>
    <div class="row">
        <div class="col-md-12">
            <?php if( $this->session->flashdata('statusMsg')): ?>
            <div class="alert alert-success fade in">
                <a href="#" class="close" data-dismiss="alert" aria-label="close"><span class="glyphicon glyphicon-remove-sign"></span></a>
                <?php echo $this->session->flashdata('statusMsg'); ?></strong>
            </div>
            <?php endif; ?>
            <div class="panel-collapse">
            <form enctype="multipart/form-data" action="" method="post">

            <div class="form-group">
                <label for="userFiles" class="col-sm-3 control-label">Choose Files</label>
                <div class="col-sm-8">
                    <input type="file" class="form-control" name="userFiles[]" multiple/>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-5">
                    <input class="form-control" type="submit" name="fileSubmit" value="UPLOAD"/>
                </div>
            </div>

            <!-- <div class="col-lg-6">
                <div class="form-group">
                    <label>Choose Files</label>
                    <input type="file" class="form-control" name="userFiles[]" multiple/>
                </div>
                <div class="form-group">
                    <input class="form-control" type="submit" name="fileSubmit" value="UPLOAD"/>
                </div>
            </div> -->
            </form>
        </div>
        <div class="col-lg-12">
            <div class="row">
                <ul class="gallery">
                    <?php if(!empty($files)): foreach($files as $file): ?>
                    <li class="item">
                        <img src="<?php echo base_url('uploads/files/'.$file['file_name']); ?>" alt="" >
                        <p>Uploaded On <?php echo date("j M Y",strtotime($file['created'])); ?></p>
                    </li>
                    <?php endforeach; else: ?>
                    <p>File(s) not found.....</p>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
<script type="text/javascript" src="<?php echo base_url("assets/js/searchquestion.js"); ?>"></script>

<div class="row">
    <div class="col-md-12">
       
        <div class="panel panel-default">
            <div class="panel-heading text-left">
                <strong>Search Question</strong>
            </div>
            <div class="panel-collapse">
                <br/>
                <div class="row">
                  <div class="col-sm-offset-2 col-sm-7">
                    <div class="input-group">
                      <input type="text" class="form-control SearchBar"  name="QueTxt" id="QueTxt" placeholder="Search for question ...">
                      <span class="input-group-btn">
                        <button type="button"  id="searchques" class="btn btn-primary btn-md">Search Question</button>
                    </span>
                    </div>
                  </div>
                </div>
                <br/>
                <div class="col-sm-offset-2 col-sm-7" id="results"></div>
            </div>

         
    </div>
</div>

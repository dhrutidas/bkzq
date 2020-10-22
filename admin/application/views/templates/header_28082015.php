<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
        <a class="navbar-brand" href="home">CMS</a>
    </div>
    <div>
      <ul class="nav navbar-nav">
        
        
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Manage Masters <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <!--<li role="separator" class="divider"></li>-->
                <li><a href="<?php echo base_url("manage-roles"); ?>">Roles</a></li>
                <li><a href="<?php echo base_url("manage-departments"); ?>">Departments</a></li>
                <li><a href="<?php echo base_url("manage-branches"); ?>">Branches</a></li>
                <li><a href="<?php echo base_url("manage-complaint-types"); ?>">Complaint Type</a></li>
                <li><a href="<?php echo base_url("manage-employees"); ?>">Employees</a></li>
                <li><a href="<?php echo base_url("manage-domain"); ?>">Domain Names</a></li>
                <li><a href="<?php echo base_url("manage-category"); ?>">Categories</a></li>
                <li><a href="<?php echo base_url("manage-sub-category"); ?>">Sub-Categories</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Administrator <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <!--<li role="separator" class="divider"></li>-->
                <li><a href="<?php echo base_url("manage-complaint-form"); ?>">Manage Complaint Form</a></li>
                <li><a href="<?php echo base_url("manage-doa"); ?>" title="Manage delegation of authorities">Manage DOA</a></li>
                <!--<li><a href="#<?php //echo base_url("manage-branches"); ?>" title="Manage turn around time">Manage TAT</a></li>-->
            </ul>
        </li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Complaints <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <!--<li role="separator" class="divider"></li>-->
                <li><a href="<?php echo base_url("manage-complaint-form"); ?>">Manage My Complaints</a></li>
                <li><a href="<?php echo base_url("add-new-complaint"); ?>">Add New Complaint</a></li>
                <li><a href="<?php echo base_url("manage-complaints"); ?>">Show all pending Complaints</a></li>
            </ul>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <!--<li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>-->
        <li><a href="<?php echo base_url('logout'); ?>"><span class="glyphicon glyphicon-log-out"></span>Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
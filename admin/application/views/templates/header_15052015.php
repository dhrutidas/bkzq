<?php $role_id = $this->sData['role_id']; 
if ( $role_id ==1 ) {
    $path = 'manage-roles';
}else{
    $path = 'home';
}
?>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="<?php echo base_url('home'); //home; ?>"><span class="glyphicon glyphicon-home"></span></a>
        </div>
        <div>
            <ul class="nav navbar-nav"><?php

                function group_assoc($array, $key) {
                    
                    $return = array();
                    foreach ($array as $v) { $return[$v[$key]][] = $v; }
                    return $return;
                }

                //Group the requests by their account_id
                $account_requests = group_assoc($groupArr, 'group_app_name');
                foreach ($account_requests AS $key => $values): ?>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $key; ?><span class="caret"></span></a>
                        <ul class="dropdown-menu">

                        <?php foreach ($values AS $value): ?>

                            <li><a href="<?php echo base_url($value['app_path']); ?>"><?php echo $value['app_name']; ?></a></li>

                        <?php endforeach; ?>

                        </ul>
                    </li>
                    
                <?php endforeach; ?>                    
            </ul>
            <?php if($role_id == 3) { ?>
                <ul class="nav navbar-nav">
                    <li><a href="<?php echo base_url('profile'); ?>"><span class=""></span>&nbsp;Profile</a></li>
                </ul>
            <?php } ?>
            <ul class="nav navbar-nav">
                <li><a href="<?php echo base_url('change-password'); ?>"><span class="glyphicon glyphicon-user"></span>&nbsp;Change password</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li><a href="<?php echo base_url('logout'); ?>"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Logout</a></li>
            </ul>

        </div>
    </div>
</nav>
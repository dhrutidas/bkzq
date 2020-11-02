<?php
$role_id = $this->sData['role_id'];
if ($role_id == 1) {
    $path = 'manage-roles';
} else {
    $path = 'home';
}
?>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="<?php echo base_url('home'); ?>"><span class="glyphicon glyphicon-home"></span></a>
        </div>
        <div>
            <ul class="nav navbar-nav"><?php
                                        if (strtotime($this->sData['expiryDate']) > strtotime(date('Y-m-d'))) {


                                            function group_assoc($array, $key)
                                            {

                                                $return = array();
                                                foreach ($array as $v) {
                                                    $return[$v[$key]][] = $v;
                                                }
                                                return $return;
                                            }

                                            //Group the requests by their account_id
                                            $account_requests = group_assoc($groupArr, 'group_app_name');
                                            // echo "<pre>";
                                            // print_r($account_requests);exit;
                                            foreach ($account_requests as $key => $values) : ?>
                        <?php if (count($values) > 1) : ?>
                            <li class="dropdown" >
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $key; ?><span class="caret"></span></a>
                                <ul class="dropdown-menu">

                                    <?php foreach ($values as $value) : ?>

                                        <li <?php if($this->uri->segment(1)==$value['app_path']){echo 'class="active"';}?>><a href="<?php echo base_url($value['app_path']); ?>"><?php echo $value['app_name']; ?></a></li>

                                    <?php endforeach; ?>

                                </ul>
                            </li>
                        <?php else : ?>

                            <?php foreach ($values as $value) : ?>

                                <li <?php if($this->uri->segment(1)==$value['app_path']){echo 'class="active"';}?>><a href="<?php echo base_url($value['app_path']); ?>"><?php echo $value['app_name']; ?></a></li>

                            <?php endforeach; ?>

                        <?php endif; ?>
                <?php endforeach;
                                        }
                ?>
            </ul>
            <?php if ($role_id == 3) { ?>
                <ul class="nav navbar-nav">
                    <li><a href="<?php echo base_url('profile'); ?>"><span class=""></span>&nbsp;Profile</a></li>
                </ul>
            <?php } ?>

            <ul class="nav navbar-nav navbar-right profileArea_right">
                
                <div class="profileArea">
                  <button class="dropdown-toggle" type="button" data-toggle="dropdown">
                      <figure class="pp">
                      <?php if($this->sData['profile_pic']):?>
                        <img src="<?php echo base_url().'assets/images/profile_pic/'.$this->sData['profile_pic'].'?ver='.date('dmyhsi'); ?>" />
                      <?php else:?>
                        <img src="<?php echo base_url("assets/images/default_profile.png"); ?>" />
                      <?php endif;?>
                         
                      </figure>
                      <?php echo $this->sData['user_first_name'] ." ".$this->sData['user_last_name'] ; ?>
                  <span class="caret"></span></button>
                  <ul class="dropdown-menu">
                    <li><a href="<?php echo base_url('profile'); ?>">profile</a></li>
                    <li><a href="<?php echo base_url('change-password'); ?>">Change password</a></li>
                    <li><a href="<?php echo base_url('logout'); ?>">Logout</a></li>
                  </ul>
                </div>
            </ul>
          

        </div>
        <!-- <ul class="profile-wrapper">
                <li>
                   
                    <div class="profile">
                        <img src="http://gravatar.com/avatar/0e1e4e5e5c11835d34c0888921e78fd4?s=80" />
                        <a href="http://swimbi.com" class="name">swimbi.com</a>
                        
                        
                        <ul class="menu">
                            <li><a href="#">Edit</a></li>
                            <li><a href="#">Change Password</a></li>
                            <li><a href="#">Log out</a></li>
                        </ul>
                    </div>
                </li>
            </ul> -->
    </div>
</nav>
<script>
  
</script>
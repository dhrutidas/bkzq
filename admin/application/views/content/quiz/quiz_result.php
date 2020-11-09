<?php if($result == "complete"):?>
<section class="finishAllAnswrWrap completedStages">
    <div class="finishAll_imageArea">
        <img src="http://placehold.it/200x200" alt="">
    </div>

    <div class="heading">Completed Stage 1</div>

    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>

    <div class="btnWrap">
        <a href="<?php echo base_url('start-quiz');?>" class="btn">Home</a>
        <a href="#" class="btn">Next Stage</a>
    </div>
</section>
<?php else:?>
<section class="finishAllAnswrWrap not_completedStages">
    <div class="finishAll_imageArea">
        <img src="http://placehold.it/200x200" alt="">
    </div>

    <div class="heading">Not Completed Stage</div>

    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>

    <div class="btnWrap">
    <a href="<?php echo base_url('start-quiz');?>" class="btn">Home</a>
        <a href="#" class="btn">Replay</a>
    </div>
</section>
<?php endif;?>
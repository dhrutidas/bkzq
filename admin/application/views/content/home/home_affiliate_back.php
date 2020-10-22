
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading text-left">Welcome, <b><?php echo $this->sData['user_first_name'] ." ".$this->sData['user_last_name'] ; ?></b>
            </div>

            <div class="panel-body">
              <div class="row">
                <div class="col-md-12">
                    <?php
                    $enc_username=$this->encryption->encrypt($this->sData['user_id']);
                    $enc_username=str_replace(array('+', '/', '='), array('-', '_', '~'), $enc_username);
                    ?>
                 <strong>  Your affiliate link is below :             </strong>       
                </div>
                <div class="col-md-12"> <strong><?php echo base_url('/signup/'.$enc_username); ?> </strong>  </div>
              </div>              
            </div>    
            <!--Tab Content-->
           
        </div>
        <!-- <div class="col-md-12"> -->
        <div class="panel panel-default">
        <div class="panel-body">
        <!-- <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more rec</p>
        <div class="col-md-4">
            <table class="table table-bordered table-sm level-tbl">
  <thead>
    <tr>
      <th scope="col">Level</th>
      <th scope="col" class="gold-cls">Gold</th>
      <th scope="col" class="silver-cls">Silver</th>
      <th scope="col" class="bronze-cls">Bronze</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td class="goldbg-cls">1000</td>
      <td class="silverbg-cls">500</td>
      <td class="bronzebg-cls">300</td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td class="goldbg-cls">300</td>
      <td class="silverbg-cls">200</td>
      <td class="bronzebg-cls">100</td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td class="goldbg-cls">200</td>
      <td class="silverbg-cls">100</td>
      <td class="bronzebg-cls">50</td>
    </tr>
    <tr>
      <th scope="row">4</th>
      <td class="goldbg-cls">100</td>
      <td class="silverbg-cls">100</td>
      <td class="bronzebg-cls">50</td>
    </tr><tr>
      <th scope="row">5</th>
      <td class="goldbg-cls">100</td>
      <td class="silverbg-cls">100</td>
      <td class="bronzebg-cls">50</td>
    </tr>
  </tbody>

</table>
</div> -->
<div class="col-md-12">
<p>When a user becomes affiliate user, they receive commission on every user who will joined through them.</p>

<p>The user can use 70% of the commission for self-withdrawal and 30% for donation or prize to other users. Eg- If the user has Rs. 10,000 in their account, then they can use Rs.7000 for their withdrawal and Rs.3000 is to be used for donation and giving prize to other users.</p>

<p>The donation and prize cannot be given to the user who have joined through you, it has to be given to user who have joined through someone else.</p>

<p>The user can withdraw the amount once in a month.</p>

<p>If any user needs financial help for education purpose like purchase of books or fees or anything else related to education can ask for help here. The purpose of help shall be verified by the admin and if the purpose is valid, then help shall be provided by the affiliate users who are willing to help.</p>

<p>The above points are only for activate affiliate users and not for any random quiz player.</p>

</div>
</div>


</div>
    </div>
</div>
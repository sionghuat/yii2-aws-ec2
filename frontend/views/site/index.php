<?php
/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
    /*body {font-family: "Times New Roman", Georgia, Serif; text-align: center}*/

</style>
<div class="site-index">

    <div class="jumbotron" style="background:gainsboro; width:40%; text-align:center; margin:20px auto;">

        <h3 class="w3-center">User Logged In : </h3>
        <p class="lead" style="color:red"> 
            <?php
            if (isset($user)) {
                echo $user->username;
            }
            if (empty($user)) {
                echo'';
            }
            ?>
        </p>
    </div>
    <div class="jumbotron" style="background:gainsboro; width:40%; text-align:center; margin:0 auto; ">
        <h3 class="w3-center">Status Instance : </h3><br>
        <div class="alert alert-success" style="text-align:center">
            <strong class="lead" >Running : <?php echo $running; ?></strong>
        </div>
        <div class="alert alert-danger" style="text-align:center">
            <strong class="lead" >Stopped : <?php echo $stopped; ?></strong>
        </div>
    </div>

</div>

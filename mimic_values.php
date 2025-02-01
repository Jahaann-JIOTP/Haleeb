<style>
    .style {
        padding-left: 3px;
        padding-right: 3px;
        padding-top: 2px;
        background-color: #000000;
        border: 1px solid #A5A5A5;
        color: #4FFF00;
        position: absolute;
    }
</style>
<?php
$STEP_STATUS = 0;
if (isset($msg1['STEP_STATUS']))
    $STEP_STATUS = $msg1['STEP_STATUS']; 
$TT1001_Scaled = 0;
if (isset($msg1['TT1001_Scaled']))
    $TT1001_Scaled = $msg1['TT1001_Scaled'];
$TT1002_Scaled = 0;
if (isset($msg1['TT1002_Scaled']))
    $TT1002_Scaled = $msg1['TT1002_Scaled'];
$TT1003_Scaled = 0;
if (isset($msg1['TT1003_Scaled']))
    $TT1003_Scaled = $msg1['TT1003_Scaled'];
$TT1004_Scaled = 0;
if (isset($msg1['TT1004_Scaled']))
    $TT1004_Scaled = $msg1['TT1004_Scaled'];
$TT1005_Scaled = 0;
if (isset($msg1['TT1005_Scaled']))
    $TT1005_Scaled = round($msg1['TT1005_Scaled'], 2);
$TT1006_Scaled = 0;
if (isset($msg1['TT1006_Scaled']))
    $TT1006_Scaled = round($msg1['TT1006_Scaled'], 2);
$TT1007_Scaled = 0;
if (isset($msg1['TT1007_Scaled']))
    $TT1007_Scaled = round($msg1['TT1007_Scaled'], 2);
$TT1008_Scaled = 0;
if (isset($msg1['TT1008_Scaled']))
    $TT1008_Scaled = round($msg1['TT1008_Scaled'], 2);
$Steam_Value_PT1001_Scaled_for_Pressure_Percentage_control_valve = 0;
if (isset($msg1['Steam_Value_PT1001_Scaled_for_Pressure_Percentage_control_valve']))
    $Steam_Value_PT1001_Scaled_for_Pressure_Percentage_control_valve = round($msg1['Steam_Value_PT1001_Scaled_for_Pressure_Percentage_control_valve'], 2);
$PT1001_Scaled = 0;
if (isset($msg1['PT1001_Scaled']))
    $PT1001_Scaled = round($msg1['PT1001_Scaled'], 2);
$TT1201_Scaled = 0;
if (isset($msg1['TT1201_Scaled']))
    $TT1201_Scaled = round($msg1['TT1201_Scaled'], 2);
$PS2001_Scaled = 0;
if (isset($msg1['PS2001_Scaled']))
    $PS2001_Scaled = round($msg1['PS2001_Scaled'], 2);
$TT0701_Scaled = 0;
if (isset($msg1['TT0701_Scaled']))
    $TT0701_Scaled = round($msg1['TT0701_Scaled'], 2);
$TT0501_Scaled = 0;
if (isset($msg1['TT0501_Scaled']))
    $TT0501_Scaled = round($msg1['TT0501_Scaled'], 2);
$Product_Supply_Scaled_Output = 0;
if (isset($msg1['Product_Supply_Scaled_Output']))
    $Product_Supply_Scaled_Output = round($msg1['Product_Supply_Scaled_Output'], 2);

?>
<!-- Tank -->
<p class="style" style="margin-top:-310px; margin-left:251px; background-color:rgb(54, 54, 54);color:white;padding:2px;font-size: 15px;">
    <?php echo round($LT0101_Scaled,1); ?>%</p>
<!-- TT0501 -->
<p class="style" style="height:30px; width:110px; margin-top:-672px; margin-left:49px;font-size: 26px;">STEP: 
<?php echo $STEP_STATUS ?></p>
<p class="style" style="height:24px; width:66px; margin-top:-102px; margin-left:369px;font-size: 20px;">
<?php echo $TT0501_Scaled ?>°C</p>
<!-- TT07.01 -->
<p class="style" style="height:24px; width:66px; margin-top:-296px; margin-left:537px;font-size: 20px;">
<?php echo $TT0701_Scaled ?>°C</p>
<!-- PT2001 -->
<p class="style" style="height:24px; width:66px; margin-top:-307px; margin-left:363px;font-size: 18px;">
<?php echo $PS2001_Scaled ?> bar</p>
<!-- V0102 -->
<p class="style" style="height:24px; width:66px; margin-top:-209px; margin-left:78px;font-size: 18px;">
<?php echo $Product_Supply_Scaled_Output ?> %</p>
<!-- TT12.01 -->
<p class="style" style="height:24px; width:66px; margin-top:-581px; margin-left:494px;font-size: 20px;">
    <?php echo $TT1201_Scaled ?>°C</p>
<!-- TT1001 -->
<p class="style" style="height:24px; width:66px; margin-top:-572px; margin-left:774px;font-size: 20px;">
<?php echo round($TT1001_Scaled,1) ?>°C</p>
<!-- PT1001 -->
<p class="style" style="height:24px; width:66px; margin-top:-640px; margin-left:1001px;font-size: 20px;">
    <?php echo $PT1001_Scaled ?> bar</p>
<!-- cv-1001 -->
<p class="style" style="height:24px; width:66px; margin-top:-567px; margin-left:1210px;font-size: 18px;">
    <?php echo $Steam_Value_PT1001_Scaled_for_Pressure_Percentage_control_valve ?> %</p>
<!-- tempurature -->
<!-- TT10002 -->
<p class="style" style="height: 20px; width:58px;margin-top:-125px; margin-left:515px;font-size: 17px; background-color: #A5A5A5;color: #000000; border-right: 2px #5a5a5a solid; padding: 0 5px 0 0;">
    <b><?php echo round($TT1002_Scaled,2)?>°C</b>
</p>
<!-- TT10003 -->
<p class="style" style="height: 20px; width:58px;margin-top:-125px; margin-left:586px;font-size: 17px; background-color: #A5A5A5;color: #000000; border-right: 2px #5a5a5a solid; padding: 0 5px 0 0;">
    <b><?php echo round($TT1003_Scaled,2)?>°C</b>
</p>
<!-- TT10004 -->
<p class="style" style="height: 20px; width:58px;margin-top:-125px; margin-left:656px;font-size: 17px; background-color: #A5A5A5;color: #000000; border-right: 2px #5a5a5a solid; padding: 0 5px 0 0;">
    <b><?php echo round($TT1004_Scaled,2)?>°C</b>
</p>
<!-- TT10005 -->
<p class="style" style="height: 20px; width:58px;margin-top:-125px; margin-left:725px;font-size: 17px; background-color: #A5A5A5;color: #000000; border-right: 2px #5a5a5a solid; padding: 0 5px 0 0;">
    <b><?php echo round($TT1005_Scaled,2)?>°C</b>
</p>
<!-- TT10006 -->
<p class="style" style="height: 20px; width:58px;margin-top:-125px; margin-left:795px;font-size: 17px; background-color: #A5A5A5;color: #000000; border-right: 2px #5a5a5a solid; padding: 0 5px 0 0;">
    <b><?php echo round($TT1006_Scaled,2)?>°C</b>
</p>
<!-- TT10007 -->
<p class="style" style="height: 20px; width:58px;margin-top:-125px; margin-left:865px;font-size: 17px; background-color: #A5A5A5;color: #000000; border-right: 2px #5a5a5a solid; padding: 0 5px 0 0;">
    <b><?php echo round($TT1007_Scaled,2)?>°C</b>
</p>
<!-- TT10008 -->
<p class="style" style="height: 20px; width:58px;padding-top:1px; padding-left:3px;padding-right:3px; margin-top:-125px; margin-left:933px;font-size: 17px; background-color: #A5A5A5;color: #000000;">
    <b><?php echo round($TT1008_Scaled,2)?>°C</b>
</p>
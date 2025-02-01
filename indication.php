<!-- motors -->
<style>
.blink2 {
    animation: blinker2 .5s linear infinite;
    opacity: 0.7;
}

@keyframes blinker2 {
    50% {
        clip-path: polygon(34.33% 32.47%, 50% 29.29%, 65.67% 32.47%, 65.67% 72.54%, 34.33% 72.54%);
        background-color: rgba(212, 0, 0, 0.72);
        width: 286px;
        height: 265px;
    }
}
</style>
<?php
$url1 = "http://13.234.241.103:1880/haleeb";
$json1 = file_get_contents($url1);
$msg1 = json_decode($json1, true);
$M0301_HMI = 0;
if (isset($msg1['M0301_HMI']))
    $M0301_HMI = $msg1['M0301_HMI'];
$M0501_HMI = 0;
if (isset($msg1['M0501_HMI']))
    $M0501_HMI = $msg1['M0501_HMI'];
$M3501_HMI = 0;
if (isset($msg1['M3501_HMI']))
    $M3501_HMI = $msg1['M3501_HMI'];
$M0804_HMI = 0;
if (isset($msg1['M0804_HMI']))
    $M0804_HMI = $msg1['M0804_HMI'];
$M0801_HMI = 0;
if (isset($msg1['M0801_HMI']))
    $M0801_HMI = round($msg1['M0801_HMI'], 2);
$V0301_HMI = 0;
if (isset($msg1['V0301_HMI']))
    $V0301_HMI = round($msg1['V0301_HMI'], 2);
$V0302_HMI = 0;
if (isset($msg1['V0302_HMI']))
    $V0302_HMI = round($msg1['V0302_HMI'], 2);
$V0303_HMI = 0;
if (isset($msg1['V0303_HMI']))
    $V0303_HMI = round($msg1['V0303_HMI'], 2);
$V0304_HMI = 0;
if (isset($msg1['V0304_HMI']))
    $V0304_HMI = round($msg1['V0304_HMI'], 2);
$V0102_HMI = 0;
if (isset($msg1['V0102_HMI']))
    $V0102_HMI = round($msg1['V0102_HMI'], 2);
$V0103_HMI = 0;
if (isset($msg1['V0103_HMI']))
    $V0103_HMI = round($msg1['V0103_HMI'], 2);
$V1901_HMI = 0;
if (isset($msg1['V1901_HMI']))
    $V1901_HMI = round($msg1['V1901_HMI'], 2);
$V0101_HMI = 0;
if (isset($msg1['V0101_HMI']))
    $V0101_HMI = round($msg1['V0101_HMI'], 2);
$V1602_HMI = 0;
if (isset($msg1['V1602_HMI']))
    $V1602_HMI = round($msg1['V1602_HMI'], 2);
$V1601_HMI = 0;
if (isset($msg1['V1601_HMI']))
    $V1601_HMI = round($msg1['V1601_HMI'], 2);
$V2001_HMI = 0;
if (isset($msg1['V2001_HMI']))
    $V2001_HMI = round($msg1['V2001_HMI'], 2);
$V1203_HMI = 0;
if (isset($msg1['V1203_HMI']))
    $V1203_HMI = round($msg1['V1203_HMI'], 2);
$V1201_HMI = 0;
if (isset($msg1['V1201_HMI']))
    $V1201_HMI = round($msg1['V1201_HMI'], 2);
$V1202_HMI = 0;
if (isset($msg1['V1202_HMI']))
    $V1202_HMI = round($msg1['V1202_HMI'], 2);
$V1001_HMI = 0;
if (isset($msg1['V1001_HMI']))
    $V1001_HMI = round($msg1['V1001_HMI'], 2);

$var20 = 0;
if (isset($msg1['var20']))
    $var20 = round($msg1['var20'], 2);
$var21 = 0;
if (isset($msg1['var21']))
    $var21 = round($msg1['var21'], 2);
$var22 = 0;
if (isset($msg1['var22']))
    $var22 = round($msg1['var22'], 2);
$PAM_HMI = 0;
if (isset($msg1['PAM_HMI']))
    $PAM_HMI = round($msg1['PAM_HMI'], 2);
$RFP_1_2_3_4_5 = 0;
if (isset($msg1['RFP_1_2_3_4_5']))
    $RFP_1_2_3_4_5 = round($msg1['RFP_1_2_3_4_5'], 2);
$PFM_ON_HMI = 0;
if (isset($msg1['PFM_ON_HMI']))
    $PFM_ON_HMI = round($msg1['PFM_ON_HMI'], 2);
$var26 = 0;
if (isset($msg1['var26']))
    $var26 = round($msg1['var26'], 2);
$V1301_HMI = 0;
if (isset($msg1['V1301_HMI']))
    $V1301_HMI = round($msg1['V1301_HMI'], 2);
$LT0101_Scaled = 0;
if (isset($msg1['LT0101_Scaled']))
    $LT0101_Scaled = round($msg1['LT0101_Scaled'], 2);

?>
<!-- M 03.01 -->
<?php if ($M0301_HMI == true) { ?>
<img src="img/Centrifugal pump 4 Shaded.png" alt="" height="45px" width="68px"
    style="position:absolute;margin-top:-100px; margin-left:169px;">
<?php } ?>
<!-- M0501 -->
<?php if ($M0501_HMI == true) { ?>
<img src="img/Centrifugal pump 4 Shaded.png" alt="" height="33px" width="51px"
    style="position:absolute;margin-top:-165px; margin-left:306px;">
<?php } ?>
<!-- M35.01 -->
<?php if ($M3501_HMI == true) { ?>
<img src="img/Horizontal pump (right) Shaded.png" alt="" height="30px" width="49px"
    style="position:absolute;margin-top:-540px; margin-left:868px">
<?php } ?>
<!-- M0804 -->
<?php if ($M0804_HMI == true) { ?>
<img src="img/Centrifugal pump 4 Shaded.png" alt="" height="34px" width="51px"
    style="position:absolute;margin-top:-287px; margin-left:1000px">
<?php } ?>
<!-- M0801 -->
<?php if ($M0801_HMI == true) { ?>
<img src="img/Centrifugal pump 4 Shaded.png" alt="" height="47px" width="73px"
    style="position:absolute;margin-top:-299px; margin-left:1057px">
<?php } ?>
<!-- vals -->
<!-- V 03.01 -->
<?php if ($V0301_HMI == true) { ?>
<img src="img/3-D Valve Shaded.png" alt="" height="37px" width="46px"
    style="position:absolute;margin-top:-65px; margin-left:60px;">
<?php } ?>
<!-- V 03.02 -->
<?php if ($V0302_HMI == true) { ?>
<img src="img/3-D Valve Shaded.png" alt="" height="37px" width="46px"
    style="position:absolute;margin-top:-116px; margin-left:60px;">
<?php } ?>
<!-- V 03.03 -->
<?php if ($V0303_HMI == true) { ?>
<img src="img/3-D Valve Shaded.png" alt="" height="37px" width="46px"
    style="position:absolute;margin-top:-170px; margin-left:59px;">
<?php } ?>
<!-- V 03.04 -->
<?php if ($V0304_HMI == true) { ?>
<img src="img/3-D Valve Shaded.png" alt="" height="37px" width="46px"
    style="position:absolute;margin-top:-92px; margin-left:278px;">
<?php } ?>
<!-- V0102 -->
<?php if ($V0102_HMI == true) { ?>
<img src="img/3-D Valve Shaded.png" alt="" height="35px" width="41px"
    style="position:absolute;margin-top:-219px; margin-left:152px; transform:rotateZ(90deg)">
<?php } ?>
<!-- V0103 -->
<?php if ($V0103_HMI == true) { ?>
<img src="img/3-D Valve Shaded.png" alt="" height="36px" width="44px"
    style="position:absolute;margin-top:-241px; margin-left:282px;">
<?php } ?>

<!-- V1901 -->
<?php if ($V1901_HMI == true) { ?>
<img src="img/3-D Valve Shaded.png" alt="" height="36px" width="47px"
    style="position:absolute;margin-top:-227px; margin-left:372px">
<?php } ?>
<!-- V0101 -->
<?php if ($V0101_HMI == true) { ?>
<img src="img/3-D Valve Shaded.png" alt="" height="41px" width="40px"
    style="position:absolute;margin-top:-426px; margin-left:371px; transform:rotateZ(270deg)">
<?php } ?>
<!-- V1602 -->
<?php if ($V1602_HMI == true) { ?>
<img src="img/3-D Valve Shaded.png" alt="" height="52px" width="47px"
    style="position:absolute;margin-top:-520px; margin-left:198px">
<?php } ?>
<!-- V16.01 -->
<?php if ($V1601_HMI == true) { ?>
<img src="img/3-D Valve Shaded.png" alt="" height="42px" width="46px"
    style="position:absolute;margin-top:-623px; margin-left:255px">
<?php } ?>
<!-- V2001 -->
<?php if ($V2001_HMI == true) { ?>
<img src="img/3-D Valve Shaded.png" alt="" height="34px" width="47px"
    style="position:absolute;margin-top:-302px; margin-left:453px">
<?php } ?>
<!-- V12.03 -->
<?php if ($V1203_HMI == true) { ?>
<img src="img/3-D Valve Shaded.png" alt="" height="36px" width="47px"
    style="position:absolute;margin-top:-375px; margin-left:669px">
<?php } ?>
<!-- V12.01 -->
<?php if ($V1201_HMI == true) { ?>
<img src="img/3-D Valve Shaded.png" alt="" height="34px" width="47px"
    style="position:absolute;margin-top:-465px; margin-left:685px; transform:rotateZ(90deg)">
<?php } ?>
<!-- V12.02 -->
<?php if ($V1202_HMI == true) { ?>
<img src="img/3-D Valve Shaded.png" alt="" height="39px" width="47px"
    style="position:absolute;margin-top:-614px; margin-left:665px; transform:rotateZ(270deg)">
<?php } ?>
<!--  -->
<?php if ($V1001_HMI == true) { ?>
<img src="img/3-D Valve Shaded.png" alt="" height="39px" width="49px"
    style="position:absolute;margin-top:-632px; margin-left:1221px">
<?php } ?>
<!-- 10.01 -->
<!-- <?php //if ($var20 == true) { ?>
<img src="img/3-D Valve Shaded.png" alt="" height="37px" width="47px"
    style="position:absolute;margin-top:-594px; margin-left:1100px">
<?php //} ?> -->
<!-- 10.02 -->
<!-- <?php //if ($var21 == true) { ?>
<img src="img/3-D Valve Shaded.png" alt="" height="37px" width="47px"
    style="position:absolute;margin-top:-542px; margin-left:1100px">
<?php //} ?> -->
<!-- 10.23 -->
<!-- <?php //if ($var22 == true) { ?>
<img src="img/3-D Valve Shaded.png" alt="" height="35px" width="43px"
    style="position:absolute;margin-top:-482px; margin-left:1187px;  transform:rotateZ(270deg)">
<?php //} ?> -->
<!-- light -->
<!-- PAM -->
<?php if ($PAM_HMI == true) { ?>
<img src="img/Green pilot light 2.png" alt="" height="28px" width="30px"
    style="position:absolute;margin-top:-85px; margin-left:921px;">
<?php } ?>
<!-- RFP -->
<?php if ($RFP_1_2_3_4_5 == true) { ?>
<img src="img/Green pilot light 2.png" alt="" height="28px" width="30px"
    style="position:absolute; margin-top:-85px; margin-left:620px;">
<?php } ?>
<!-- PFM -->
<?php if ($PFM_ON_HMI == true) { ?>
<img src="img/Green pilot light 2.png" alt="" height="28px" width="30px"
    style="position:absolute;margin-top:-85px; margin-left:777px;">
<?php } ?>
<!-- blink lights -->
<!-- 15.01 -->
<?php if ($var26 == true) { ?>
<div class="blink1" style="position:absolute;margin-top:-676px; margin-left:218px;"></div>
<?php } ?>
<!-- 15.02 -->
<!-- <div class="blink1" style="position:absolute;margin-top:-662px; margin-left:240px;"></div> -->
<!-- pal13.01 -->
<?php if ($V1301_HMI == true) { ?>
<div class="blink1" style="position:absolute;margin-top:-690px; margin-left:468px;"></div>
<?php } ?>
<!-- water -->
<?php if ($LT0101_Scaled < '1') { ?> 
<?php } elseif ($LT0101_Scaled >= '85') { ?>
<img src="img/milk.png" alt="" width="37px" height="88px"
    style="position:absolute;margin-top:-348px; margin-left:214px; opacity:0.7">
<?php } elseif ($LT0101_Scaled >= '65') { ?>
<img src="img/milk.png" alt="" width="37px" height="76px"
    style="position:absolute;margin-top:-336px; margin-left:214px; opacity:0.7">
<?php } elseif ($LT0101_Scaled >= '55') { ?>
<img src="img/milk.png" alt="" width="37px" height="50px"
    style="position:absolute;margin-top:-310px; margin-left:214px; opacity:0.7">
<?php } elseif ($LT0101_Scaled >= '45') { ?>
<img src="img/milk.png" alt="" width="37px" height="28px"
    style="position:absolute;margin-top:-288px; margin-left:214px; opacity:0.7">
<?php } elseif ($LT0101_Scaled >= '35') { ?>
<img src="img/milk.png" alt="" width="37px" height="17px"
    style="position:absolute;margin-top:-277px; margin-left:214px; opacity:0.7">
<?php } elseif ($LT0101_Scaled >= '20' || $LT0101_Scaled <= '20') { ?>
<img src="img/milk.png" alt="" width="37px" height="7px"
    style="position:absolute;margin-top:-267px; margin-left:214px; opacity:0.7">
<?php } ?>
<img src="img/logo3.png" width="auto" height="110px" style="position: absolute;margin-top:-175px; margin-left:1164px; opacity:0.7" alt="">
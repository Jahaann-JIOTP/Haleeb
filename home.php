<?php
session_start();
error_reporting(E_ERROR | E_PARSE);

if (!isset($_SESSION['auth'])) {
    header('Location:index.php');
}
include('Action/db_connection.php');
$email = $_SESSION["user"];
// echo $email;
$result = mysqli_query($con, "SELECT * FROM accounts WHERE  email= '$email'");
$row = mysqli_fetch_assoc($result);
// var_dump($row);
// echo $row['user_level']; 
$permstring = $row['user_level'];
// echo $permstring; 
$userLevelArray = explode(",", $permstring);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Haleeb Foods Monitoring System</title>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <link rel="icon" type="gif" href="https://haleebfoods.com/wp-content/uploads/2022/08/favicon.png" />
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="./css/data_table.css">
    <script src="./js_libraries/jspdf.debug.js"></script>
    <script src="./js_libraries/jspdf.plugin.autotable.js"></script>
    <script src="./js_libraries/jspdf.umd.min.js"></script>
    <!-- <link rel="stylesheet" href="https://cdn.amcharts.com/lib/4/charts.css"> -->
    <style>
        /* Table CSS ADDED  */
        .th th {
            background-color: #d8bc5a;
            border-color: #d8bc5a;
            color: black;
        }

        .table {
            /* background: #f5f5f5; */
            border-collapse: separate;
            font-size: 16px;
            line-height: 24px;
            margin: 30px auto;
            text-align: left;
        }

        .myDivOpen {
            width: 106%;
            overflow: hidden;
            transition: width 0.5s ease;

        }

        th {
            color: #fff;
            font-weight: bold;
            padding: 10px 15px;
            position: relative;
            text-shadow: 0 1px 0 #000;
        }

        td {

            padding: 10px 15px;
            position: relative;
            transition: all 300ms;
        }

        /* END */

        /* ===== Scrollbar CSS ===== */
        /* Firefox */
        * {
            scrollbar-width: auto;
            scrollbar-color: #b6b5b9 #ffffff;
        }

        /* Chrome, Edge, and Safari */
        *::-webkit-scrollbar {
            width: 8px;
        }

        *::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
            border-radius: 10px;
            background-color: #F5F5F5;
        }

        *::-webkit-scrollbar-thumb {
            background-color: #c8c6d2;
            border-radius: 15px;
            border: 1px solid #c8c6d2;
        }

        #close-dropdown {
            background-color: #0C4B93;
            color: white;
            border: none;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            height: 25px;
            margin-top: -5px;
        }

        #close-dropdown:hover {
            background-color: #45a049;
        }

        .checkbox-dropdown {
            width: 200px;
            border: 1px solid #aaa;
            color: black;
            padding: 5px;
            position: relative;
            user-select: none;
            background-color: #fff;
        }

        /* Display CSS arrow to the right of the dropdown text */
        .checkbox-dropdown:after {
            content: '';
            position: absolute;
            width: 0;
            border: 6px solid transparent;
            border-top-color: #000;
            top: 50%;
            right: 10px;
            margin-top: -3px;
        }

        /* Reverse the CSS arrow when the dropdown is active */
        .checkbox-dropdown.is-active:after {
            border-bottom-color: #000;
            border-top-color: #fff;
            margin-top: -9px;
        }

        .checkbox-dropdown-list {
            list-style: none;
            margin: 0;
            padding: 0;
            position: absolute;
            top: 100%;
            /* align the dropdown right below the dropdown text */
            border: inherit;
            border-top: none;
            left: -1px;
            /* align the dropdown to the left */
            right: -1px;
            background-color: #fff;
            /* align the dropdown to the right */
            opacity: 0;
            /* hide the dropdown */
            transition: opacity 0.4s ease-in-out;
            pointer-events: none;
            z-index: 9999;
            /* avoid mouse click events inside the dropdown */
        }

        .is-active .checkbox-dropdown-list {
            opacity: 1;
            /* display the dropdown */
            pointer-events: auto;
            /* make sure that the user still can select checkboxes */
        }

        .checkbox-dropdown-list li label {
            display: block;
            border-bottom: 1px solid silver;
            padding: 5px;

            transition: all 0.2s ease-out;
        }

        .checkbox-dropdown-list li label:hover {
            background-color: #555;
            color: white;
        }

        .dropdown select {
            float: right;
            margin-top: -30px;
            padding: 8px 16px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #fff;
            cursor: pointer;
        }

        .dropdown select:focus {
            outline: none;
            border-color: #888;
            box-shadow: 0 0 4px rgba(0, 0, 0, 0.1);
        }

        .btn {
            display: inline-block;
            font-weight: 400;
            color: #212529;
            text-align: center;
            vertical-align: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            background-color: transparent;
            border: 1px solid transparent;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 0.25rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out,
                border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .btn-primary {
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            color: #fff;
            background-color: #0069d9;
            border-color: #0062cc;
        }

        .card {
            border: 1px solid rgba(0, 0, 0, 0.125);
            border-radius: 0.25rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .card-header {
            padding: 0.75rem 1.25rem;
            margin-bottom: 0;
            background: none;
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
            font-size: 20px;
        }

        .card-body {
            padding: 1.25rem;
        }

        .card-title {
            margin-bottom: 0.75rem;
        }

        .card-text {
            margin-bottom: 0;
        }

        .card-img-top {
            width: 100%;
            border-top-left-radius: calc(0.25rem - 1px);
            border-top-right-radius: calc(0.25rem - 1px);
        }

        .card-link {
            text-decoration: none;
        }

        @font-face {
            font-family: 'digital-7';
            src: url('fonts/Digital Numbers 400.ttf');
        }

        .led-green {
            font-size: 24px;
            color: #000000;
            padding-top: 15px;
            text-align: center;
            border-radius: 5px;
            margin: 0 auto;
            width: 60px;
            height: 40px;
            background-color: #ABFF00;
            float: right;
            /*   border-radius: 50%; */
            box-shadow: rgba(0, 0, 0, 0.2) 0 -1px 7px 1px, inset #304701 0 -1px 9px, #89FF00 0 2px 12px;
        }

        .led-red {
            /* margin: 0 auto; */
            font-size: 24px;
            color: #000000;
            padding-top: 15px;
            text-align: center;
            margin: 0 auto;
            width: 60px;
            height: 40px;
            float: right;
            border-radius: 5px;
            background-color: #F00;
            /*   border-radius: 50%; */
            box-shadow: rgba(0, 0, 0, 0.2) 0 -1px 7px 1px, inset #441313 0 -1px 9px, rgba(255, 0, 0, 0.5) 0 2px 12px;
            -webkit-animation: blinkRed 0.5s infinite;
            -moz-animation: blinkRed 0.5s infinite;
            -ms-animation: blinkRed 0.5s infinite;
            -o-animation: blinkRed 0.5s infinite;
            animation: blinkRed 0.5s infinite;
        }

        footer {
            font-family: "Poppins", sans-serif;
            position: absolute;
            bottom: 5px;
            width: 100%;
            height: 60px;
            /* display:inline-flex; */
            /* align-items: center; */
            justify-content: space-between;
            flex-direction: column;
            padding: 9px 0px;
            border-radius: 20px;
            background: #2662b1;
            /* border-top: aliceblue 5px solid; */
        }

        p {
            color: aliceblue;
        }

        .button-41 {
            background-color: initial;
            background-image: linear-gradient(-180deg, #00D775, #017301);
            border-radius: 5px;
            box-shadow: rgba(0, 0, 0, 0.1) 0 2px 4px;
            color: #FFFFFF;
            cursor: pointer;
            display: inline-block;
            font-family: Inter, -apple-system, system-ui, Roboto, "Helvetica Neue", Arial, sans-serif;
            height: 44px;
            line-height: 14px;
            outline: 0;
            overflow: hidden;
            padding: 0 20px;
            pointer-events: auto;
            position: relative;
            text-align: center;
            touch-action: manipulation;
            user-select: none;
            -webkit-user-select: none;
            vertical-align: top;
            white-space: nowrap;
            width: 90px;
            z-index: 9;
            border: 0;
            position: relative;
            margin-bottom: 10px;
            margin-top: -15px;
            /* text-indent: -9999px; */
        }

        .button-41:hover {
            background: #017301;
        }

        h2 {
            margin-bottom: -0.1px;
        }

        .p {
            height: 40px;
            margin-top: -.01px;
            margin-right: 15px;
            margin-left: 15px;
            font-size: 26px;
            margin-top: 5px
        }

        .header {
            background-color: #0C4B93;
            height: 40px;
            margin-top: -70px;
            border-radius: 30px;
            width: 95.5%;
        }

        .head,
        .head5 {
            height: 40px;
            border-radius: 15px;
            padding-right: 190px;
            font-size: 32px;
            color: #f1f1f1;
        }

        .container {
            width: 95%;
            overflow: auto;
        }

        .tab {
            float: left;
            width: 12.8%;
            height: 74.2vh;

        }

        .tablinks.active {
            background-color: #0C4B93;
            border-left: 4px solid #5AF45A;
            box-shadow: 5px 5px 7px #8b8b8b,
                -5px -5px 7px #ffffff;
        }

        .tab button {
            background-color: grey;
            border: 1px solid transparent;
            border-radius: 3px;
            box-shadow: rgba(255, 255, 255, .4) 0 1px 0 0 inset;
            box-sizing: border-box;
            color: #fff;
            cursor: pointer;
            display: inline-block;
            font-family: -apple-system, system-ui, "Segoe UI", "Liberation Sans", sans-serif;
            font-weight: 400;
            line-height: 1.15385;
            margin: 0;
            outline: none;
            padding: 16px 12px;
            width: 100%;
            height: 7.5%;
            position: relative;
            text-align: center;
            text-decoration: none;
            user-select: none;
            -webkit-user-select: none;
            touch-action: manipulation;
            vertical-align: baseline;
            white-space: nowrap;
            transition: 0.3s;
            font-size: 17px;
            margin-bottom: 8%;
            margin-top: 1%;
            overflow: hidden;
        }

        .tab button:hover,
        .tab button:focus {
            background-color: #0C4B93;
        }

        .tab button:active {
            background-color: #0C4B93;
            box-shadow: none;
        }

        /* Style the tab content */
        .tabcontent {
            float: right;
            /* padding: 0px 12px; */
            border: 1px solid #ccc;
            width: 80%;
            /* border-left: none; */
            height: 75vh;
            text-align: left;
            overflow: auto;
            border-radius: 20px;
            margin-top: -5px;
        }

        .weather {
            border-radius: 10px !important;
            background: none;
            margin-top: -17px;
            margin-right: -80px;
            margin-left: 20px;
        }

        .element {
            height: 60px;
            width: 60px;
            margin-right: 10px;
            margin-top: 4px;
        }

        .elements {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;

        }

        .white {
            fill: #FFFFFF
        }

        .gray {
            fill: #E0E0E0
        }

        .yellow {
            fill: #FFEB3B;
        }

        navbar .navbar-body {
            display: flex;
            display: -webkit-flex;
            flex-direction: row;
            align-items: center;
            -webkit-align-items: center;
            justify-content: space-between;
            height: 100%;
            position: relative;
            background-color: #2B70C9;
            color: #f1f1f1;
            border-radius: 20px;
        }

        navbar div.navbar-end {
            align-items: flex-start;
            -webkit-align-items: flex-start;
        }

        navbar div.navbar-start,
        navbar div.navbar-end {
            /* flex: 1; */
            /* -webkit-flex: 1; */
            display: flex;
            display: -webkit-flex;
            flex-direction: row;
            /* align-items: center; */
            /* -webkit-align-items: center; */
            justify-content: space-around;
        }

        navbar div.navbar-start .logo {
            opacity: 0.6;
            width: 30px;
        }

        /*Integrating Two Navbars Together*/
        navbar .nav {
            z-index: 2;
        }

        navbar .tabs {
            margin-top: 50px;
            z-index: 1;
            position: relative;
        }

        navbar .tabs .navbar-body {
            padding: 0;
            margin-bottom: 0;
        }

        /* @import url('https://fonts.cdnfonts.com/css/digital-numbers'); */

        .rectangle {
            height: 47px;
            width: 215px;
            background-color: #000000;
            border: 4px solid grey;
            font-family: 'digital-7', sans-serif;
            color: #4FFF00;
            font-size: 38px;
        }

        .rectangle1 {
            height: 47px;
            width: 345px;
            background-color: #000000;
            border: 4px solid grey;
            font-family: 'digital-7', sans-serif;
            color: #4FFF00;
            font-size: 38px;
        }

        .rectangle2 {
            /* height: 50px; */
            /* width: 90px; */
            display: inline-block;
            margin-left: 5px;
            background-color: #000000;
            border: 2px solid grey;
            font-family: 'digital-7', sans-serif;
            color: #4FFF00;
            font-size: 30px;
        }

        .rectangle3 {
            height: 30px;
            width: 90px;
            background-color: rgb(1, 115, 1);
            border: 2px solid rgb(194, 194, 194);
            color: white;
            padding: 4px 0px 0px 0px;
            font-size: 24px;
            margin-bottom: 7px;
        }

        .rectangle4 {
            height: 30px;
            width: 110px;
            background-color: rgb(1, 115, 1);
            border: 2px solid rgb(194, 194, 194);
            color: white;
            font-size: 24px;
            margin-bottom: 7px;
            padding: 4px 0px 0px 0px;
        }

        .rectangle5 {
            height: 45px;
            width: 160px;
            background-color: #003c74a8;
            border: 2px solid rgb(194, 194, 194);
            color: #f1f1f1;
            font-size: 28px;
            margin-bottom: 10px;
            padding: 11px 0px 0px 0px;
            font-weight: 100;
            border-radius: 5px;
            box-shadow: rgba(0, 0, 0, 0.1) 0 2px 4px;
            cursor: pointer;
            overflow: hidden;
            pointer-events: auto;
            text-align: center;
            touch-action: manipulation;
            user-select: none;
            -webkit-user-select: none;
            vertical-align: top;
            white-space: nowrap;
            z-index: 9;
            border: 0;
        }

        .rectangle5:active {
            transform: scale(0.9);
        }

        .line {
            border-bottom: 3px solid rgb(255, 0, 0);
            width: 200px;
            transform: rotate(45deg);
            position: relative;
            margin-top: 69px;
            margin-left: 157px;
            z-index: -1;
        }

        .line1 {
            border-bottom: 3px solid rgb(255, 0, 0);
            width: 200px;
            transform: rotate(135deg);
            position: relative;
            margin-top: -3px;
            z-index: -1;
            margin-left: 455px;
        }

        .oval {
            width: 100px;
            height: 40px;
            background: #8106BC;
            border-radius: 100px / 40px;
            font-size: 34px;
            color: #fff;
            padding: 4px 0px 6px 0px;
            font-family: 'digital-7', sans-serif;
        }

        :root {
            --theme-primary: url('img/1751407.jpg');
            --theme-secondary: #eeeeee;
            --theme-font-color: black;
        }

        html[data-theme='light'] {
            --theme-primary: url('img/1751407.jpg');
            --theme-secondary: #eeeeee;
            --theme-even: #f2f2f2 !important;
            --theme-odd: #e6e6ff !important;
            --theme-font-color: black;
        }

        html[data-theme='dark'] {
            --theme-primary: #111;
            --theme-secondary: #222;
            --theme-even: #4E4E4E !important;
            --theme-odd: #939496 !important;
            --theme-font-color: white;
        }

        body {
            background-image: var(--theme-primary);
            background: var(--theme-primary);
            /* background-image: url('img/1751407.jpg'); */
            background-position: center;
            /* background-repeat: no-repeat; */
            background-size: cover;
            color: var(--theme-font-color);

        }

        .top-bar {
            display: flex;
            justify-content: center;
            padding: 1rem 3rem
        }

        #theme-switcher {
            padding: 3px 5px 5px 3px;
            background: #2B70C9;
            border: none;
            border-radius: .2em;
            color: inherit;
            font-size: 30px;
            box-shadow: 0 0 10px -5px #888;
            cursor: pointer;
            transition: box-shadow 300ms ease;
            height: 35px;
            width: 35px;
            margin-right: 25px;
            margin-top: 13px;
        }

        #theme-switcher:hover {
            box-shadow: 1px 1px 10px -3px #888;
        }

        #theme-switcher:active {
            box-shadow: 0 0 10px -8px #888;
        }

        #theme-switcher>i {
            display: inline-block;
            width: 1em;
            height: 1em;
            position: relative;
        }

        #theme-switcher .icon {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            animation-duration: 300ms;
            animation-timing-function: ease-out;
            animation-fill-mode: forwards;
        }

        #theme-switcher .icon.moon {
            opacity: 0;
        }

        html[data-theme="light"] #theme-switcher .icon.sun {
            animation-name: risein;
        }

        html[data-theme="light"] #theme-switcher .icon.moon {
            animation-name: setout;
        }

        html[data-theme="dark"] #theme-switcher .icon.sun {
            animation-name: setout;
        }

        html[data-theme="dark"] #theme-switcher .icon.moon {
            animation-name: risein;
        }

        @keyframes risein {
            from {
                transform-origin: 200% 100%;
                transform: rotate(-50deg);
                opacity: 0;
            }

            to {
                transform-origin: 200% 100%;
                transform: rotate(0);
                opacity: 1;
            }
        }

        @keyframes setout {
            from {
                transform-origin: 200% 100%;
                transform: rotate(0);
                opacity: 1;
            }

            to {
                transform-origin: 200% 100%;
                transform: rotate(50deg);
                opacity: 0;
            }
        }

        .log {
            margin-right: 20px;
        }

        @media (max-width: 1210px) {
            .wid {
                width: 1400px;
            }
        }

        @media (max-width: 850px) {
            .head {
                font-size: 18px;
                padding: 10px;
                float: right;
            }

            .head5 {
                font-size: 18px;
                padding: 1px;
                float: right;
            }
        }

        @media (max-width: 630px) {
            .p {
                font-size: 16px;
                padding-top: 7px;
            }

            .display {
                display: none;
            }

            .small {
                width: 180px;
                margin-right: -80px;
            }

            .small {
                transform: scale(0.7);
                margin-left: -25px;
            }

            .wsmall {
                margin-left: -4px;
            }

            .log {
                margin-right: 5px;
            }

            .element {
                height: 30px;
                width: 30px;
                margin-left: -30px;
                margin-top: 14px;
            }
        }

        @media (max-width: 780px) {
            .center {
                margin-left: -120px;
            }

            .tab button {
                font-size: 12px;
            }
        }

        @media (max-width: 428px) {


            .tab button {
                width: 55px;
            }

            .tabcontent {
                margin-left: -5px;
            }
        }

        @media (max-width: 500px) {
            .top {
                margin-top: 30px;
            }
        }

        .hero--wrapper {
            margin: 0 auto;
            width: 100%;
        }

        #hero--buttons {
            margin: 0px auto;
            text-align: center;
        }

        #finance-btn {
            color: #090909;
            padding: 0.7em 1.7em;
            font-size: 18px;
            margin-right: 10px;
            border-radius: 0.5em;
            background: #358EA0;
            border: 1px solid #358EA0;
            color: #fff;
            cursor: pointer;
            transition: all .3s;
            box-shadow: -6px -6px 12px #c5c5c5,
                6px 6px 12px #ffffff;
        }

        #finance-btn:active {
            color: #666;
            box-shadow: inset 4px 4px 12px #c5c5c5,
                inset -4px -4px 12px #ffffff;
        }

        #mngrol-btn {
            color: #090909;
            padding: 0.7em 1.7em;
            font-size: 18px;
            margin-right: 10px;
            border-radius: 0.5em;
            background: #358EA0;
            border: 1px solid #358EA0;
            color: #fff;
            cursor: pointer;
            transition: all .3s;
            box-shadow: -6px -6px 12px #c5c5c5,
                6px 6px 12px #ffffff;
        }

        #mngrol-btn:active {
            color: #666;
            box-shadow: inset 4px 4px 12px #c5c5c5,
                inset -4px -4px 12px #ffffff;
        }

        #user-btn {
            color: #0c4b93;
            padding: 0.7em 1.7em;
            font-size: 18px;
            border-radius: 0.5em;
            background: #0c4b93;
            border: 1px solid #0c4b93;
            color: #fff;
            transition: all .3s;
            box-shadow: -6px -6px 12px #c5c5c5,
                6px 6px 12px #ffffff;
            margin-right: 10px;
        }

        #user-btn:active {
            color: #666;
            box-shadow: inset 4px 4px 12px #c5c5c5,
                inset -4px -4px 12px #ffffff;
        }


        #refer-btn {
            color: #090909;
            padding: 0.7em 1.7em;
            font-size: 18px;
            cursor: pointer;
            border-radius: 0.5em;
            background: #d8bc5a;
            border: 1px solid #d8bc5a;
            transition: all .3s;
            box-shadow: -6px -6px 12px #c5c5c5,
                6px 6px 12px #ffffff;
        }

        #refer-btn:active {
            color: #666;
            box-shadow: inset 4px 4px 12px #c5c5c5,
                inset -4px -4px 12px #ffffff;
        }


        #mngpriv-btn {
            color: #f1f1f1;
            padding: 0.7em 1.7em;
            font-size: 18px;
            border-radius: 0.5em;
            background: #733b97;
            border: 1px solid #733b97;
            cursor: pointer;
            transition: all .3s;
            box-shadow: -6px -6px 12px #c5c5c5,
                6px 6px 12px #ffffff;
        }

        #mngpriv-btn:active {
            color: #666;
            box-shadow: inset 4px 4px 12px #c5c5c5,
                inset -4px -4px 12px #ffffff;
        }

        #view-user-btn {
            color: #090909;
            padding: 0.7em 1.7em;
            font-size: 18px;
            border-radius: 0.5em;
            background: #d8bc5a;
            border: 1px solid #d8bc5a;
            cursor: pointer;
            transition: all .3s;
            box-shadow: -6px -6px 12px #c5c5c5,
                6px 6px 12px #ffffff;
        }

        #view-user-btn:active {
            color: #666;
            box-shadow: inset 4px 4px 12px #c5c5c5,
                inset -4px -4px 12px #ffffff;
        }

        #gform_7,
        #gform_63 {
            display: none;
        }

        #gform_7 {
            margin: 0 auto;
            width: 95%;
            height: 570px;
            padding: 10px;
        }

        #gform_63 {
            margin: 0 auto;
            width: 95%;
            height: 570px;
            padding: 10px;
        }

        .i {
            margin: 20px auto;
        }

        .date1 {
            -webkit-text-size-adjust: none;
            margin: 0;
            border: 0;
            font: inherit;
            vertical-align: baseline;
            float: right;
            box-sizing: border-box;
            padding: 0 0 0 1.5em;
        }

        .date2 {
            -webkit-text-size-adjust: none;
            margin: 0;
            border: 0;
            font: inherit;
            vertical-align: baseline;
            float: left;
            box-sizing: border-box;
            padding: 0 0 0 1.5em;
        }

        #chartdiv {
            width: 100%;
            height: 500px;
        }

        #chartdata {
            /* max-height: 400px; */
            overflow: auto;
        }

        #chartdata table {
            width: 100%;
        }

        /* img:active {
            transform: scale(0.9);
        } */
        #charttemp {
            width: 100%;
            height: 530px;
        }

        #reportForm {
            width: 70%;
            margin: 20px auto;
            background: none;
            padding: 20px;
            border-radius: 8px;
            /* box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); */
            display: grid;
            /* Use grid layout */
            gap: 10px;
            /* Add gap between grid items */
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }

        .rep select,
        .rep input[type="date"] {
            width: 100%;
            /* Set width to 100% */
            padding: 10px;
            font-size: 14px;
            border-radius: 4px;
            border: 1px solid #ccc;
            color: #333;
            box-sizing: border-box;
            /* Include padding in the width calculation */
        }

        button.btn-generate {
            background-color: #0070AD;
            color: white;
            padding: 10px 16px;
            font-size: 14px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button.btn-generate:hover {
            background-color: #45a049;
        }

        input[type="checkbox"] {
            margin-right: 5px;
            margin-left: 20px;
        }

        #dynamicOptions {
            margin-top: 10px;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
        }

        #dynamicOptions label {
            display: block;
            margin-bottom: 5px;
        }

        #dynamicOptions input[type="checkbox"] {
            margin-right: 5px;
            margin-bottom: 5px;
        }

        #dynamicOptions input[type="checkbox"]:checked+label {
            color: #4caf50;
            font-weight: bold;
        }

        #privileges {
            margin-top: 10px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
        }

        #privileges div {
            display: flex;
            align-items: center;
        }

        #privileges label {
            margin-left: 5px;
            margin-bottom: 0;
        }

        #privileges input[type="checkbox"] {
            margin-right: 5px;
            margin-bottom: 0;
        }

        #privileges input[type="checkbox"]:checked+label {
            color: #4caf50;
            font-weight: bold;
        }

        .blink {
            animation: blinker .5s linear infinite;
            color: white;
            font-weight: bold;
        }

        @keyframes blinker {
            50% {
                background: red;
            }
        }

        .blink1 {
            animation: blinker1 .5s linear infinite;
            height: 19px;
            width: 19px;
        }

        @keyframes blinker1 {
            50% {
                background-image: url("img/Green pilot light 2.png");
                background-size: 18px 18px;
                background-repeat: no-repeat;
            }
        }

        .styled-table {
            border-collapse: collapse;
            width: 100%;
            font-size: 14px;
        }

        .styled-table th {
            background-color: #FF6384;
            color: #FFFFFF;
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
            font-weight: bold;
            text-transform: uppercase;
        }

        .styled-table td {
            border: 1px solid #ddd;
            padding: 12px;
        }

        .styled-table tr:nth-child(even) {
            background-color: var(--theme-even) !important;
        }

        .styled-table tr:hover {
            background-color: var(--theme-odd) !important;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            background-color: #358EA0;
            color: white;
        }

        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        tr:nth-child(even) {
            background-color: var(--theme-even) !important;
        }

        tr:nth-child(odd) {
            background-color: var(--theme-odd) !important;
        }

        .event tr:hover {
            background-color: #FFDDAA !important;
        }

        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #DDDDDD;
        }

        .pagination a {
            color: #000000;
            padding: 8px 16px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .pagination a:hover {
            background-color: #F9F9F9;
        }

        .pagination .active {
            background-color: #0C4B93;
            color: #FFFFFF;
        }

        .Low {
            color: rgb(17, 0, 255) !important;
            font-weight: 700 !important;
            border-left: 5px rgb(17, 0, 255) solid;
        }

        .High {
            color: rgb(255, 0, 0) !important;
            font-weight: 700 !important;
            border-left: 5px rgb(255, 0, 0) solid;
        }

        .container {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .pcontainer {
            display: flex;
            justify-content: space-between;
        }

        .card {
            border: 1px solid #0C4B93;
            border-radius: 4px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            padding: 10px;
            width: 20%;
            margin-right: 20px;
            background-color: #39506b;
        }

        .card:last-child {
            margin-right: 0;
        }

        .card h3 {
            margin-top: 0;
            color: #f1f1f1;
        }

        .card p {
            text-align: center;
            margin-bottom: 0;
            font-family: 'digital-7', sans-serif;
            color: #4FFF00;
            font-size: 30px;
        }

        .triangle-right {
            width: 0;
            height: 0;
            border-top: 25px solid transparent;
            border-left: 50px solid #555;
            border-bottom: 25px solid transparent;
        }

        .form-body {
            /* line-height: 0.5; */
            margin: 2% 2% 0 2%;
            padding: 0 2% 0 2%;
            /* border: 1px solid gray; */
            border-radius: 2rem;

        }

        .button-7 {
            background: #398197;
            border-radius: 999px;
            box-shadow: #398197 0 10px 20px -10px;
            box-sizing: border-box;
            color: #FFFFFF;
            cursor: pointer;
            font-family: Inter, Helvetica, "Apple Color Emoji", "Segoe UI Emoji", NotoColorEmoji, "Noto Color Emoji", "Segoe UI Symbol", "Android Emoji", EmojiSymbols, -apple-system, system-ui, "Segoe UI", Roboto, "Helvetica Neue", "Noto Sans", sans-serif;
            font-size: 16px;
            font-weight: 700;
            line-height: 24px;
            opacity: 1;
            outline: 0 solid transparent;
            padding: 8px 18px;
            user-select: none;
            -webkit-user-select: none;
            touch-action: manipulation;
            width: fit-content;
            word-break: break-word;
            border: 0;
        }

        .button-8 {
            background: red;
            border-radius: 1rem;
            /* box-shadow: #398197 0 10px 20px -10px; */
            box-sizing: border-box;
            color: #FFFFFF;
            cursor: pointer;
            font-family: Inter, Helvetica, "Apple Color Emoji", "Segoe UI Emoji", NotoColorEmoji, "Noto Color Emoji", "Segoe UI Symbol", "Android Emoji", EmojiSymbols, -apple-system, system-ui, "Segoe UI", Roboto, "Helvetica Neue", "Noto Sans", sans-serif;
            font-size: 14px;
            font-weight: 700;
            line-height: 24px;
            opacity: 1;
            outline: 0 solid transparent;
            padding: 4px 8px;
            user-select: none;
            -webkit-user-select: none;
            touch-action: manipulation;
            width: fit-content;
            word-break: break-word;
            border: 0;
            margin-left: auto;
            margin-right: auto;
            display: block;
        }

        .input {
            margin-left: 4.3rem;
            line-height: 1.3rem;
            margin-top: 6px;
        }

        .expandable-div {
            transition: all 0.3s ease;
        }

        .expanded {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            zoom: 1.3;
            z-index: 999;
        }

        #pressure-options,
        #temperature-options {
            display: none;
        }


        @keyframes slideInFromLeft {
            0% {
                transform: translateX(-100%);
                opacity: 0;
            }

            100% {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .hidden {
            display: none;
        }

        .card1 {
            /* display: block; */
            animation: slideInFromLeft 1s ease-out forwards;
            padding: 10px;
            border-radius: 10px;
            box-shadow: rgba(0, 0, 0, 0.44) 0px 3px 8px;
        }

        .chartsize {
            width: 100% !important;
        }

        .sizedetail {
            width: 60px !important;
        }

        #toggleButton,
        #toggleButton1 {
            width: 0px;
            height: 70px;
            margin-top: 65px;
            font-size: x-large;
            padding-right: 7px;
            padding-left: 0px;
            background-color: #1F5897;
            color: #fff;
            border-radius: 5px;
        }

        .myDivClosed {
            width: 3%;
            overflow: hidden;
            transition: width 0.5s ease;
        }

        .myDivOpen1 {
            width: 33%;
            overflow: hidden;
            transition: width 0.5s ease;

        }
    </style>
</head>

<body>
    <?php include('preloader.php') ?>
    <navbar>
        <div class="navbar nav navbar-fixed-top navbar-inverse">
            <div class="container-fluid">
                <div class="v-flex">
                    <div class="navbar-body">
                        <div class="navbar-start">
                            <div class="hamburger-menu">
                                <div class="ic_menu">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </div>
                            <?php
                            $apiKey = "489a3eb5ccabc52d1145eee38cc114eb";
                            $cityId = "1172451";
                            $googleApiUrl = "http://api.openweathermap.org/data/2.5/weather?id=" . $cityId . "&lang=en&units=metric&APPID=" . $apiKey;
                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_HEADER, 0);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                            curl_setopt($ch, CURLOPT_URL, $googleApiUrl);
                            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                            curl_setopt($ch, CURLOPT_VERBOSE, 0);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                            $response = curl_exec($ch);
                            curl_close($ch);
                            $data = json_decode($response);
                            $currentTime = time();
                            //echo $response;
                            ?>
                            <div class="navbar-nav col-lg-2 col-sm-6 ml-auto">
                                <div class="weather">
                                    <div class="card-body row" style="height:40px;">
                                        <div class="current elements">
                                            <!-- Cloudy with sun -->
                                            <div class="element">
                                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 61.7 42.8" style="enable-background:new 0 0 61.7 42.8;" xml:space="preserve">
                                                    <g id="Cloud_3">
                                                        <g id="White_cloud_3">
                                                            <path id="XMLID_24_" class="white" d="M47.2,42.8H7.9c-4.3,0-7.9-3.5-7.9-7.9l0,0C0,30.5,3.5,27,7.9,27h39.4c4.3,0,7.9,3.5,7.9,7.9 v0C55.1,39.2,51.6,42.8,47.2,42.8z" />
                                                            <circle id="XMLID_23_" class="white" cx="17.4" cy="25.5" r="9.3" />
                                                            <circle id="XMLID_22_" class="white" cx="34.5" cy="23.9" r="15.6" />
                                                            <animateTransform attributeName="transform" attributeType="XML" dur="2s" keyTimes="0;0.5;1" repeatCount="indefinite" type="translate" values="0;5;0" calcMode="linear">
                                                            </animateTransform>
                                                        </g>
                                                        <g id="Sun_3">
                                                            <circle id="XMLID_30_" class="yellow" cx="31.4" cy="18.5" r="9" />
                                                            <g>
                                                                <path id="XMLID_31_" class="yellow" d="M31.4,6.6L31.4,6.6c-0.4,0-0.6-0.3-0.6-0.6V0.6C30.8,0.3,31,0,31.3,0l0.1,0 C31.7,0,32,0.3,32,0.6v5.5C32,6.4,31.7,6.6,31.4,6.6z" />
                                                                <path id="XMLID_34_" class="yellow" d="M31.4,30.1L31.4,30.1c-0.4,0-0.6,0.3-0.6,0.6v5.5c0,0.3,0.3,0.6,0.6,0.6h0.1 c0.3,0,0.6-0.3,0.6-0.6v-5.5C32,30.4,31.7,30.1,31.4,30.1z" />
                                                                <path id="XMLID_35_" class="yellow" d="M19.6,18.3L19.6,18.3c0,0.4-0.3,0.6-0.6,0.6h-5.5c-0.3,0-0.6-0.3-0.6-0.6v-0.1 c0-0.3,0.3-0.6,0.6-0.6H19C19.3,17.8,19.6,18,19.6,18.3z" />
                                                                <path id="XMLID_33_" class="yellow" d="M43.1,18.3L43.1,18.3c0,0.4,0.3,0.6,0.6,0.6h5.5c0.3,0,0.6-0.3,0.6-0.6v-0.1 c0-0.3-0.3-0.6-0.6-0.6h-5.5C43.4,17.8,43.1,18,43.1,18.3z" />
                                                                <path id="XMLID_37_" class="yellow" d="M22.4,26L22.4,26c0.3,0.3,0.2,0.7,0,0.9l-4.2,3.6c-0.2,0.2-0.6,0.2-0.8-0.1l-0.1-0.1 c-0.2-0.2-0.2-0.6,0.1-0.8l4.2-3.6C21.9,25.8,22.2,25.8,22.4,26z" />
                                                                <path id="XMLID_36_" class="yellow" d="M40.3,10.7L40.3,10.7c0.3,0.3,0.6,0.3,0.8,0.1l4.2-3.6c0.2-0.2,0.3-0.6,0.1-0.8l-0.1-0.1 c-0.2-0.2-0.6-0.3-0.8-0.1l-4.2,3.6C40.1,10.1,40,10.5,40.3,10.7z" />
                                                                <path id="XMLID_39_" class="yellow" d="M22.4,10.8L22.4,10.8c0.3-0.3,0.2-0.7,0-0.9l-4.2-3.6c-0.2-0.2-0.6-0.2-0.8,0.1l-0.1,0.1 c-0.2,0.2-0.2,0.6,0.1,0.8l4.2,3.6C21.9,11,22.2,11,22.4,10.8z" />
                                                                <path id="XMLID_38_" class="yellow" d="M40.3,26.1L40.3,26.1c0.3-0.3,0.6-0.3,0.8-0.1l4.2,3.6c0.2,0.2,0.3,0.6,0.1,0.8l-0.1,0.1 c-0.2,0.2-0.6,0.3-0.8,0.1l-4.2-3.6C40.1,26.7,40,26.3,40.3,26.1z" />
                                                                <animate attributeType="CSS" attributeName="opacity" attributeType="XML" dur="0.3s" keyTimes="0;0.5;1" repeatCount="indefinite" values="1;0.6;1" calcMode="linear" />
                                                            </g>
                                                        </g>
                                                        <animateTransform attributeName="transform" attributeType="XML" dur="1s" keyTimes="0;1" repeatCount="indefinite" type="scale" values="1;1" calcMode="linear">
                                                        </animateTransform>
                                                    </g>
                                                    <g id="Gray_cloud_3">
                                                        <path id="XMLID_20_" class="gray" d="M55.7,25.1H34.4c-3.3,0-6-2.7-6-6v0c0-3.3,2.7-6,6-6h21.3c3.3,0,6,2.7,6,6v0 C61.7,22.4,59,25.1,55.7,25.1z" />
                                                        <circle id="XMLID_19_" class="gray" cx="46.7" cy="13.4" r="10.7" />
                                                        <animateTransform attributeName="transform" attributeType="XML" dur="2s" keyTimes="0;0.5;1" repeatCount="indefinite" type="translate" values="0;-3;0" calcMode="linear">
                                                        </animateTransform>
                                                    </g>
                                                    </g>
                                                </svg>
                                            </div>
                                            <span class="wsmall" style="color: white;margin-top:11px;font-size: 28px;"><?php echo $data->main->temp_max;
                                                                                                                        ?>&deg;<sup>c</sup></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <img src="img/logo3.png" height="62px" width="170px" class="small">

                        <div class="navbar-end">
                            <button id="theme-switcher">
                                <i>
                                    <svg class="icon sun" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12.998 22H10.998V19H12.998V22ZM18.362 19.778L16.241 17.657L17.655 16.243L19.777 18.365L18.364 19.778H18.362ZM5.63405 19.778L4.21905 18.364L6.33905 16.242L7.75405 17.656L5.63405 19.777V19.778ZM11.998 17.007C9.23302 17.0059 6.99231 14.7637 6.99305 11.9987C6.99378 9.23364 9.23568 6.99263 12.0007 6.993C14.7657 6.99337 17.007 9.23497 17.007 12C17.0043 14.7649 14.763 17.0053 11.998 17.007ZM11.998 8.993C10.3376 8.9941 8.99231 10.3409 8.99305 12.0013C8.99378 13.6618 10.3403 15.0074 12.0007 15.007C13.6612 15.0066 15.007 13.6605 15.007 12C15.0054 10.3392 13.6589 8.99355 11.998 8.993ZM21.998 13H18.998V11H21.998V13ZM4.99805 13H1.99805V11H4.99805V13ZM17.654 7.758L16.241 6.343L18.362 4.221L19.777 5.636L17.655 7.757L17.654 7.758ZM6.34105 7.758L4.22105 5.637L5.63605 4.223L7.75605 6.345L6.34205 7.757L6.34105 7.758ZM12.998 5H10.998V2H12.998V5Z" fill="currentColor"></path>
                                    </svg>
                                    <svg class="icon moon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M18.248 16.9972C18.1656 16.9991 18.0829 17 18 17C11.9249 17 7 12.0751 7 5.99999C7 5.91709 7.00092 5.8344 7.00275 5.75192C5.17211 7.21851 4 9.47339 4 12C4 16.4182 7.58172 20 12 20C14.5266 20 16.7814 18.8279 18.248 16.9972ZM19.4661 14.8812C18.989 14.9593 18.4992 15 18 15C13.0294 15 9 10.9706 9 5.99999C9 5.50074 9.04065 5.01099 9.11882 4.53386C9.25094 3.72745 9.49024 2.9571 9.82162 2.23792C8.96026 2.42928 8.14073 2.73173 7.37882 3.12946C4.18215 4.79821 2 8.14425 2 12C2 17.5228 6.47715 22 12 22C15.8557 22 19.2017 19.8178 20.8705 16.6212C21.2682 15.8593 21.5707 15.0397 21.762 14.1784C21.0429 14.5098 20.2725 14.7491 19.4661 14.8812Z" fill="currentColor"></path>
                                    </svg>
                                </i>
                            </button>
                            <a href="Action/logout.php" style="text-transform: uppercase"><img class="log" src="img\power-button-icon-8366.png" alt="" width="55px" height="auto"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--2 navbar for pushing 1 above after scrolling (Not Implemented yet.)-->
    </navbar><br><br><br><br><br>
    <center>
        <div class="header">
            <span style="float: left; margin-right:-70px; height:60px">
                <p class="p" id="display"></p>
            </span>
            <span class="head" id="head1">New Mimic (P & ID)</span>
            <span class="head" id="head2">Temperature Trends</span>
            <span class="head" id="head3">Reports</span>
            <span class="head" id="head4">Production Dashboard UHT3 Plant</span>
            <span class="head" id="head0">Production Efficiency</span>
            <span class="head5" id="head5">Total <span class="rectangle2" id="rowCount"></span>&#160;Alarms</span>
            <span class="head" id="head6">User Management</span>
            <span class="display" style="float: right;height:60px; margin-top:-40px">
                <p id="p" class="p"></p>
            </span>
        </div>
        <div class="container">
            <!-- Buttons -->
            <div class="tab" style="position:relative">
                <!-- cHECKING THE PERMISSION IN ARRY  -->
                <?php

                $numberToCheck = 1;
                if (in_array($numberToCheck, $userLevelArray)) {
                ?>

                    <!-- END -->

                    <button class="tablinks" id="Main1" onclick="openCity(event, 'Main'); head1()">New Mimic (P &
                        ID)</button>

                <?php
                }
                $numberToCheck = 2;
                if (in_array($numberToCheck, $userLevelArray)) {
                ?>
                    <button class="tablinks" id="Output1" onclick="openCity(event, 'Output'); ">Temperature
                        Trends</button>

                <?php
                }
                $numberToCheck = 3;
                if (in_array($numberToCheck, $userLevelArray)) {
                ?>
                    <button class="tablinks" id="Force1" onclick="openCity(event, 'Force'); head3()">Reports</button>
                <?php
                }
                $numberToCheck = 4;
                if (in_array($numberToCheck, $userLevelArray)) {
                ?>
                    <button class="tablinks" id="Weigher1" onclick="openCity(event, 'Weigher'); head4()">Production</button>
                    <button class="tablinks" id="Check1" onclick="openCity(event, 'Check'); head0()">Production
                        Efficiency</button>

                <?php
                }
                $numberToCheck = 5;
                // if (in_array($numberToCheck, $userLevelArray)) {
                // 
                ?>



                <?php
                // }
                // $numberToCheck = 6;
                if (in_array($numberToCheck, $userLevelArray)) {
                ?>

                    <div id="load2">
                        <button class="tablinks" id="Counter1" onclick="openCity(event, 'Counter'); head5()">Alarms</button>
                    </div>

                <?php
                }
                $numberToCheck = 7;
                if (in_array($numberToCheck, $userLevelArray)) {
                ?>

                    <button class="tablinks" id="Timer1" onclick="openCity(event, 'Timer'); head6()">User
                        Management</button>

                <?php
                }
                $numberToCheck = 8;
                if (in_array($numberToCheck, $userLevelArray)) {
                ?>
                    <button class="tablinks" id="Main1" onclick="openCity(event, 'Main'); head1()">New Mimic (P &
                        ID)</button>
                    <button class="tablinks" id="Weigher1" onclick="openCity(event, 'Weigher'); head4()">Production</button>
                    <button class="tablinks" id="Check1" onclick="openCity(event, 'Check'); head0()">Production
                        Efficiency</button>
                    <button class="tablinks" id="Output1" onclick="openCity(event, 'Output'); head2()">Temperature
                        Trends</button>
                    <button class="tablinks" id="Force1" onclick="openCity(event, 'Force'); head3()">Reports</button>


                    <span id="load2">
                        <?php
                        $sql1 = "SELECT * FROM blink";
                        $result1 = $con->query($sql1);
                        $row1 = $result1->fetch_assoc();
                        $alert = $row1['alert'];
                        // echo $newtime; 
                        if ($alert == 'on') { ?>
                            <button class="tablinks blink" id="Counter1" data-record-id="1" onclick="openCity(event, 'Counter'); head5(); updateValue(this)">Alarms</button>
                            <!-- <button class="tablinks blink" id="Counter1" onclick="openCity(event, 'Counter'); head5()">Alarms</button> -->
                        <?php  } elseif ($alert == 'off') { ?>
                            <button class="tablinks" id="Counter1" onclick="openCity(event, 'Counter'); head5()">Alarms</button>
                        <?php } ?>
                    </span>
                    <button class="tablinks" id="Timer1" onclick="openCity(event, 'Timer'); head6()">User
                        Management</button>
                <?php
                }
                ?>
                <img src="img/haleeb.gif" width="100%" style="position:absolute;bottom: 0;left:0;height:27%;border-radius:3px;" alt="">

            </div>

            <!-- Page 1 -->

            <div id="Main" class="tabcontent expandable-div" style="background-color: #5A5A5A;">

                <button id="expand-button" style="position: absolute; z-index:999;">Expand</button>
                <div style="position: relative; margin-left:4%">
                    <img src="img\Haleeb_Mimic.PNG" class="expandable-div" alt="" height="692px"><br><br>
                    <div id="load1">
                        <?php include('indication.php') ?>
                        <?php include('mimic_values.php') ?>
                    </div>
                </div>
            </div>
            <!-- Page 2 -->
            <div id="Output" class="tabcontent">
                <br>
                <div class="hero--row">
                    <div class="hero--wrapper">
                        <div id="hero--buttons">
                            <button id="finance-btn">Real Time Trend</button>
                            <button id="refer-btn">Historical Trend</button>
                        </div>
                        <div class="i">
                            <div id="gform_7">
                                <div class="card-header">Real Time Trend
                                    <div class="dropdown top">
                                        <select onchange="live_trend(this.options[this.selectedIndex].value);">
                                            <option value="">Select Options</option>
                                            <option value="T_1">TT1001</option>
                                            <option value="T_2">TT1002</option>
                                            <option value="T_3">TT1003</option>
                                            <option value="T_4">TT1004</option>
                                            <option value="T_5">TT1005</option>
                                            <option value="T_6">TT1006</option>
                                            <option value="T_7">TT1007</option>
                                            <option value="T_8">TT1008</option>
                                            <option value="T_9">TT0501</option>
                                            <option value="T_10">TT0701</option>
                                            <option value="T_11">TT1201</option>
                                            <option value="L_12">LT0101</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="charttemp"></div>
                                </div>
                            </div>
                            <div id="gform_63">
                                <div class="card-header">Historical Trend</div>
                                <div class="card-body">
                                    <div class="row row-cards">
                                        <div style="margin-top: -30px;">
                                            <div class="date2">
                                                <div class="checkbox-dropdown" id="checkbox-dropdown">
                                                    Select Options
                                                    <ul class="checkbox-dropdown-list" id="ec_location" style="height: 400px; overflow: auto;">
                                                        <li style="border-top: 1px solid silver;">
                                                            <label>
                                                                <input type="checkbox" value="TT1001_Scaled" name="Temperature_1" />TT1001</label>
                                                        </li>
                                                        <li>
                                                            <label>
                                                                <input type="checkbox" value="TT1002_Scaled" name="Temperature_2" />TT1002</label>
                                                        </li>
                                                        <li>
                                                            <label>
                                                                <input type="checkbox" value="TT1003_Scaled" name="Temperature_3" />TT1003</label>
                                                        </li>
                                                        <li>
                                                            <label>
                                                                <input type="checkbox" value="TT1004_Scaled" name="Temperature_4" />TT1004</label>
                                                        </li>
                                                        <li>
                                                            <label>
                                                                <input type="checkbox" value="TT1005_Scaled" name="Temperature_5" />TT1005</label>
                                                        </li>
                                                        <li>
                                                            <label>
                                                                <input type="checkbox" value="TT1006_Scaled" name="Temperature_6" />TT1006</label>
                                                        </li>
                                                        <li>
                                                            <label>
                                                                <input type="checkbox" value="TT1007_Scaled" name="Temperature_7" />TT1007</label>
                                                        </li>
                                                        <li>
                                                            <label>
                                                                <input type="checkbox" value="TT1008_Scaled" name="Temperature_7" />TT1008</label>
                                                        </li>
                                                        <li>
                                                            <label>
                                                                <input type="checkbox" value="TT0501_Scaled" name="Temperature_7" />TT0501</label>
                                                        </li>
                                                        <li>
                                                            <label>
                                                                <input type="checkbox" value="TT0701_Scaled" name="Temperature_7" />TT0701</label>
                                                        </li>
                                                        <li>
                                                            <label>
                                                                <input type="checkbox" value="TT1201_Scaled" name="Temperature_7" />TT1201</label>
                                                        </li>
                                                        <li>
                                                            <label>
                                                                <input type="checkbox" value="LT0101_Scaled" name="Level_7" />LT0101</label>
                                                        </li>
                                                        <li>
                                                            <label>
                                                                <input type="checkbox" value="PT1001_Scaled" name="Pressure_1" />PT1001</label>
                                                        </li>
                                                        <li>
                                                            <label>
                                                                <input type="checkbox" value="PT2001_Scaled" name="Pressure_2" />PT2001</label>
                                                        </li>

                                                        <button id="close-dropdown" onclick="drawChart()">OK</button>
                                                    </ul>
                                                </div>
                                                <!-- <div class="dropdown" style="margin-top: 30px;">
                                                    <select id="ec_location" onchange="drawChart()">
                                                        <option value="">Select Temperature</option>
                                                        <option value="U_25_ACTIVE_ENERGY_IMPORT_KWH">TT1001</option>
                                                        <option value="T_2">TT1002</option>
                                                        <option value="T_3">TT1003</option>
                                                        <option value="T_4">TT1004</option>
                                                        <option value="T_2">TT1005</option>
                                                        <option value="T_3">TT1006</option>
                                                        <option value="T_4">TT1007</option>
                                                        <option value="T_2">TT1008</option>
                                                    </select>
                                                </div> -->
                                            </div>
                                            <span class="mlauto">
                                                <div class="col-lg-2 date1">
                                                    <span>End Date:</span>
                                                    <input name="ec_end_date" value="<?php echo date("Y-m-d"); ?>" onchange="drawChart()" type="date" id="ec_end_date" required>
                                                </div>
                                                <div class="col-lg-2 date1">
                                                    <span>Start Date:</span>
                                                    <input name="ec_start_date" value="<?php echo date("Y-m-d"); ?>" onchange="drawChart()" type="date" id="ec_start_date" required>
                                                </div>

                                            </span>
                                        </div>

                                        <div class="pt-0 card-body" id="txt_hint2" style="margin-top:20px;">
                                            <div id="dashboard">
                                                <div id="chartdiv"></div>
                                                <div id="chartdata" style="display: none;"></div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Page 3 -->
            <div id="Force" class="tabcontent">

                <div>
                    <div id="reportForm">
                        <h2>Generate Report</h2>
                        <form method="POST" id="data-form" action="fetch_data.php">
                            <div class="form-group">
                                <label for="source">Select Source:</label>
                                <div class="rep">
                                    <select id="source" onchange="updateOptions()">
                                        <option value="">Select...</option>
                                        <option value="pressure">Pressure</option>
                                        <option value="temperature">Temperature</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="options">Select Options:</label>
                                <div class="rep" style="margin-top: 10px;">
                                    <div id="temperature-options" class="option-set">
                                        <div id="dynamicOptions">
                                            <input type="checkbox" value="TT1001_Scaled" id="TT1001_Scaled" name="selected_temperatures[]">
                                            <label for="TT1001_Scaled">TT1001</label>

                                            <input type="checkbox" value="TT1002_Scaled" id="TT1002_Scaled" name="selected_temperatures[]">
                                            <label for="TT1002_Scaled">TT1002</label>

                                            <input type="checkbox" value="TT1003_Scaled" id="TT1003_Scaled" name="selected_temperatures[]">
                                            <label for="TT1003_Scaled">TT1003</label>

                                            <input type="checkbox" value="TT1004_Scaled" id="TT1004_Scaled" name="selected_temperatures[]">
                                            <label for="TT1004_Scaled">TT1004</label>

                                            <input type="checkbox" value="TT1005_Scaled" id="TT1005_Scaled" name="selected_temperatures[]">
                                            <label for="TT1005_Scaled">TT1005</label>

                                            <input type="checkbox" value="TT1006_Scaled" id="TT1006_Scaled" name="selected_temperatures[]">
                                            <label for="TT1006_Scaled">TT1006</label>

                                            <input type="checkbox" value="TT1007_Scaled" id="TT1007_Scaled" name="selected_temperatures[]">
                                            <label for="TT1007_Scaled">TT1007</label>

                                            <input type="checkbox" value="TT1008_Scaled" id="TT1008_Scaled" name="selected_temperatures[]">
                                            <label for="TT1008_Scaled">TT1008</label>
                                            <!-- Add more temperature options here -->
                                            <input type="checkbox" value="TT0501_Scaled" id="TT0501_Scaled" name="selected_temperatures[]">
                                            <label for="TT0501_Scaled">TT0501</label>

                                            <input type="checkbox" value="TT0701_Scaled" id="TT0701_Scaled" name="selected_temperatures[]">
                                            <label for="TT0701_Scaled">TT0701</label>

                                            <input type="checkbox" value="TT1201_Scaled" id="TT1201_Scaled" name="selected_temperatures[]">
                                            <label for="TT1201_Scaled">TT1201</label>
                                        </div>
                                        <!-- Add more temperature options here -->
                                    </div>

                                    <div id="pressure-options" class="option-set">
                                        <!-- <div id="privileges"> -->
                                        <input type="checkbox" value="PT1001_Scaled" id="PT1001_Scaled" name="selected_pressure[]">
                                        <label for="PT1001_Scaled">PT-1001</label>

                                        <input type="checkbox" value="PS2001_Scaled" id="PS2001_Scaled" name="selected_pressure[]">
                                        <label for="PS2001_Scaled">PT-2001</label>

                                        <input type="checkbox" value="Steam_Value_PT1001_Scaled_for_Pressure_Percentage_control_valve" id="Steam_Value_PT1001_Scaled_for_Pressure_Percentage_control_valve" name="selected_pressure[]">
                                        <label for="Steam_Value_PT1001_Scaled_for_Pressure_Percentage_control_valve">PCV-1001</label>
                                        <!-- </div> -->
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="startDate">Start Date:</label>
                                <div class="rep">
                                    <input type="date" id="startDate" name="start_date" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="endDate">End Date:</label>
                                <div class="rep">
                                    <input type="date" id="endDate" name="end_date" required>
                                </div>
                            </div>

                            <div class="form-group" style="text-align: center;">
                                <!-- <button class="btn-generate" onclick="generateReport()">Generate Report</button> -->
                                <button type="submit" class="btn-generate">Generate Report</button>

                            </div>
                        </form>
                    </div>

                </div>
                <div id="data-table"></div>

                <!-- <br><br><br><br>
                <img src="img/home1.png" alt="" width="100px" height="auto"
                    style="margin-left:90%; padding-bottom:0%; cursor:pointer" onclick="openCity(event, 'Main')"> -->

            </div>
            <!-- Page 4 -->
            <?php include('./production_val.php') ?>
            <div id="Check" class="tabcontent" style="border: none;">
                <div style="height: 47%;box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px; margin:10px; border-radius: 10px;">

                    <div style="display: flex; height: 100%;">
                        <!-- chart -->
                        <div style="width: 78%; height: 100%;">
                            <div style="margin-top: 10px;">
                                <span style="margin-left: 20px;">Efficiency Comparision Chart</span>
                                <select id="periodSelect" onchange="updateChart(this.value)" style="float: right; margin: 10px; margin-top: -5px;">
                                    <option value="this-week-last-week">This Week vs Last Week</option>
                                    <option value="today-yesterday">Today vs Yesterday</option>
                                    <!-- <option value="this-month-last-month">This Month vs Last Month</option> -->
                                </select>
                            </div>
                            <div id="periodchartdiv" style="width: 100%; height: 90%;"></div>
                        </div>
                        <div style="width:20%; float:right">
                            <div class="card" style="width:100%; height:90px;">
                                <h3 style="display: flex; justify-content: space-between;">
                                    <div>Efficiency (%)</div>
                                    <div style="color:#C9C9C9;font-size: 0.9vw"><input type="date" id="eff_date">
                                    </div>
                                </h3>
                                <p id="efficiencyPercentage" style="font-size: 24px">%</p>
                            </div>
                            <div id="myDiv" class="myDivOpen" style=" border:1px solid black; border-radius: 5px; margin-top:10px">
                                <!-- Content of your div goes here -->
                            </div>
                        </div>
                    </div>
                </div>
                <div style="height: 47%;margin: 10px;box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px; border-radius: 10px;"><br>
                    <span style="margin-left: 20px;">Historical Efficiency</span>
                    <span style="float: right; margin-top: -10px; margin-right: 20px;">
                        <input name="eb_start_date" value="<?php echo date("Y-m-d", strtotime('-10 day')); ?>" type="date" id="eb_start_date" required>
                        <input name="eb_end_date" value="<?php echo date("Y-m-d", strtotime('-1 day')); ?>" type="date" id="eb_end_date" required>
                        <button onclick="efficienybar()">Generate</button>
                    </span>
                    <div id="efficiencychart" style="width: 100%; height: 90%;"></div>
                </div>
            </div>
            <!-- Page 5 -->

            <div id="Weigher" class="tabcontent">
                <div id="load6">
                    <div class="pcontainer wid" style="margin-top: 10px;">
                        <div class="card">
                            <h3 style="display: flex; justify-content: space-between;">
                                <div style="font-size: 0.98vw">Production Setup Time</div>
                                <div style="color:#C9C9C9;font-size: 0.9vw">Today</div>
                            </h3>
                            <p style="font-size: 1.25vw"><?php echo $Production_Setup_COUNTER; ?> Hrs</p>
                        </div>
                        <div class="card">
                            <h3 style="display: flex; justify-content: space-between;">
                                <div style="font-size: 0.98vw">Total Production Time</div>
                                <div style="color:#C9C9C9;font-size: 0.9vw">Today</div>
                            </h3>
                            <p style="font-size: 1.25vw"><?php echo $STEP10_COUNTER; ?> Hrs</p>
                        </div>
                        <div class="card">
                            <h3 style="display: flex; justify-content: space-between;">
                                <div style="font-size: 0.98vw">Plant Idle Time</div>
                                <div style="color:#C9C9C9;font-size: 0.9vw">Today</div>
                            </h3>
                            <p style="font-size: 1.25vw"><?php echo $STEP6_COUNTER ?> Hrs</p>
                        </div>
                        <div class="card">
                            <h3 style="display: flex; justify-content: space-between;">
                                <div style="font-size: 0.98vw">Plant Power OFF Time</div>
                                <div style="color:#C9C9C9;font-size: 0.9vw">Today</div>
                            </h3>
                            <p style="font-size: 1.25vw"><?php echo $MACHINE_OFF_COUNTER; ?> Hrs</p>
                        </div>
                        <div class="card">
                            <h3 style="margin-bottom:7px">Production Start Time: <br><span style="font-size: 15px ;font-family: 'digital-7', sans-serif; color: #4FFF00;"><?php echo $Start_production_time; ?></span>
                            </h3>
                            <h3 style="margin-bottom:7px">Duration: <span style="font-size: 15px ;font-family: 'digital-7', sans-serif; color: #4FFF00;"><?php echo $STEP10_Duration ?>
                                </span></h3>
                            <h3 style="margin-bottom:0px">Current Step: <span style="font-size: 15px ;font-family: 'digital-7', sans-serif; color: #4FFF00;"><?php echo $STEP_STATUS ?>
                                </span></h3>
                        </div>

                    </div>
                </div>
                <div style="display:flex">

                    <div id="sizedetail" class="sizedetail" style="width:280px;height: 560px; margin-top: 10px; border-radius: 10px;">
                        <button onclick="toggleDiv()" style=" margin-top: 10px;">Details</button>

                        <div id="production-summary" class="card1 hidden">
                            <h3 class="card-title" style="padding-left: 20px;">Production Summary</h3>
                            <div style="padding-right: 10px;">
                                <ul>
                                    <li><b>Production Setup Time</b> is defined on the bases of "Step Status" if the Step_Status is 0
                                        to 34 except 2, 6 and 10.</li><br>
                                    <li><b>Plant Power OFF Time</b> is defined on the bases of "Control Circuit Switch" if the Control Circuit Switch is OFF.
                                    </li><br>
                                    <li><b>Production Time</b> is defined on the bases of "Step Status" if the Step_Status is 10.</li><br>
                                    <li><b>Plant Idle Time</b> is defined on the bases of "Step Status" if the Step_Status is 2 or 6.</li>
                                </ul>
                            </div>
                            <h3 class="card-title" style="padding-left: 20px;">Note</h3>
                            <div style="padding-right: 10px;">
                                <ul>
                                    <li><b>Efficiency Formula:</b><br>(Prodction Time/24 Hours)×100</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div id="chartsize" class="card-body wid chartsize" style="height: 480px; width:80%">
                        <div class="d-flex">
                            <h3 class="card-title">Historical Production Details (hh:mm:ss) <span class="mlauto">
                                    <div class="col-lg-2 date1">
                                        <button onclick="chartpiediv()">Generate</button>
                                    </div>
                                    <div class="col-lg-2 date1">
                                        <span>End Date:</span>
                                        <input name="ec_end_date" value="<?php echo date("Y-m-d", strtotime('-1 day')); ?>" type="date" id="ec_end_date1" max="<?php echo date("Y-m-d", strtotime('-1 day')); ?>" required>
                                    </div>
                                    <div class="col-lg-2 date1">
                                        <span>Start Date:</span>
                                        <input name="ec_start_date" value="<?php echo date("Y-m-d", strtotime('-1 day')); ?>" type="date" id="ec_start_date1" max="<?php echo date("Y-m-d", strtotime('-1 day')); ?>" required>
                                    </div>

                                </span></h3>
                        </div>
                        <div style="display:flex; width: 100%; height: 100%;">
                            <div id="chartpiediv" style="width: 100%; height: 100%;"></div>
                            <button id="toggleButton1" class="btn btn-info" onclick="togglebtnlegend()" style="cursor: pointer;">›</button>
                            <div id="myDiv1" class="myDivOpen1" style="border:1px solid #C6CACE; border-radius: 5px;">
                            </div>
                        </div>
                    </div>
                    <!-- <img src="img/home1.png" alt="" width="100px" height="auto"
                        style="margin-left:90%; margin-top:232px; cursor:pointer" onclick="openCity(event, 'Main')"> -->
                </div>
            </div>
            <!-- Page 6 -->
            <div id="Counter" class="tabcontent">

                <!-- <button onclick="window.location.reload();" style="float: right; margin-top:-22px; position:absolute">Refresh</button> -->
                <div style="height: 68.2vh; margin-top:10px;">
                    <table class="styled-table" id="myTable">
                        <thead>
                            <tr>
                                <th style="background-color: #358EA0;">Trigger Time</th>
                                <th style="background-color: #358EA0;">Message</th>
                                <th style="background-color: #358EA0;">Priority Level</th>
                                <th style="background-color: #358EA0;">Occurrences</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Initially, the table is populated with PHP -->
                            <?php
                            //include('alarm.php'); // Replace with the actual path to your PHP script
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- <div class="pagination">
              </div> -->

                <!-- <img src="img/home1.png" alt="" width="100px" height="auto"
                style="margin-left:90%; margin-top:287px; cursor:pointer" onclick="openCity(event, 'Main')"> -->

            </div>
            <!-- Page 7 -->

            <div id="Timer" class="tabcontent">
                <br>
                <div>
                    <div class="hero--row">
                        <div class="hero--wrapper">
                            <div id="hero--buttons">
                                <button id="mngrol-btn">Roles</button>
                                <!-- <button id="mngpriv-btn">Privileges</button> -->
                                <button id="user-btn">Add Users</button>
                                <button id="view-user-btn">View Users</button>
                            </div>
                        </div>
                    </div>
                    <!-- Adding iv to showand add roles -->
                    <div class="i">
                        <div id="role-section" style="display: none;">
                            <div class="card-header">Add New Role
                            </div>
                            <div class="form-body" style="font-size: 18px;">
                                <form method="POST" action="Action/queries.php">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" style="padding-bottom:23px; line-height: 1rem"> Role
                                            Title:</label><br>
                                        <div class=" col-12">
                                            <input type="text" class="form-control" style="width:69%;  height: 1.5rem;  border-radius: 1px;" name="name" placeholder="Enter New Role" required>
                                        </div>
                                    </div>
                                    <div style="text-align:right; margin-top:-55px;   margin-bottom: 0px;">
                                        <button type="submit" role="button" class="button-7">Add
                                            Role</button>
                                    </div>
                                </form>
                            </div>


                            <div class="card-block table-border-style">
                                <div class="table-responsive" style="border-radius: 1rem;">
                                    <table class="table" width="100%" style="text-align:center;">
                                        <thead style="background-color:#398197 ; border-bottom: 3px solid #398197;">
                                            <tr align="center">
                                                <th scope="col" class="w1-" style="text-align: center;  font-size: 15px;  width: 19px;">
                                                    <i class="fa fa-hashtag" style="color: blue"></i> Sr No
                                                </th>
                                                <th scope="col" class="w1-" style="text-align: center;   font-size: 15px; width: 13rem;">
                                                    <i class="fa fa-user" style="color: red; width: 30px;"></i>
                                                    Role Title
                                                </th>
                                                <th scope="col" class="w1-" style="text-align: center;  font-size: 15px; width: 11rem;">
                                                    <i class="fa fa-bullseye" style="color: green; "></i>
                                                    Action
                                                </th>
                                            </tr>
                                            </tr>

                                        </thead>
                                        <tbody>
                                            <?php

                                            $con = mysqli_connect("127.0.0.1", "jahaann", "Jahaann#321", "haleeb");
                                            $query = mysqli_query($con, "select * from `roles`");
                                            $counter = 1;
                                            while ($row = mysqli_fetch_array($query)) {
                                            ?>
                                                <tr align="center">
                                                    <td scope="row" style="text-align: center;  border:1px solid #C4C8CA;">
                                                        <?php echo $counter; ?></td>
                                                    <td style=" border:1px solid #C4C8CA;">
                                                        <?php echo $row["role_name"]; ?></td>
                                                    <td style=" border:1px solid #C4C8CA;">
                                                        <!-- adding the new delete button -->
                                                        <button class="button-8">
                                                            <a style="text-decoration: none; color: white;" href="Action/delete_role.php?role_id=<?php echo $row['role_id']; ?>" onclick="return confirm('Are you sure you want to delete this role? ');">
                                                                Delete
                                                            </a></button>
                                                        <!-- <?php echo $row['role_id']; ?> -->

                                                        <!-- end -->

                                                    </td>
                                                </tr>
                                            <?php
                                                $counter++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- end -->

                    <!-- Adding div to showand Add privillages -->
                    <div class="i">
                        <div id="priv-section" style="display: none;">
                            <div class="card-header">Add New Privilege
                            </div>
                            <div class="form-body" style="font-size: 18px;">
                                <form method="POST" action="Action/add_priv.php">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" style="padding-bottom:23px; line-height: 1 rem"> Privilege
                                            Title</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" style="width:69%;  height: 1.5rem;  border-radius: 1px;" name="name" placeholder="Enter New Privilege" required>
                                        </div>
                                    </div><br>
                                    <div style=" text-align:right; margin-top:-77px;   margin-bottom: 0px;">
                                        <button type="submit" role="button" class="button-7">Add
                                            Privilege </button>
                                    </div>
                                </form>
                            </div>


                            <div class="card-block table-border-style">
                                <div class="table-responsive" style="border-radius: 1rem;">
                                    <table class="table" width="100%" style="text-align:center;">
                                        <thead style="background-color:#398197 ; border-bottom: 3px solid #398197;">
                                            <tr align="center">
                                                <th scope="col" class="w1-" style="text-align: center;  font-size: 15px;  width: 19px;">
                                                    <i class="fa fa-hashtag" style="color: blue"></i> Sr No
                                                </th>
                                                <th scope="col" class="w1-" style="text-align: center;   font-size: 15px; width: 13rem;">
                                                    <i class="fa fa-user" style="color: red; width: 30px;"></i>
                                                    Privillege Title
                                                </th>
                                                <th scope="col" class="w1-" style="text-align: center;  font-size: 15px; width: 11rem;">
                                                    <i class="fa fa-bullseye" style="color: green; "></i>
                                                    Action
                                                </th>
                                            </tr>
                                            </tr>

                                        </thead>
                                        <tbody>
                                            <?php

                                            $con = mysqli_connect("127.0.0.1", "jahaann", "Jahaann#321", "haleeb");
                                            $query = mysqli_query($con, "select * from `permissions`");
                                            $counter = 1;
                                            while ($row = mysqli_fetch_array($query)) {
                                            ?>
                                                <tr align="center">
                                                    <td scope="row" style="text-align: center;  border:1px solid #C4C8CA;">
                                                        <?php echo $counter; ?></td>
                                                    <td style=" border:1px solid #C4C8CA;">
                                                        <?php echo $row["perm_desc"]; ?></td>
                                                    <td style=" border:1px solid #C4C8CA;">
                                                        <!-- adding the new delete button -->
                                                        <button class="button-8">
                                                            <a style="text-decoration: none; color: white;" href="Action/delete_prev.php?perm_id=<?php echo $row['perm_id']; ?>" onclick="return confirm('Are you sure you want to delete this Privillege? ');">
                                                                Delete
                                                            </a></button>


                                                        <!-- end -->

                                                    </td>
                                                </tr>
                                            <?php
                                                $counter++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- end -->

                    <!-- Adding div to showand add new user -->
                    <div class="i">
                        <div id="use-section" style="display: none;">
                            <div class="card-header">Add New User
                            </div>
                            <div style="padding-left: 2rem;padding-right: 2rem">
                                <center>
                                    <div id="hidediv">
                                        <h4 style="color: #4ECDC4;">
                                            <?php
                                            if (isset($_SESSION['registered'])) {
                                            ?>
                                                <div id="alert">
                                                    <strong><?php echo $_SESSION['registered']; ?></strong>
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            <?php
                                                unset($_SESSION['registered']);
                                            }
                                            ?>
                                        </h4>
                                    </div>
                                </center>
                                <!-- <div style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px; width: 78%;"> -->
                                <div style="background-color:#0c3d75; height: 30px; text-align: center; border-radius:10px">
                                    <h4 style="color: white; font-size: 18px;padding-top:3px">Basic Inputs</h4>
                                </div>

                                <div style="padding: 1rem;">
                                    <form method="POST" action="Action/insert.php" onsubmit="return myfunction()">
                                        <div>
                                            <label>User Name</label><br>
                                            <input class="input" type="text" name="name" placeholder="Enter User Name" required>
                                        </div><br>
                                        <div>
                                            <label>Email</label><br>
                                            <input type="email" class="input" name="email" placeholder="Enter Email Address" title="Invalid email address" required>
                                        </div><br>
                                        <div>
                                            <label>Password</label><br>
                                            <input class="input" type="password" name="password" id="id_password" placeholder="Enter Password" required>
                                            <span><i class="far fa-eye" id="togglePassword" style="margin-left: -30px; cursor: pointer; color:  #96c8c3;  float: right; top: -25px; right: 10px; position: relative; cursor: pointer;"></i></span>
                                        </div><br>
                                        <!-- <div>
                                            <label>Confirm Password</label><br>
                                            <input class="input" class="input" type="password" name="password"
                                                placeholder="Enter Password" required id="con_password">
                                            <span><i class="far fa-eye" id="toggleconPassword"
                                                    style="margin-left: -30px; cursor: pointer; color:  #96c8c3;  float: right; top: -25px; right: 10px; position: relative; cursor: pointer;"></i></span>
                                        </div><br> -->
                                        <div>
                                            <label>Privileges</label><br>
                                            <div style="padding-left: 63px;" id="privileges">
                                                <?php
                                                // Connect to the database (assuming you already have the database connection)

                                                // Fetch the privileges from the permissions table
                                                $con = mysqli_connect("127.0.0.1", "jahaann", "Jahaann#321", "haleeb");
                                                $query = "SELECT * FROM permissions";
                                                $result = mysqli_query($con, $query);

                                                if (mysqli_num_rows($result) > 0) {
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $privilegeId = $row['perm_id'];
                                                        $privilegeName = $row['perm_desc'];
                                                        echo "<div>
                                                                    <input type='checkbox' name='type[]' value='$privilegeId'>
                                                                    <label>$privilegeName</label>
                                                                </div>";
                                                    }
                                                } else {
                                                    echo "No privileges found";
                                                }

                                                // Close the database connection
                                                // mysqli_close($con);
                                                ?>
                                            </div>
                                        </div><br>
                                        <div>
                                            <label>User Role</label><br>
                                            <select class="input" name="level">
                                                <option value="">Select User Role</option>
                                                <?php
                                                // Assuming you have already established a database connection
                                                // Retrieve the roles from the database
                                                $con = mysqli_connect("127.0.0.1", "jahaann", "Jahaann#321", "haleeb");
                                                $sql = "SELECT * FROM roles";
                                                $result = mysqli_query($con, $sql);

                                                // Check if any roles were returned
                                                if (mysqli_num_rows($result) > 0) {
                                                    // Loop through each role and create an option element
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $role_id = $row['role_id'];
                                                        $role_name = $row['role_name'];
                                                        echo "<option value='$role_id'>$role_name</option>";
                                                    }
                                                } else {
                                                    // If no roles were found in the database
                                                    echo "<option value=''>No roles found</option>";
                                                }
                                                ?>
                                            </select>
                                        </div><br><br>
                                        <div style="text-align: center; padding-right: 33px;">
                                            <button type="submit" role="button" class="button-7" style="color: white; background-color:#0c3d75;">Add
                                                User</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- </div> -->
                    <!-- end -->

                    <!-- View all users -->
                    <div class="i">
                        <div id="view-section" style="display: none;">
                            <div class="card-header">View Users
                            </div>
                            <div class="card-block table-border-style">
                                <div class="table-responsive" style="border-radius: 1rem;">
                                    <table class="table" width="100%" style="text-align:center;">
                                        <thead style="background-color:#398197 ; border-bottom: 3px solid #398197;">
                                            <tr align="center" class="th">
                                                <th scope="col" class="w1-" style="text-align: center;   font-size: 15px;  width: 40px;">
                                                    <i class="fa fa-hashtag" style="color: blue; "></i> Sr No
                                                </th>
                                                <th scope="col" class="w1-" style="text-align: center;"><i class="fa fa-user" style="color: red"></i>
                                                    Name</th>
                                                <th scope="col" class="w1-" style="text-align: center;"><i class="fa fa-envelope" style="color: blue"></i> Email
                                                </th>
                                                <th scope="col" class="w1-" style="text-align: center;"><i class="fa fa-lock" style="color: red"></i>
                                                    Password</th>
                                                <th scope="col" class="w1-" style="text-align: center;"> <i class="icon-copy dw dw-edit"></i> Actions
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            include('Action/db_connection.php');
                                            $query = mysqli_query($con, "select * from `accounts`");
                                            $counter = 1;
                                            while ($row = mysqli_fetch_array($query)) {
                                            ?>
                                                <tr align="center">
                                                    <td scope="row" style="text-align: center;  border:1px solid #C4C8CA;">
                                                        <?php echo $counter; ?></td>
                                                    <td style=" border:1px solid #C4C8CA;">
                                                        <?php echo $row["name"]; ?>
                                                    </td>
                                                    <td style=" border:1px solid #C4C8CA;">
                                                        <?php echo $row["email"]; ?>
                                                    </td>
                                                    <td style=" border:1px solid #C4C8CA;">
                                                        <?php echo $row["pass"]; ?>
                                                    </td>
                                                    <td style=" border:1px solid #C4C8CA;">
                                                        <!-- adding the new delete button -->
                                                        <button class="button-8">
                                                            <a style="text-decoration: none; color: white;" href="Action/delete_user.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this User? ');">
                                                                Delete
                                                            </a></button>
                                                        <!-- end -->
                                                    </td>
                                                </tr>
                                            <?php
                                                $counter++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </center>
    <!-- <br> -->
    <!-- footer -->
    <footer style="width: 99%; margin-left:0.5%; position:relative; margin-top: 10px;">
        <span style="float: left; margin-left:20px; margin-top:-10px"><img src="img/Jahaann_01-01.png" alt="" width="113px"></span>
        <span style="float: right;margin-right:20px"><img src="img/sahamid-logo-up.png" alt="" width="243px"></span>
        <p>Copyright &copy; All rights reserved
            <br>Designed by Jahaann, 2025
        </p>

    </footer>

    <script src="js\date&time.js"></script>
    <script src="https://www.amcharts.com/lib/4/core.js"></script>
    <script src="https://www.amcharts.com/lib/4/charts.js"></script>
    <script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>
    <script src="https://www.amcharts.com/lib/4/themes/dataviz.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/dark.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"> -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script>
        function togglebtnlegend() {
            var div = document.getElementById("myDiv1");
            var button = document.getElementById("toggleButton1");

            if (div.classList.contains("myDivClosed")) {
                div.classList.remove("myDivClosed");
                div.classList.add("myDivOpen1");
                button.innerHTML = "›";
            } else {
                div.classList.remove("myDivOpen1");
                div.classList.add("myDivClosed");
                button.innerHTML = "›";
            }
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const dateInput = document.getElementById("eff_date");
            const efficiencyPercentage = document.getElementById("efficiencyPercentage");
            const todayEfficiency = <?php echo round(($STEP10_COUNTER1 / '86400') * 100, 2); ?> + ' %';

            // Function to fetch and update the percentage
            function fetchAndUpdatePercentage(sdate) {
                fetch('./calculation/today_efficiency.php?start_date=' + sdate + '&end_date=' + sdate)
                    .then(response => response.json())
                    .then(data => {
                        const percentageData = data.find(item => item.steps === "Production Percentage");
                        if (percentageData) {
                            efficiencyPercentage.textContent = percentageData.percentage;
                        }
                    })
                    .catch(error => console.error('Error fetching data:', error));
            }

            // Function to update the efficiency percentage based on the selected date
            setInterval(function updateEfficiency() {
                const selectedDate = dateInput.value;
                const today = new Date().toISOString().split('T')[0];
                if (selectedDate) {
                    if (selectedDate === today) {
                        efficiencyPercentage.textContent = todayEfficiency;
                    } else {
                        fetchAndUpdatePercentage(selectedDate);
                    }
                }
            }, 5000);

            // Attach the onchange event to the date input
            dateInput.addEventListener("change", function() {
                updateEfficiency();
            });

            // Set today's date and efficiency on page load
            const today = new Date().toISOString().split('T')[0];
            dateInput.value = today; // Set the input value to today's date
            efficiencyPercentage.textContent = todayEfficiency; // Display today's efficiency

            // Set an interval to refresh the efficiency percentage every 5 seconds

        });
    </script>

    <script>
        function toggleDiv() {
            var div = document.getElementById("production-summary");
            if (div.classList.contains("hidden")) {
                div.classList.remove("hidden");
            } else {
                div.classList.add("hidden");
            }
            var div = document.getElementById("sizedetail");
            if (div.classList.contains("sizedetail")) {
                div.classList.remove("sizedetail");
            } else {
                div.classList.add("sizedetail");
            }
            var div = document.getElementById("chartsize");
            if (div.classList.contains("chartsize")) {
                div.classList.remove("chartsize");
            } else {
                div.classList.add("chartsize");
            }
        }
    </script>
    <script>
        function updateValue(button) {
            // Get the record ID from the data attribute.
            var recordId = button.getAttribute("data-record-id");

            // Send an AJAX request to the server to update the value in the database.
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "Action/update.php", true); // Specify the server-side script (e.g., update.php).
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Handle the response from the server if needed.
                    var response = xhr.responseText;
                    // You can perform further actions based on the response here.
                }
            };

            // Send the record ID as a parameter to the server.
            var data = "recordId=" + encodeURIComponent(recordId);
            xhr.send(data);
        }
    </script>
    <script>
        const expandButton = document.getElementById('expand-button');
        const expandableDiv = document.querySelector('.expandable-div');

        expandButton.addEventListener('click', () => {
            expandableDiv.classList.toggle('expanded');
        });
        // table rows count
        function updateRowCount() {
            // Get the table element
            var table = document.getElementById('myTable');

            // Get the row count
            var rowCount = table.rows.length - 1; // Subtract 1 to exclude the header row

            // Update the row count on the page
            var rowCountElement = document.getElementById('rowCount');
            rowCountElement.textContent = rowCount;
        }

        // Initial update
        updateRowCount();

        // Set an interval to update the row count every 1 second
        setInterval(updateRowCount, 100000);
        // Propagation
        $(".checkbox-dropdown").click(function() {
            $(this).toggleClass("is-active");
        });

        $(".checkbox-dropdown ul").click(function(e) {
            e.stopPropagation();
        });
        document.getElementById('close-dropdown').addEventListener('click', function() {
            document.getElementById('checkbox-dropdown').classList.remove("is-active");
        });
        // Real Time chart
        function live_trend(str_live) {
            am4core.unuseTheme(am4themes_animated);
            // Create chart instance
            var chart = am4core.create("charttemp", am4charts.XYChart);
            if (chart.logo) {
                chart.logo.disabled = true;
            }
            chart.paddingRight = 20;

            // Create axes
            var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
            dateAxis.renderer.minGridDistance = 100;

            var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
            valueAxis.min = -10; // Set minimum value to 5°C
            valueAxis.max = 200;


            // Create series
            var series = chart.series.push(new am4charts.LineSeries());
            series.dataFields.valueY = "value";
            series.dataFields.dateX = "time";
            series.tooltipText = "{value}°C";
            series.strokeWidth = 2;
            series.propertyFields.stroke = "lineColor"; // Use lineColor property for dynamic stroke color

            // Add bullets
            var bullet = series.bullets.push(new am4charts.CircleBullet());
            bullet.circle.radius = 4;
            bullet.circle.strokeWidth = 2;
            bullet.circle.fill = am4core.color("#ffffff");
            bullet.propertyFields.stroke = "bulletColor";
            // Add tooltip to bullets
            bullet.tooltipText = "{valueY}°C\n[bold]{dateX}[/]";
            // Add scrollbar
            chart.scrollbarX = new am4charts.XYChartScrollbar();
            chart.scrollbarX.series.push(series);

            // Set up data
            var data = [];
            var tag = str_live;
            var time = new Date();

            // Generate initial data point
            generateData();

            // Generate data and update chart
            setInterval(function() {
                generateData();
                updateChart();
            }, 1000);

            function generateData() {
                time = new Date(time.getTime() + 1000); // Update data every 5 seconds
                $.getJSON("getdataapi.php", function(OBJ) {
                    var visits;
                    if (tag === 'T_1') {
                        visits = OBJ.TT1001_Scaled;
                        series.name = 'TT1001';
                    } else if (tag === 'T_2') {
                        visits = OBJ.TT1002_Scaled;
                        series.name = 'TT1002';
                    } else if (tag === 'T_3') {
                        visits = OBJ.TT1003_Scaled;
                        series.name = 'TT1003';
                    } else if (tag === 'T_4') {
                        visits = OBJ.TT1004_Scaled;
                        series.name = 'TT1004';
                    } else if (tag === 'T_5') {
                        visits = OBJ.TT1005_Scaled;
                        series.name = 'TT1005';
                    } else if (tag === 'T_6') {
                        visits = OBJ.TT1006_Scaled;
                        series.name = 'TT1006';
                    } else if (tag === 'T_7') {
                        visits = OBJ.TT1007_Scaled;
                        series.name = 'TT1007';
                    } else if (tag === 'T_8') {
                        visits = OBJ.TT1008_Scaled;
                        series.name = 'TT1008';
                    } else if (tag === 'T_9') {
                        visits = OBJ.TT0501_Scaled;
                        series.name = 'TT0501';
                    } else if (tag === 'T_10') {
                        visits = OBJ.TT0701_Scaled;
                        series.name = 'TT0701';
                    } else if (tag === 'T_11') {
                        visits = OBJ.TT1201_Scaled;
                        series.name = 'TT1201';
                    } else if (tag === 'L_12') {
                        visits = OBJ.LT0101_Scaled;
                        series.name = 'LT0101';
                    }
                    // visits += Math.round((Math.random() < 0.5 ? 1 : -1) * Math.random() * 5);
                    data.push({
                        time: time,
                        value: visits.toFixed(2)
                    });

                    // Remove old data if time exceeds 20 minutes (1200000 milliseconds)
                    if (time - data[0].time > 60000) {
                        data.shift(); // Remove the first data item
                    }
                });
            }

            // Add horizontal line representing the upper range
            var upperRange = valueAxis.axisRanges.create();
            // upperRange.value = 160; // Upper range value
            upperRange.grid.stroke = am4core.color("#ff0000"); // Red color for the upper range
            upperRange.label.text = "Max Range"
            upperRange.label.inside = true;
            upperRange.label.verticalCenter = "bottom";
            upperRange.label.fill = am4core.color("#ff0000");
            upperRange.grid.strokeOpacity = 1;
            upperRange.grid.strokeWidth = 1.5;
            // Add horizontal line representing the lower range
            var lowerRange = valueAxis.axisRanges.create();
            // lowerRange.value = 90;
            lowerRange.grid.stroke = am4core.color("#67B7DC"); // Blue color for the lower range
            lowerRange.label.text = "Min Range"
            lowerRange.label.inside = true;
            lowerRange.label.verticalCenter = "top";
            lowerRange.label.fill = am4core.color("#67B7DC");
            lowerRange.grid.strokeOpacity = 1;
            lowerRange.grid.strokeWidth = 1.5;
            if (tag === 'L_12') {
                valueAxis.title.text = "Level (%)";
            } else {
                valueAxis.title.text = "Temperature (°C)";
            }


            if (tag === 'T_9' || tag === 'T_10' || tag === 'T_11') {
                function updateChart() {
                    chart.data = data;

                    // Set line color based on value exceeding the range
                    data.forEach(function(item) {
                        if (item.value > 130) {
                            item.lineColor = am4core.color("#ff0000");
                            item.bulletColor = am4core.color("#ff0000"); // Red color for values outside the range
                        } else if (item.value < 25) {
                            item.lineColor = am4core.color("#67B7DC");
                            item.bulletColor = am4core.color("#67B7DC"); // Blue color for values within the range
                        } else {
                            item.lineColor = am4core.color("#72B41A");
                            item.bulletColor = am4core.color("#72B41A");
                        }
                    });
                }
                lowerRange.value = 25;
                upperRange.value = 130; // Upper range value
            } else if (tag === 'L_12') {
                function updateChart() {
                    chart.data = data;

                    // Set line color based on value exceeding the range
                    data.forEach(function(item) {

                        item.lineColor = am4core.color("#72B41A");
                        item.bulletColor = am4core.color("#72B41A");

                    });
                }
                lowerRange.value = 0;
                upperRange.value = 100; // Upper range value
            } else {
                function updateChart() {
                    chart.data = data;

                    // Set line color based on value exceeding the range
                    data.forEach(function(item) {
                        if (item.value > 160) {
                            item.lineColor = am4core.color("#ff0000");
                            item.bulletColor = am4core.color("#ff0000"); // Red color for values outside the range
                        } else if (item.value < 90) {
                            item.lineColor = am4core.color("#67B7DC");
                            item.bulletColor = am4core.color("#67B7DC"); // Blue color for values within the range
                        } else {
                            item.lineColor = am4core.color("#72B41A");
                            item.bulletColor = am4core.color("#72B41A");
                        }
                    });
                }
                lowerRange.value = 90;
                upperRange.value = 160; // Upper range value
            }
            chart.legend = new am4charts.Legend();
            chart.legend.labels.template.text = "[font-size: 12px]{name}[/]";
            chart.legend.markers.template.width = 15;
            chart.legend.markers.template.height = 15;
            // Listen for the "themeChanged" event
            document.body.addEventListener("themeChanged", function(event) {
                var isDarkTheme = event.detail.isDarkTheme;
                // Call the function to update chart colors based on the theme
                updateChartColors(isDarkTheme);
            });

            // Function to update chart colors based on the theme
            function updateChartColors(isDarkTheme) {
                if (isDarkTheme) {
                    // Set dark theme colors
                    chart.colors.list = [
                        am4core.color("#ffffff"), // White
                        am4core.color("#ff0000"), // Red
                        am4core.color("#00ff00") // Green
                        // Add more colors as needed
                    ];
                    valueAxis.title.fill = am4core.color("#ffffff");
                    // Set dark theme grid and label colors
                    dateAxis.renderer.grid.template.stroke = am4core.color("#ffffff");
                    dateAxis.renderer.labels.template.fill = am4core.color("#ffffff");
                    // valueAxis.renderer.grid.template.stroke = am4core.color("#ffffff");
                    valueAxis.renderer.labels.template.fill = am4core.color("#ffffff");
                    chart.legend.labels.template.fill = am4core.color("#ffffff");


                } else {
                    // Set light theme colors
                    chart.colors.list = [
                        am4core.color("#000000"), // Black
                        am4core.color("#ff0000"), // Red
                        am4core.color("#00ff00") // Green
                        // Add more colors as needed
                    ];
                    valueAxis.title.fill = am4core.color("#000000");
                    // Set light theme grid and label colors
                    dateAxis.renderer.grid.template.stroke = am4core.color("#000000");
                    dateAxis.renderer.labels.template.fill = am4core.color("#000000");
                    // valueAxis.renderer.grid.template.stroke = am4core.color("#000000");
                    valueAxis.renderer.labels.template.fill = am4core.color("#000000");
                    chart.legend.labels.template.fill = am4core.color("#000000");

                }
            }

            // Call the function initially to set chart colors based on the current theme
            var isDarkTheme = document.documentElement.getAttribute("data-theme") === "dark";
            updateChartColors(isDarkTheme);
            var isDarkTheme = document.documentElement.getAttribute("data-theme") === "dark";
            document.body.dispatchEvent(new CustomEvent("themeChanged", {
                detail: {
                    isDarkTheme: isDarkTheme
                }
            }));
        }
    </script>
    <script>
        function updateOptions() {
            var source = document.getElementById("source").value;
            var temperatureOptions = document.getElementById("temperature-options");
            var pressureOptions = document.getElementById("pressure-options");

            temperatureOptions.style.display = "none";
            pressureOptions.style.display = "none";

            if (source === "temperature") {
                temperatureOptions.style.display = "block";
            } else if (source === "pressure") {
                pressureOptions.style.display = "block";
            }
        }

        //
        function openCity(evt, cityName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].classList.remove("active");
            }

            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.classList.add("active");
            document.cookie = "cityName=" + cityName + "1; expires=Thu, 18 Dec 2090 12:00:00 UTC; path=/";
        }

        document.addEventListener("DOMContentLoaded", function() {
            // Handler when the DOM is fully loaded
            var selectedCity = getCookie("cityName");
            var defaultTab = document.getElementById("Main1");
            <?php
            $numberToCheck = 1;
            if (in_array($numberToCheck, $userLevelArray)) {
            ?>
                var defaultTab = document.getElementById("Main1"); // Specify the ID of the default tab

            <?php
            }
            $numberToCheck = 2;
            if (in_array($numberToCheck, $userLevelArray)) {
            ?>

                var defaultTab = document.getElementById("Output1"); // Specify the ID of the default tab
            <?php
            }
            $numberToCheck = 3;
            if (in_array($numberToCheck, $userLevelArray)) {
            ?>

                var defaultTab = document.getElementById("Force1"); // Specify the ID of the default tab
            <?php
            }
            $numberToCheck = 4;
            if (in_array($numberToCheck, $userLevelArray)) {
            ?>

                var defaultTab = document.getElementById("Check1"); // Specify the ID of the default tab
            <?php
            }
            $numberToCheck = 5;
            if (in_array($numberToCheck, $userLevelArray)) {
            ?>

                var defaultTab = document.getElementById("Weigher1"); // Specify the ID of the default tab
            <?php
            }
            $numberToCheck = 6;
            if (in_array($numberToCheck, $userLevelArray)) {
            ?>

                var defaultTab = document.getElementById("Counter1"); // Specify the ID of the default tab
            <?php
            }
            $numberToCheck = 7;
            if (in_array($numberToCheck, $userLevelArray)) {
            ?>

                var defaultTab = document.getElementById("Timer1"); // Specify the ID of the default tab
            <?php
            }
            ?>

            if (selectedCity != "" && document.getElementById(selectedCity)) {
                document.getElementById(selectedCity).click();
            } else {
                defaultTab.click();
                document.cookie = "cityName=" + defaultTab.id +
                    "; expires=Thu, 18 Dec 2090 12:00:00 UTC; path=/";
            }
        });

        function getCookie(cname) {
            var name = cname + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var ca = decodedCookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }
    </script>
    <script>
        // // Number of rows per page
        // var rowsPerPage = 15;

        // // Get the table body and rows
        // var tableBody = document.querySelector(".styled-table tbody");
        // var tableRows = tableBody.getElementsByTagName("tr");

        // // Calculate the number of pages
        // var numPages = Math.ceil(tableRows.length / rowsPerPage);

        // // Generate pagination links
        // var paginationDiv = document.querySelector(".pagination");
        // for (var i = 1; i <= numPages; i++) {
        //     var pageLink = document.createElement("a");
        //     pageLink.href = "#";
        //     pageLink.innerHTML = i;

        //     // Add an event listener to handle page link click
        //     pageLink.addEventListener("click", function(event) {
        //         var pageNum = parseInt(event.target.innerHTML);
        //         showPage(pageNum);

        //         // Remove the 'active' class from all pagination links
        //         var links = document.querySelectorAll(".pagination a");
        //         links.forEach(function(link) {
        //             link.classList.remove("active");
        //         });

        //         // Add the 'active' class to the clicked link
        //         event.target.classList.add("active");
        //     });

        //     // Append the page link to the pagination div
        //     paginationDiv.appendChild(pageLink);
        // }

        // // Function to show the specified page
        // function showPage(pageNum) {
        //     // Calculate the starting and ending indices of the rows to display
        //     var startIndex = (pageNum - 1) * rowsPerPage;
        //     var endIndex = startIndex + rowsPerPage;

        //     // Hide all rows
        //     for (var i = 0; i < tableRows.length; i++) {
        //         tableRows[i].style.display = "none";
        //     }

        //     // Show the rows for the current page
        //     for (var j = startIndex; j < endIndex && j < tableRows.length; j++) {
        //         tableRows[j].style.display = "table-row";
        //     }
        // }

        // // Show the first page initially
        // showPage(1);
        // var firstPageLink = document.querySelector(".pagination a");
        // firstPageLink.classList.add("active");
        document.addEventListener("DOMContentLoaded", function() {
            // Handler when the DOM is fully loaded
            var themeSwitcher = document.getElementById("theme-switcher");

            themeSwitcher.addEventListener("click", function() {

                var currentTheme = document.documentElement.getAttribute("data-theme");
                var newTheme = currentTheme === "light" ? "dark" : "light";

                // Dispatch the themeChanged event
                var isDarkTheme = document.documentElement.getAttribute("data-theme") == "light";
                document.body.dispatchEvent(new CustomEvent("themeChanged", {
                    detail: {
                        isDarkTheme: isDarkTheme
                    }
                }));

                document.documentElement.setAttribute("data-theme", newTheme);
                setCookie("theme", newTheme, 365);
            });

            var savedTheme = getCookie("theme");
            if (savedTheme) {
                document.documentElement.setAttribute("data-theme", savedTheme);
            }
        });

        function setCookie(name, value, days) {
            var expires = "";
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + (value || "") + expires + "; path=/";
        }

        function getCookie(name) {
            var nameEQ = name + "=";
            var ca = document.cookie.split(";");
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == " ") {
                    c = c.substring(1, c.length);
                }
                if (c.indexOf(nameEQ) == 0) {
                    return c.substring(nameEQ.length, c.length);
                }
            }
            return null;
        }
    </script>
    <script>
        $(document).ready(function() {
            setInterval(function() {
                $("#load2").load(window.location.href + " #load2");
            }, 1000);
        });
    </script>
    <script>
        $(document).ready(function() {
            setInterval(function() {
                $("#load1").load(window.location.href + " #load1");
            }, 1000);
        });
    </script>

    <script>
        $(document).ready(function() {
            setInterval(function() {
                $("#load4").load(window.location.href + " #load4");
            }, 1000);
        });
    </script>
    <script>
        $(document).ready(function() {
            setInterval(function() {
                $("#load5").load(window.location.href + " #load5");
            }, 5000);
        });
    </script>
    <script>
        $(document).ready(function() {
            setInterval(function() {
                $("#load6").load(window.location.href + " #load6");
            }, 1000);
        });
    </script>
    <script>
        $(document).ready(function() {
            setInterval(function() {
                $("#load7").load(window.location.href + " #load7");
            }, 1000);
        });
    </script>
    <script>
        $(document).ready(function() {
            setInterval(function() {
                $("#load8").load(window.location.href + " #load8");
            }, 5000);
        });
    </script>
    <script>
        $(document).ready(function() {
            setInterval(function() {
                $("#load9").load(window.location.href + " #load9");
            }, 5000);
        });
    </script>
    <!-- trend page control script -->
    <script>
        let broker = document.getElementById('refer-btn');
        let brokerShow = document.getElementById('gform_63');
        let borrower = document.getElementById('finance-btn');
        let borrowerShow = document.getElementById('gform_7');

        borrower.addEventListener('click', function() {
            if (borrowerShow.style.display == 'block') {
                borrowerShow.style.display = 'none';

            } else {
                borrowerShow.style.display = 'block';
                brokerShow.style.display = 'none';
            }
        }, false);


        broker.addEventListener('click', function() {
            if (brokerShow.style.display == 'block') {
                brokerShow.style.display = 'none';

            } else {
                brokerShow.style.display = 'block';
                borrowerShow.style.display = 'none';
            }
        }, false);

        //chart script
        // chart script
        function drawChart() {
            var str = document.getElementById("ec_start_date").value;
            var str2 = document.getElementById("ec_end_date").value;
            var checkboxes = document.querySelectorAll("#ec_location input[type=checkbox]:checked");
            var str5 = [];
            for (var i = 0; i < checkboxes.length; i++) {
                str5.push(checkboxes[i].value);
            }

            // var units = "°C";


            // Check if the tag is 'LT0101_Scaled'




            $('#dashboard').show();

            var jsonData = $.ajax({
                url: "trends_calculation.php?start_date=" + str + "&end_date=" + str2 + "&location=" + str5,
                dataType: "json",
                async: false
            }).responseText;

            const data = JSON.parse(jsonData);
            am4core.ready(function() {
                am4core.useTheme(am4themes_animated);

                // Create chart instance
                var chart = am4core.create("chartdiv", am4charts.XYChart);
                if (chart.logo) {
                    chart.logo.disabled = true;
                }

                // Add data
                for (var key in data) {
                    var values = data[key];
                    chart.data.push({
                        tag: key,
                        data: values
                    });
                }

                // Set input format for the dates
                chart.dateFormatter.inputDateFormat = "yyyy-MM-ddTHH:mm:SS.SSS+zz:zz";

                // Create axes
                var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
                dateAxis.renderer.grid.template.location = 0;
                dateAxis.renderer.minGridDistance = 50;
                dateAxis.dateFormats.setKey("hour", "hha");

                chart.language.locale["AM"] = "am";
                chart.language.locale["PM"] = "pm";
                dateAxis.baseInterval = {
                    "timeUnit": "second",
                    "count": 1
                };

                var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

                // Create series dynamically
                for (var i = 0; i < chart.data.length; i++) {
                    var tag = chart.data[i].tag;
                    if (tag === 'LT0101_Scaled') {
                        var units = "%";
                    } else {
                        var units = "°C";
                    }
                    var values = chart.data[i].data;

                    var series = chart.series.push(new am4charts.LineSeries());
                    series.dataFields.valueY = "values";
                    series.dataFields.dateX = "date";
                    series.tooltipText = "{name}: [b]{valueY}[/] " + units + "\n{dateX}";
                    series.tooltip.getFillFromObject = false;
                    series.tooltip.label.fill = am4core.color("#ffffff");
                    series.strokeWidth = 3;
                    series.minBulletDistance = 15;

                    // series.fillOpacity = 0.3;
                    // series.propertyFields.stroke = am4core.color("#ff0000");
                    // series.propertyFields.fill = "color";
                    var segment = series.segments.template;
                    segment.interactionsEnabled = true;

                    var hs = segment.states.create("hover");
                    hs.properties.strokeWidth = 6;

                    if (tag == 'TT1001_Scaled') {
                        series.name = 'TT1001';
                        series.tooltip.background.fill = am4core.color("red");
                        series.stroke = am4core.color("red");
                    } else if (tag == 'TT1002_Scaled') {
                        series.name = 'TT1002';
                        series.tooltip.background.fill = am4core.color("#784136");
                        series.stroke = am4core.color("#784136");
                    } else if (tag == 'TT1003_Scaled') {
                        series.name = 'TT1003';
                        series.tooltip.background.fill = am4core.color("#009A8E");
                        series.stroke = am4core.color("#009A8E");
                    } else if (tag == 'TT1004_Scaled') {
                        series.name = 'TT1004';
                        series.tooltip.background.fill = am4core.color("#6771DC");
                        series.stroke = am4core.color("#6771DC");
                    } else if (tag == 'TT1005_Scaled') {
                        series.name = 'TT1005';
                        series.tooltip.background.fill = am4core.color("#67B7DC");
                        series.stroke = am4core.color("#67B7DC");
                    } else if (tag == 'TT1006_Scaled') {
                        series.name = 'TT1006';
                        series.tooltip.background.fill = am4core.color("violet");
                        series.stroke = am4core.color("violet");
                    } else if (tag == 'TT1007_Scaled') {
                        series.name = 'TT1007';
                        series.tooltip.background.fill = am4core.color("#F15168");
                        series.stroke = am4core.color("#F15168");
                    } else if (tag == 'TT1008_Scaled') {
                        series.name = 'TT1008';
                        series.tooltip.background.fill = am4core.color("#29B473");
                        series.stroke = am4core.color("#29B473");
                    } else if (tag == 'TT0501_Scaled') {
                        series.name = 'TT0501';
                        series.tooltip.background.fill = am4core.color("#F7B400");
                        series.stroke = am4core.color("#F7B400");
                    } else if (tag == 'TT0701_Scaled') {
                        series.name = 'TT0701';
                        series.tooltip.background.fill = am4core.color("#7A20CD");
                        series.stroke = am4core.color("#7A20CD");
                    } else if (tag == 'TT1201_Scaled') {
                        series.name = 'TT1201';
                        series.tooltip.background.fill = am4core.color("green");
                        series.stroke = am4core.color("green");
                    } else if (tag == 'LT0101_Scaled') {
                        series.name = 'LT0101';
                        series.tooltip.background.fill = am4core.color("#96c8c3");
                        series.stroke = am4core.color("#96c8c3");
                    } else if (tag == 'PT1001_Scaled') {
                        series.name = 'PT1001';
                        series.tooltip.background.fill = am4core.color("#358EA0");
                        series.stroke = am4core.color("#358EA0");
                    } else if (tag == 'PT2001_Scaled') {
                        series.name = 'PT2001';
                        series.tooltip.background.fill = am4core.color("#D8BC5A");
                        series.stroke = am4core.color("#D8BC5A");
                    }
                    series.data = values;
                    // series.tensionX = 0.8;
                    // Add a drop shadow filter on columns
                    // var shadow = series.filters.push(new am4core.DropShadowFilter);
                    // // Add a drop shadow filter on columns
                    // var shadow = series.filters.push(new am4core.DropShadowFilter);
                    // shadow.opacity = 0.5;
                }

                // Add chart's data into a table
                chart.events.on("datavalidated", function(ev) {
                    var tableData = [];

                    // Generate table data for each trend
                    chart.data.forEach(function(trend) {
                        var tag = trend.tag;
                        var values = trend.data.map(function(dataItem) {
                            return {
                                date: dataItem.date,
                                value: dataItem.values
                            };
                        });
                        tableData.push({
                            tag: tag,
                            data: values
                        });
                    });

                    var tableHTML = '<table class="table table-striped table-hover table-sm">';
                    tableHTML += '<thead><tr><th>Date</th>';

                    // Add column headers
                    tableData.forEach(function(item) {
                        if (item.tag == 'TT1001_Scaled') {
                            tableHTML += '<th>TT1001</th>';
                        } else if (item.tag == 'TT1002_Scaled') {
                            tableHTML += '<th>TT1002</th>';
                        } else if (item.tag == 'TT1003_Scaled') {
                            tableHTML += '<th>TT1003</th>';
                        } else if (item.tag == 'TT1004_Scaled') {
                            tableHTML += '<th>TT1004</th>';
                        } else if (item.tag == 'TT1005_Scaled') {
                            tableHTML += '<th>TT1005</th>';
                        } else if (item.tag == 'TT1006_Scaled') {
                            tableHTML += '<th>TT1006</th>';
                        } else if (item.tag == 'TT1007_Scaled') {
                            tableHTML += '<th>TT1007</th>';
                        } else if (item.tag == 'TT1008_Scaled') {
                            tableHTML += '<th>TT1008</th>';
                        } else if (item.tag == 'TT0501_Scaled') {
                            tableHTML += '<th>TT0501</th>';
                        } else if (item.tag == 'TT0701_Scaled') {
                            tableHTML += '<th>TT0701</th>';
                        } else if (item.tag == 'TT1201_Scaled') {
                            tableHTML += '<th>TT1201</th>';
                        } else if (item.tag == 'LT0101_Scaled') {
                            tableHTML += '<th>LT0101</th>';
                        } else if (item.tag == 'PT1001_Scaled') {
                            tableHTML += '<th>PT1001</th>';
                        } else if (item.tag == 'PT2001_Scaled') {
                            tableHTML += '<th>PT2001</th>';
                        }

                    });

                    tableHTML += '</tr></thead><tbody>';

                    // Find the maximum number of rows for all trends
                    var maxRowCount = 0;
                    tableData.forEach(function(item) {
                        if (item.data.length > maxRowCount) {
                            maxRowCount = item.data.length;
                        }
                    });

                    // Add table rows
                    for (var i = 0; i < maxRowCount; i++) {
                        tableHTML += '<tr>';
                        tableHTML += '<td>' + tableData[0].data[i].date + '</td>';

                        tableData.forEach(function(item) {
                            var value = (item.data[i] && item.data[i].value) ? item.data[i].value :
                                '';
                            // tableHTML += '<td>' + value + '°C' + '</td>';


                            if (item.tag == 'LT0101_Scaled') {
                                tableHTML += '<td>' + value + '%' + '</td>';
                            } else {
                                tableHTML += '<td>' + value + '°C' + '</td>';
                            }


                        });

                        tableHTML += '</tr>';
                    }

                    tableHTML += '</tbody></table>';

                    var div = document.getElementById("chartdata");
                    div.innerHTML = tableHTML;
                });

                // A button to toggle the data table
                var button = chart.createChild(am4core.SwitchButton);
                button.align = "right";
                button.leftLabel.text = "Show data";
                button.leftLabel.fill = am4core.color("gray");
                button.isActive = false;

                // Set toggling of data table
                button.events.on("toggled", function(ev) {
                    var div = document.getElementById("chartdata");
                    if (button.isActive) {
                        div.style.display = "block";
                    } else {
                        div.style.display = "none";
                    }
                });
                // Add legend
                chart.legend = new am4charts.Legend();
                chart.legend.labels.template.text = "[font-size: 12px]{name}[/]";
                chart.legend.markers.template.width = 15;
                chart.legend.markers.template.height = 15;

                // Add cursor
                chart.cursor = new am4charts.XYCursor();
                chart.cursor.xAxis = dateAxis;
                chart.zoomOutButton.background.cornerRadius(5, 5, 5, 5);
                chart.zoomOutButton.background.fill = am4core.color("#25283D");
                chart.zoomOutButton.icon.stroke = am4core.color("#EFD9CE");
                chart.zoomOutButton.icon.strokeWidth = 2;

                chart.zoomOutButton.background.states.getKey("hover").properties.fill = am4core.color("#606271");

                // Add scrollbar
                chart.scrollbarX = new am4charts.XYChartScrollbar();
                chart.scrollbarX.minHeight = 30;
                // chart.scrollbarX.series.push(series)
                // Style scrollbar
                function customizeGrip(grip) {
                    // Remove default grip image
                    grip.icon.disabled = true;

                    // Disable background
                    grip.background.disabled = true;

                    // Add rotated rectangle as bi-di arrow
                    var img = grip.createChild(am4core.Rectangle);
                    img.width = 8;
                    img.height = 8;
                    img.fill = am4core.color("#999");
                    img.rotation = 45;
                    img.align = "center";
                    img.valign = "middle";

                    // Add vertical bar
                    var line = grip.createChild(am4core.Rectangle);
                    line.height = 25;
                    line.width = 3;
                    line.fill = am4core.color("#999");
                    line.align = "center";
                    line.valign = "middle";

                }

                customizeGrip(chart.scrollbarX.startGrip);
                customizeGrip(chart.scrollbarX.endGrip);
                // // Bring back colors
                chart.scrollbarX.scrollbarChart.plotContainer.filters.clear();

                // Set up export
                chart.exporting.menu = new am4core.ExportMenu();
                chart.exporting.menu.items[0].icon =
                    "data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjxzdmcgaGVpZ2h0PSIxNnB4IiB2ZXJzaW9uPSIxLjEiIHZpZXdCb3g9IjAgMCAxNiAxNiIgd2lkdGg9IjE2cHgiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6c2tldGNoPSJodHRwOi8vd3d3LmJvaGVtaWFuY29kaW5nLmNvbS9za2V0Y2gvbnMiIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIj48dGl0bGUvPjxkZWZzLz48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiIGlkPSJJY29ucyB3aXRoIG51bWJlcnMiIHN0cm9rZT0ibm9uZSIgc3Ryb2tlLXdpZHRoPSIxIj48ZyBmaWxsPSIjMDAwMDAwIiBpZD0iR3JvdXAiIHRyYW5zZm9ybT0idHJhbnNsYXRlKC03MjAuMDAwMDAwLCAtNDMyLjAwMDAwMCkiPjxwYXRoIGQ9Ik03MjEsNDQ2IEw3MzMsNDQ2IEw3MzMsNDQzIEw3MzUsNDQzIEw3MzUsNDQ2IEw3MzUsNDQ4IEw3MjEsNDQ4IFogTTcyMSw0NDMgTDcyMyw0NDMgTDcyMyw0NDYgTDcyMSw0NDYgWiBNNzI2LDQzMyBMNzMwLDQzMyBMNzMwLDQ0MCBMNzMyLDQ0MCBMNzI4LDQ0NSBMNzI0LDQ0MCBMNzI2LDQ0MCBaIE03MjYsNDMzIiBpZD0iUmVjdGFuZ2xlIDIxNyIvPjwvZz48L2c+PC9zdmc+";
                chart.exporting.adapter.add("data", function(data, target) {
                    // Assemble data from series
                    var data = [];
                    chart.series.each(function(series) {
                        for (var i = 0; i < series.data.length; i++) {
                            series.data[i].name = series.name;
                            data.push(series.data[i]);
                        }
                    });
                    return {
                        data: data
                    };
                });
                // Add titles
                var title = chart.titles.create();
                title.text = "Comparison Trends";
                title.fontSize = 20;
                title.marginBottom = 10;

                // var dateRange = chart.titles.create();
                // dateRange.text = "Date Range: " + str + " - " + str2;
                // dateRange.fontSize = 14;

                // var selectedLocations = chart.titles.create();
                // selectedLocations.text = "Selected Locations: " + str5.join(", ");
                // selectedLocations.fontSize = 14;
                // Listen for the "themeChanged" event
                document.body.addEventListener("themeChanged", function(event) {
                    var isDarkTheme = event.detail.isDarkTheme;
                    // Call the function to update chart colors based on the theme
                    updateChartColors(isDarkTheme);
                });

                // Function to update chart colors based on the theme
                function updateChartColors(isDarkTheme) {
                    if (isDarkTheme) {
                        // Set dark theme colors
                        chart.colors.list = [
                            am4core.color("#ffffff"), // White
                            am4core.color("#ff0000"), // Red
                            am4core.color("#00ff00") // Green
                            // Add more colors as needed
                        ];
                        // Set dark theme grid and label colors
                        dateAxis.renderer.grid.template.stroke = am4core.color("#ffffff");
                        dateAxis.renderer.labels.template.fill = am4core.color("#ffffff");
                        valueAxis.renderer.grid.template.stroke = am4core.color("#ffffff");
                        valueAxis.renderer.labels.template.fill = am4core.color("#ffffff");
                        chart.legend.labels.template.fill = am4core.color("#ffffff");
                        title.fill = am4core.color("#ffffff"); // Set the title color to white

                    } else {
                        // Set light theme colors
                        chart.colors.list = [
                            am4core.color("#000000"), // Black
                            am4core.color("#ff0000"), // Red
                            am4core.color("#00ff00") // Green
                            // Add more colors as needed
                        ];
                        // Set light theme grid and label colors
                        dateAxis.renderer.grid.template.stroke = am4core.color("#000000");
                        dateAxis.renderer.labels.template.fill = am4core.color("#000000");
                        valueAxis.renderer.grid.template.stroke = am4core.color("#000000");
                        valueAxis.renderer.labels.template.fill = am4core.color("#000000");
                        chart.legend.labels.template.fill = am4core.color("#000000");
                        title.fill = am4core.color("#000000"); // Set the title color to white
                    }
                }

                // Call the function initially to set chart colors based on the current theme
                var isDarkTheme = document.documentElement.getAttribute("data-theme") === "dark";
                updateChartColors(isDarkTheme);
                var isDarkTheme = document.documentElement.getAttribute("data-theme") === "dark";
                document.body.dispatchEvent(new CustomEvent("themeChanged", {
                    detail: {
                        isDarkTheme: isDarkTheme
                    }
                }));
            });
        }
        $(window).resize(function() {
            drawChart();
        });
    </script>
    <script>
        chartpiediv()

        function chartpiediv() {
            var str = document.getElementById("ec_start_date1").value;
            var str2 = document.getElementById("ec_end_date1").value;
            am4core.ready(function() {
                // var htmlElement = document.documentElement;

                // if (htmlElement.getAttribute('data-theme') === 'dark') {
                //     am4core.useTheme(am4themes_dark);
                // } else {
                //     am4core.useTheme(am4themes_animated);
                // }
                // Themes begin
                am4core.useTheme(am4themes_animated);
                // Themes end

                // Create chart instance
                var chart = am4core.create("chartpiediv", am4charts.PieChart);
                chart.hiddenState.properties.opacity = 0;
                if (chart.logo) {
                    chart.logo.disabled = true;
                }

                // Add data
                var jsonData = $.ajax({
                    url: "./calculation/database5.php?start_date=" + str + "&end_date=" + str2,
                    dataType: "json",
                    async: false
                }).responseText;

                chart.data = JSON.parse(jsonData);

                // Add and configure Series
                var pieSeries = chart.series.push(new am4charts.PieSeries());
                pieSeries.dataFields.value = "stimes";
                pieSeries.dataFields.category = "steps";
                pieSeries.slices.template.cornerRadius = 5;
                pieSeries.slices.template.showOnInit = true;
                pieSeries.slices.template.hiddenState.properties.shiftRadius = 1;
                pieSeries.slices.template.tooltipText =
                    "Category:{steps}\n Time Duration:{times.formatDuration('mm:ss')}";
                // Remove or set innerRadius to 0 to create a pie chart
                // pieSeries.innerRadius = am4core.percent(50);

                // var rgm = new am4core.RadialGradientModifier();
                // rgm.brightnesses.push(-0.8, -0.8, -0.5, 0, -0.5);
                // pieSeries.slices.template.fillModifier = rgm;
                // pieSeries.slices.template.strokeModifier = rgm;
                // pieSeries.slices.template.strokeOpacity = 0.4;
                // pieSeries.slices.template.strokeWidth = 0;

                // Create legend
                chart.legend = new am4charts.Legend();

                // Create parent container for legend
                chart.legend.parent = am4core.create("myDiv1", am4core.Container);

                // Disable the amCharts logo
                if (chart.legend.parent.logo) {
                    chart.legend.parent.logo.disabled = true;
                }

                // Set width and height of the parent container
                chart.legend.parent.width = am4core.percent(100);
                chart.legend.parent.height = am4core.percent(100);

                // Make legend scrollable
                chart.legend.scrollable = true;

                // Configure legend item layout
                chart.legend.itemContainers.template.layout = "horizontal";

                // Align legend labels to the left
                chart.legend.labels.template.align = "left";
                chart.legend.labels.template.valign = "middle";
                chart.legend.labels.template.maxWidth = 200; // Adjust max width as needed

                // Align legend value labels to the right
                chart.legend.valueLabels.template.align = "right";
                chart.legend.valueLabels.template.valign = "middle";
                chart.legend.valueLabels.template.width = 100; // Adjust width as needed

                // Set value text for legend items
                pieSeries.legendSettings.valueText = "[bold]{times.formatDuration('mm:ss')}[/bold]";

                // chart.legend.maxWidth = 400;
                pieSeries.colors.list = [
                    am4core.color("#57CD7D"), // green
                    am4core.color("#25B7E5"), // blue
                    am4core.color("#F6CA00"), // yellow
                    am4core.color("#BD2D18") // red
                    // Add more colors as needed
                ];

            }); // end am4core.ready()

        }
    </script>

    <!-- triger the div on clicking the roles btn -->
    <script>
        document.getElementById("mngrol-btn").addEventListener("click", function() {
            var roleSection = document.getElementById("role-section");
            var privSection = document.getElementById("priv-section");
            var userSection = document.getElementById("use-section");
            var viewSection = document.getElementById("view-section");

            roleSection.style.display = "block";
            privSection.style.display = "none";
            userSection.style.display = "none";
            viewSection.style.display = "none";
        });
    </script>
    <!-- end role -->

    <!-- triger the div on clicking the Privileges btn -->
    <script>
        document.getElementById("mngpriv-btn").addEventListener("click", function() {
            var roleSection = document.getElementById("role-section");
            var privSection = document.getElementById("priv-section");
            var userSection = document.getElementById("use-section");
            var viewSection = document.getElementById("view-section");

            roleSection.style.display = "none";
            privSection.style.display = "block";
            userSection.style.display = "none";
            viewSection.style.display = "none";
        });
    </script>
    <!-- end Privileges -->

    <!-- triger the div on clicking the Users btn -->
    <script>
        document.getElementById("user-btn").addEventListener("click", function() {
            var roleSection = document.getElementById("role-section");
            var privSection = document.getElementById("priv-section");
            var userSection = document.getElementById("use-section");
            var viewSection = document.getElementById("view-section");

            roleSection.style.display = "none";
            privSection.style.display = "none";
            userSection.style.display = "block";
            viewSection.style.display = "none";
        });
    </script>
    <!-- end Users -->

    <!-- triger the div on clicking the Users btn -->
    <script>
        document.getElementById("view-user-btn").addEventListener("click", function() {
            var roleSection = document.getElementById("role-section");
            var privSection = document.getElementById("priv-section");
            var userSection = document.getElementById("use-section");
            var viewSection = document.getElementById("view-section");


            roleSection.style.display = "none";
            privSection.style.display = "none";
            userSection.style.display = "none";
            viewSection.style.display = "block";
        });
        // for title control
        function head1() {
            document.getElementById('head0').style.display = 'none';
            document.getElementById('head1').style.display = 'block';
            document.getElementById('head2').style.display = 'none';
            document.getElementById('head3').style.display = 'none';
            document.getElementById('head4').style.display = 'none';
            document.getElementById('head5').style.display = 'none';
            document.getElementById('head6').style.display = 'none';
        }

        function head2() {
            document.getElementById('head0').style.display = 'none';
            document.getElementById('head1').style.display = 'none';
            document.getElementById('head2').style.display = 'block';
            document.getElementById('head3').style.display = 'none';
            document.getElementById('head4').style.display = 'none';
            document.getElementById('head5').style.display = 'none';
            document.getElementById('head6').style.display = 'none';
        }

        function head3() {
            document.getElementById('head0').style.display = 'none';
            document.getElementById('head1').style.display = 'none';
            document.getElementById('head2').style.display = 'none';
            document.getElementById('head3').style.display = 'block';
            document.getElementById('head4').style.display = 'none';
            document.getElementById('head5').style.display = 'none';
            document.getElementById('head6').style.display = 'none';
        }

        function head4() {
            document.getElementById('head0').style.display = 'none';
            document.getElementById('head1').style.display = 'none';
            document.getElementById('head2').style.display = 'none';
            document.getElementById('head3').style.display = 'none';
            document.getElementById('head4').style.display = 'block';
            document.getElementById('head5').style.display = 'none';
            document.getElementById('head6').style.display = 'none';
        }

        function head0() {
            document.getElementById('head0').style.display = 'block';
            document.getElementById('head1').style.display = 'none';
            document.getElementById('head2').style.display = 'none';
            document.getElementById('head3').style.display = 'none';
            document.getElementById('head4').style.display = 'none';
            document.getElementById('head5').style.display = 'none';
            document.getElementById('head6').style.display = 'none';
        }

        function head5() {
            document.getElementById('head0').style.display = 'none';
            document.getElementById('head1').style.display = 'none';
            document.getElementById('head2').style.display = 'none';
            document.getElementById('head3').style.display = 'none';
            document.getElementById('head4').style.display = 'none';
            document.getElementById('head5').style.display = 'block';
            document.getElementById('head6').style.display = 'none';
        }

        function head6() {
            document.getElementById('head0').style.display = 'none';
            document.getElementById('head1').style.display = 'none';
            document.getElementById('head2').style.display = 'none';
            document.getElementById('head3').style.display = 'none';
            document.getElementById('head4').style.display = 'none';
            document.getElementById('head5').style.display = 'none';
            document.getElementById('head6').style.display = 'block';
        }
    </script>
    <script>
        $(document).ready(function() {
            $("#data-form").submit(function(e) {
                e.preventDefault(); // Prevent the default form submission

                // Serialize the form data
                var formData = $(this).serialize();

                // Make an AJAX request to fetch and display data
                $.ajax({
                    type: "POST",
                    url: "fetch_data.php", // The PHP script to handle data retrieval
                    data: formData,
                    success: function(response) {
                        // Display the data in the "data-table" div
                        $("#data-table").html(response);
                    }
                });
            });
        });
    </script>
    <script>
        // Get the temperature and pressure checkbox elements
        const temperatureCheckboxes = document.querySelectorAll('input[name="selected_temperatures[]"]');
        const pressureCheckboxes = document.querySelectorAll('input[name="selected_pressure[]"]');

        // Add event listeners to the temperature checkboxes
        temperatureCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                if (checkbox.checked) {
                    // If a temperature checkbox is checked, uncheck all pressure checkboxes
                    pressureCheckboxes.forEach(pressureCheckbox => {
                        pressureCheckbox.checked = false;
                    });
                }
            });
        });

        // Add event listeners to the pressure checkboxes
        pressureCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                if (checkbox.checked) {
                    // If a pressure checkbox is checked, uncheck all temperature checkboxes
                    temperatureCheckboxes.forEach(temperatureCheckbox => {
                        temperatureCheckbox.checked = false;
                    });
                }
            });
        });
    </script>
    <script type="text/javascript">
        var headerImgData;
        headerImgData =
            'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAABkCAYAAABkW8nwAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyBpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMC1jMDYwIDYxLjEzNDc3NywgMjAxMC8wMi8xMi0xNzozMjowMCAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNSBXaW5kb3dzIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjkxQTQzMTFFNjg1QjExRTdCOTAxODFDOUEzRTVGMzgzIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjkxQTQzMTFGNjg1QjExRTdCOTAxODFDOUEzRTVGMzgzIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6OTFBNDMxMUM2ODVCMTFFN0I5MDE4MUM5QTNFNUYzODMiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6OTFBNDMxMUQ2ODVCMTFFN0I5MDE4MUM5QTNFNUYzODMiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz6ULFxQAABTd0lEQVR42uy9B3wd1ZU/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';
        var headerImgData1;
        headerImgData1 =
            'data:image/png;base64,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';

        function generatereport() {
            var doc = new jsPDF('portrait', 'pt', [841.89, 852.55]);
            // header of pdf 
            var header = function(data) {
                doc.setFontSize(12);
                doc.setTextColor(40);
                doc.setFontStyle('normal'); //margin,width , height  
                doc.addImage(headerImgData, 'JPEG', data.settings.margin.left, 10, 130, 100);
                var xOffset = 600; // Adjust this value as needed
                doc.addImage(headerImgData1, 'JPEG', data.settings.margin.left + xOffset, 30, 200, 60);
                doc.setTextColor(100);

                // Get the input element by its ID
                var startDateInput = document.getElementById("startDate");
                var startDateValue = startDateInput.value;
                // end_date
                var endDateInput = document.getElementById("endDate");
                var endDateValue = endDateInput.value;
                doc.text(150, 130, 'Start Date: ' + startDateValue + '', 'right');
                doc.text(320, 130, 'End Date: ' + endDateValue + '', 'right');
                doc.setDrawColor(0, 0, 0);
                doc.line(10, 10, 840 - 10, 10);
                doc.line(10, 10, 10, 120 - 10);
                doc.setLineWidth(2);
                doc.line(10, 120 - 10, 840 - 10, 120 - 10);
                doc.setLineWidth(1);
                doc.line(840 - 10, 120 - 10, 840 - 10, 10);
                doc.line(10, 150 - 10, 840 - 10, 150 - 10);
                // get date 
                var today = new Date();
                var dd = today.getDate();
                var mm = today.getMonth() + 1;
                var yyyy = today.getFullYear();
                today1 = dd + '/' + mm + '/' + yyyy;
                // get time in 12 h format 
                var today = new Date();
                var hours = today.getHours();
                var minutes = today.getMinutes();
                var ampm = hours >= 12 ? 'PM' : 'AM';
                hours = hours % 12;
                hours = hours ? hours : 12; // the hour '0' should be '12'
                minutes = minutes < 10 ? '0' + minutes : minutes;
                strTime = hours + ':' + minutes + ' ' + ampm;
                doc.setFontSize(10);
                doc.setFontStyle('normal');
                doc.text(strTime, 730, 128);
                doc.text("Reported Date:" + today1, 605, 128);
            };
            // page content headings design 
            doc.setFillColor(62, 161, 255);
            doc.rect(20, 150, 800, 20, 'F');
            doc.setFontSize(16);
            doc.setTextColor(255, 255, 255)
            const temperatureCheckboxes = document.querySelectorAll('[name="selected_temperatures[]"]');
            let isTemperatureChecked = false;

            temperatureCheckboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    isTemperatureChecked = true;
                }
            });
            doc.text(340, 165, isTemperatureChecked ? 'Temperature Report' : 'Pressure Report', '');
            // page content borders 
            doc.setLineWidth(1);
            doc.setDrawColor(0, 0, 0);
            //left border
            doc.line(10, 820, 10, 120 - 10);
            //right border
            doc.line(840 - 10, 820, 840 - 10, 120 - 10);
            //bottom border
            doc.line(10, 820, 840 - 10, 820);
            var footer = function(data) {
                // fonts of footer texts
                doc.setFontSize(12);
                // doc.setFontStyle('normal');
                // single line specs for footer border
                doc.setLineWidth(3);
                doc.setDrawColor(0, 0, 0);
                doc.line(10, 820, 840 - 10, 820);
                // get page numbers 
                const pageCount = doc.internal.getNumberOfPages();
                // console.log(pageCount);
                // Iterate through each page
                for (var i = 1; i <= pageCount; i++) {
                    // Go to the current page
                    doc.setPage(i);

                    // Define the coordinates for placing the page number text
                    const x = 735; // X-coordinate
                    const y = 844; // Y-coordinate

                    // Print "Page X of Y" text
                    doc.text('Page ' + String(i), x, y);
                }

                var today = new Date();
                var dd = today.getDate();
                var mm = today.getMonth() + 1;
                var yyyy = today.getFullYear();
                today1 = dd + '/' + mm + '/' + yyyy;
                // get time in 12 h format 
                var hours = today.getHours();
                var minutes = today.getMinutes();
                var ampm = hours >= 12 ? 'PM' : 'AM';
                hours = hours % 12;
                hours = hours ? hours : 12; // the hour '0' should be '12'
                minutes = minutes < 10 ? '0' + minutes : minutes;
                strTime = hours + ':' + minutes + ' ' + ampm;
                doc.setTextColor(0, 0, 0);
                doc.text("Generated on: " + today1, 15, 845);
                doc.text(strTime, 200, 845);
            }
            var options = { // variable for autotable for table specs 
                beforePageContent: header,
                afterPageContent: footer,
                margin: {
                    top: 200,
                    left: 20,
                    right: 20,
                    bottom: 45
                },
                //drawHeaderCell: function (cell, data) {        >>>>>>>>>>>controling individual column
                //  console.log(cell.text[0]);

                //  if (cell.text[0] ==='No.') {//paint.Name header red
                // cell.styles.fontSize= 12;
                //   cell.styles.textColor = [255,255,255];
                //   cell.styles.fillColor = "#43a089";
                //   console.log('pop');
                // } else {
                //     cell.styles.textColor = 255;
                //     cell.styles.fontSize = 10;
                // }
                //},
                startY: false,
                theme: 'grid',
                tableWidth: 'auto',
                columnWidth: 'wrap',
                showHeader: 'everyPage',
                tableLineColor: 200,
                tableLineWidth: 2,
                columnStyles: {
                    0: {
                        columnWidth: 'auto',
                        halign: 'center'
                    },
                    1: {
                        columnWidth: 'auto',
                        halign: 'center'
                    },
                    2: {
                        columnWidth: 'auto',
                        halign: 'center'
                    },
                    3: {
                        columnWidth: 'auto',
                        halign: 'center'
                    },
                    4: {
                        columnWidth: 'auto',
                        halign: 'center'
                    },
                    5: {
                        columnWidth: 'auto',
                        halign: 'center'
                    },
                    6: {
                        columnWidth: 'auto',
                        halign: 'center'
                    },
                    7: {
                        columnWidth: 'auto',
                        halign: 'center'
                    },
                    8: {
                        columnWidth: 'auto',
                        halign: 'center'
                    },
                    9: {
                        columnWidth: 'auto',
                        halign: 'center'
                    },
                    10: {
                        columnWidth: 'auto',
                        halign: 'center'
                    },
                    11: {
                        columnWidth: 'auto',
                        halign: 'center'
                    },
                    12: {
                        columnWidth: 'auto',
                        halign: 'center'
                    },
                    13: {
                        columnWidth: 'auto',
                        halign: 'center'
                    },
                    14: {
                        columnWidth: 'auto',
                        halign: 'center'
                    },
                    15: {
                        columnWidth: 'auto',
                        halign: 'center'
                    },
                    16: {
                        columnWidth: 'auto',
                        halign: 'center'
                    },
                    17: {
                        columnWidth: 'auto',
                        halign: 'center'
                    },
                },
                headerStyles: {
                    theme: 'striped',
                    halign: 'center',
                    fillColor: [70, 186, 204],
                    textColor: [0, 0, 0],
                    fontSize: 11,
                },
                headerStyles1: {
                    theme: 'striped',
                    halign: 'center',
                    fillColor: [70, 186, 204],
                    textColor: [0, 0, 0],
                    fontSize: 11,
                },
                footerStyles: {
                    theme: 'striped',
                    halign: 'center'
                },
                styles: {
                    overflow: 'linebreak',
                    fillColor: [70, 186, 204],
                    columnWidth: 'wrap',
                    font: 'arial',
                    fontSize: 10,
                    cellPadding: 8,
                    textColor: [0, 0, 0],
                    overflowColumns: 'linebreak',
                    halign: 'right'
                },
                createdCell: function(cell, data) {
                    var rowIdx = data.row.index;
                    // Check if the row index is even or odd and set the color accordingly
                    if (rowIdx % 2 === 0) { // Even row
                        cell.styles.fillColor = [255, 255, 255]; // Set the color for even rows (white)
                    } else { // Odd row
                        cell.styles.fillColor = [105, 173, 214]; // Set the color for odd rows (light blue)
                    }
                },
            };
            let odd_no = 0;
            var res1 = doc.autoTableHtmlToJson(document.getElementById("demo-table"));
            doc.autoTable(res1.columns, res1.rows, options);
            doc.save(isTemperatureChecked ? 'Temperature Report' : 'Pressure Report' + today1 + ".pdf");
        }
    </script>
    <!-- <script src="js_libraries\jspdf.debug.js"></script>
    <script src="js_libraries\jspdf.plugin.autotable.js"></script>
    <script src="js_libraries\jspdf.umd.min.js"></script> -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- DataTables CDN -->

    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js">
    </script>

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
    <script>
        $(document).ready(function() {
            function updateTable() {
                // Use AJAX to fetch the latest data from the server
                $.ajax({
                    url: 'alarm.php', // Replace with the actual path to your PHP script
                    type: 'GET',
                    success: function(data) {
                        // Update the table content with the latest data
                        $('#myTable tbody').html(data);
                    },
                    error: function() {
                        console.error('Error fetching data from the server.');
                    }
                });
            }

            // Initialize DataTable
            $('#myTable').DataTable();

            // Update the table every second
            setInterval(updateTable, 1000);
        });
    </script>
    <script>
        efficienybar()

        function efficienybar() {
            var eb_str = document.getElementById("eb_start_date").value;
            var eb_str2 = document.getElementById("eb_end_date").value;
            am4core.ready(function() {

                // Themes begin
                am4core.useTheme(am4themes_animated);
                // Themes end

                // Create chart instance
                var chart = am4core.create("efficiencychart", am4charts.XYChart);
                if (chart.logo) {
                    chart.logo.disabled = true;
                }
                // Add data
                var jsonData = $.ajax({
                    url: "./calculation/test.php?start_date=" + eb_str + "&end_date=" + eb_str2,
                    dataType: "json",
                    async: false
                }).responseText;

                chart.data = JSON.parse(jsonData);

                // Create axes
                var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
                dateAxis.renderer.minGridDistance = 50;

                var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
                valueAxis.title.text = "Efficiency (%)";
                valueAxis.min = 0;
                valueAxis.max = 100;

                // Create series
                var series = chart.series.push(new am4charts.ColumnSeries());
                series.dataFields.valueY = "efficiency";
                var field = "efficiency";
                // Initially set valueZ to the same field
                series.dataFields.valueZ = field;

                // Function to convert seconds to hh:mm:ss format
                function secondsToHms(d) {
                    d = Number(d);
                    var h = Math.floor(d / 3600).toString().padStart(2, '0');
                    var m = Math.floor(d % 3600 / 60).toString().padStart(2, '0');
                    var s = Math.floor(d % 3600 % 60).toString().padStart(2, '0');

                    return h + ":" + m + ":" + s;
                }

                // Calculate valueZ dynamically and convert to hh:mm:ss format
                series.events.on("beforedatavalidated", function(ev) {
                    series.dataItems.each(function(dataItem) {
                        // Get the value dynamically based on the field variable
                        var fieldValue = dataItem.dataContext[field];
                        // Perform the calculation
                        var calculatedValue = (fieldValue * 86400) / 100;
                        // Convert to hh:mm:ss format
                        dataItem.valueZ = secondsToHms(calculatedValue);
                    });
                });
                series.dataFields.dateX = "date";
                series.name = "Efficiency";
                series.tooltipText = "{dateX}: [b]{valueY}%[/b]\nDuration: [b]{valueZ} hrs[/b]";
                series.strokeWidth = 2;
                series.fillOpacity = 0.7;

                // Add legend
                chart.legend = new am4charts.Legend();
                // Add cursor
                chart.cursor = new am4charts.XYCursor();
                chart.cursor.xAxis = dateAxis;
                chart.cursor.snapToSeries = series;

                // Enable export
                chart.exporting.menu = new am4core.ExportMenu();

            }); // end am4core.ready()
        }
    </script>
    <script>
        updateChart('this-week-last-week');

        function updateChart(selection) {
            am4core.useTheme(am4themes_animated);

            var chart;

            am4core.ready(function() {
                // Create chart instance
                chart = am4core.create("periodchartdiv", am4charts.XYChart);
                if (chart.logo) {
                    chart.logo.disabled = true;
                }

                // Initial data retrieval and setting
                function loadData(url) {
                    var jsonData = $.ajax({
                        url: url,
                        dataType: "json",
                        async: false
                    }).responseText;
                    return JSON.parse(jsonData);
                }

                // Create axes
                var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
                categoryAxis.dataFields.category = "category";
                categoryAxis.title.text = "Date / Day / Week";

                // Add grid lines between days
                categoryAxis.renderer.grid.template.location = 0;
                categoryAxis.renderer.grid.template.stroke = am4core.color("grey");
                categoryAxis.renderer.grid.template.strokeOpacity = 1;
                categoryAxis.renderer.grid.template.strokeWidth = 1;
                categoryAxis.renderer.grid.template.disabled = false;

                categoryAxis.renderer.labels.template.location = 0.5;

                var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
                valueAxis.title.text = "Efficiency (%)";
                valueAxis.min = 0;
                valueAxis.max = 100;

                // Create series
                function createSeries(field, name, color, tooltipPosition) {
                    var series = chart.series.push(new am4charts.ColumnSeries());
                    series.dataFields.valueY = field;

                    // Function to convert seconds to hh:mm:ss format
                    function secondsToHms(d) {
                        d = Number(d);
                        var h = Math.floor(d / 3600).toString().padStart(2, '0');
                        var m = Math.floor(d % 3600 / 60).toString().padStart(2, '0');
                        var s = Math.floor(d % 3600 % 60).toString().padStart(2, '0');
                        return h + ":" + m + ":" + s;
                    }

                    // Calculate valueZ dynamically and convert to hh:mm:ss format
                    series.events.on("beforedatavalidated", function(ev) {
                        series.dataItems.each(function(dataItem) {
                            var fieldValue = dataItem.dataContext[field];
                            var calculatedValue = (fieldValue * 86400) / 100;
                            dataItem.valueZ = secondsToHms(calculatedValue);
                        });
                    });

                    series.dataFields.categoryX = "category";
                    series.name = name;
                    series.columns.template.tooltipText = "{name}: [bold]{valueY}[/]";
                    series.columns.template.fillOpacity = 0.7;
                    series.columns.template.fill = color;
                    series.columns.template.stroke = color;

                    var columnTemplate = series.columns.template;
                    columnTemplate.strokeWidth = 2;
                    columnTemplate.strokeOpacity = 1;

                    // Adjust tooltip positioning
                    series.tooltip.getFillFromObject = false;
                    series.tooltip.background.fill = color;
                    series.tooltip.pointerOrientation = "horizontal";
                    series.tooltipHTML = '<div style="text-align: ' + tooltipPosition + ';">{name}:<br>Efficiency: <strong>{valueY} %</strong><br>Duration: <strong>{valueZ} hrs</strong></div>';
                }

                // Create initial series with tooltip alignments and positions
                createSeries("previousEfficiency", "Previous Period", am4core.color("#F70000"), "left");
                createSeries("currentEfficiency", "Current Period", am4core.color("#00F700"), "left");

                // Add legend
                chart.legend = new am4charts.Legend();
                chart.legend.parent = am4core.create("myDiv", am4core.Container);
                if (chart.legend.parent.logo) {
                    chart.legend.parent.logo.disabled = true;
                }
                chart.legend.parent.width = am4core.percent(100);
                chart.legend.parent.height = am4core.percent(100);
                chart.legend.scrollable = true;

                // Add cursor
                chart.cursor = new am4charts.XYCursor();

                // Function to calculate max value and add guide
                function calculateMaxValue() {
                    var data = chart.data;
                    var maxValue = -Infinity;

                    for (var i = 0; i < data.length; i++) {
                        var previousValue = Number(data[i]["previousEfficiency"]);
                        var currentValue = Number(data[i]["currentEfficiency"]);

                        if (previousValue > maxValue) {
                            maxValue = previousValue;
                        }
                        if (currentValue > maxValue) {
                            maxValue = currentValue;
                        }
                    }

                    if (maxValue !== -Infinity) {
                        var maxRange = valueAxis.axisRanges.create();
                        maxRange.value = maxValue;
                        maxRange.grid.stroke = am4core.color("#0C4B93");
                        maxRange.grid.strokeWidth = 1.5;
                        maxRange.grid.strokeOpacity = 1;
                        maxRange.label.text = "Max Efficiency: " + maxValue.toFixed(2) + " %";
                        maxRange.label.fill = am4core.color("#FFFFFF");
                        maxRange.label.inside = true;
                        maxRange.label.fill = maxRange.grid.stroke;
                        maxRange.label.verticalCenter = "bottom";
                        maxRange.label.fontSize = 14;
                        maxRange.label.fontWeight = "bold";
                        maxRange.label.valign = "bottom";
                    }
                }

                // Update chart based on selection
                switch (selection) {
                    case 'today-yesterday':
                        chart.data = loadData("./calculation/period_db.php?select_date=today-yesterday");
                        calculateMaxValue();
                        break;
                    case 'this-week-last-week':
                        chart.data = loadData("./calculation/period_db.php?select_date=this-week-last-week");
                        calculateMaxValue();
                        break;
                    case 'this-month-last-month':
                        chart.data = loadData("./calculation/period_db.php?select_date=this-month-last-month");
                        calculateMaxValue();
                        break;
                }

                chart.invalidateRawData(); // Refresh chart data
            });
        }
    </script>


</body>

</html>
<?php

$ch = curl_init('https://www.cbr-xml-daily.ru/daily_json.js');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
curl_close($ch);
$json = json_decode($response, true);
$usd_now = 64.5;
//$usd_now = round($json['Valute']['USD']['Value'], 1);
$usd_was = round($json['Valute']['USD']['Previous'], 1);
$eur_now = round($json['Valute']['EUR']['Value'], 1);
$eur_was = round($json['Valute']['EUR']['Previous'], 1);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <style>
        body {
            padding: 1em;
            font-family: 'Oswald';
        }

        * {
            margin: 0;
            padding: 0;
        }

        .speedbox {
            margin: 5em;
            height: 200px;
            width: 200px;
            display: flex;
            display: -webkit-flex;
            flex-direction: column;
            -webkit-flex-direction: column;
            align-items: center;
            -webkit-align-items: center;
            position: relative;
        }

        .speedbox__groove {
            height: 100px;
            width: 200px;
            background: transparent;
            border-top-left-radius: 100px;
            border-top-right-radius: 100px;
            border: 20px solid #eee;
            border-bottom: 0;
            box-sizing: border-box;
            position: absolute;
            left: 0;
            top: 0;
        }

        .speedbox__score {
            position: absolute;
            left: 0;
            top: 0;
            -webkit-transform: rotate(-45deg);
            height: 200px;
            width: 200px;
            background: transparent;
            border-radius: 50%;
            border: 20px solid #1e5188;
            border-color: transparent transparent #1e5188 #1e5188;
            box-sizing: border-box;
            cursor: pointer;
            z-index: 3;
        }

        .speedbox__score_was {
            position: absolute;
            left: 0;
            top: 0;
            -webkit-transform: rotate(-45deg);
            height: 200px;
            width: 200px;
            background: transparent;
            border-radius: 50%;
            border: 20px solid #7b2727;
            border-color: transparent transparent #7b2727  #7b2727;
            box-sizing: border-box;
            cursor: pointer;
            z-index: 4;

        }

        .speedbox__base {
            width: 240px;
            height: 100px;
            background: white;
            position: relative;
            top: 100px;
            z-index: 20;
        }

        .speedbox__base:before {
            content: '';
            width: 240px;
            position: absolute;
            top: 0;
            border-bottom: 1px solid #eee;
            box-shadow: 1px 3px 15px rgba(0, 0, 0, 0.5);
        }

        .speedbox__odo {
            text-align: center;
            position: absolute;
            color: #5c6f7b;
            bottom: 100px;
            left: 50%;
            transform: translateX(-50%);
        }

        .speedbox__odo i {
            font-size: 13px;
            opacity: 0.6;
        }

        .speedbox__odo > div {
            margin-bottom: 0;
        }

        .speedbox__odo span {
            font-size: 0.7em;
        }

        .speedbox__cur i {
            font-size: 20px;
            margin-bottom: 0.2em;
        }

        .speedbox__was {
            font-size: 18px;
            line-height: 0.6em;
            color: #7b2727;
        }

        .speedbox__now {
            font-size: 25px;
            text-shadow: 0 0 3px rgba(0, 0, 0, 0.2);
            line-height: 1.2em;
            color: #1e5188;
        }

        .speedbox__start {
            font-size: 17px;
            color: rgba(5, 7, 19, 0.65);
            left: -15%;
            bottom: 50%;
            position: absolute;
        }
        .speedbox__end {
            font-size: 17px;
            color: rgba(5, 7, 19, 0.65);
            text-shadow: 0 0 3px rgba(0, 0, 0, 0.2);
            right: -15%;
            bottom: 50%;
            position: absolute;
        }

    </style>
</head>
<body>

<div class="speedbox">
    <div class="speedbox__score" id="speedbox-score-usd-now"></div>
    <div class="speedbox__score_was" id="speedbox-score-usd-was"></div>
    <div class="speedbox__groove"></div>
    <div class="speedbox__odo">
        <div class="speedbox__cur"><i class="fa fa-usd"></i></div>
        <div class="speedbox__was"><small>was </small> <span id="usd_was"><?= $usd_was ?></span><small> rub</small></div>
        <div class="speedbox__now"><small>now </small> <span id="usd_now"><?= $usd_now ?></span><small> rub</small></div>
    </div>
    <div class="speedbox__start" id="usd_start"></div>
    <div class="speedbox__end" id="usd_end"></div>
    <div class="speedbox__base"></div>
</div>


<div class="speedbox">
    <div class="speedbox__score" id="speedbox-score-eur-now"></div>
    <div class="speedbox__score_was" id="speedbox-score-eur-was"></div>
    <div class="speedbox__groove"></div>
    <div class="speedbox__odo">
        <div class="speedbox__cur"><i class="fa fa-eur"></i></div>
        <div class="speedbox__was"><small>was </small> <span id="eur_was"><?= $eur_was ?></span><small> rub</small></div>
        <div class="speedbox__now"><small>now </small> <span id="eur_now"><?= $eur_now ?></span><small> rub</small></div>
    </div>
    <div class="speedbox__start" id="eur_start"></div>
    <div class="speedbox__end" id="eur_end"></div>
    <div class="speedbox__base"></div>
</div>

</body>
<script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous">
</script>
<script>
    (function setUsdScore(){
        let curUsdNow = parseFloat($("#usd_now").text());
        let curUsdWas = parseFloat($("#usd_was").text());

        let maxCurUsd = curUsdNow > curUsdWas ? curUsdNow : curUsdWas;
        let minCurUsd = curUsdNow > curUsdWas ? curUsdWas : curUsdNow;

        let initScoreValues = getInitScoreValues(minCurUsd, maxCurUsd);
        let startScorePosition = initScoreValues.min;
        let endScorePosition = initScoreValues.max;

        usd_start.innerHTML = startScorePosition;
        usd_end.innerHTML = endScorePosition;

        let rotateScoreNowValue = getRotateDegree(curUsdNow, startScorePosition, endScorePosition);
        let rotateScoreWasValue = getRotateDegree(curUsdWas, startScorePosition, endScorePosition);

        $("#speedbox-score-usd-now").css("transform", "rotate(" + rotateScoreNowValue + "deg)");
        $("#speedbox-score-usd-was").css("transform", "rotate(" + rotateScoreWasValue + "deg)");

        let zindexNow = curUsdNow > curUsdWas? '1' : '3';
        let zindexWas = curUsdNow > curUsdWas? '3' : '1';

        $("#speedbox-score-usd-now").css("z-index", zindexNow);
        $("#speedbox-score-usd-was").css("z-index" , zindexWas);
    })();

    (function setEurScore(){
        let curEurNow = parseFloat($("#eur_now").text());
        let curEurWas = parseFloat($("#eur_was").text());

        let maxCurEur= curEurNow > curEurWas ? curEurNow : curEurWas;
        let minCurEur = curEurNow > curEurWas ? curEurWas : curEurNow;

        let initScoreValues = getInitScoreValues(minCurEur, maxCurEur);
        let startScorePosition = initScoreValues.min;
        let endScorePosition = initScoreValues.max;

        eur_start.innerHTML = startScorePosition;
        eur_end.innerHTML = endScorePosition;

        let rotateScoreNowValue = getRotateDegree(curEurNow, startScorePosition, endScorePosition);
        let rotateScoreWasValue = getRotateDegree(curEurWas, startScorePosition, endScorePosition);

        $("#speedbox-score-eur-now").css("transform", "rotate(" + rotateScoreNowValue + "deg)");
        $("#speedbox-score-eur-was").css("transform", "rotate(" + rotateScoreWasValue + "deg)");

        let zindexNow = curEurNow > curEurWas? '1' : '3';
        let zindexWas = curEurNow > curEurWas? '3' : '1';

        $("#speedbox-score-eur-now").css("z-index", zindexNow);
        $("#speedbox-score-eur-was").css("z-index" , zindexWas);
    })();

    function getRotateDegree(score, start, end){
        return ((Math.round(score * 10) / 10) - start) * 90/(end-start);
    }

    function getInitScoreValues(min, max){

        let startScorePosition = Math.floor(min);
        let endScorePosition = Math.ceil(max);
        console.log(max);
        console.log(endScorePosition);
        return {
            "min" : startScorePosition,
            "max" : endScorePosition
        }
    }


</script>
</html>
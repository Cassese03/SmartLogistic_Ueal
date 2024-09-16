<?php /* TIN04x5;01/08/2025;0*/
/* TIN04x5;01/08/2025;13GI24TIN04*/ ?>
<?php $magazzino_prova = DB::select('SELECT MG.*,MGUbicazione.Cd_MGUbicazione from MG LEFT JOIN MGUbicazione on MGUbicazione.Cd_MG = MG.Cd_MG'); ?>
<?php $magazzino_ord = DB::select('SELECT * from MG '); //TODO MANCANO GLI ALERT?>
    <!doctype html>
<html lang="en" class="md">

<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, user-scalable=no, shrink-to-fit=no, viewport-fit=cover">
    <link rel="apple-touch-icon" href="/img/icona_arca.png">
    <link rel="icon" href="/img/icona_arca.png">
    <link rel="stylesheet" href="/vendor/bootstrap-4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="/vendor/materializeicon/material-icons.css">
    <link rel="stylesheet" href="/vendor/swiper/css/swiper.min.css">
    <link id="theme" rel="stylesheet" href="/css/style.css" type="text/css">
    <title>SMART LOGISTIC</title>
    <div
        style="position: fixed;top: 0px;left: 0px;width: 100%;height: 100%;background: rgba(255, 255, 255,1);z-index: 1000000000;display: none;"
        id="ajax_loader">

        <img src="<?php echo URL::asset('img/icona_arca.png') ?>" alt="AdminLTE Logo"
             style="width:400px;margin:0 auto;display:block;margin-top:200px;">
        <h2 style="text-align:center;margin-top:10px;">Operazione In Corso....</h2>
    </div>
</head>

<style>
    @charset "UTF-8";

    .collapsable-source pre {
        font-size: small;
    }

    .input-field {
        display: flex;
        align-items: center;
        width: 260px;
    }

    .input-field label {
        flex: 0 0 auto;
        padding-right: 0.5rem;
    }

    .input-field input {
        flex: 1 1 auto;
        height: 20px;
    }

    .input-field button {
        flex: 0 0 auto;
        height: 28px;
        font-size: 20px;
        width: 40px;
    }

    .icon-barcode {
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center center;
        background-image: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz48IURPQ1RZUEUgc3ZnIFBVQkxJQyAiLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4iICJodHRwOi8vd3d3LnczLm9yZy9HcmFwaGljcy9TVkcvMS4xL0RURC9zdmcxMS5kdGQiPjxzdmcgdmVyc2lvbj0iMS4xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB3aWR0aD0iMzIiIGhlaWdodD0iMzIiIHZpZXdCb3g9IjAgMCAzMiAzMiI+PHBhdGggZD0iTTAgNGg0djIwaC00ek02IDRoMnYyMGgtMnpNMTAgNGgydjIwaC0yek0xNiA0aDJ2MjBoLTJ6TTI0IDRoMnYyMGgtMnpNMzAgNGgydjIwaC0yek0yMCA0aDF2MjBoLTF6TTE0IDRoMXYyMGgtMXpNMjcgNGgxdjIwaC0xek0wIDI2aDJ2MmgtMnpNNiAyNmgydjJoLTJ6TTEwIDI2aDJ2MmgtMnpNMjAgMjZoMnYyaC0yek0zMCAyNmgydjJoLTJ6TTI0IDI2aDR2MmgtNHpNMTQgMjZoNHYyaC00eiI+PC9wYXRoPjwvc3ZnPg==);
    }

    .overlay {
        overflow: hidden;
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        width: 100%;
        background-color: rgba(0, 0, 0, 0.3);
    }

    .overlay__content {
        top: 50%;
        position: absolute;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 90%;
        max-height: 90%;
        max-width: 800px;
    }

    .overlay__close {
        position: absolute;
        right: 0;
        padding: 0.5rem;
        width: 2rem;
        height: 2rem;
        line-height: 2rem;
        text-align: center;
        background-color: white;
        cursor: pointer;
        border: 3px solid black;
        font-size: 1.5rem;
        margin: -1rem;
        border-radius: 2rem;
        z-index: 100;
        box-sizing: content-box;
    }

    .overlay__content video {
        width: 100%;
        height: 100%;
    }

    .overlay__content canvas {
        position: absolute;
        width: 100%;
        height: 100%;
        left: 0;
        top: 0;
    }

    #interactive.viewport {
        position: relative;
    }

    #interactive.viewport > canvas, #interactive.viewport > video {
        max-width: 100%;
        width: 100%;
    }

    canvas.drawing, canvas.drawingBuffer {
        position: absolute;
        left: 0;
        top: 0;
    }

    /* line 16, ../sass/_viewport.scss */
    .controls fieldset {
        border: none;
        margin: 0;
        padding: 0;
    }

    /* line 19, ../sass/_viewport.scss */
    .controls .input-group {
        float: left;
        autocomplete: off;

    }

    /* line 21, ../sass/_viewport.scss */
    .controls .input-group input, .controls .input-group button {
        display: block;
        autocomplete: off;

    }

    /* line 25, ../sass/_viewport.scss */
    .controls .reader-config-group {
        float: right;
    }

    /* line 28, ../sass/_viewport.scss */
    .controls .reader-config-group label {
        display: block;
    }

    /* line 30, ../sass/_viewport.scss */
    .controls .reader-config-group label span {
        width: 9rem;
        display: inline-block;
        text-align: right;
    }

    /* line 37, ../sass/_viewport.scss */
    .controls:after {
        content: '';
        display: block;
        clear: both;
    }

    /* line 22, ../sass/_viewport.scss */
    #result_strip {
        margin: 10px 0;
        border-top: 1px solid #EEE;
        border-bottom: 1px solid #EEE;
        padding: 10px 0;
    }

    /* line 28, ../sass/_viewport.scss */
    #result_strip ul.thumbnails {
        padding: 0;
        margin: 0;
        list-style-type: none;
        width: auto;
        overflow-x: auto;
        overflow-y: hidden;
        white-space: nowrap;
    }

    /* line 37, ../sass/_viewport.scss */
    #result_strip ul.thumbnails > li {
        display: inline-block;
        vertical-align: middle;
        width: 160px;
    }

    /* line 41, ../sass/_viewport.scss */
    #result_strip ul.thumbnails > li .thumbnail {
        padding: 5px;
        margin: 4px;
        border: 1px dashed #CCC;
    }

    /* line 46, ../sass/_viewport.scss */
    #result_strip ul.thumbnails > li .thumbnail img {
        max-width: 140px;
    }

    /* line 49, ../sass/_viewport.scss */
    #result_strip ul.thumbnails > li .thumbnail .caption {
        white-space: normal;
    }

    /* line 51, ../sass/_viewport.scss */
    #result_strip ul.thumbnails > li .thumbnail .caption h4 {
        text-align: center;
        word-wrap: break-word;
        height: 40px;
        margin: 0px;
    }

    /* line 61, ../sass/_viewport.scss */
    #result_strip ul.thumbnails:after {
        content: "";
        display: table;
        clear: both;
    }

    @media (max-width: 603px) {
        /* line 2, ../sass/phone/_core.scss */
        #container {
            margin: 10px auto;
            -moz-box-shadow: none;
            -webkit-box-shadow: none;
            box-shadow: none;
        }
    }

    @media (max-width: 603px) {
        /* line 5, ../sass/phone/_viewport.scss */
        .reader-config-group {
            width: 100%;
        }

        .reader-config-group label > span {
            width: 50%;
        }

        .reader-config-group label > select, .reader-config-group label > input {
            autocomplete: off;
            max-width: calc(50% - 2px);
        }

        #interactive.viewport {
            width: 100%;
            height: auto;
            overflow: hidden;
        }

        /* line 20, ../sass/phone/_viewport.scss */
        #result_strip {
            margin-top: 5px;
            padding-top: 5px;
        }

        #result_strip ul.thumbnails {
            width: 100%;
            height: auto;
        }

        /* line 24, ../sass/phone/_viewport.scss */
        #result_strip ul.thumbnails > li {
            width: 150px;
        }

        /* line 27, ../sass/phone/_viewport.scss */
        #result_strip ul.thumbnails > li .thumbnail .imgWrapper {
            width: 130px;
            height: 130px;
            overflow: hidden;
        }

        /* line 31, ../sass/phone/_viewport.scss */
        #result_strip ul.thumbnails > li .thumbnail .imgWrapper img {
            margin-top: -25px;
            width: 130px;
            height: 180px;
        }
    }
</style>

<body class="color-theme-blue push-content-right theme-light" style="font-size: 18px;">

<audio controls hidden="hidden" id="successAudio">
    <source src="/audio/success.mp3" type="audio/mpeg">
    Your browser does not support the audio tag.
</audio>

<audio controls hidden="hidden" id="errorAudio">
    <source src="/audio/error.mp3" type="audio/mpeg">
    Your browser does not support the audio tag.
</audio>

<div class="loader justify-content-center ">
    <div class="maxui-roller align-self-center">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>
</div>
<div class="wrapper">

    <!-- page main start -->

    <div class="page">
        <form class="searchcontrol">
            <div class="input-group">
                <div class="input-group-prepend">
                    <button type="button" class="input-group-text close-search"><i class="material-icons">keyboard_backspace</i>
                    </button>
                </div>
                <input type="text" id="cerca" class="form-control border-0" placeholder="Cerca Fornitore..."
                       aria-label="Username" autocomplete="off" ;>
            </div>
        </form>
        <header class="row m-0 fixed-header">
            <div class="left">
                <a style="padding-left:20px;" href="/magazzino"><i class="material-icons">arrow_back_ios</i></a>
            </div>
            <div class="col center">
                <a href="#" class="logo">
                    <figure><img src="/img/logo_arca.png" alt=""></figure>
                    Aggiungi Articoli</a>
            </div>
            <div class="right">
                <a style="padding-left:20px;" href="/"><i class="material-icons">home</i></a>
            </div>
        </header>

        <div class="page-content">
            <div class="content-sticky-footer">

                <input style="width:1px;height: 1px" type="text" id="cerca_articolo2" onkeyup="check();" autofocus
                       autocomplete="off">
                <div class="background bg-125"><img src="/img/background.png" alt=""></div>
                <div class="w-100">
                    <h1 class="text-center text-white title-background"><?php echo $fornitore->Descrizione ?>
                        <br><small><?php echo $documento->Cd_Do ?> N.<?php echo $documento->NumeroDoc ?>
                            Del <?php echo date('d/m/Y', strtotime($documento->DataDoc)) ?></small></h1>
                </div>
                <form method="post" id="session" style="margin: 2%;display: none">
                    <input type="hidden" name="change_mg_session" value="change_mg_session">
                    <div style="width: 90%;display: flex;gap: 5%;margin:2% 5% 0 5%">
                        <div style="width: 90%;">
                            <label for="cd_mg_p" style="font-weight: bolder;">
                                Codice Magazzino Partenza
                            </label>
                            <input value="{{ $session_mag['cd_mg_p'] }}" class="form-control" id="cd_mg_p"
                                   autocomplete="off"
                                   name="cd_mg_p" onblur="change_mag()"
                                   list="magazzini_partenza">
                            <datalist id="magazzini_partenza">
                                @foreach($magazzini as $m)
                                    <option value="{{$m->Cd_MG}}"> {{$m->Descrizione}}</option>
                                @endforeach
                            </datalist>
                        </div>
                        <div style="width: 90%;">
                            <label for="cd_mg_a" style="font-weight: bolder;">
                                Codice Magazzino di Arrivo
                            </label>
                            <input value="{{ $session_mag['cd_mg_a'] }}" class="form-control" id="cd_mg_a"
                                   autocomplete="off"
                                   name="cd_mg_a" onblur="change_mag('cd_mg_a')"
                                   list="magazzini_arrivo">
                            <datalist id="magazzini_arrivo">
                                @foreach($magazzini as $m)
                                    <option value="{{$m->Cd_MG}}"> {{$m->Descrizione}}</option>
                                @endforeach
                            </datalist>
                        </div>
                        <div style="width: 90%;">
                            <label for="doc_evadi" style="font-weight: bolder;">
                                Documento da evadere in
                            </label>
                            <input value="{{ $session_mag['doc_evadi'] }}" class="form-control" id="doc_evadi"
                                   autocomplete="off"
                                   name="doc_evadi" onblur="change_mag('doc_evadi')"
                                   list="doc_evasione">
                            <datalist id="doc_evasione">
                                @foreach($flusso as $f)
                                    <option class="form-control" type="text"
                                            value="{{$f->Cd_DO}}">{{$f->Cd_DO}}</option>
                                @endforeach
                            </datalist>
                        </div>
                    </div>
                </form>


                <!--
                <fieldset class="reader-config-group" style="margin-top:50px;">
                    <label>
                        <span>Barcode-Type</span>
                        <select name="decoder_readers">
                            <option value="ean">EAN</option>
                            <option value="ean_8">EAN-8</option>
                        </select>
                    </label>
                </fieldset>
                -->

                <button
                    style="margin-top:10px !important;width:80%;margin:auto;display:block;background-color:lightblue;border:lightblue"
                    class="btn btn-primary" type="button"
                    onclick="url = window.location.href; pos = url.search('/magazzino'); url = url.substring(0,pos);
                    top.location.href = url + '/magazzino/carico04/'+'<?php echo $fornitore->Id_CF ?>'+'/'+'<?php echo $id_dotes ?>';">
                    Cambia Modalitá (Aggiungi a Documento)
                </button>
                <button
                    style="margin-top:10px !important;width:80%;margin:0 auto;display:block;background-color:red;border: red"
                    class="btn btn-primary" type="button" onclick="evadi_articolo2('1');">Conferma Evasione Righe
                </button>
                <input type="hidden" id="DORIG" value="">
                <input type="hidden" id="lung" value="0">
                <?php if (sizeof($documento->righe) > 0){ ?>

                <div class="row">

                    <div class="col-sm-6 col-xl-12" style="margin-top:5px;">
                        <ul class="list-group" id="lista">

                                <?php foreach ($documento->righe as $r){
                                $totale = 0; ?>
                                <?php if ($r->QtaEvadibile > 0){ ?>
                            <input type="hidden"
                                   id="qta_max_evad_<?php echo $r->Id_DORig; ?>"
                                   value="<?php echo $r->QtaEvadibile;?>">

                            <li class="list-group-item" id="riga_<?php echo $r->Id_DORig ?>">
                                <a href="#" onclick="" class="media">
                                    <div class="media-body">
                                        <div class="row">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-xl-12"
                                                 style="text-align: center;">

                                                <div style="text-align: center;color: blue;"
                                                     id="riga_<?php echo $r->Id_DORig; ?>_counter"></div>
                                                <h4 <?php if ($r->QtaEvadibile == 0) echo 'style="color: red"' ?>><?php echo $r->Cd_AR . '<br> '; ?> </h4>
                                                <h5 <?php if ($r->QtaEvadibile == 0) echo 'style="color: red"' ?>>

                                                        <?php echo $r->Descrizione; ?>
                                                    <br><?php echo 'Prezzo :' . round(floatval($r->PrezzoUnitarioV), 2); ?>
                                                    @if($r->Cd_ARLotto != '')
                                                            <?php echo '<br> Lotto : ' . $r->Cd_ARLotto; ?>
                                                    @endif
                                                    @if($r->Data_Scadenza != '')
                                                            <?php echo '<br> Data Scadenza : ' . date('d/m/Y', strtotime($r->Data_Scadenza)); ?>
                                                    @endif

                                                    <br> Qta
                                                    : <?php echo floatval($r->QtaEvadibile) ?><?php /* echo  'Magazzino di Partenza: '.$r->Cd_MG_P;if($r->Cd_MGUbicazione_A != null) echo ' - '.$r->Cd_MGUbicazione_A;?><br><?php echo' Magazzino di Arrivo: '.$r->Cd_MG_A;?><br><?php if($r->Cd_ARLotto != Null)echo 'Lotto: '.$r->Cd_ARLotto;*/ ?>
                                                </h5>

                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-xl-12"
                                                 style="padding-left: 10px">
                                                <form method="post"
                                                      onsubmit="return confirm('Vuoi Eliminare Questa Riga ?')">
                                                    <div class="row">
                                                        <input type="hidden" id="codice"
                                                               value="<?php echo $r->Cd_AR ?>">
                                                        <button type="reset" name="segnalazione"
                                                                value=""
                                                                class="btn btn-warning btn-sm col-3"
                                                                onclick="rimuoviLotto('<?php echo $r->Id_DORig?>')">
                                                            <i class="fa fa-exclamation-triangle" aria-hidden="true">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                     height="16" fill="currentColor"
                                                                     class="bi bi-exclamation-triangle"
                                                                     viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.146.146 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.163.163 0 0 1-.054.06.116.116 0 0 1-.066.017H1.146a.115.115 0 0 1-.066-.017.163.163 0 0 1-.054-.06.176.176 0 0 1 .002-.183L7.884 2.073a.147.147 0 0 1 .054-.057zm1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566z"/>
                                                                    <path
                                                                        d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995z"/>
                                                                </svg>
                                                            </i>
                                                        </button>
                                                        <button type="reset" name="modifica_riga"
                                                                value="<?php echo $r->Cd_AR;?>"
                                                                class="btn btn-primary btn-sm col-3"
                                                                onclick="$('#modal_modifica_<?php echo $r->Id_DORig ?>').modal('show');">
                                                            <i class="bi bi-pencil">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                     height="16" fill="currentColor"
                                                                     class="bi bi-pencil"
                                                                     viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                                                </svg>
                                                            </i>
                                                        </button>
                                                        <button type="reset" name="evadi_riga"
                                                                value="<?php echo $r->Cd_AR;?>"
                                                                class="btn btn-success btn-sm col-3"
                                                                onclick="controllo_articolo_smart2('<?php echo $r->Cd_AR?>;0;<?php echo ($r->Cd_ARLotto) ? $r->Cd_ARLotto :'0' ?>')">
                                                            <i class="bi bi-check-circle">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                     height="16" fill="currentColor"
                                                                     class="bi bi-check-circle" viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                                    <path
                                                                        d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                                                                </svg>
                                                            </i>
                                                        </button>
                                                        <input type="hidden" name="Id_DORig"
                                                               value="<?php echo $r->Id_DORig ?>">
                                                        <button type="submit" name="elimina_riga"
                                                                value="Elimina" class="btn btn-danger btn-sm col-3">
                                                            <i class="bi bi-trash-fill">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                     height="16" fill="currentColor"
                                                                     class="bi bi-trash-fill" viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                                                </svg>
                                                            </i>
                                                        </button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <?php } ?>
                            <?php } ?>
                        </ul>
                    </div>
                </div>


                <?php } ?>
                {{--
                                <button
                                    style="margin-top:10px !important;width:80%;margin:0 auto;display:block;background-color:violet;border: violet"
                                    class="btn btn-primary" onclick="$('#modal_inserisci_scatole').modal('show');">Inserire Scatoli
                                </button>--}}
                <?php if (sizeof($documento->righe) > 0){ ?>
                <button
                    style="margin-top:10px !important;width:80%;margin:0 auto;display:block;background-color:#007bff;border: #007bff"
                    class="btn btn-primary" onclick="$('#modal_salva_documento').modal('show');">Salva Documento
                </button>
                <?php } ?>
                {{--<?php if ($documento->Cd_Do == 'OVC'){ ?>
                <button
                    style="margin-top:10px !important;width:80%;margin:0 auto;display:block;background-color:#007bff;border: #007bff"
                    class="btn btn-primary" onclick="$('#modal_stampa_documento').modal('show');">Stampa Documento
                </button>
                <?php } ?>--}}
            </div>
        </div>

    </div>
    <!-- page main ends -->

</div>


<div class="modal" id="modal_cerca_articolo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Carica Articolo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="$('#modal_cerca_articolo').modal('hide');$('#cerca_articolo2').val('');$('#cerca_articolo2').focus()">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">

                <label>Cerca Articolo</label>
                <input class="form-control" type="text" id="cerca_articolo" value=""
                       placeholder="Inserisci barcode,codice o nome dell'articolo" autocomplete="off" autofocus>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        onclick="$('#modal_cerca_articolo').modal('hide');$('#cerca_articolo2').val('');$('#cerca_articolo2').focus()">
                    Chiudi
                </button>
                <button type="button" class="btn btn-primary" onclick="cerca_articolo_smart_automatico();">Cerca
                    Articolo
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modal_lista_articoli_daevadere" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Articolo da Evadere</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            onclick="$('#modal_lista_articoli_daevadere').modal('hide');$('#cerca_articolo2').val('');$('#cerca_articolo2').focus()">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" style="display: none" id="ajax_lista_articoli"></div>
                <div class="modal-body">

                    <label>Articolo</label>
                    <input class="form-control" type="text" id="modal_controllo_articolo" value="" autocomplete="off"
                           readonly>

                    <label>Quantita</label>
                    <input class="form-control" type="text" id="modal_controllo_quantita" value="" autocomplete="off">

                    <label>Lotto</label>
                    <input class="form-control" list="modal_list_controllo_lotto" id="modal_controllo_lotto"
                           onchange="change_scad()">
                    <datalist id="modal_list_controllo_lotto"></datalist>

                    <label>Data Scadenza</label>
                    <select class="form-control" id="modal_controllo_data_scadenza" autocomplete="off">
                    </select>

                    <input class="form-control" type="hidden" id="modal_controllo_dorig" value="" autocomplete="off"
                           readonly>


                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                            onclick="$('#modal_lista_articoli_daevadere').modal('hide');$('#cerca_articolo2').val('');$('#cerca_articolo2').focus()">
                        Chiudi
                    </button>
                    <button type="button" class="btn btn-primary"
                            onclick="$('#modal_lista_articoli_daevadere').modal('hide');$('#cerca_articolo2').val('');$('#cerca_articolo2').focus();evadi_articolo2('0');">
                        Evadi Riga
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal" id="modal_salva_documento" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Salvataggio Documento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            onclick="$('#modal_salva_documento').modal('hide');$('#cerca_articolo2').val('');$('#cerca_articolo2').focus()">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">
                    <label>Vuoi salvare il documento?</label>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                            onclick="$('#modal_salva_documento').modal('hide');$('#cerca_articolo2').val('');$('#cerca_articolo2').focus()">
                        No
                    </button>
                    <button type="button" class="btn btn-primary" onclick="salva_documento()">Si</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal" id="modal_inserisci_scatole" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Inserire Scatoloni</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            onclick="$('#modal_inserisci_scatole').modal('hide');$('#cerca_articolo2').val('');$('#cerca_articolo2').focus()">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row" style="margin: 2%">
                        @foreach($scatoli as $s)
                            <div class="col-xl-4 col-xs-4" style="padding: 1%">
                                <input type="text" readonly class="form-control"
                                       id="ar_scatolo_{{$s->Cd_AR}}"
                                       value="<?php echo $s->Cd_AR ?>">
                            </div>
                            <div class="col-xl-6 col-xs-6" style="padding: 1%">
                                <input type="text" readonly class="form-control"
                                       id="desc_scatolo_{{$s->Cd_AR}}"
                                       value="<?php echo $s->Descrizione?>">
                            </div>
                            <div class="col-xl-2 col-xs-2" style="padding: 1%">
                                <input type="number" class="form-control" step="1" min="0" max="99"
                                       id="qta_scatolo_{{$s->Cd_AR}}" value="0">
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                            onclick="$('#modal_inserisci_scatole').modal('hide');$('#cerca_articolo2').val('');$('#cerca_articolo2').focus()">
                        No
                    </button>
                    <button type="button" class="btn btn-primary" onclick="salva_scatoloni()">Si</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal" id="modal_stampa_documento" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Stampa Documento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            onclick="$('#modal_stampa_documento').modal('hide');$('#cerca_articolo2').val('');$('#cerca_articolo2').focus()">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">

                    <label>Vuoi Stampare il Documento ? </label>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                            onclick="$('#modal_stampa_documento').modal('hide');$('#cerca_articolo2').val('');$('#cerca_articolo2').focus()">
                        No
                    </button>
                    <button type="button" class="btn btn-primary"
                            onclick="top.location.href='/ajax/stampe/'+'<?php echo$id_dotes ?>';">Si
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal" id="modal_lista_salva" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Righe non Evase</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            onclick="$('#modal_lista_salva').modal('hide');$('#cerca_articolo2').val('');$('#cerca_articolo2').focus()">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body" id="ajax_lista_documenti_1">
                </div>
                <?php foreach ($documento->righe as $r) { ?>
                <input type="hidden" name="modal_Cd_ARLotto_c_<?php echo $r->Id_DORig?>"
                       id="modal_Cd_ARLotto_c_<?php echo $r->Id_DORig?>">
                <input type="hidden" name="modal_Cd_AR_c_<?php echo $r->Id_DORig?>"
                       id="modal_Cd_AR_c_<?php echo $r->Id_DORig?>">
                <input type="hidden" name="modal_Qta_c_<?php echo $r->Id_DORig?>"
                       id="modal_Qta_c_<?php echo $r->Id_DORig?>">
                <input type="hidden" name="modal_QtaEvasa_c_<?php echo $r->Id_DORig?>"
                       id="modal_QtaEvasa_c_<?php echo $r->Id_DORig?>">
                <input type="hidden" name="modal_QtaEvadibile_c_<?php echo $r->Id_DORig?>"
                       id="modal_QtaEvadibile_c_<?php echo $r->Id_DORig?>">
                <input type="hidden" name="modal_Prezzo_c_<?php echo $r->Id_DORig?>"
                       id="modal_Prezzo_c_<?php echo $r->Id_DORig?>">
                <?php } ?>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                            onclick="$('#modal_lista_salva').modal('hide');$('#cerca_articolo2').val('');$('#cerca_articolo2').focus()">
                        Chiudi
                    </button>
                    <button type="button" class="btn btn-primary" onclick="checkDoc();invia()">Salva Documento</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal" id="modal_lista_documenti" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Righe da Evadere</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            onclick="$('#modal_lista_documenti').modal('hide');$('#cerca_articolo2').val('');$('#cerca_articolo2').focus()">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body" id="ajax_lista_documenti"></div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                            onclick="$('#modal_lista_documenti').modal('hide');$('#cerca_articolo2').val('');$('#cerca_articolo2').focus()">
                        Chiudi
                    </button>
                    <button type="button" class="btn btn-primary" onclick="evadi_documento1()">Evadi Documento</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php foreach ($documento->righe as $r){ ?>
<div class="modal" id="modal_segnalazione<?php echo $r->Id_DORig?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Segnalazione</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            onclick="$('#modal_segnalazione<?php echo $r->Id_DORig?>').modal('hide');$('#cerca_articolo2').val('');$('#cerca_articolo2').focus()">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">

                    <input type="number" class="form-control" id="Segnala_riga" value="<?php echo $r->Id_DORig;?>"
                           readonly><br>
                    <input type="text" class="form-control" id="Segnalazione" value=""
                           placeholder="Inserire Segnalazione..." autofocus autocomplete="off">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                            onclick="$('#modal_segnalazione<?php echo $r->Id_DORig?>').modal('hide');$('#cerca_articolo2').val('');$('#cerca_articolo2').focus()">
                        Chiudi
                    </button>
                    <button type="button" class="btn btn-primary" onclick="segnalazione();">Invia Segnalazione</button>
                </div>

            </div>
        </form>
    </div>
</div>
<?php } ?>

<?php foreach ($documento->righe as $r){ ?>
<div class="modal" id="modal_rimuovi_lotto_<?php echo $r->Id_DORig?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Rimuovi Lotto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            onclick="$('#modal_rimuovi_lotto_<?php echo $r->Id_DORig?>').modal('hide');$('#cerca_articolo2').val('');$('#cerca_articolo2').focus()">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div id="ajax_rimuovi_lotti<?php echo $r->Id_DORig ?>"></div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                            onclick="$('#modal_rimuovi_lotto_<?php echo $r->Id_DORig?>').modal('hide');$('#cerca_articolo2').val('');$('#cerca_articolo2').focus()">
                        Chiudi
                    </button>
                    {{--<button type="button" class="btn btn-primary" onclick="">Cambia Lotti</button>--}}
                </div>

            </div>
        </form>
    </div>
</div>
<?php } ?>


<div class="modal" id="modal_carico" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Carica Articolo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="$('#modal_carico').modal('hide');$('#cerca_articolo2').val('');$('#cerca_articolo2').focus()">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="ajax_modal_carico"></div>
                <input type="hidden" name="Cd_AR" id="modal_Cd_AR" value="">
                <label>Quantita</label>
                <input class="form-control" type="number" id="modal_quantita" value="" required
                       placeholder="Inserisci una Quantità" autocomplete="off">
                <input type="hidden" value="0" id="modal_lotto">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        onclick="$('#modal_carico').modal('hide');$('#cerca_articolo2').val('');$('#cerca_articolo2').focus()">
                    Chiudi
                </button>
                <button type="button" class="btn btn-primary" onclick="carica_articolo();">Carica Articolo</button>
            </div>
        </div>
    </div>
</div>


<div class="modal" id="modal_inserimento" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Articolo Mancante</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">
                    <input class="form-control" type="text" id="modal_inserimento_barcode" value="" autocomplete="off"
                           ;>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                    <button type="button" class="btn btn-primary" onclick="crea_articolo();">Crea Articolo</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php foreach ($documento->righe as $r) { ?>
<div class="modal" id="modal_modifica_<?php  echo $r->Id_DORig ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modifica Articolo <?php echo $r->Cd_AR ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            onclick="$('#modal_modifica_<?php  echo $r->Id_DORig ?>').modal('hide');$('#cerca_articolo2').val('');$('#cerca_articolo2').focus()">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="ajax_modal_modifica"></div>

                    <label>Quantita</label>
                    <input class="form-control" type="number" name="Qta" value="<?php echo floatval($r->Qta) ?>"
                           required placeholder="Inserisci una Quantità" autocomplete="off" step="0.01">

                        <?php /*
                    <label>Quantita Evadibile</label>
                    <input class="form-control" type="number" name="QtaEvadibile" value="<?php echo floatval($r->QtaEvadibile) ?>" required placeholder="Inserisci una Quantità" autocomplete="off" step="0.01" >

                    <label>Prezzo</label>
                    <input class="form-control" type="number" name="PrezzoUnitarioV" value="<?php echo round(floatval($r->PrezzoUnitarioV), 2); ?>" required placeholder="Inserisci un Prezzo" autocomplete="off" step="0.01" >
*/ ?>
                    <input class="form-control" type="hidden" name="modal_lotto_m" value="0" autocomplete="off">

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="Id_DORig" value="<?php echo $r->Id_DORig ?>">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                            onclick="$('#modal_modifica_<?php  echo $r->Id_DORig ?>').modal('hide');$('#cerca_articolo2').val('');$('#cerca_articolo2').focus()">
                        Chiudi
                    </button>
                    <button type="submit" name="modifica_riga" value="Salva" class="btn btn-primary">Salva</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php } ?>

<?php foreach ($documento->righe as $r) { ?>
<div class="modal" id="modal_evadi_riga_<?php  echo $r->Id_DORig ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Evadi Articolo <?php echo $r->Cd_AR ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            onclick="$('#modal_evadi_riga_<?php  echo $r->Id_DORig ?>').modal('hide');$('#cerca_articolo2').val('');$('#cerca_articolo2').focus()">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="ajax_modal_evadi_riga_<?php  echo $r->Id_DORig ?>"></div>

                    <label>Quantita</label>
                    <input class="form-control" type="number" id="modal_Qta_<?php  echo $r->Id_DORig ?>" min="0"
                           max="<?php echo floatval($r->QtaEvadibile)?>"
                           value="<?php echo floatval($r->QtaEvadibile) ?>" required
                           placeholder="Inserisci la Quantità da evadere" step="0.01">
                    <br>
                    <label>Documento da Evadere in :</label>
                    <select style="width:100%;border:none;font-size:medium;background:transparent;"
                            id="modal_inserimento_flusso_<?php  echo $r->Id_DORig ?>">
                            <?php foreach ($flusso as $f){ ?>
                        <option class="form-control" type="text"
                                value="<?php echo $f->Cd_DO ?>"><?php echo $f->Cd_DO ?></option>
                        <?php } ?>
                    </select>
                    <br><br>
                    <input type="hidden" id="modal_inserimento_magazzino_<?php echo $r->Id_DORig?>" value="00001">
                    <input type="hidden" id="modal_magazzino_<?php  echo $r->Id_DORig ?>"
                           value="<?php if(str_replace(" ","",$documento->Cd_Do) == 'OF') echo $r->Cd_MG_A; if(str_replace(" ","",$documento->Cd_Do) == 'OC') echo $r->Cd_MG_P ;?>">
                    <input type="hidden" id="modal_codice_<?php  echo $r->Id_DORig ?>" value="<?php echo $r->Cd_AR?>">
                    <input type="hidden" id="modal_ubicazione_<?php  echo $r->Id_DORig ?>"
                           value="<?php echo $r->Cd_MGUbicazione_A?>">
                    <input type="hidden" id="modal_lotto_<?php  echo $r->Id_DORig ?>"
                           value="<?php if($r->Cd_ARLotto!=null)echo $r->Cd_ARLotto; else echo '0'?>">
                    <!--

                    <input type="hidden" id="modal_PrezzoUnitarioV_<?php echo $r->Id_DORig ?>" value="<?php echo $r->PrezzoUnitarioV ?>">
-->


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" style="width: 33%" data-dismiss="modal"
                            onclick="$('#modal_evadi_riga_<?php  echo $r->Id_DORig ?>').modal('hide');$('#cerca_articolo2').val('');$('#cerca_articolo2').focus()">
                        Chiudi
                    </button>
                    <button type="button" class="btn btn-primary" style="width: 33%"
                            onclick="evadi_articolo(<?php echo $r->Id_DORig; ?>);">Evadi
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php } ?>

<div class="modal" id="modal_conf_riga" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Evadi Documento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            onclick="$('#modal_conf_riga').modal('hide');$('#cerca_articolo2').val('');$('#cerca_articolo2').focus()">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label>Magazzino di Partenza</label>
                    <input type="text" readonly value="{{$session_mag['cd_mg_p'] }}"
                           style="width:100%;border:none;font-size:medium;background:transparent;">
                    <br><br>
                    <label>Magazzino di Arrivo</label>
                    <input type="text" readonly value="{{$session_mag['cd_mg_a'] }}"
                           style="width:100%;border:none;font-size:medium;background:transparent;">
                    <br><br>
                    <label>Documento da Evadere in :</label>
                    <input type="text" readonly value="{{$session_mag['doc_evadi'] }}"
                           style="width:100%;border:none;font-size:medium;background:transparent;">
                    <br><br>
                    <div id="error_evasione"></div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" style="width: 33%" data-dismiss="modal"
                            onclick="$('#modal_conf_riga').modal('hide');$('#cerca_articolo2').val('');$('#cerca_articolo2').focus()">
                        Chiudi
                    </button>
                    <button type="button" class="btn btn-primary" style="width: 33%"
                            onclick="conferma_righe();">Evadi
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal" id="modal_segnalare" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Articolo non Trovato</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            onclick="$('#modal_segnalare').modal('hide');$('#cerca_articolo2').val('');$('#cerca_articolo2').focus()">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">
                    Vuoi effettuare una segnalazione?<br>
                    <input type="hidden" class="form-control" id="id_dotes_C" value=""
                           placeholder="Vuoi Effettuare la segnalazione?" autofocus autocomplete="off">
                    <input type="hidden" class="form-control" id="Segnalazione_C" value=""
                           placeholder="Vuoi Effettuare la segnalazione?" autofocus autocomplete="off">
                    <input type="hidden" class="form-control" id="id_dorig_C" value=""
                           placeholder="Vuoi Effettuare la segnalazione?" autofocus autocomplete="off">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                            onclick="$('#modal_segnalare').modal('hide');$('#cerca_articolo2').val('');$('#cerca_articolo2').focus()">
                        Chiudi
                    </button>
                    <button type="button" class="btn btn-primary" onclick="segnalazioneControllo1();">Invia
                        Segnalazione
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>


<div class="modal" id="modal_numero_colli" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Numero Colli Documento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            onclick="$('#modal_numero_colli').modal('hide');$('#cerca_articolo2').val('');$('#cerca_articolo2').focus()">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="ajax_numero_colli">
                    <label>Vuoi inserire il numero dei colli ?</label>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" style="width: 33%" data-dismiss="modal"
                            onclick="$('#modal_numero_colli').modal('hide');$('#cerca_articolo2').val('');$('#cerca_articolo2').focus()">
                        No
                    </button>
                    <button type="button" class="btn btn-primary" style="width: 33%"
                            onclick="invia_numero_colli();">Si
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal" id="modal_peso" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Inserire Peso</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            onclick="$('#modal_peso').modal('hide');$('#cerca_articolo2').val('');$('#cerca_articolo2').focus()">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="ajax_peso">
                    <label>Vuoi inserire il peso ?</label>
                    <input type="number" class="form-control" step="0.01" min="0" id="peso_documento" value="0">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" style="width: 33%" data-dismiss="modal"
                            onclick="$('#modal_peso').modal('hide');top.location.reload();">
                        No
                    </button>
                    <button type="button" class="btn btn-primary" style="width: 33%"
                            onclick="invia_peso();">Si
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal" id="modal_noriga" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="alert alert-warning alert-dismissible fade show">
        <button type="button" class="close"
                onclick="$('#modal_noriga').modal('hide');$('#cerca_articolo2').val('');$('#cerca_articolo2').focus()">
            &times;
        </button>
        <strong>Warning!</strong> <br>Non hai scelto nessuna riga da evadere</a>.
    </div>
</div>

<div class="modal" id="modal_alertEvasione" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="alert alert-success alert-dismissible fade show">
        <button type="button" class="close"
                onclick="$('#modal_alertEvasione').modal('hide');$('#cerca_articolo2').val('');$('#cerca_articolo2').focus() ">
            &times;
        </button>
        <strong>Warning!</strong> <br>La riga è gia' in fase di evasione</a>.
    </div>
</div>
<div class="modal" id="modal_alertMaxEvasione" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="alert alert-success alert-dismissible fade show">
        <button type="button" class="close"
                onclick="$('#modal_alertMaxEvasione').modal('hide');$('#cerca_articolo2').val('');$('#cerca_articolo2').focus() ">
            &times;
        </button>
        <strong>Warning!</strong> <br>La riga ha raggiunto il massimo della quantità evadibile</a>.
    </div>
</div>
<div class="modal" id="modal_alertSegnalazione" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="alert alert-success alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert"
                onclick="$('#modal_alertSegnalazione').modal('hide');$('#cerca_articolo2').val('');$('#cerca_articolo2').focus()">
            &times;
        </button>
        <strong>Success!</strong> <br>Segnalazione Effettuata</a>.
    </div>
</div>

<div class="modal" id="modal_alertEvase" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="alert alert-success alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert" onclick="location.reload()">&times;</button>
        <strong>Success!</strong> <br>Le righe sono state completamente Evase</a>.
    </div>
</div>

<div class="modal" id="modal_alertQuantita" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="alert alert-warning alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert"
                onclick="$('#modal_alertQuantita').modal('hide');$('#cerca_articolo2').val('');$('#cerca_articolo2').focus()">
            &times;
        </button>
        <strong>Alert!</strong> <br>Inserire una quantita </a>.
    </div>
</div>

<div class="modal" id="modal_alertInserimento" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="alert alert-success alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert" onclick="location.reload()">&times;</button>
        <strong>Success!</strong> <br>Articolo Inserito Correttamente</a>.
    </div>
</div>

<div class="modal" id="modal_alertUbicazione" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="alert alert-warning alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert"
                onclick="$('#modal_alertUbicazione').modal('hide');$('#cerca_articolo2').val('');$('#cerca_articolo2').focus()">
            &times;
        </button>
        <strong>Alert!</strong> <br>Ubicazione inserita non corretta o inesistente</a>.
    </div>
</div>

<div class="modal" id="modal_alertQuantita0" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="alert alert-warning alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert"
                onclick="$('#modal_alertQuantita0').modal('hide');$('#cerca_articolo2').val('');$('#cerca_articolo2').focus()">
            &times;
        </button>
        <strong>Alert!</strong> <br>Impossibile Evadere la Quantita' Evadibile a zero </a>.
    </div>
</div>

<div class="modal" id="modal_alertTrovare" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="alert alert-warning alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert"
                onclick="$('#modal_alertTrovare').modal('hide');$('#cerca_articolo2').val('');$('#cerca_articolo2').focus()">
            &times;
            <strong>Alert!</strong><br> Nessun Articolo Trovato </a>.
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="/js/jquery-3.2.1.min.js"></script>
<script src="/js/popper.min.js"></script>
<script src="/vendor/bootstrap-4.1.3/js/bootstrap.min.js"></script>
<script src="/vendor/cookie/jquery.cookie.js"></script>
<script src="/vendor/sparklines/jquery.sparkline.min.js"></script>
<script src="/vendor/circle-progress/circle-progress.min.js"></script>
<script src="/vendor/swiper/js/swiper.min.js"></script>
<script src="/js/main.js"></script>
<script src="//webrtc.github.io/adapter/adapter-latest.js" type="text/javascript"></script>
<script src="/dist/quagga.js" type="text/javascript"></script>
<script src="/js/live_w_locator.js" type="text/javascript"></script>
<script src="/js/jquery.scannerdetection.js" type="text/javascript"></script>

</body>
</html>{{--
<script>
    window.addEventListener('beforeunload', function (e) {
        var confirmationMessage = 'Sei sicuro di voler lasciare questa pagina?';

        // Mostra il messaggio di conferma
        e.preventDefault(); // Necessario per mostrare il dialogo
        e.returnValue = confirmationMessage; // Compatibilità con alcuni browser
        return confirmationMessage; // Compatibilità con alcuni browser
    });
</script>--}}

<script type="text/javascript">

    errorAudio = document.getElementById('errorAudio');

    successAudio = document.getElementById('successAudio');

    var evadi = {};

    function invia_numero_colli(dotes) {
        $.ajax({
            url: "<?php echo URL::asset('ajax/inserisci_numero_colli') ?>/" + dotes,
        }).done(function (result) {
        });
    }

    function rimuoviLotto(id_dorig) {

        document.getElementById('ajax_rimuovi_lotti' + id_dorig).innerHTML = '';


        let lotti = Object.keys(evadi).filter(key => key.startsWith(id_dorig)).map(key => ({
            key: key,
            value: evadi[key]
        }));

        newElement = document.createElement('div');
        newElement.classList.add('row');
        newElement.style.marginBottom = '2%';

        lotto = document.createElement('button');
        lotto.classList.add('btn');
        lotto.classList.add('btn-sm');
        lotto.classList.add('btn-primary');
        lotto.classList.add('col-3');
        lotto.disabled = 'true';
        lotto.innerHTML = 'Lotto';

        scadenza = document.createElement('button');
        scadenza.classList.add('btn');
        scadenza.classList.add('btn-sm');
        scadenza.classList.add('btn-primary');
        scadenza.classList.add('col-3');
        scadenza.disabled = 'true';
        scadenza.value = 'Scadenza';
        scadenza.innerHTML = 'Scadenza';

        codice = document.createElement('button');
        codice.classList.add('btn');
        codice.classList.add('btn-sm');
        codice.classList.add('btn-primary');
        codice.classList.add('col-3');
        codice.disabled = 'true';
        codice.value = 'Id Riga';
        codice.innerHTML = 'Id Riga';

        rimuovi = document.createElement('button');
        rimuovi.classList.add('btn');
        rimuovi.classList.add('btn-sm');
        rimuovi.classList.add('btn-danger');
        rimuovi.classList.add('col-3');
        codice.disabled = 'true';
        rimuovi.value = 'Rimuovi';
        rimuovi.innerHTML = 'Rimuovi';


        newElement.appendChild(codice);
        newElement.appendChild(lotto);
        newElement.appendChild(scadenza);
        newElement.appendChild(rimuovi);

        document.getElementById('ajax_rimuovi_lotti' + id_dorig).appendChild(newElement);

        lotti.forEach(item => {
                const result = item.key.split(';');
                newElement = document.createElement('div');
                newElement.classList.add('row');

                lotto = document.createElement('button');
                lotto.classList.add('btn');
                lotto.classList.add('btn-sm');
                lotto.classList.add('btn-primary');
                lotto.classList.add('col-3');
                lotto.disabled = 'true';
                lotto.value = result[2];
                lotto.innerHTML = result[2];

                scadenza = document.createElement('button');
                scadenza.classList.add('btn');
                scadenza.classList.add('btn-sm');
                scadenza.classList.add('btn-primary');
                scadenza.classList.add('col-3');
                scadenza.disabled = 'true';
                scadenza.value = result[1];
                scadenza.innerHTML = result[1];

                codice = document.createElement('button');
                codice.classList.add('btn');
                codice.classList.add('btn-sm');
                codice.classList.add('btn-primary');
                codice.classList.add('col-3');
                codice.disabled = 'true';
                codice.value = result[0];
                codice.innerHTML = result[0];

                rimuovi = document.createElement('button');
                rimuovi.classList.add('btn');
                rimuovi.classList.add('btn-sm');
                rimuovi.classList.add('btn-danger');
                rimuovi.classList.add('col-3');
                rimuovi.onclick = function () {
                    eliminaLotto(item.key);
                };
                rimuovi.value = 'Rimuovi';
                rimuovi.type = 'Button';
                rimuovi.innerHTML = 'Rimuovi';

                newElement.appendChild(codice);
                newElement.appendChild(lotto);
                newElement.appendChild(scadenza);
                newElement.appendChild(rimuovi);

                // newElement.innerHTML = 'Vuoi eliminare Lotto ' + result[2] + ' con valore : ' + item.value;


                document.getElementById('ajax_rimuovi_lotti' + id_dorig).appendChild(newElement);
            }
        );
        $('#modal_rimuovi_lotto_' + id_dorig).modal('show');

    }

    function eliminaLotto(identificativo) {

        delete evadi[identificativo];

        document.getElementById('riga_' + identificativo + '_counter').remove();

        let id_riga = identificativo.split(';');

        id_riga = id_riga[0];

        let lotti = Object.keys(evadi).filter(key => key.startsWith(id_riga)).map(key => ({
            key: key,
            value: evadi[key]
        }));

        let somma = lotti.reduce((acc, item) => acc + item.value, 0);

        if (parseInt(somma) > 0) {
            document.getElementById('riga_' + text).style.backgroundColor = 'yellow';
            newElement2 = document.getElementById('riga_' + text);
            document.getElementById('riga_' + text).remove();
            document.getElementById('lista').insertBefore(newElement2, document.getElementById('lista').firstChild);
        } else {
            document.getElementById('riga_' + text).style.backgroundColor = 'white';
            newElement2 = document.getElementById('riga_' + text);
        }
        $('#modal_rimuovi_lotto_' + id_riga).modal('hide');
    }

    function invia_peso() {
        $('#modal_peso').modal('hide');

        dotes = document.getElementById('ajax_peso').value;

        invia_numero_colli(dotes);

        peso = document.getElementById('peso_documento').value;


        $.ajax({
            url: "<?php echo URL::asset('ajax/inserisci_peso') ?>/" + dotes + "/" + peso,
        }).done(function (result) {
            if (result == 'Errore')
                alert('Peso non inserito. Prego comunicare all\'amministrazione!');
            else
                top.location.href = '<?php echo ($do[0]->CliFor == 'C') ? '/magazzino/attivo' : '/magazzino/passivi' ?>'
        });
    }

    function change_scad() {
        lotto = document.getElementById('modal_controllo_lotto').value;
        scadenza = document.getElementById('modal_controllo_data_scadenza');
        scadenze = scadenza.options;

        for (i = 0; i < scadenze.length; i++) {
            if (scadenze[i].getAttribute('lotto') === lotto) {
                scadenze[i].selected = true;
                break;
            }
        }
    }

    function change_mag() {
        $('#session').submit();
    }

    cd_cf = '<?php echo $fornitore->Cd_CF ?>';

    function segnalazione() {
        Id_DoRig = document.getElementById('Segnala_riga').value;
        Segnalazione = document.getElementById('Segnalazione').value;

        if (Id_DoRig != '') {
            $.ajax({
                url: "<?php echo URL::asset('ajax/segnalazione') ?>/<?php echo $id_dotes ?>/" + Id_DoRig + "/-" + encodeURIComponent(Segnalazione),

            }).done(function (result) {
            });
        }
        if (Id_DoRig != '') {
            $.ajax({
                url: "<?php echo URL::asset('ajax/invia_mail') ?>/<?php echo $id_dotes ?>/" + 2 + "/-" + Segnalazione
            }).done(function (result) {
                $('#modal_alertSegnalazione').modal('show');
            });
        }
    }

    function salva_scatoloni() {
        @foreach($scatoli as $s)
            ar = document.getElementById('ar_scatolo_{{$s->Cd_AR}}').value;
        qta = document.getElementById('qta_scatolo_{{$s->Cd_AR}}').value;
        if (qta >= 1) {

            $.ajax({
                url: "<?php echo URL::asset('ajax/inserisci_scatolone_in_doc_evaso') ?>/<?php echo $id_dotes ?>/" + ar + "/" + qta,
            }).done(function (result) {
                if (result == 'Errore')
                    alert('Scatolone non inserito. Prego Riprovare');
            });
        }
        @endforeach
        $('#modal_inserisci_scatole').modal('hide');
        $('#modal_peso').modal('show');

        //top.location.reload();
    }

    function salva_documento() {

        Cd_Do = 0;
        Id_DoTes = '<?php echo $id_dotes ?>';
        magazzino_A = 0;

        if (Id_DoTes != '')
            $.ajax({
                url: "<?php echo URL::asset('ajax/salva_documento1') ?>/" + Id_DoTes + "/" + Cd_Do + "/" + magazzino_A

            }).done(function (result) {


                $('#modal_evadi_documento').modal('hide');
                $('#modal_lista_salva').modal('show');
                $('#ajax_lista_documenti_1').html(result);

            });

    }

    function check() {
        check2 = document.getElementById('cerca_articolo2').value;
        lung = document.getElementById('lung').value;

        if (check2.length != 0) {
            if (lung == check2.length) {
                controllo_articolo_smart();
                document.getElementById('lung').value = 0;
                document.getElementById('cerca_articolo2').value = '';
            } else {
                document.getElementById('lung').value = check2.length;
                const myTimeout = setTimeout(check, 500);
                return;
            }
        }
    }

    function conferma_righe() {

        $('#ajax_loader').fadeIn();

        cd_do = document.getElementById('doc_evadi').value;

        cd_mg_p = document.getElementById('cd_mg_p').value;

        if (cd_mg_p == '' || cd_mg_p == 'undefined' || cd_mg_p == undefined || cd_mg_p == null || cd_mg_p == 'Scegli il magazzino...')
            cd_mg_p = 'ND';

        cd_mg_a = document.getElementById('cd_mg_a').value;
        if (cd_mg_a == '' || cd_mg_a == 'undefined' || cd_mg_a == undefined || cd_mg_a == null || cd_mg_a == 'Scegli il magazzino...')
            cd_mg_a = 'ND';

        dorig = JSON.stringify(evadi);
        $.ajax({
            url: "<?php echo URL::asset('ajax/conferma_righe') ?>/" + 'old' + "/" + cd_mg_a + "/" + cd_mg_p + "/" + cd_do,
            data: evadi,
            contentType: "application/json; charset=utf-8",
            dataType: "json",
        }).done(function (result) {
            $('#ajax_loader').fadeOut();
            $('#modal_conf_riga').modal('hide');

            document.getElementById('ajax_numero_colli').value = result;
            document.getElementById('ajax_peso').value = result;

            $('#modal_inserisci_scatole').modal('show');

//            $('#modal_numero_colli').modal('show');
            /* if (result.length > 1)
                 $('#modal_alertQuantita0').modal('show');
             else
                 $('#modal_alertEvasa').modal('show');*/
        }).fail(function (result) {
            $('#ajax_loader').fadeOut();
            newElement = document.createElement('h5');
            newElement.style.textAlign = 'center';
            newElement.innerHTML = 'Errore durante l\'evasione ->' + result.responseText;
            document.getElementById('error_evasione').appendChild(newElement);
        });
    }

    function evadi_articolo2(conf) {

        if (conf != '1') {
            document.getElementById('cerca_articolo2').value = '';
            text = document.getElementById('modal_controllo_dorig').value;
            textXEvasione = document.getElementById('modal_controllo_dorig').value;

            data_scadenza = document.getElementById('modal_controllo_data_scadenza').value;
            if (data_scadenza == 'Nessuna Scadenza' || data_scadenza == 'undefined' || data_scadenza == null)
                data_scadenza = 0;

            lotto = document.getElementById('modal_controllo_lotto').value;
            if (lotto == 'Nessun Lotto' || lotto == 'undefined' || lotto == null)
                lotto = 0;

            textXEvasione = textXEvasione + ';' + data_scadenza;
            textXEvasione = textXEvasione + ';' + lotto;

            dorig = document.getElementById('DORIG').value;
            max_evasione = document.getElementById('qta_max_evad_' + text).value;
            qta_da_evadere = document.getElementById('modal_controllo_quantita').value;

            let lotti = Object.keys(evadi).filter(key => key.startsWith(text)).map(key => ({
                key: key,
                value: evadi[key]
            }));
            let somma = lotti.reduce((acc, item) => acc + item.value, 0);
            console.log('qta da evadere + somma ');
            console.log((parseInt(qta_da_evadere) + parseInt(somma)));
            console.log('max evasione : ');
            console.log(parseInt(max_evasione));

            if (typeof (evadi[textXEvasione]) != "undefined" && evadi[textXEvasione] !== null && somma != 0) {

                if ((parseInt(qta_da_evadere) + parseInt(somma)) <= parseInt(max_evasione)) {
                    evadi[textXEvasione] = parseInt(evadi[textXEvasione]) + parseInt(qta_da_evadere);
                } else {
                    errorAudio.play();
                    $('#modal_alertMaxEvasione').modal('show');
                    return;
                }

            } else {
                if (somma > 0) {
                    if ((parseInt(qta_da_evadere) + parseInt(somma)) <= parseInt(max_evasione)) {
                        evadi[textXEvasione] = parseInt(qta_da_evadere);
                    } else {
                        errorAudio.play();
                        $('#modal_alertMaxEvasione').modal('show');
                        return;
                    }
                } else {

                    if ((parseInt(qta_da_evadere)) <= parseInt(max_evasione)) {
                        evadi[textXEvasione] = parseInt(qta_da_evadere);
                    } else {
                        errorAudio.play();
                        $('#modal_alertMaxEvasione').modal('show');
                        return;
                    }
                }
            }

            document.getElementById('cerca_articolo2').focus();

            let newlotti = Object.keys(evadi).filter(key => key.startsWith(text)).map(key => ({
                key: key,
                value: evadi[key]
            }));
            let newsomma = newlotti.reduce((acc, item) => acc + item.value, 0);
            console.log('new somma');
            console.log(newsomma);
            if (parseInt(newsomma) === parseInt(max_evasione)) {
                document.getElementById('riga_' + text).style.backgroundColor = 'green';
                newElement2 = document.getElementById('riga_' + text);
                document.getElementById('riga_' + text).remove();
                document.getElementById('lista').appendChild(newElement2);
            } else {
                document.getElementById('riga_' + text).style.backgroundColor = 'yellow';
                newElement2 = document.getElementById('riga_' + text);
                document.getElementById('riga_' + text).remove();
                document.getElementById('lista').insertBefore(newElement2, document.getElementById('lista').firstChild);
            }
            var checkElement = document.getElementById('riga_' + textXEvasione + '_counter');
            if (checkElement === undefined || checkElement === null) {
                newElement = document.createElement('h5');
                newElement.style.textAlign = 'center';
                newElement.style.color = 'blue';
                newElement.id = 'riga_' + textXEvasione + '_counter';
                if (lotto !== 0)
                    newElement.innerHTML = 'Righe in Evasione (' + lotto + '):  ' + evadi[textXEvasione];
                else
                    newElement.innerHTML = 'Righe in Evasione : ' + evadi[textXEvasione];
                document.getElementById('riga_' + text + '_counter').appendChild(newElement);
            } else {
                if (lotto !== 0)
                    document.getElementById('riga_' + textXEvasione + '_counter').innerHTML = 'Righe in Evasione (' + lotto + '):  ' + evadi[textXEvasione];
                else
                    document.getElementById('riga_' + textXEvasione + '_counter').innerHTML = 'Righe in Evasione : ' + evadi[textXEvasione];
            }
            successAudio.play();
        } else {
            if (Object.keys(evadi).length > 0) {
                $('#modal_conf_riga').modal('show');
            } else {
                errorAudio.play();
                $('#modal_noriga').modal('show');
                return;
            }

        }
    }

    function evadi_articolo1() {
        dorig = document.getElementById('modal_controllo_dorig').value;
        $('#modal_evadi_riga_' + dorig).modal('show');
    }

    function evadi_articolo(dorig) {

        codice = $('#modal_codice_' + dorig).val();
        documento = $('#modal_inserimento_flusso_' + dorig).val();
        magazzino_A = $('#modal_inserimento_magazzino_' + dorig).val();
        lotto = $('#modal_lotto_' + dorig).val();
        magazzino = $('#modal_magazzino_' + dorig).val();
        ubicazione = $('#modal_ubicazione_' + dorig).val();
        quantita_evasa = $('#modal_Qta_' + dorig).val();
        if (ubicazione != '') {
            pos = ubicazione.indexOf(" - ");
            pos = pos + 3;
            magazzino_prova = ubicazione.substring(pos);
            pos = pos - 3;
            ubicazione = ubicazione.substring(0, pos);
            if (magazzino_prova != magazzino_A.substring(0, 5))
                $('#modal_ubicazione').modal('show');
        } else
            ubicazione = '0';
        if (magazzino_A == null) {
            magazzino_A = '0';
        }

        if (quantita_evasa != '' || quantita_evasa == '0') {
            $.ajax({
                url: "<?php echo URL::asset('ajax/evadi_articolo') ?>/" + dorig + "/" + quantita_evasa + "/" + magazzino.substring(0, 5) + "/" + ubicazione + "/" + lotto + "/" + cd_cf + "/" + documento + "/" + codice + "/" + magazzino_A.substring(0, 5)
            }).done(function (result) {
                if (result.length > 1)
                    $('#modal_alertQuantita0').modal('show');
                else
                    $('#modal_alertEvasa').modal('show');
                location.reload();
            });

        } else
            $('#modal_alertQuantita').modal('show');

    }

    function carica_articolo() {

        codice = $('#modal_Cd_AR').val();
        codice = codice.replaceAll(';', 'punto');
        codice = codice.replaceAll('/', 'slash');
        quantita = $('#modal_quantita').val();
        magazzino_A = '00001 - Magazzino Centrale';
        magazzino_P = '00001 - Magazzino Centrale';
        lotto = $('#modal_lotto').val();


        if (quantita != '') {
            $.ajax({
                url: "<?php echo URL::asset('ajax/aggiungi_articolo_ordine') ?>/<?php echo $id_dotes ?>/" + codice + "/" + quantita + "/" + magazzino_A.substring(0, 5) + "/" + 'ND' + "/" + lotto + "/" + magazzino_P.substring(0, 5) + "/" + 'ND'
            }).done(function (result) {
                $('#modal_carico').modal('hide');
                $('#modal_Cd_AR').val('');
                $('#modal_quantita').val('');
                if (result == 'Ubicazione inserita inesistente in quel magazzino')
                    $('#modal_alertUbicazione').modal('show');
                if (result == 'Articolo Caricato Correttamente ')
                    $('#modal_alertInserimento').modal('show');
            });

        } else
            $('#modal_alertQuantita').modal('show');
    }

    function modifica_articolo() {

        codice = document.getElementById('codice').value;
        quantita = $('#modal_quantita_m').val();
        magazzino_P = $('#modal_magazzino_P_m').val();
        magazzino_A = $('#modal_magazzino_A_m').val();
        lotto = $('#modal_lotto_m').val();
        if (quantita != '') {
            $.ajax({
                url: "<?php echo URL::asset('ajax/modifica_articolo_ordine') ?>/<?php echo $id_dotes ?>/" + codice + "/" + quantita + "/" + magazzino_A.substring(0, 5) + "/" + 'ND' + "/" + lotto + "/" + magazzino_P.substring(0, 5) + "/" + 'ND'

            }).done(function (result) {
                $('#modal_modifica').modal('hide');
                $('#modal_Cd_AR').val('');
                $('#modal_quantita').val('');
                $('#modal_magazzino').val();
                location.reload();

            });

        } else
            $('#modal_alertQuantita').modal('show');
    }

    function crea_articolo() {

        barcode = $('#modal_inserimento_barcode').val();
        if (barcode != '') {
            top.location.href = '/nuovo_articolo?redirect=/magazzino/carico4/<?php echo $fornitore->Id_CF ?>/<?php echo $id_dotes ?>&barcode=' + barcode;
        }
    }

    function cerca_articolo_smart_automatico() {

        testo = $('#cerca_articolo').val();
        testo = testo.replaceAll(';', 'punto');
        testo = testo.replaceAll('/', 'slash');
        testo = testo.trimEnd();

        if (testo != '') {

            $.ajax({
                url: "<?php echo URL::asset('ajax/cerca_articolo_smart_automatico') ?>/" + encodeURIComponent(testo) + "/" + cd_cf,
                context: document.body
            }).done(function (result) {
                if (result != '') {

                    result = result.replaceAll(';', 'punto');
                    result = result.replaceAll('/', 'slash');
                    $('#modal_cerca_articolo').modal('hide');
                    cerca_articolo_codice(result);
                } else
                    $('#modal_alertTrovare').modal('show');
            });

        }

    }


    function cerca_articolo_codice(fornitore, codice, lotto, qta) {


        if (fornitore.length > 6) {
            const myArray = fornitore.split("','");
            codice = myArray[1];
            lotto = myArray[2];
            qta = myArray[3];
        }


        $.ajax({
            url: "/ajax/cerca_articolo_codice/<?php echo $fornitore->Cd_CF ?>/" + codice + "/" + lotto + "/" + qta,
            context: document.body
        }).done(function (result) {

            if (result != '') {
                $('#modal_carico').modal('show');
                $('#ajax_modal_carico').html(result);
            } else {
                $('#modal_inserimento').modal('show');
                $('#modal_inserimento_barcode').val(code);
            }
        });
    }

    function controllo_articolo_smart() {
        testo = $('#cerca_articolo2').val();
        testo = testo.replaceAll(';', 'punto');
        testo = testo.replaceAll('/', 'slash');
        id_dotes = "<?php echo $id_dotes ?>";
        if (testo != '') {

            $.ajax({
                url: "<?php echo URL::asset('ajax/controllo_articolo_smart') ?>/" + testo + "/" + id_dotes,
                context: document.body
            }).done(function (result) {
                if (result != '') {
                    $('#modal_cerca_articolo').modal('hide');
                    $('#ajax_lista_articoli').html(result);
                    evadi_articolo2('0');
                } else {
                    errorAudio.play();
                    $('#modal_segnalare').modal('show');
                    $('#cerca_articolo2').value = '';
                    document.getElementById('Segnalazione_C').value = testo;
                    document.getElementById('id_dotes_C').value = id_dotes;
                    document.getElementById('id_dorig_C').value = id_dorig;
                }
            });

        }
    }

    function controllo_articolo_smart2(codice) {

        testo = codice;
        testo = testo.replaceAll(';', 'punto');
        testo = testo.replaceAll('/', 'slash');
        id_dotes = "<?php echo $id_dotes ?>";
        if (testo != '') {

            $.ajax({
                url: "<?php echo URL::asset('ajax/controllo_articolo_smart') ?>/" + testo + "/" + id_dotes,
                context: document.body
            }).done(function (result) {
                if (result != '') {
                    $('#modal_cerca_articolo').modal('hide');
                    $('#modal_lista_articoli_daevadere').modal('show');
                    $('#ajax_lista_articoli').html(result);
                } else {
                    errorAudio.play();
                    $('#modal_segnalare').modal('show');
                    document.getElementById('Segnalazione_C').value = testo;
                    document.getElementById('id_dotes_C').value = id_dotes;
                    document.getElementById('id_dorig_C').value = id_dorig;
                }
            });

        }
    }

    function invia() {
        $.ajax({
            url: "<?php echo URL::asset('ajax/crea_doc_riordino') ?>/<?php echo $id_dotes ?>",
        }).done(function (result) {
            top.location.href = '<?php echo ($do[0]->CliFor == 'C') ? '/magazzino/attivo' : '/magazzino/passivi' ?>'
        });
    }

    function checkDoc() {
        segnalazioni = '<br>';
        <?php foreach ($documento->righe as $r){ ?>
            articolo = $('#modal_Cd_AR_c_<?php echo $r->Id_DORig ?>').val();
        articolo = articolo.replaceAll(';', 'punto');
        articolo = articolo.replaceAll('/', 'slash');
        quantita = $('#modal_Qta_c_<?php echo $r->Id_DORig ?>').val();
        lotto = $('#modal_Cd_ARLotto_c_<?php echo $r->Id_DORig ?>').val();
        lotto = lotto.replaceAll(';', 'punto');
        lotto = lotto.replaceAll('/', 'slash');
        quantita_evasa = $('#modal_QtaEvasa_c_<?php echo $r->Id_DORig ?>').val();
        quantitaEvadibile = $('#modal_QtaEvadibile_c_<?php echo $r->Id_DORig ?>').val();
        id_dorig = '00000';
        if (!articolo.startsWith('SCATOLO')) {
            if (quantita_evasa != '0') {
                if (articolo != '' && quantita != '') {
                    if (lotto != '')
                        testo = 'Articolo ' + articolo + ' del lotto ' + lotto + ' con quantita ' + quantitaEvadibile + ' non evaso ';
                    else
                        testo = 'Articolo ' + articolo + ' con quantita ' + quantitaEvadibile + ' non evaso ';

                    $.ajax({
                        url: "<?php echo URL::asset('ajax/segnalazione_salva') ?>/<?php echo $id_dotes ?>/" + id_dorig + "/" + testo,
                    }).done(function (result) {

                    });
                    segnalazioni = segnalazioni + testo + '<br>';
                }
            }
        }
        <?php } ?>

        $('#modal_alertSegnalazione').modal('show');
    }

    function segnalazioneControllo1() {

        id_dotes = $('#id_dotes_C').val();

        id_dorig = '00000';

        Segnalazione = $('#Segnalazione_C').val();

        segnalazioneControllo(id_dotes, id_dorig, Segnalazione);
    }

    function segnalazioneControllo(id_dotes, id_dorig, Segnalazione) {

        if (id_dotes != '') {
            $.ajax({
                url: "<?php echo URL::asset('ajax/segnalazione') ?>/<?php echo $id_dotes ?>/" + id_dorig + "/" + Segnalazione
            }).done(function (result) {
                $('#modal_alertSegnalazione').modal('show');
            });
        }

        if (id_dotes != '') {
            $.ajax({
                url: "<?php echo URL::asset('ajax/invia_mail') ?>/<?php echo $id_dotes ?>/" + 1 + "/" + Segnalazione
            }).done(function (result) {

            });
        }

    }

    if (window.innerWidth > 800) {
        $('#interactive').css('display', 'none');
    }

    $('.modal').on('shown.bs.modal', function () {
        $(this).find('[autofocus]').focus();
    });
</script>


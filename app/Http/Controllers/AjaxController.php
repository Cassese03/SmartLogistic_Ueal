<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use PhpParser\Node\Stmt\Else_;
use Spatie\GoogleCalendar\Event;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use NGT\Barcode\GS1Decoder\Decoder;
use Symfony\Component\VarDumper\Cloner\Data;


/**
 * Controller principale del webticket
 * Class HomeController
 * @package App\Http\Controllers
 */
class AjaxController extends Controller
{

    public function cerca_articolo($q)
    {
// PAGINA ARTICOLI

        $articoli = DB::select('SELECT [Id_AR],[Cd_AR],[Descrizione] FROM AR where (Cd_AR Like \'' . $q . '%\' or  Descrizione Like \'%' . $q . '%\' or CD_AR IN (SELECT CD_AR from ARAlias where Alias LIKE \'%' . $q . '%\'))  Order By Id_AR DESC');
        if (sizeof($articoli) == '0') {
            $decoder = new Decoder($delimiter = '');
            $barcode = $decoder->decode($q);
            $where = ' where 1=1 ';

            foreach ($barcode->toArray()['identifiers'] as $field) {

                if ($field['code'] == '01') {
                    $testo = trim($field['content'], '*,');
                    $where .= ' and AR.Cd_AR Like \'%' . $testo . '%\'';
                }

            }
            $articoli = DB::select('SELECT [Id_AR],[Cd_AR],[Descrizione] FROM AR ' . $where . '  Order By Id_AR DESC');
        }
        if (sizeof($articoli) != '0')
            foreach ($articoli as $articolo) { ?>

                <li class="list-group-item">
                    <a href="/modifica_articolo/<?php echo $articolo->Id_AR ?>" class="media">
                        <div class="media-body">
                            <h5><?php echo $articolo->Descrizione ?></h5>
                            <p>Codice: <?php echo $articolo->Cd_AR ?></p>
                        </div>
                    </a>
                </li>

            <?php }


    }

    public function stampe($id_dotes)
    {
        DB::update("Update dotes set dotes.reserved_1= 'RRRRRRRRRR' where dotes.id_dotes = $id_dotes exec asp_DO_End $id_dotes");
        DB::statement("exec asp_DO_End $id_dotes");
        $id_dotes = DB::SELECT('SELECT * FROM DOTes WHERE Id_DOTes = \'' . $id_dotes . '\'')[0];
        if ($id_dotes->Cd_Do == 'DDT') {
            $html = View::make('stampe.ddt', compact('id_dotes'));
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8']);
            $mpdf->curlAllowUnsafeSslRequests = true;
            $mpdf->SetTitle('Ddt');
            $mpdf->WriteHTML($html);
            $mpdf->Output('ddt.pdf', 'I');
        }
        if ($id_dotes->Cd_Do == 'RCF') {
            $html = View::make('stampe.rcf', compact('id_dotes'));
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8']);
            $mpdf->curlAllowUnsafeSslRequests = true;
            $mpdf->SetTitle('Rcf');
            $mpdf->WriteHTML($html);
            $mpdf->Output('RCF.pdf', 'I');
        }
    }

    public function id_dotes($id_dotes)
    {
        DB::update("Update dotes set dotes.reserved_1= 'RRRRRRRRRR' where dotes.id_dotes = $id_dotes exec asp_DO_End $id_dotes");
        DB::statement("exec asp_DO_End $id_dotes");
    }

    public function visualizza_lotti($articolo)
    {

        $giacenza = DB::SELECT('SELECT SUM(QuantitaSign) as Giacenza  FROM MGMov where Cd_AR =\'' . $articolo . '\' and  Cd_MGEsercizio = YEAR(GETDATE()) and Cd_MG = \'00001\' ');
        foreach ($giacenza as $l) {
            ?>
            <li class="list-group-item">
                <a class="media" onclick="">
                    <div class="media-body">
                        <h3>Giacenza: <?php echo $l->Giacenza;
                            if ($l->Giacenza == '') echo '0';/*echo $l->Cd_AR.' - '.$l->Descrizione */ ?></h3>
                        <small><?php /*echo $l->Giacenza; if($l->Giacenza=='') echo '0';*/ ?></small>
                        <small><?php /*if($l->xCd_xPallet!='')echo 'Pallet : '.$l->xCd_xPallet ?></small>
                        <small><?php if($l->xNr_PalletFornitore!='')echo 'NrPalletFornitore : '.$l->xNr_PalletFornitore*/ ?></small>
                    </div>
                </a>
            </li>
        <?php }
    }

    /*
        public function storialotto($articolo,$lotto){
            $lotto1 = DB::SELECT('SELECT * FROM MGMov WHERE Cd_AR = \''.$articolo.'\' AND Cd_MGEsercizio = YEAR(GETDATE()) AND Cd_ARLotto = \''.$lotto.'\' ORDER BY DataMov ASC , PartenzaArrivo Desc');
            $giacenza =DB::SELECT('SELECT SUM(QuantitaSign) as Giacenza,Cd_AR,Cd_MG,Cd_ARLotto FROM MGMov WHERE Cd_AR = \''.$articolo.'\' AND Cd_ARLotto = \''.$lotto.'\' GROUP BY Cd_AR,Cd_ARLotto,Cd_MG HAVING SUM(QuantitaSign)>0');
            foreach ($lotto1 as $l){?>
                <li class="list-group-item">
                    <a class="media">
                        <div class="media-body">
                            <h5><?php echo $l->Cd_ARLotto ?></h5>
                            <p>Azione : <?php
                                if($l->Ini=='1') echo 'Iniziale';
                                if($l->Ret=='1') echo 'Rettifica';
                                if($l->Car=='1') echo 'Carico';
                                if($l->Sca=='1') echo 'Scarico';?></p>
                            <small>Magazzino : <?php echo  $l->Cd_MG ?></small>
                            <small>Quantita' : <?php echo floatval($l->QuantitaSign) ?></small>
                        </div>
                    </a>
                </li>
            <?php } ?>
            <li class="list-group-item">
                    <a class="media">
                        <div class="media-body">
                            <h5><?php echo $giacenza[0]->Cd_ARLotto ?></h5>
                            <p>Azione : <?php echo 'Giacenza'?></p>
                            <small>Magazzino : <?php echo  $giacenza[0]->Cd_MG ?></small>
                            <small>Quantita' : <?php echo floatval($giacenza[0]->Giacenza) ?></small>
                        </div>
                    </a>
                </li>
       <?php }

        public function inserisci_lotto($lotto,$articolo,$fornitore,$descrizione,$fornitore_pallet,$pallet){
            $esiste = DB::SELECT('SELECT * FROM ARLotto WHERE Cd_AR = \''.$articolo.'\' and Cd_ARLotto = \''.$lotto.'\' ');
            if(sizeof($esiste)>0){
                echo 'Impossibile creare il lotto in quanto gi?? esistente';
            }else {
                if($fornitore!='0') {
                    $fornitori = DB::select('SELECT [Id_CF],[Cd_CF],[Descrizione] FROM CF where Fornitore = 1 and (Cd_CF Like \'%' . $fornitore . '%\' or  Descrizione Like \'%' . $fornitore . '%\')  Order By Id_CF DESC');
                    if ($fornitori == null) {
                        echo 'Fornitore non trovato';
                        exit();
                    } else
                        $fornitori = $fornitori[0]->Cd_CF;
                }
                    $id_Lotto = DB::table('ARLotto')->insertGetId(['Cd_AR' => $articolo, 'Cd_ARLotto' => $lotto, 'Descrizione' => $descrizione]);
                if($fornitore!='0'){
                            DB::update("UPDATE ARLotto Set Cd_CF = '$fornitori' where Id_ARLotto = '$id_Lotto' ");
                }
                if($fornitore_pallet!='0'){
                    DB::update("UPDATE ARLotto Set xNr_PalletFornitore = '$fornitore_pallet' where Id_ARLotto = '$id_Lotto' ");
                }
                if($pallet!='0'){
                    DB::update("UPDATE ARLotto Set xCd_xPallet = '$pallet' where Id_ARLotto = '$id_Lotto' ");
                }
                echo 'Lotto Inserito Correttamente';
            }
        }
    */
    public function segnalazione_salva($id_dotes, $id_dorig, $testo)
    {
        $testo = str_replace('*', '', $testo);
        $esiste = DB::SELECT('SELECT * FROM DoTes WHERE Id_DoTes = \'' . $id_dotes . '\' ')[0]->NotePiede;
        if ($esiste != null) {
            $esiste .= '                                    ';
            $esiste .= $testo;
            DB::update('Update DoTes set NotePiede = \'' . $esiste . '\' where Id_DoTes = \'' . $id_dotes . '\' ');
        } else
            DB::update('Update DOTes set NotePiede = \'' . $testo . '\' where Id_DoTes = \'' . $id_dotes . '\' ');
    }

    public function segnalazione($id_dotes, $id_dorig, $testo)
    {

        if (substr($testo, 0, 2) == '01') {
            $decoder = new Decoder($delimiter = '');
            $barcode = $decoder->decode($testo);
            $where = 'Articolo ';
            foreach ($barcode->toArray()['identifiers'] as $field) {

                if ($field['code'] == '01') {
                    $contenuto = trim($field['content'], '*,');
                    $where .= $contenuto . ' con lotto ';

                }
                if ($field['code'] == '10') {
                    $where .= $field['content'] . ' non trovato.';

                }
                /*
                if ($field['code'] == '310') {
                    $decimali = floatval(substr($field['raw_content'],-2));
                    $qta = floatval(substr($field['raw_content'],0,4))+$decimali/100;
                    $where .= ' and Qta Like \'%' . $qta . '%\'';
                }*/

            }
        } else {
            $testo = trim($testo, '-');
            $where = $testo;
        }
        $esiste = DB::SELECT('SELECT * FROM DoTes WHERE Id_DoTes = \'' . $id_dotes . '\' ')[0]->NotePiede;
        if ($esiste != null) {
            $esiste .= '                                    ';
            $esiste .= $where;
            DB::update('Update DoTes set NotePiede = \'' . $esiste . '\' where Id_DoTes = \'' . $id_dotes . '\' ');
        } else
            DB::update('Update DOTes set NotePiede = \'' . $where . '\' where Id_DoTes = \'' . $id_dotes . '\' ');

    }

    public function cerca_fornitore_new($q = '', $dest)
    {

        $dest1 = DB::SELECT('SELECT * FROM DO WHERE Cd_DO = \'' . $dest . '\' ')[0]->CliFor;

        if ($dest1 == ('F')) {
            if ($q == '') {
                $fornitori = DB::select('SELECT [Id_CF],[Cd_CF],[Descrizione] FROM CF where Fornitore = 1 Order By Id_CF DESC');
            } else {
                $fornitori = DB::select('SELECT [Id_CF],[Cd_CF],[Descrizione] FROM CF where Fornitore = 1 and (Cd_CF Like \'%' . $q . '%\' or  Descrizione Like \'%' . $q . '%\')  Order By Id_CF DESC');
            }
        }
        if ($dest1 == ('C')) {
            if ($q == '') {
                $fornitori = DB::select('SELECT [Id_CF],[Cd_CF],[Descrizione] FROM CF where Cliente = 1 Order By Id_CF DESC');
            } else {
                $fornitori = DB::select('SELECT [Id_CF],[Cd_CF],[Descrizione] FROM CF where Cliente = 1 and (Cd_CF Like \'%' . $q . '%\' or  Descrizione Like \'%' . $q . '%\')  Order By Id_CF DESC');
            }
        }
        if ($dest == 'BCV') {
            foreach ($fornitori as $f) { ?>

                <li class="list-group-item">
                    <a href="/magazzino/trasporto_documento/BCV/<?php echo $f->Cd_CF ?>" class="media">
                        <div class="media-body">
                            <h5><?php echo $f->Descrizione ?></h5>
                            <p>Codice: <?php echo $f->Cd_CF ?></p>

                        </div>
                    </a>
                </li>

            <?php }
        } else {
            foreach ($fornitori as $f) { ?>

                <li class="list-group-item">
                    <a href="/magazzino/carico03/<?php echo $f->Id_CF ?>/<?php echo $dest ?>" class="media">
                        <div class="media-body">
                            <h5><?php echo $f->Descrizione ?></h5>
                            <p>Codice: <?php echo $f->Cd_CF ?></p>

                        </div>
                    </a>
                </li>

            <?php }
        }
    }

    public function cerca_cliente_new($q = '', $dest)
    {


        if ($q == '') {
            $clienti = DB::select('SELECT [Id_CF],[Cd_CF],[Descrizione] FROM CF where Cliente = 1 Order By Id_CF DESC');
        } else {
            $clienti = DB::select('SELECT [Id_CF],[Cd_CF],[Descrizione] FROM CF where Cliente = 1 and (Cd_CF Like \'%' . $q . '%\' or  Descrizione Like \'%' . $q . '%\')  Order By Id_CF DESC');
        }
        if ($dest == 'S2') {
            foreach ($clienti as $f) { ?>

                <li class="list-group-item">
                    <a href="/magazzino/scarico3/<?php echo $f->Id_CF ?>/OVC" class="media">
                        <div class="media-body">
                            <h5><?php echo $f->Descrizione ?></h5>
                            <p>Codice: <?php echo $f->Cd_CF ?></p>

                        </div>
                    </a>
                </li>

            <?php }
        }
        if ($dest == 'S02') {
            foreach ($clienti as $f) { ?>

                <li class="list-group-item">
                    <a href="/magazzino/scarico03/<?php echo $f->Id_CF ?>/DDT" class="media">
                        <div class="media-body">
                            <h5><?php echo $f->Descrizione ?></h5>
                            <p>Codice: <?php echo $f->Cd_CF ?></p>

                        </div>
                    </a>
                </li>

            <?php }
        }
    }

    public function cerca_articolo_codice($cd_cf, $codice, $Cd_ARLotto, $qta)
    {
        $codice = str_replace("slash", "/", $codice);
        $codice = str_replace("punto", ";", $codice);


        $articoli = DB::select('SELECT AR.Id_AR,AR.Cd_AR,AR.Descrizione,ARAlias.Alias as barcode,ARARMisura.UMFatt,DORig.PrezzoUnitarioV,LSArticolo.Prezzo from AR
            LEFT JOIN ARAlias ON AR.Cd_AR = ARAlias.Cd_AR
            LEFT JOIN ARARMisura ON ARARMisura.Cd_AR = ARAlias.CD_AR and  ARARMisura.CD_ARMisura = ARAlias.CD_ARMisura
            LEFT JOIN LSArticolo ON LSArticolo.Cd_AR = AR.Cd_AR
            LEFT JOIN DORig ON DOrig.Cd_CF LIKE \'' . $cd_cf . '\' and DORig.Cd_AR = AR.Cd_AR
            where ARAlias.Alias Like \'' . $codice . '\'
            order by DORig.DataDoc DESC');

        $magazzino_selected = DB::select('SELECT MgMov.Cd_MG, Mg.Descrizione from MGMov LEFT JOIN MG ON MG.Cd_MG = MgMov.Cd_MG WHERE MgMov.Cd_ARLotto = \'' . $Cd_ARLotto . '\'  and MgMov.Cd_AR = \'' . $codice . '\' and MgMov.Cd_MGEsercizio = YEAR(GETDATE()) ');

        if ($magazzino_selected != null) {
            $magazzino_selected = $magazzino_selected[0];
            $magazzino_selezionato = $magazzino_selected->Cd_MG;
        } else
            $magazzino_selezionato = '0';

        $magazzini = DB::select('SELECT * from MG WHERE Cd_MG !=\'' . $magazzino_selezionato . '\' ');

        //TODO Controllare Data Scadenza togliere i commenti
        /*
                $date = date('d/m/Y',strtotime('today')) ;

                IF($Cd_ARLotto!='0')
                    $lotto = DB::select('SELECT * FROM ARLotto WHERE Cd_AR = \'' . $codice . '\' and Cd_ARLotto !=\''.$Cd_ARLotto.'\' AND DataScadenza > \''.$date.'\' and Cd_ARLotto in (select Cd_ARLotto from MGMov group by Cd_ARLotto having SUM(QuantitaSign) >= 0)  ');
                else
                    $lotto = DB::select('SELECT * FROM ARLotto WHERE Cd_AR = \'' . $codice . '\'  AND DataScadenza > \''.$date.'\' and Cd_AR in (select Cd_AR from MGMov group by Cd_AR having SUM(QuantitaSign) >= 0)  ');
        */
        if (sizeof($articoli) > 0) {
            $articolo = $articoli[0];
            echo '<h3>    Barcode: ' . $articolo->barcode . '<br>
                          Codice: ' . $articolo->Cd_AR . '<br>
                          Descrizione:<br>' . $articolo->Descrizione . '</h3>';
            ?>
            <script type="text/javascript">
                $('#modal_quantita').val(<?php echo intval($articolo->UMFatt) ?>);

                <?php /*if($articolo->CostoDb){ ?>
                $('#modal_prezzo').val('<?php echo number_format($articolo->CostoDb,2,'.','') ?>');
                $('#modal_quantita').val(<?php echo intval($articolo->UMFatt) ?>);
                <?php } else {*/if($articolo->PrezzoUnitarioV){ ?>
                $('#modal_prezzo').val('<?php echo number_format($articolo->PrezzoUnitarioV, 2, '.', '') ?>');
                <?php } else { ?>
                $('#modal_prezzo').val('<?php echo number_format($articolo->Prezzo, 2, '.', '') ?>');
                <?php } /*?>
                $('#modal_lotto').html
                <?php if($Cd_ARLotto!='0'){ ?>
                ('<option><?php echo $Cd_ARLotto ?></option>')
                <?php } ?>
                $('#modal_lotto').append( '<option>Nessun Lotto</option>')
                <?php foreach($lotto as $l){?>
                $('#modal_lotto').append('<option><?php echo $l->Cd_ARLotto ?></option>')
                <?php }*/ ?>
                $('#modal_magazzino_P').html
                <?php  if($magazzino_selezionato != '0'){ ?>
                ('<option><?php echo $magazzino_selected->Cd_MG . ' - ' . $magazzino_selected->Descrizione?></option>')
                <?php } ?>
                <?php foreach($magazzini as $m){?>
                $('#modal_magazzino_P').append('<option><?php echo $m->Cd_MG . ' - ' . $m->Descrizione ?></option>')
                <?php } ?>
                $('#modal_Cd_AR').val('<?php echo $articolo->Cd_AR ?>');


                cambioMagazzino();
            </script>
            <?php
        }

        if (sizeof($articoli) < 1) {
            $articoli = DB::select('
                SELECT AR.Id_AR,AR.Cd_AR,AR.Descrizione,ARARMisura.UMFatt,DORig.PrezzoUnitarioV,LSArticolo.Prezzo from AR
                LEFT JOIN ARARMisura ON ARARMisura.Cd_AR = AR.CD_AR
                LEFT JOIN LSArticolo ON LSArticolo.Cd_AR = AR.Cd_AR
                LEFT JOIN LSRevisione ON LSRevisione.Id_LSRevisione = LSArticolo.Id_LSRevisione and LSRevisione.Cd_LS = \'LSF\'
                LEFT JOIN DORig ON DOrig.Cd_CF LIKE \'' . $cd_cf . '\' and DORig.Cd_AR = AR.Cd_AR
                where AR.CD_AR LIKE \'' . $codice . '\'
                order by DORig.DataDoc DESC');
            if ($Cd_ARLotto != '')
                $lotto = DB::select('SELECT * FROM ARLotto WHERE Cd_AR = \'' . $codice . '\' and Cd_ARLotto !=\'' . $Cd_ARLotto . '\' and  Cd_ARLotto in (select Cd_ARLotto from MGMov group by Cd_ARLotto having SUM(QuantitaSign) > 0)  ');
            else
                $lotto = DB::select('SELECT * FROM ARLotto WHERE Cd_AR = \'' . $codice . '\' and Cd_AR in (select Cd_AR from MGMov group by Cd_AR having SUM(QuantitaSign) > 0) ');
            if (sizeof($articoli) > 0) {
                $articolo = $articoli[0];
                echo '<h3>Barcode : Non inserito <br>
                          Codice: ' . $articolo->Cd_AR . '<br>
                          Pezzi x Collo: ' . intval($articolo->UMFatt) . '<br><br>
                          Descrizione:<br>' . $articolo->Descrizione . '</h3>';
                ?>
                <script type="text/javascript">

                    $('#modal_Cd_AR').val('<?php echo $articolo->Cd_AR ?>');
                    <?php if($articolo->PrezzoUnitarioV){ ?>
                    $('#modal_prezzo').val('<?php echo number_format($articolo->PrezzoUnitarioV, 2, '.', '') ?>');
                    <?php } else { ?>
                    $('#modal_prezzo').val('<?php echo number_format($articolo->Prezzo, 2, '.', '') ?>');
                    <?php }?>
                    $('#modal_lotto').html
                    <?php if($Cd_ARLotto != '0'){ ?>
                    ('<option><?php echo $Cd_ARLotto ?></option>');
                    <?php } ?>
                    $('#modal_lotto').append('<option>Nessun Lotto</option>');
                    <?php foreach($lotto as $l){?>
                    $('#modal_lotto').append('<option><?php echo $l->Cd_ARLotto ?></option>')
                    <?php } ?>


                </script>
                <?php
            }
        }
    }

    public function salva_documento1($Id_DoTes, $Cd_DO)
    {
        $righe = DB::SELECT('SELECT * FROM DoRig WHERE Id_DoTes = \'' . $Id_DoTes . '\' and QtaEvadibile > \'0\' ');
        foreach ($righe as $riga) {
            ?>
            <li class="list-group-item">
                <a href="#" class="media">
                    <div class="media-body">
                        <h5><?php echo $riga->Cd_AR;
                            if ($riga->Cd_ARLotto != '') echo '  Lotto: ' . $riga->Cd_ARLotto; ?></h5>
                        <p>Quantita': <?php echo $riga->Qta ?></p>
                    </div>
                </a>
            </li>
            <script type="text/javascript">
                $('#modal_Cd_AR_c_<?php echo $riga->Id_DORig ?>').val('<?php echo $riga->Cd_AR ?>');
                $('#modal_Cd_ARLotto_c_<?php echo $riga->Id_DORig ?>').val('<?php echo $riga->Cd_ARLotto ?>');
                $('#modal_Qta_c_<?php echo $riga->Id_DORig ?>').val('<?php echo $riga->Qta ?>');
                $('#modal_QtaEvasa_c_<?php echo $riga->Id_DORig ?>').val('<?php echo $riga->QtaEvasa ?>');
                $('#modal_QtaEvasa_c_<?php echo $riga->Id_DORig ?>').val('<?php echo $riga->PrezzoUnitarioV ?>');
            </script>
        <?php }
    }

    public function evadi_articolo($Id_DoRig, $qtadaEvadere, $magazzino, $ubicazione, $lotto, $cd_cf, $documento, $cd_ar, $magazzino_A)
    {
        $cd_ar = str_replace("slash", "/", $cd_ar);
        $cd_ar = str_replace("punto", ";", $cd_ar);
        $Id_DoTes = '0';
        if ($qtadaEvadere == '0') {
            echo 'Impossibile evadere la Quantita a 0';
            exit();
        } else {
            $date = date('d/m/Y', strtotime('today'));
            $controllo = DB::SELECT('SELECT * FROM DORIG WHERE Id_DORig = \'' . $Id_DoRig . '\'')[0]->Id_DOTes;
            $controlli = DB::SELECT('SELECT * FROM DORIG WHERE Id_DOTes = \'' . $controllo . '\'');
            foreach ($controlli as $c) {
                $testata = DB::SELECT('SELECT * FROM DORIG WHERE Id_DORig_Evade = \'' . $c->Id_DORig . '\' and DataDoc = \'' . $date . '\'');
                if ($testata != null)
                    $Id_DoTes = $testata[0]->Id_DOTes;
            }

        }
        if ($Id_DoTes == '0')
            $Id_DoTes = '';
        $Id_DoTes_old = DB::SELECT('SELECT * from DoRig where id_dorig = \'' . $Id_DoRig . '\' ')[0]->Id_DOTes;
        $listino = DB::SELECT('SELECT * from DOTes where Id_DOTes = \'' . $Id_DoTes_old . '\' ');
        $insert_evasione['PrezzoUnitarioV'] = $controlli[0]->PrezzoUnitarioV;
        if ($listino[0]->Cd_LS_1 != null)
            $listino = $listino[0]->Cd_LS_1;
        else
            $listino = '';
        if ($Id_DoTes == '' && $listino != '')
            $Id_DoTes = DB::table('DOTes')->insertGetId(['Cd_CF' => $cd_cf, 'Cd_Do' => $documento, 'Cd_LS_1' => $listino]);
        if ($Id_DoTes == '' && $listino == '')
            $Id_DoTes = DB::table('DOTes')->insertGetId(['Cd_CF' => $cd_cf, 'Cd_Do' => $documento]);
        $pagamento = DB::SELECT('SELECT * FROM DOTes WHERE ID_DOTes = \'' . $controllo . '\'');
        if ($pagamento[0]->Cd_PG != '') {
            $pagamento = $pagamento[0]->Cd_PG;
            DB::update("Update DOTes set Cd_PG = '$pagamento' where ID_DOTes = '$controllo'");
        }
        $agente = DB::SELECT('SELECT * FROM DOTes WHERE ID_DOTes = \'' . $controllo . '\'');
        if ($agente[0]->Cd_Agente_1 != '') {
            $agente = $agente[0]->Cd_Agente_1;
            DB::update("Update DOTes set Cd_Agente_1 = '$agente' where ID_DOTes = '$controllo'");
        }
        if ($magazzino_A != 0)
            $insert_evasione['Cd_MG_A'] = $magazzino_A;
        if ($magazzino != 0)
            $insert_evasione['Cd_MG_P'] = $magazzino;

        if ($lotto != '0')
            $insert_evasione['Cd_ARLotto'] = $lotto;
        $Id_DoTes1 = $Id_DoTes;
        $insert_evasione['Cd_AR'] = $cd_ar;
        $insert_evasione['Id_DORig_Evade'] = $Id_DoRig;
        $insert_evasione['Qta'] = $qtadaEvadere;
        $insert_evasione['QtaEvasa'] = $insert_evasione['Qta'];
        $Riga = DB::SELECT('SELECT * FROM DoRig where Id_DoRig=\'' . $Id_DoRig . '\'');
        $insert_evasione['Cd_Aliquota'] = $Riga[0]->Cd_Aliquota;
        $insert_evasione['PrezzoUnitarioV'] = $Riga[0]->PrezzoUnitarioV;
        if ($Riga[0]->ScontoRiga != '')
            $insert_evasione['ScontoRiga'] = $Riga[0]->ScontoRiga;
        $insert_evasione['Cd_CGConto'] = $Riga[0]->Cd_CGConto;
        $insert_evasione['Id_DoTes'] = $Id_DoTes1;
        $qta_evasa = DB::SELECT('SELECT * FROM DORig WHERE Id_DoRig= \'' . $Id_DoRig . '\' ')[0]->QtaEvasa;
        $qta_evasa = intval($qta_evasa) + intval($qtadaEvadere);
        $qta_evadibile = DB::SELECT('SELECT * FROM DORig WHERE Id_DoRig= \'' . $Id_DoRig . '\' ')[0]->QtaEvadibile;
        $qta_evadibile = intval($qta_evadibile) - intval($qtadaEvadere);
        DB::table('DoRig')->insertGetId($insert_evasione);
        $Id_DoRig_OLD = DB::SELECT('SELECT TOP 1 * FROM DORig ORDER BY Id_DORig DESC')[0]->Id_DORig;

        if ($qtadaEvadere < $Riga[0]->QtaEvadibile) {
            DB::UPDATE('Update DoRig set QtaEvadibile = \'' . $qta_evadibile . '\'WHERE Id_DoRig = \'' . $Id_DoRig . '\'');
            DB::UPDATE('Update DoRig set QtaEvasa = \'' . $qta_evasa . '\'WHERE Id_DoRig = \'' . $Id_DoRig_OLD . '\'');
        } else {
            DB::UPDATE('Update DoRig set QtaEvadibile = \'0\'WHERE Id_DoRig = \'' . $Id_DoRig . '\'');
            DB::update('Update dorig set Evasa = \'1\'   where Id_DoRig = \'' . $Id_DoRig . '\' ');
            DB::update("Update dotes set dotes.reserved_1= 'RRRRRRRRRR' where dotes.id_dotes = '$Id_DoTes_old'");
            DB::statement("exec asp_DO_End '$Id_DoTes_old'");
        }
        DB::update("Update dotes set dotes.reserved_1= 'RRRRRRRRRR' where dotes.id_dotes = '$Id_DoTes1'");
        DB::statement("exec asp_DO_End '$Id_DoTes1'");
    }

    public function conferma_righe($Id_DoRig, $cd_mg_a, $cd_mg_p, $cd_do)
    {
        $Id_DoTes = '';
        $date = date('d/m/Y', strtotime('today'));
        $controllo = DB::SELECT('SELECT * FROM DORIG WHERE Id_DORig in (\'' . $Id_DoRig . '\')')[0]->Id_DOTes;
        $controlli = DB::SELECT('SELECT * FROM DORIG WHERE Id_DOTes = \'' . $controllo . '\'');
        foreach ($controlli as $c) {
            $testata = DB::SELECT('SELECT * FROM DORIG WHERE Id_DORig_Evade = \'' . $c->Id_DORig . '\'');
            if ($testata != null)
                if ($testata[0]->DataDoc == $date)
                    $Id_DoTes = $testata[0]->Id_DOTes;
        }

        $righe = DB::select('SELECT * FROM DORIG WHERE ID_DORIG IN (\'' . $Id_DoRig . '\')');
        foreach ($righe as $r) {
            $Id_DoRig = $r->Id_DORig;
            $qtadaEvadere = $r->QtaEvadibile;
            $magazzino = $r->Cd_MG_A;
            $ubicazione = '0';
            $lotto = $r->Cd_ARLotto;
            $cd_cf = $r->Cd_CF;
            $documento = $cd_do;
            $cd_ar = $r->Cd_AR;
            $magazzino_A = $cd_mg_a; //magazzino di default
            $magazzino = $cd_mg_p; //magazzino di default
            $insert_evasione['Cd_MG_P'] = '';
            $insert_evasione['Cd_MG_A'] = '';

            if ($Id_DoTes == '') {
                DB::table('DOTes')->insertGetId(['Cd_CF' => $cd_cf, 'Cd_Do' => $documento]);
                $Id_DoTes = DB::SELECT('SELECT TOP 1 Id_DOTes from DOTes ORDER BY TimeIns Desc')[0]->Id_DOTes;
                if ($ubicazione != '0')
                    $insert_evasione['Cd_MGUbicazione_P'] = $ubicazione;
                if ($magazzino != '0')
                    $insert_evasione['Cd_MG_P'] = $magazzino;
                if ($magazzino_A != '0')
                    $insert_evasione['Cd_MG_A'] = $magazzino_A;

                DB::update("Update dotes set dotes.reserved_1= 'RRRRRRRRRR' where dotes.id_dotes = '$Id_DoTes'");
                DB::statement("exec asp_DO_End $Id_DoTes");
            }

            if ($insert_evasione['Cd_MG_P'] == null || $insert_evasione['Cd_MG_P'] == '0')
                $insert_evasione['Cd_MG_P'] = $magazzino;
            if ($insert_evasione['Cd_MG_A'] == null || $insert_evasione['Cd_MG_A'] == '0')
                $insert_evasione['Cd_MG_A'] = $magazzino_A;
            if ($lotto != '0')
                $insert_evasione['Cd_ARLotto'] = $lotto;
            $check = DB::SELECT('SELECT * from MGCausale where Cd_MGCausale IN (SELECT Cd_MGCausale FROM DO where cd_do = (SELECT TOP 1 Cd_DO FROM DOTes where Id_DOTes = \'' . $Id_DoTes . '\'))');
            if (sizeof($check) > 0) {
                if ($check[0]->MagPFlag == 0)
                    unset($insert_evasione['Cd_MG_P']);
                if ($check[0]->MagAFlag == 0)
                    unset($insert_evasione['Cd_MG_A']);
            }
            $Id_DoTes1 = $Id_DoTes;
            $insert_evasione['Cd_AR'] = $cd_ar;
            $insert_evasione['Id_DORig_Evade'] = $Id_DoRig;
            $insert_evasione['PrezzoUnitarioV'] = $r->PrezzoUnitarioV;
            $insert_evasione['Qta'] = $qtadaEvadere;
            $insert_evasione['QtaEvasa'] = $insert_evasione['Qta'];

            $Riga = DB::SELECT('SELECT * FROM DoRig where Id_DoRig=\'' . $Id_DoRig . '\'');
            $insert_evasione['Cd_Aliquota'] = $r->Cd_Aliquota;
            $insert_evasione['Cd_CGConto'] = $r->Cd_CGConto;
            $insert_evasione['Id_DoTes'] = $Id_DoTes1;


            $qta_evasa = DB::SELECT('SELECT * FROM DORig WHERE Id_DoRig= \'' . $Id_DoRig . '\' ')[0]->QtaEvasa;
            $qta_evasa = intval($qta_evasa) + intval($qtadaEvadere);
            $qta_evadibile = DB::SELECT('SELECT * FROM DORig WHERE Id_DoRig= \'' . $Id_DoRig . '\' ')[0]->QtaEvadibile;
            $qta_evadibile = intval($qta_evadibile) - intval($qtadaEvadere);
            DB::table('DoRig')->insertGetId($insert_evasione);
            $Id_DoRig_OLD = DB::SELECT('SELECT TOP 1 * FROM DORIG ORDER BY Id_DORig DESC')[0]->Id_DORig;

            if ($qtadaEvadere < $Riga[0]->QtaEvadibile) {
                DB::UPDATE('Update DoRig set QtaEvadibile = \'' . $qta_evadibile . '\'WHERE Id_DoRig = \'' . $Id_DoRig . '\'');
                DB::UPDATE('Update DoRig set QtaEvasa = \'' . $qta_evasa . '\'WHERE Id_DoRig = \'' . $Id_DoRig_OLD . '\'');
            } else {
                DB::UPDATE('Update DoRig set QtaEvadibile = \'0\'WHERE Id_DoRig = \'' . $Id_DoRig . '\'');
                DB::update('Update dorig set Evasa = \'1\'   where Id_DoRig = \'' . $Id_DoRig . '\' ');
                $Id_DoTes_old = DB::SELECT('SELECT * from DoRig where id_dorig = \'' . $Id_DoRig . '\' ')[0]->Id_DOTes;
                DB::update("Update dotes set dotes.reserved_1= 'RRRRRRRRRR' where dotes.id_dotes = '$Id_DoTes_old'");
                DB::statement("exec asp_DO_End '$Id_DoTes_old'");
            }
            DB::update("Update dotes set dotes.reserved_1= 'RRRRRRRRRR' where dotes.id_dotes = '$Id_DoTes1'");
            DB::statement("exec asp_DO_End '$Id_DoTes1'");
        }
        return true;
    }

    public
    function crea_documento($cd_cf, $cd_do, $numero, $data)
    {

        $fornitore = DB::SELECT('SELECT * FROM CF WHERE Cd_CF = \'' . $cd_cf . '\' ');
        if (sizeof($listino) > 0)
            $listino = $fornitore[0]->Cd_LS_1;
        else
            $listino = 'BANCO';
        $insert_testata_ordine['Cd_LS_1'] = $listino;
        $insert_testata_ordine['Cd_CF'] = $cd_cf;
        $insert_testata_ordine['Cd_Do'] = $cd_do;
        $insert_testata_ordine['NumeroDoc'] = $numero;
        /*if($cd_do == 'DDT')
            $insert_testata_ordine['Modificabile'] = 0 ;*/
        if ($cd_do == 'DDT') {
            $insert_testata_ordine['Cd_DoSped'] = '02';
            $insert_testata_ordine['Cd_DoPorto'] = '01';
            $insert_testata_ordine['Cd_DoTrasporto'] = '001';
            $insert_testata_ordine['Cd_DoAspBene'] = 'AV';
            date_default_timezone_set('Europe/Rome');
            $ora = date('Y-m-d', strtotime('now'));
            $insert_testata_ordine['TrasportoDataOra'] = $ora;
        }
        if ($fornitore[0]->Cd_CGConto_Banca)
            $insert_testata_ordine['Cd_CGConto_Banca'] = $fornitore[0]->Cd_CGConto_Banca;
        $data = str_replace('-', '', $data);
        $insert_testata_ordine['DataDoc'] = $data;
        $Id_DoTes = DB::table('DOTes')->insertGetId($insert_testata_ordine);
        echo $Id_DoTes;
    }

    public
    function crea_documento_rif($cd_cf, $cd_do, $numero, $data, $numero_rif, $data_rif, $dest)
    {

        $fornitore = DB::SELECT('SELECT * FROM CF WHERE Cd_CF = \'' . $cd_cf . '\' ');
        if (sizeof($fornitore) > 0)
            $listino = $fornitore[0]->Cd_LS_1;
        else
            $listino = 'BANCO';
        if (sizeof($fornitore) > 0)
            if ($fornitore[0]->Cd_PG != null)
                $insert_testata_ordine['Cd_PG'] = $fornitore[0]->Cd_PG;
        $insert_testata_ordine['Cd_LS_1'] = $listino;
        $insert_testata_ordine['Cd_CF'] = $cd_cf;
        $insert_testata_ordine['Cd_Do'] = $cd_do;
        if ($fornitore[0]->Cd_CGConto_Banca)
            $insert_testata_ordine['Cd_CGConto_Banca'] = $fornitore[0]->Cd_CGConto_Banca;
        $insert_testata_ordine['NumeroDoc'] = $numero;
        /*if ($cd_do == 'DDT')
            $insert_testata_ordine['Modificabile'] = 0;*/
        $data = str_replace('-', '', $data);
        $insert_testata_ordine['DataDoc'] = $data;
        if ($numero_rif != '0') {
            $insert_testata_ordine['NumeroDocRif'] = $numero_rif;
            $data_rif = str_replace('-', '', $data_rif);
        }
        if ($data_rif != '0')
            $insert_testata_ordine['DataDocRif'] = $data_rif;
        if ($cd_do == 'DDT') {
            $insert_testata_ordine['Cd_DoSped'] = '02';
            $insert_testata_ordine['Cd_DoPorto'] = '01';
            $insert_testata_ordine['Cd_DoTrasporto'] = '001';
            $insert_testata_ordine['Cd_DoAspBene'] = 'AV';
            date_default_timezone_set('Europe/Rome');
            $ora = date('Y-m-d', strtotime('now'));
            $ora = str_replace('-', '', $ora);
            $insert_testata_ordine['TrasportoDataOra'] = $ora;
            if ($dest != 0)
                $insert_testata_ordine['Cd_CFDest'] = $dest;
        }
        $Id_DoTes = DB::table('DOTes')->insertGetId($insert_testata_ordine);
        echo $Id_DoTes;
    }

    public
    function aggiungi_articolo_ordine($id_ordine, $codice, $quantita, $magazzino_A, $ubicazione_A, $lotto, $magazzino_P, $ubicazione_P)
    {
        $codice = str_replace('slash', '/', $codice);
        $i = 0;
        $magazzini = DB::SELECT('SELECT * FROM MGUbicazione WHERE Cd_MG=\'' . $magazzino_A . '\'');
        foreach ($magazzini as $m) {
            if ($m->Cd_MGUbicazione == $ubicazione_A)
                $i++;
        }
        if ($ubicazione_A == 'ND')
            $i++;
        if ($i > 0) {
            ArcaUtilsController::aggiungi_articolo($id_ordine, $codice, $quantita, $magazzino_A, 1, $ubicazione_A, $lotto, $magazzino_P, $ubicazione_P);

            $ordine = DB::select('SELECT * from DOTes where Id_DOtes = ' . $id_ordine)[0];

            echo 'Articolo Caricato Correttamente ';

        } else {
            echo 'Ubicazione inserita inesistente in quel magazzino';
            exit();
        }
    }

    public
    function cerca_articolo_smart_automatico($q, $cd_cf)
    {
        $q = str_replace("slash", "/", $q);
        $q = str_replace("punto", ";", $q);
        $qta = 'ND';/*
            $decoder = new Decoder($delimiter = '');
            $barcode = $decoder->decode($q);
            $where = ' where 1=1 ';
            foreach ($barcode->toArray()['identifiers'] as $field) {

                if ($field['code'] == '01') {
                    $testo = trim($field['content'], '*,');
                    $where .= ' and AR.Cd_AR Like \'%' . $testo . '%\'';
                }
                if ($field['code'] == '310') {
                    $decimali = floatval(substr($field['raw_content'],-2));
                    $qta = floatval(substr($field['raw_content'],0,4))+$decimali/100;
                }
                if ($field['code'] == '10') {
                    $where .= ' and ARLotto.Cd_ARLotto Like \'%' . $field['content'] . '%\'';
                }

            }
            $articoli = DB::select('SELECT AR.[Id_AR],AR.[Cd_AR],AR.[Descrizione],ARLotto.[Cd_ARLotto] FROM AR LEFT JOIN ARLotto on AR.Cd_AR = ARLotto.Cd_AR ' . $where . '  Order By Id_AR DESC');
*/
        $q = explode(';', $q);
        $q = $q[0];
        $articoli = DB::select('SELECT AR.[Id_AR],AR.[Cd_AR],AR.[Descrizione],ARLotto.[Cd_ARLotto] FROM AR LEFT JOIN ARLotto ON AR.Cd_AR = ARLotto.Cd_ARLotto LEFT JOIN ARAlias ON ARAlias.Cd_AR = AR.Cd_AR where AR.Obsoleto = 0 AND AR.Cd_AR Like \'' . $q . '%\' or  AR.Descrizione Like \'%' . $q . '%\' or AR.CD_AR IN (SELECT CD_AR from ARAlias where Alias LIKE \'%' . $q . '%\') Order By AR.Id_AR DESC');
        if (sizeof($articoli) > 0) {
            $articolo = $articoli[0];
            ?>
            '<?php echo $cd_cf ?>','<?php echo $q; ?>','<?php if ($articolo->Cd_ARLotto != '') echo $articolo->Cd_ARLotto; else echo '0'; ?>','<?php if ($qta != '') echo $qta; else echo '0'; ?>'
            <?php
        }
    }

    public
    function cerca_articolo_smart_manuale($q, $cd_cf)
    {
        $q = str_replace("slash", "/", $q);
        $q = str_replace("punto", ";", $q);
        $qta = 'ND';/*
            $decoder = new Decoder($delimiter = '');
            $barcode = $decoder->decode($q);
            $where = ' where 1=1 ';
            foreach ($barcode->toArray()['identifiers'] as $field) {

                if ($field['code'] == '01') {
                    $testo = trim($field['content'], '*,');
                    $where .= ' and AR.Cd_AR Like \'%' . $testo . '%\'';
                }
                if ($field['code'] == '310') {
                    $decimali = floatval(substr($field['raw_content'],-2));
                    $qta = floatval(substr($field['raw_content'],0,4))+$decimali/100;
                }
                if ($field['code'] == '10') {
                    $where .= ' and ARLotto.Cd_ARLotto Like \'%' . $field['content'] . '%\'';
                }

            }
            $articoli = DB::select('SELECT AR.[Id_AR],AR.[Cd_AR],AR.[Descrizione],ARLotto.[Cd_ARLotto] FROM AR LEFT JOIN ARLotto on AR.Cd_AR = ARLotto.Cd_AR ' . $where . '  Order By Id_AR DESC');
*/

        $articoli = DB::select('SELECT AR.[Id_AR],AR.[Cd_AR],AR.[Descrizione],ARLotto.[Cd_ARLotto] FROM AR LEFT JOIN ARLotto ON AR.Cd_AR = ARLotto.Cd_ARLotto LEFT JOIN ARAlias ON ARAlias.Cd_AR = AR.Cd_AR where AR.Obsoleto = 0 AND AR.Cd_AR Like \'' . $q . '%\' or  AR.Descrizione Like \'%' . $q . '%\' or AR.CD_AR IN (SELECT CD_AR from ARAlias where Alias LIKE \'%' . $q . '%\') Order By AR.Id_AR DESC');
        if (sizeof($articoli) > 0) {
            foreach ($articoli as $articolo) { ?>

                <li class="list-group-item">
                    <a href="#" onclick="" class="media">
                        <div class="media-body"
                             onclick="cerca_articolo_codice('<?php echo $cd_cf ?>','<?php echo $q ?>','<?php if ($articolo->Cd_ARLotto != '') echo $articolo->Cd_ARLotto; else echo '0'; ?>','<?php if ($qta != '') echo $qta; else echo '0'; ?>')">
                            <h5><?php echo $articolo->Descrizione; ?></h5>
                            <p>Codice: <?php echo $articolo->Cd_AR ?></p>
                        </div>
                    </a>
                </li>

            <?php }
        }
    }


    public
    function controllo_articolo_smart($q, $id_dotes)
    {
        /*
                $decoder = new Decoder($delimiter = '');
                $barcode = $decoder->decode($q);
                $where = ' where 1=1 ';
                foreach ($barcode->toArray()['identifiers'] as $field) {

                    if ($field['code'] == '01') {
                        $contenuto = trim($field['content'],'*,');
                        $where .= ' and Cd_AR Like \'%' . $contenuto . '%\'';

                    }
                    if ($field['code'] == '10') {
                        $where .= ' and Cd_ARLotto Like \'%' . $field['content'] . '%\'';

                    }
                    if ($field['code'] == '310') {
                        $decimali = floatval(substr($field['raw_content'],-2));
                        $qta = floatval(substr($field['raw_content'],0,4))+$decimali/100;
                        $where .= ' and Qta Like \'%' . $qta . '%\'';

                    }

                }*/

        $q = str_replace("slash", "/", $q);
        $q = str_replace("punto", ";", $q);
        $q = explode(';', $q);
        $q = $q[0];
        $c = $q;
        $q = DB::SELECT('SELECT * FROM ARALias WHERE Alias = \'' . $q . '\' ');


        if (sizeof($q) != 0)
            $q = $q[0]->Cd_AR;
        else
            $q = $c;
        $articoli = DB::select('SELECT * FROM DoRig WHERE Cd_AR = \'' . $q . '\' and Id_DoTes in (\'' . $id_dotes . '\') Order By QtaEvadibile DESC');
        if (sizeof($articoli) > 0)
            $articoli = $articoli[0]; ?>

        <script type="text/javascript">

            $('#modal_controllo_articolo').val('<?php echo $articoli->Cd_AR ?>');
            $('#modal_controllo_quantita').val(<?php echo floatval($articoli->Qta) ?>);
            $('#modal_controllo_lotto').val('<?php echo $articoli->Cd_ARLotto ?>');
            $('#modal_controllo_dorig').val('<?php echo $articoli->Id_DORig ?>');


        </script>

        <?php
        //TODO CAMBAIRE GESTIONE EVASIONE A PZ A SECONDA DEL BARCODE

    }


    /**
     * Sezione Inventario di Magazzino
     * @return mixed
     */


    public
    function cerca_articolo_inventario($barcode)
    {

        $articoli = DB::select('SELECT AR.[Id_AR],AR.[Cd_AR],AR.[Descrizione],ARLotto.[Cd_ARLotto] FROM AR LEFT JOIN ARLotto ON AR.Cd_AR = ARLotto.Cd_AR where AR.Cd_AR = \'' . $barcode . '\' or  AR.Descrizione = \'' . $barcode . '\' or AR.CD_AR IN (SELECT CD_AR from ARAlias where Alias = \'' . $barcode . '\')  Order By AR.Id_AR DESC');


        if (sizeof($articoli) == '0') {
            $decoder = new Decoder($delimiter = '');
            $barcode = $decoder->decode($barcode);
            $where = ' where 1=1  ';

            foreach ($barcode->toArray()['identifiers'] as $field) {

                if ($field['code'] == '01') {
                    $testo = trim($field['content'], '*,');
                    $where .= ' and AR.Cd_AR Like \'%' . $testo . '%\'';

                }
                if ($field['code'] == '10') {
                    $where .= ' and ARLotto.Cd_ARLotto Like \'%' . $field['content'] . '%\'';
                    $Cd_ARLotto = $field['content'];
                }

            }
            $articoli = DB::select('SELECT AR.[Id_AR],AR.[Cd_AR],AR.[Descrizione],ARLotto.[Cd_ARLotto] FROM AR LEFT JOIN ARLotto on AR.Cd_AR = ARLotto.Cd_AR ' . $where . '  Order By Id_AR DESC');

        }
        if (sizeof($articoli) > 0) {
            $articolo = $articoli[0];
            $quantita = 0;
            $disponibilita = DB::select('SELECT ISNULL(sum(QuantitaSign),0) as disponibilita from MGMOV where Cd_MGEsercizio = ' . date('Y') . ' and Cd_AR = \'' . $articolo->Cd_AR . '\'');
            if (sizeof($disponibilita) > 0) {
                $quantita = floatval($disponibilita[0]->disponibilita);
                $prova = DB::SELECT('SELECT ISNULL(sum(QuantitaSign),0) as disponibilita,Cd_ARLotto,Cd_MG from MGMOV where Cd_MGEsercizio = ' . date('Y') . ' and Cd_AR = \'' . $articolo->Cd_AR . '\' and Cd_ARLotto IS NOT NULL group by Cd_ARLotto, Cd_MG HAVING SUM(QuantitaSign)!= 0  ');
            }

            /*  echo '<h3>Disponibilit??: ' . $quantita . '</h3>';*/
            ?>
            <script type="text/javascript">
                $('#modal_Cd_AR').val('<?php echo $articolo->Cd_AR ?>');
                $('#modal_Cd_ARLotto').html('<option value="">Nessun Lotto</option>');
                <?php foreach($prova as $l){?>
                $('#modal_Cd_ARLotto').append('<option quantita="<?php echo floatval($l->disponibilita) ?>" magazzino="<?php echo $l->Cd_MG ?>" <?php echo ($Cd_ARLotto == $l->Cd_ARLotto) ? 'selected' : '' ?>><?php echo $l->Cd_ARLotto . ' - ' . $l->Cd_MG ?></option>')
                <?php } ?>

                cambioLotto();

            </script>
        <?php }
    }


    public
    function rettifica_articolo($codice, $quantita, $lotto, $magazzino)
    {

        try {
            DB::beginTransaction();

            $id_MGMovInt = DB::table('MGMovInt')->insertGetId(array('Tipo' => 0, 'DataMov' => date('Ymd'), 'Descrizione' => 'Movimenti Rettifica'));
            DB::insert('INSERT INTO MGMoV(DataMov,PartenzaArrivo,PadreComponente,Cd_MGEsercizio,Cd_AR,Cd_MG,Quantita,Ret,Id_MgMovInt,Cd_ARLotto) VALUES (\'' . date('Ymd') . '\',\'A\',\'P\',' . date('Y') . ',\'' . $codice . '\',\'' . $magazzino . '\',' . $quantita . ',1,' . $id_MGMovInt . ',\'' . $lotto . '\' )');
            echo 'Quantit?? Rettificata con Successo';

            DB::commit();
        } catch (\PDOException $e) {
            // Woopsy
            print_r($e);
            DB::rollBack();
        }


    }

    public
    function cerca_articolo_smart_inventario($q, $tipo)
    {
        $Cd_ARLotto = 'NESSUN LOTTO';
        if ($tipo == 'GS1') {

            $decoder = new Decoder($delimiter = '');
            $barcode = $decoder->decode($q);
            $where = ' where 1=1 ';

            foreach ($barcode->toArray()['identifiers'] as $field) {

                if ($field['code'] == '01') {
                    $testo = trim($field['content'], '*,');
                    $where .= ' and AR.Cd_AR Like \'%' . $testo . '%\'';

                }
                if ($field['code'] == '10') {
                    $Cd_ARLotto = $field['content'];
                }

            }

            $articoli = DB::select('SELECT [Id_AR],[Cd_AR],[Descrizione] FROM AR ' . $where . '  Order By Id_AR DESC');
            if (sizeof($articoli) > 0) {
                foreach ($articoli as $articolo) { ?>

                    <li class="list-group-item">
                        <a href="#" onclick="" class="media">
                            <div class="media-body"
                                 onclick="cerca_articolo_inventario_codice('<?php echo $articolo->Cd_AR ?>','<?php echo $Cd_ARLotto; ?>') ">
                                <h5><?php echo $articolo->Descrizione ?></h5>
                                <p>Codice: <?php echo $articolo->Cd_AR ?></p>
                            </div>
                        </a>
                    </li>

                <?php }
            } else
                echo 'Nessun Articolo Trovato';
        }
        if ($tipo == 'EAN') {
            $articoli = DB::select('SELECT [Id_AR],[Cd_AR],[Descrizione] FROM AR where (Cd_AR Like \'' . $q . '%\' or  Descrizione Like \'%' . $q . '%\' or CD_AR IN (SELECT CD_AR from ARAlias where Alias LIKE \'%' . $q . '%\'))  Order By Id_AR DESC');
            if (sizeof($articoli) > 0) {
                foreach ($articoli as $articolo) { ?>

                    <li class="list-group-item">
                        <a href="#" onclick="" class="media">
                            <div class="media-body"
                                 onclick="cerca_articolo_inventario_codice('<?php echo $articolo->Cd_AR ?>','NESSUNLOTTO')">
                                <h5><?php echo $articolo->Descrizione ?></h5>
                                <p>Codice: <?php echo $articolo->Cd_AR ?></p>
                            </div>
                        </a>
                    </li>

                <?php }
            } else
                echo 'Nessun Articolo Trovato';
        }
    }


    public
    function cerca_articolo_inventario_codice($codice, $Cd_ARLotto)
    {

        $articoli = DB::select('SELECT AR.Cd_AR from AR where Cd_AR = \'' . $codice . '\'');

        if (sizeof($articoli) > 0) {
            $articolo = $articoli[0];
            $quantita = 0;
            $disponibilita = DB::select('SELECT ISNULL(sum(QuantitaSign),0) as disponibilita from MGMOV where Cd_MGEsercizio = ' . date('Y') . ' and Cd_AR = \'' . $articolo->Cd_AR . '\'');
            if (sizeof($disponibilita) > 0) {
                $prova = DB::SELECT('SELECT ISNULL(sum(QuantitaSign),0) as disponibilita,Cd_ARLotto,Cd_MG from MGMOV where Cd_MGEsercizio = ' . date('Y') . ' and Cd_AR = \'' . $articolo->Cd_AR . '\' and Cd_ARLotto IS NOT NULL group by Cd_ARLotto, Cd_MG HAVING SUM(QuantitaSign)!= 0  ');
            }

            /* echo '<h3>Disponibilit??: ' . $quantita . '</h3>';*/
            ?>
            <script type="text/javascript">
                $('#modal_Cd_AR').val('<?php echo $articolo->Cd_AR ?>');
                $('#modal_Cd_ARLotto').html('<option value="">Nessun Lotto</option>');
                <?php foreach($prova as $l){?>
                $('#modal_Cd_ARLotto').append('<option quantita="<?php echo floatval($l->disponibilita) ?>" magazzino="<?php echo $l->Cd_MG ?>" <?php echo ($Cd_ARLotto == $l->Cd_ARLotto) ? 'selected' : '' ?>><?php echo $l->Cd_ARLotto . ' - ' . $l->Cd_MG ?></option>')
                <?php } ?>

                cambioLotto();

            </script>
            <?php
        }

    }

    public
    function elimina($id_dotes)
    {
        DB::table('DoRig')->where('Id_DOTes', $id_dotes)->delete();
        DB::table('DOTes')->where('Id_DOTes', $id_dotes)->delete();
        echo 'Eliminato';
    }

    public
    function salva($id_dotes)
    {
        //DB::update("Update dotes set Modificabile = 0 where id_dotes = $id_dotes ");
        DB::statement("exec asp_DO_End $id_dotes");
    }

    public
    function invia_mail($id_dotes, $id_dorig, $testo)
    {
        if ($id_dorig == '1') {
            if (substr($testo, 0, 2) == '01') {
                $decoder = new Decoder($delimiter = '');
                $barcode = $decoder->decode($testo);
                $where = 'Articolo ';
                foreach ($barcode->toArray()['identifiers'] as $field) {

                    if ($field['code'] == '01') {
                        $contenuto = trim($field['content'], '*,');
                        $where .= $contenuto;

                    }
                    if ($field['code'] == '10') {
                        $where .= ' con lotto ' . $field['content'];

                    }
                    /*
                    if ($field['code'] == '310') {
                        $decimali = floatval(substr($field['raw_content'],-2));
                        $qta = floatval(substr($field['raw_content'],0,4))+$decimali/100;
                        $where .= ' and Qta Like \'%' . $qta . '%\'';
                    }*/

                }
                $where .= ' non trovato. ';
            }
        } else {
            if ($id_dorig == '2') {
                $testo = str_replace('*', '', $testo);
                $where = $testo;
            } else {
                $where = trim($testo, '-');
            }


        }

        if ($id_dorig == '3') {
            $documento = DB::SELECT('Select * from dotes where Id_DOTes = \'' . $id_dotes . '\'')[0]->Cd_Do;
            $testo = str_replace('(documento)', $documento, $testo);
            $where = $testo;
        }

    }


}

<?php
   /**
    * Gerenciador Clï¿½nico Odontolï¿½gico
    * Copyright (C) 2006 - 2009
    * Autores: Ivis Silva Andrade - Engenharia e Design(ivis@expandweb.com)
    *          Pedro Henrique Braga Moreira - Engenharia e Programaï¿½ï¿½o(ikkinet@gmail.com)
    *
    * Este arquivo ï¿½ parte do programa Gerenciador Clï¿½nico Odontolï¿½gico
    *
    * Gerenciador Clï¿½nico Odontolï¿½gico ï¿½ um software livre; vocï¿½ pode
    * redistribuï¿½-lo e/ou modificï¿½-lo dentro dos termos da Licenï¿½a
    * Pï¿½blica Geral GNU como publicada pela Fundaï¿½ï¿½o do Software Livre
    * (FSF); na versï¿½o 2 da Licenï¿½a invariavelmente.
    *
    * Este programa ï¿½ distribuï¿½do na esperanï¿½a que possa ser ï¿½til,
    * mas SEM NENHUMA GARANTIA; sem uma garantia implï¿½cita de ADEQUAï¿½ï¿½O
    * a qualquer MERCADO ou APLICAï¿½ï¿½O EM PARTICULAR. Veja a
    * Licenï¿½a Pï¿½blica Geral GNU para maiores detalhes.
    *
    * Vocï¿½ recebeu uma cï¿½pia da Licenï¿½a Pï¿½blica Geral GNU,
    * que estï¿½ localizada na raï¿½z do programa no arquivo COPYING ou COPYING.TXT
    * junto com este programa. Se nï¿½o, visite o endereï¿½o para maiores informaï¿½ï¿½es:
    * http://www.gnu.org/licenses/old-licenses/gpl-2.0.html (Inglï¿½s)
    * http://www.magnux.org/doc/GPL-pt_BR.txt (Portuguï¿½s - Brasil)
    *
    * Em caso de dï¿½vidas quanto ao software ou quanto ï¿½ licenï¿½a, visite o
    * endereï¿½o eletrï¿½nico ou envie-nos um e-mail:
    *
    * http://www.smileodonto.com.br/gco
    * smile@smileodonto.com.br
    *
    * Ou envie sua carta para o endereï¿½o:
    *
    * Smile Odontolï¿½ogia
    * Rua Laudemira Maria de Jesus, 51 - Lourdes
    * Arcos - MG - CEP 35588-000
    *
    *
    */
	include "../lib/config.inc.php";
	include "../lib/func.inc.php";
	include "../lib/classes.inc.php";
	require_once '../lang/'.$idioma.'.php';
	header("Content-type: text/html; charset=ISO-8859-1", true);
	if(!checklog()) {
		die($frase_log);
	}
	$paciente = new TOrtodontia();
	if(isset($_POST['Salvar'])) {
		$paciente->LoadOrtodontia($_GET['codigo']);
		foreach($_POST as $chave => $valor) {
            if($chave != 'Salvar') {
                $paciente->SetDados($chave, $valor);
            }
		}
		$paciente->Salvar();
	}
	$frmActEdt = "?acao=editar&codigo=".$_GET['codigo'];
	$paciente->LoadOrtodontia($_GET['codigo']);
	$strLoCase = encontra_valor('pacientes', 'codigo', $_GET['codigo'], 'nome').' - '.$_GET['codigo'];
	$row = $paciente->RetornaTodosDados();
	$check = array('tratamento');
	foreach($check as $campo) {
		if($row[$campo] == 'Sim') {
			$chk[$campo]['Sim'] = 'checked';
		} else {
			$chk[$campo]['Nï¿½o'] = 'checked';
		}
	}
	$acao = '&acao=editar';
	if(isset($strScrp)) {
		echo '<scr'.'ipt>'.$strScrp.'</scr'.'ipt>';
		die();
	}
?>
<link href="../css/smile.css" rel="stylesheet" type="text/css" />

  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="conteudo">
    <tr>
      <td width="100%">&nbsp;&nbsp;&nbsp;<img src="pacientes/img/pacientes.png" alt="<?php echo $LANG['patients']['manage_patients']?>"> <span class="h3"><?php echo $LANG['patients']['manage_patients']?> &nbsp;[<?php echo $strLoCase?>] </span></td>
    </tr>
  </table>
<div class="conteudo" id="table dados">
<br />
<?php include('submenu.php')?>
<br>
  <table width="610" border="0" align="center" cellpadding="0" cellspacing="0" class="tabela_titulo">

    <tr>
      <td height="26">&nbsp;<?php echo $LANG['patients']['orthodonty']?> </td>
    </tr>
  </table>
  <table width="610" border="0" align="center" cellpadding="0" cellspacing="0" class="tabela">
    <tr>
      <td>
      <form id="form2" name="form2" method="POST" action="pacientes/ortodontia_ajax.php<?php echo $frmActEdt?>" onsubmit="formSender(this, 'conteudo'); return false;"><br /><fieldset>
        <table width="100%" border="0" cellpadding="2" cellspacing="0" class="texto">
          <tr>
            <td width="50%">&nbsp;</td>
            <td width="50%">&nbsp;</td>
          </tr>
          <tr bgcolor="#F8F8F8">
            <td>
              <?php echo $LANG['patients']['has_the_patient_been_under_orthodontic_treatment_before']?>
            </td>
            <td>
              <input name="tratamento" <?php echo $chk['tratamento']['Sim']?> type="radio" <?php echo $disable?> value="Sim" /> <?php echo $LANG['patients']['yes']?>
              <input name="tratamento" <?php echo $chk['tratamento']['Nï¿½o']?> type="radio" <?php echo $disable?> value="Nï¿½o" /> <?php echo $LANG['patients']['no']?>
            </td>
          </tr>
          <tr>
            <td>
              <?php echo $LANG['patients']['forecast_for_orthodontic_treatment']?>
            </td>
            <td>
              <input name="previsao" value="<?php echo $row['previsao']?>" size="40" type="text" class="forms" <?php echo $disable?> />
            </td>
          </tr>
          <tr bgcolor="#F8F8F8">
            <td>
              <?php echo $LANG['patients']['reasons_for_orthodontic_treatment']?>
            </td>
            <td>
              <input name="razoes" value="<?php echo $row['razoes']?>" size="40" type="text" class="forms" <?php echo $disable?> />
            </td>
          </tr>
          <tr>
            <td>
              <?php echo $LANG['patients']['patients_degree_of_motivation']?>
            </td>
            <td>
              <input name="motivacao" value="<?php echo $row['motivacao']?>" size="40" type="text" class="forms" <?php echo $disable?> />
            </td>
          </tr>
          <tr bgcolor="#F8F8F8">
            <td>
              <?php echo $LANG['patients']['evaluation_of_profile']?>
            </td>
            <td>
              <input name="perfil" value="<?php echo $row['perfil']?>" size="40" type="text" class="forms" <?php echo $disable?> />
            </td>
          </tr>
          <tr>
            <td>
              <?php echo $LANG['patients']['facial_symmetry']?>
            </td>
            <td>
              <input name="simetria" value="<?php echo $row['simetria']?>" size="40" type="text" class="forms" <?php echo $disable?> />
            </td>
          </tr>
          <tr bgcolor="#F8F8F8">
            <td>
              <?php echo $LANG['patients']['patients_facial_type']?>
            </td>
            <td>
              <input name="tipologia" value="<?php echo $row['tipologia']?>" size="40" type="text" class="forms" <?php echo $disable?> />
            </td>
          </tr>
          <tr>
            <td>
              <?php echo $LANG['patients']['patients_dental_class']?>
            </td>
            <td>
              <input name="classe" value="<?php echo $row['classe']?>" size="40" type="text" class="forms" <?php echo $disable?> />
            </td>
          </tr>
          <tr bgcolor="#F8F8F8">
            <td>
              <?php echo $LANG['patients']['cross_bite']?>
            </td>
            <td>
              <input name="mordida" value="<?php echo $row['mordida']?>" size="40" type="text" class="forms" <?php echo $disable?> />
            </td>
          </tr>
          <tr>
            <td>
              <?php echo $LANG['patients']['spee_curve']?>
            </td>
            <td>
              <input name="spee" value="<?php echo $row['spee']?>" size="40" type="text" class="forms" <?php echo $disable?> />
            </td>
          </tr>
          <tr bgcolor="#F8F8F8">
            <td>
              <?php echo $LANG['patients']['overbite']?>
            </td>
            <td>
              <input name="overbite" value="<?php echo $row['overbite']?>" size="40" type="text" class="forms" <?php echo $disable?> />
            </td>
          </tr>
          <tr>
            <td>
              <?php echo $LANG['patients']['overjet']?>
            </td>
            <td>
              <input name="overjet" value="<?php echo $row['overjet']?>" size="40" type="text" class="forms" <?php echo $disable?> />
            </td>
          </tr>
          <tr bgcolor="#F8F8F8">
            <td>
              <?php echo $LANG['patients']['midline']?>
            </td>
            <td>
              <input name="media" value="<?php echo $row['media']?>" size="40" type="text" class="forms" <?php echo $disable?> />
            </td>
          </tr>
          <tr>
            <td>
              <?php echo $LANG['patients']['atm_status']?>
            </td>
            <td>
              <input name="atm" value="<?php echo $row['atm']?>" size="40" type="text" class="forms" <?php echo $disable?> />
            </td>
          </tr>
          <tr bgcolor="#F8F8F8">
            <td>
              <?php echo $LANG['patients']['radiographic_analysis']?>
            </td>
            <td colspan="3">
              <textarea name="radio" cols="40" rows="5" class="forms" <?php echo $disable?>><?php echo $row['radio']?></textarea>
            </td>
          </tr>
          <tr>
            <td>
              <?php echo $LANG['patients']['model_analysis']?>
            </td>
            <td colspan="3">
              <textarea name="modelo" cols="40" rows="5" class="forms" <?php echo $disable?>><?php echo $row['modelo']?></textarea>
            </td>
          </tr>
          <tr bgcolor="#F8F8F8">
            <td>
              <?php echo $LANG['patients']['comments']?>
            </td>
            <td colspan="3">
              <textarea name="observacoes" cols="40" rows="5" class="forms" <?php echo $disable?>><?php echo $row['observacoes']?></textarea>
            </td>
          </tr>
        </table>
        </fieldset>
        <br />
        <div align="center"><br />
          <input name="Salvar" type="submit" class="forms" <?php echo $disable?> id="Salvar" value="<?php echo $LANG['patients']['save']?>" />
        </div>
      </form>      </td>
    </tr>
  </table>

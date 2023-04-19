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
	if($_GET['confirm_del'] == 'delete') {
        mysql_query("DELETE FROM laboratorios_procedimentos_status WHERE codigo = ".$_GET['codigo_status']) or die(mysql_error());
	}
	$r = '';
	if(isset($_POST['Salvar'])) {
        if($_POST['status'] != '') {
            mysql_query("INSERT INTO laboratorios_procedimentos_status (codigo_procedimento, status, datahora) VALUES (".$_GET['codigo_procedimento'].", '".utf8_decode ( htmlspecialchars( utf8_encode($_POST['status']) , ENT_QUOTES | ENT_COMPAT, 'utf-8') )."', NOW())");
            $strScrp = 'Ajax("pacientes/laboratorio_status", "conteudo", "codigo='.$_GET['codigo'].'&acao=editar&codigo_procedimento='.$_GET['codigo_procedimento'].'")';
        } else {
            $r = '<font color="#FF0000">';
        }
	}
	$strLoCase = encontra_valor('pacientes', 'codigo', $_GET['codigo'], 'nome').' - '.$_GET['codigo'];
	$acao = '&acao=editar';
	if(isset($strScrp)) {
		echo '<scr'.'ipt>'.$strScrp.'</scr'.'ipt>';
		die();	
	}
	$row = mysql_fetch_assoc(mysql_query("SELECT tlp.*, tl.nomefantasia FROM laboratorios_procedimentos tlp INNER JOIN laboratorios tl ON tlp.codigo_laboratorio = tl.codigo WHERE tlp.codigo = ".$_GET['codigo_procedimento']));
	$codigo_dentista = $row['codigo_dentista'];
?>
<link href="../css/smile.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style4 {color: #FFFFFF}
-->
</style>
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
      <td height="26">&nbsp;<?php echo $LANG['patients']['laboratory_materials']?></td>
    </tr>
  </table>
  <table width="610" border="0" align="center" cellpadding="0" cellspacing="0" class="tabela">
    <tr>
      <td>
        <form id="form2" name="form2" method="POST" action="pacientes/laboratorio_status_ajax.php?acao=editar&codigo=<?php echo $_GET['codigo']?>&codigo_procedimento=<?php echo $_GET['codigo_procedimento']?>" onsubmit="formSender(this, 'conteudo'); return false;">
          <fieldset>
            <legend><?php echo $LANG['patients']['procedure']?></legend>
            <table width="98%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="3%"></td>
                <td width="94%">
                  <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="40%" valign="top"><?php echo $LANG['patients']['procedure']?>:<br />
                      <?php echo $row['procedimento']?></td>
                      <td width="30%" valign="top"><?php echo $LANG['patients']['laboratory']?>:<br />
                      <?php echo $row['nomefantasia']?></td>
                      <td width="30%" valign="top"><?php echo $LANG['patients']['date']?>:<br />
                      <?php echo converte_datahora(substr($row['datahora'], 0, 16), 2)?></td>
                    </tr>
                  </table>
                </td>
                <td width="3%"></td>
              </tr>
            </table>
          </fieldset><br />
          <fieldset>
            <legend><?php echo $LANG['patients']['status']?></legend>
            <table width="98%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="3%"></td>
                <td width="94%">
                  <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="85%"><?php echo $r?> *<?php echo $LANG['patients']['status']?>:<br />
                      <input type="text" class="forms" size="80" name="status" id="status" /></td>
                      <td width="15%" valign="bottom"><input type="submit" name="Salvar" value="<?php echo $LANG['patients']['save']?>" class="forms" />
                      </td>
                    </tr>
                  </table>
                </td>
                <td width="3%"></td>
              </tr>
            </table>
          </fieldset><br />
          <table width="98%" border="0" cellpadding="2" cellspacing="0" align="center">
            <tr bgcolor="#009BE6">
              <td width="60%">&nbsp;</td>
              <td width="30%">&nbsp;</td>
              <td width="10%">&nbsp;</td>
            </tr>
            <tr class="tabela_titulo" height="23">
              <td><?php echo $LANG['patients']['status']?></td>
              <td><?php echo $LANG['patients']['date']?></td>
              <td><?php echo $LANG['patients']['delete']?></td>
            </tr>
<?php
    $query = mysql_query("SELECT * FROM laboratorios_procedimentos_status WHERE codigo_procedimento = ".$_GET['codigo_procedimento']." ORDER BY datahora DESC");
    while($row = mysql_fetch_assoc($query)) {
        if($_SESSION['codigo'] == $codigo_dentista) {
            $delete = '<a href="javascript:Ajax(\'pacientes/laboratorio_status\', \'conteudo\', \'codigo='.$_GET['codigo'].'&acao=editar&codigo_procedimento='.$_GET['codigo_procedimento'].'&codigo_status='.$row['codigo'].'" onclick="return confirmLink(this)"><img src="imagens/icones/excluir.gif" border="0"></a>';
        }
?>
            <tr>
              <td><input type="text" class="forms" size="50" name="status_novo[]" value="<?php echo $row['status']?>" id="status_novo[]"  onblur="Ajax('pacientes/atualiza_status', 'lab_atualiza', 'codigo=<?php echo $row['codigo']?>&status='%2Bthis.value)"></td>
              <td><?php echo converte_datahora(substr($row['datahora'], 0, 16), 2)?></td>
              <td align="center"><?php echo $delete?></td>
            </tr>
<?php
    }
?>
          </table><br />
      </form>
      </td>
    </tr>
  </table>
  <div id="lab_atualiza">&nbsp;</div>

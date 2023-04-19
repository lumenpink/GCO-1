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
	$acao = '&acao=editar';
	$paciente = new TPacientes();
    $query = mysql_query("SELECT * FROM odontograma WHERE codigo_paciente = ".$_GET['codigo']) or die('Line 39: '.mysql_error());
    while($row = mysql_fetch_assoc($query)) {
        $dente[$row['dente']] = $row['descricao'];
    }
	$strLoCase = encontra_valor('pacientes', 'codigo', $_GET['codigo'], 'nome').' - '.$_GET['codigo'];
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
<br />
<table width="610" border="0" align="center" cellpadding="0" cellspacing="0" class="tabela_titulo">
  <tr>
    <td height="26">&nbsp;<?php echo $LANG['patients']['odontogram']?></td>
  </tr>
</table>
<table width="610" border="0" align="center" cellpadding="0" cellspacing="0" class="tabela">
  <tr>
    <td>
      <form id="form2" name="form2" method="POST" action="pacientes/incluir_ajax.php<?php echo $frmActEdt?>" onsubmit="formSender(this, 'conteudo'); return false;"><br /><fieldset>
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="background: url('pacientes/img/odontograma.gif') center center no-repeat;">
        <tr>
          <td width="35%" align="right">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
<?php
    for($i = 18; $i != 49; $i++) {
?>
              <tr>
                <td width="100%" align="right" style="height: 25px" valign="middle">
                  <input type="text" name="dente[<?php echo $i?>]" value="<?php echo $dente[$i]?>" class="forms" <?php echo $disable?>
                  onblur="Ajax('pacientes/atualiza', 'pacientes_atualiza', 'descricao='%2Bthis.value%2B'&codigo_paciente=<?php echo $_GET['codigo']?>&dente=<?php echo $i?>');" />
                </td>
              </tr>
<?php
        if($i == 11) {
            $i = 40;
        }
        if($i < 40) {
            $i -= 2;
        }
    }
?>
            </table>
          </td>
          <td width="30%" align="center">

          </td>
          <td width="35%" align="center">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
<?php
    for($i = 28; $i != 39; $i++) {
?>
              <tr>
                <td width="100%" align="left" style="height: 25px" valign="middle">
                  <input type="text" name="dente[<?php echo $i?>]" value="<?php echo $dente[$i]?>" class="forms" <?php echo $disable?>
                  onblur="Ajax('pacientes/atualiza', 'pacientes_atualiza', 'descricao='%2Bthis.value%2B'&codigo_paciente=<?php echo $_GET['codigo']?>&dente=<?php echo $i?>');" />
                </td>
              </tr>
<?php
        if($i == 21) {
            $i = 30;
        }
        if($i < 30) {
            $i -= 2;
        }
    }
?>
            </table>
          </td>
        </tr>
      </table>
    </form>
    </td>
  </tr>
    <tr>
      <td align="right"> <br />
        <img src="../imagens/icones/imprimir.gif"> <a href="relatorios/odontograma.php?codigo=<?php echo $_GET['codigo']?>" target="_blank"><?php echo $LANG['patients']['print_odontogram']?></a>&nbsp;
      </td>
    </tr>
</table>
<div id="pacientes_atualiza"></div>

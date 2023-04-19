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
	$strUpCase = "ALTERAï¿½ï¿½O";
	$strLoCase = encontra_valor('pacientes', 'codigo', $_GET['codigo'], 'nome').' - '.$_GET['codigo'];
	$acao = '&acao=editar';
?>
<link href="../css/smile.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style4 {color: #FFFFFF}
-->
</style>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="conteudo">
    <tr>
      <td width="100%">&nbsp;&nbsp;&nbsp;<img src="pacientes/img/pacientes.png" alt="<?php echo $LANG['patients']['manage_patients']?>"> <span class="h3"><?php echo $LANG['patients']['manage_patients']?> [<?php echo $strLoCase?>] </span></td>
    </tr>
  </table>
<div class="conteudo" id="table dados">
<br />
<?php include('submenu.php')?>
<br>
  <table width="610" border="0" align="center" cellpadding="0" cellspacing="0" class="tabela_titulo">
    
    <tr>
      <td height="26">&nbsp;<?php echo $LANG['patients']['radiograph']?></td>
    </tr>
  </table>
  <table width="610" border="0" align="center" cellpadding="0" cellspacing="0" class="tabela">
    <tr>
      <td>
        <br />
        <fieldset>
        <br />
          <table width="550" border="0" align="center">
            <tr>
<?php
    $query = mysql_query("SELECT * FROM radiografias WHERE codigo = '".$_GET['codigo_foto']."'") or die(mysql_error());
    $row = mysql_fetch_array($query);
?>
              <td align="left">
                <a href="javascript:Ajax('pacientes/radio', 'conteudo', 'codigo=<?php echo $_GET['codigo']?>&acao=editar&modelo=<?php echo $row['modelo']?>');"><< Voltar</a>
              </td>
            </tr>
            <tr>
              <td width="100%" align="center" valign="top">
                <img src="pacientes/verfoto_r.php?codigo=<?php echo $row['codigo']?>&tamanho=thumb" border="0"><BR>
                <font size="1"><?php echo $row['legenda']?><br /><?php echo converte_data($row['data'], 2)?></font><br><br>
                <?php echo ((verifica_nivel('pacientes', 'E'))?'<a href="pacientes/excluirfotos_r_ajax.php?codigo='.$_GET['codigo'].'&codigo_foto='.$row['codigo'].'&modelo='.$_GET['modelo'].'" onclick="return confirmLink(this)" target="iframe_upload">'.$LANG['patients']['delete_radiograph'].'</a>':'')?>
                <br />
                <br />
                <a href="pacientes/verfoto_r.php?codigo=<?php echo $row['codigo']?>" target="_blank"><?php echo $LANG['patients']['view_radiograph_in_original_size']?></a>
              </td>
           </tr>
        </table>
        <br />
        <iframe name="iframe_upload" width="1" height="1" frameborder="0" scrolling="No"></iframe>
          <form id="form2" name="form2" method="POST" action="pacientes/incluirradiodiagnostico_ajax.php?codigo=<?php echo $row['codigo']?>" enctype="multipart/form-data" target="iframe_upload"> <?php/*onsubmit="Ajax('arquivos/daclinica/arquivos', 'conteudo', '');">*/?>
  		  <table width="310" border="0" align="center" cellpadding="0" cellspacing="0">
    		<tr align="center">
              <td width="70%"><?php echo $LANG['patients']['radio_diagnosis']?> <br />
                <textarea cols="50" rows="8" class="forms" <?php echo $disable?> name="texto"><?php echo $row['diagnostico']?></textarea>
              </td>
            </tr>
            <tr align="center">
              <td width="30%"> <br />
                <input type="submit" name="Salvar" id="Salvar" value="<?php echo $LANG['patients']['save']?>" class="forms" <?php echo $disable?>>
              </td>
            </tr>
          </table>
          </form>
          <br />
        </fieldset>
        <br />
        <div align="center"><a href="relatorios/radiodiagnostico.php?codigo=<?php echo $row['codigo']?>" target="_blank"><?php echo $LANG['patients']['print'].' '.$LANG['patients']['radio_diagnosis']?></a></div>
        <br />
      </td>
    </tr>
  </table>

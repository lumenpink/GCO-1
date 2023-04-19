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
        <div align="center"><select name="modelo" class="forms" onchange="Ajax('pacientes/radio', 'conteudo', 'codigo=<?php echo $_GET['codigo']?>&acao=editar&modelo='%2Bthis.value)">
<?php
    $_GET['modelo'] = (($_GET['modelo'] != '')?$_GET['modelo']:'Panoramica');
    $valores = array('Panoramica' => $LANG['patients']['panoramic'], 'Oclusal' => $LANG['patients']['occlusal'], 'Periapical' => $LANG['patients']['periapical'], 'Interproximal' => $LANG['patients']['interproximal'], 'ATM' => $LANG['patients']['atm'], 'PA' => $LANG['patients']['posteroanterior'], 'AP' => $LANG['patients']['anteroposterior'], 'Lateral' => $LANG['patients']['lateral']);
    foreach($valores as $chave => $valor) {
        echo '          <option value="'.$chave.'" '.(($chave == $_GET['modelo'])?'selected':'').'>'.$valor.'</option>'."\n";
    }
?>
        </select></div>
        <br />
        <fieldset>
        <br />
          <table width="550" border="0" align="center">
            <tr>
<?php
	$i = 0;
	$query = mysql_query("SELECT * FROM radiografias WHERE modelo = '".$_GET['modelo']."' AND codigo_paciente = '".$_GET['codigo']."' ORDER BY data DESC, codigo DESC") or die(mysql_error());
	while($row = mysql_fetch_array($query)) {
		if($i % 2 === 0) {
			echo '</tr><tr>';
		}
?>
              <td width="50%" align="center" valign="top">
               <a href="javascript:Ajax('pacientes/radio_detalhe', 'conteudo', 'codigo=<?php echo $_GET['codigo']?>&acao=editar&codigo_foto=<?php echo $row['codigo']?>')">
               <img src="pacientes/verfoto_r.php?codigo=<?php echo $row['codigo']?>&tamanho=thumb" border="0"></a><BR>
               <font size="1"><?php echo $row['legenda']?><br /><?php echo converte_data($row['data'], 2)?></font><br><br>
               <?php echo ((verifica_nivel('pacientes', 'E'))?'<a href="pacientes/excluirfotos_r_ajax.php?codigo='.$_GET['codigo'].'&codigo_foto='.$row['codigo'].'&modelo='.$_GET['modelo'].'" onclick="return confirmLink(this)" target="iframe_upload">'.$LANG['patients']['delete_radiograph'].'</a>':'')?>
              </td>
<?php
		$i++;
	}
?>
           </tr>
        </table> 
        <br />
        </fieldset>
        <br />
        <iframe name="iframe_upload" width="1" height="1" frameborder="0" scrolling="No"></iframe>
          <form id="form2" name="form2" method="POST" action="pacientes/incluirfotos_r_ajax.php?codigo=<?php echo $_GET['codigo']?>" enctype="multipart/form-data" target="iframe_upload"> <?php/*onsubmit="Ajax('arquivos/daclinica/arquivos', 'conteudo', '');">*/?>
          <input type="hidden" name="modelo" value="<?php echo $_GET['modelo']?>" />
  		  <table width="310" border="0" align="center" cellpadding="0" cellspacing="0">
    		<tr align="center">
              <td width="70%"><?php echo $LANG['patients']['file']?> <br />
                <input type="file" size="20" name="arquivo" id="arquivo" class="forms" <?php echo $disable?>>
              </td>
            </tr>
    		<tr align="center">
              <td width="70%"><?php echo $LANG['patients']['legend']?> <br />
                <input type="text" size="33" name="legenda" id="legenda" class="forms" <?php echo $disable?>>
              </td>
            </tr>
    		<tr align="center">
              <td width="70%"><?php echo $LANG['patients']['date']?> <br />
                <input type="text" size="33" name="data" id="data" value="<?php echo date('d/m/Y')?>" class="forms" <?php echo $disable?>>
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
      </td>
    </tr>
  </table>

<?php
// esempio di generazione di template

function ShowTemplate($template,$title,$content) {

	$TemplateOut = implode(file($template));
	
	$TemplateOut = str_replace("###TITLE###",$title,$TemplateOut);
	$TemplateOut = str_replace("###CONTENT###",$content,$TemplateOut);
	
	
	return $TemplateOut;

}


$content = "Ciao";






echo ShowTemplate("template.html","TIT",$content);

?>
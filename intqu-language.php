<?php
declare(strict_types=1);
// Presentation-only translation. Stored values, validation and private storage remain canonical.
function intquIsRo(): bool { return ($_GET['lang'] ?? $_POST['lang'] ?? '') === 'ro'; }
function intquRoMap(): array {
    static $map=null;
    if ($map===null) $map=json_decode((string)file_get_contents(__DIR__.'/intqu-ro.json'),true) ?: [];
    return $map;
}
function intquTranslateText(string $text): string {
    $map=intquRoMap();$key=trim(html_entity_decode($text,ENT_QUOTES|ENT_HTML5,'UTF-8'));
    $suffix='';
    if(!isset($map[$key]) && str_ends_with($key,' – IntQu.net')) {$key=substr($key,0,-strlen(' – IntQu.net'));$suffix=' – IntQu.net';}
    if(!isset($map[$key]) && str_ends_with($key,' *')) {$key=substr($key,0,-2);$suffix=' *';}
    if(!isset($map[$key])) return $text;
    preg_match('/^\s*/u',$text,$lead);preg_match('/\s*$/u',$text,$tail);
    return $lead[0].htmlspecialchars($map[$key].$suffix,ENT_QUOTES|ENT_SUBSTITUTE,'UTF-8').$tail[0];
}
function intquLanguageUrl(string $url,string $lang): string {
    if(preg_match('~^(?:[a-z][a-z0-9+.-]*:|//)~i',$url)) return $url;
    $parts=explode('#',$url,2);$base=$parts[0];$frag=isset($parts[1])?'#'.$parts[1]:'';
    $bits=explode('?',$base,2);$query=[];parse_str($bits[1]??'',$query);$query['lang']=$lang;
    return $bits[0].'?'.http_build_query($query).$frag;
}
function intquLanguageRender(string $html): string {
    if(isset($_GET['admin']) || isset($_GET['setup']) || stripos($html,'<html')===false) return $html;
    $ro=intquIsRo();$lang=$ro?'ro':'de';
    if($ro){
        // Exclude user input, stored privacy notices, scripts and styles from text replacement.
        $parts=preg_split('~(<(?:script|style|textarea|pre)\b[^>]*>.*?</(?:script|style|textarea|pre)>|<[^>]+>)~si',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
        foreach($parts as &$part){
            if($part==='' || $part[0]==='<') continue;
            $part=intquTranslateText($part);
        }unset($part);$html=implode('',$parts);
        $html=preg_replace('~<html\s+lang="de"~','<html lang="ro"',$html,1);
        $html=preg_replace_callback('~\b(alt|aria-label|placeholder|content)="([^"]*)"~',function($m){return $m[1].'="'.intquTranslateText($m[2]).'"';},$html);
        // The operator's saved privacy notice is retained verbatim until its translation is supplied.
        $html=str_replace('<pre>','<p class="note" lang="ro">Informarea operatorului privind protecția datelor — textul original în germană:</p><pre lang="de">',$html);
        $html=preg_replace_callback('~\b(href|action)="([^"]*)"~',function($m){
            $url=html_entity_decode($m[2],ENT_QUOTES|ENT_HTML5,'UTF-8');
            if(str_starts_with($url,'#')) return $m[0];
            return $m[1].'="'.htmlspecialchars(intquLanguageUrl($url,'ro'),ENT_QUOTES,'UTF-8').'"';
        },$html);
        $html=preg_replace('~(<form\b[^>]*>)~i','$1<input type="hidden" name="lang" value="ro">',$html);
    }
    $query=$_GET;unset($query['success'],$query['preview']);
    $query['lang']='de';$de='?'.http_build_query($query);$query['lang']='ro';$roUrl='?'.http_build_query($query);
    $switch='<div class="intqu-languages" aria-label="Deutsch / Română"><a lang="de" href="'.htmlspecialchars($de,ENT_QUOTES,'UTF-8').'"'.(!$ro?' aria-current="true"':'').'>Deutsch</a> · <a lang="ro" href="'.htmlspecialchars($roUrl,ENT_QUOTES,'UTF-8').'"'.($ro?' aria-current="true"':'').'>Română</a></div>';
    $html=preg_replace('~</header>~',$switch.'</header>',$html,1);
    $html=str_replace('</head>','<style>.intqu-languages{display:flex;gap:8px;align-items:center;justify-content:flex-end;font:14px/1.4 Arial,sans-serif;padding:8px 0;white-space:nowrap}.intqu-languages a{color:inherit}.intqu-languages [aria-current]{font-weight:700;text-decoration:underline}.v2-header{flex-wrap:wrap}</style></head>',$html);
    return $html;
}
function intquFlushLanguage(): void {
    if ((ob_get_status()['name'] ?? '') === 'intquLanguageRender') ob_end_flush();
}
ob_start('intquLanguageRender');

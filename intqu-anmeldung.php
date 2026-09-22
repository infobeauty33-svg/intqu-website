<?php
declare(strict_types=1);
require_once __DIR__.'/intqu-language.php';
// IntQu.net registration MVP. Does not replace index.php.
$publicProfiles = isset($_GET['profiles']) && !isset($_GET['admin']);
ini_set('display_errors', '0');
header('Content-Type: text/html; charset=UTF-8');
header('Cache-Control: no-store');
if (!$publicProfiles) header('X-Robots-Tag: noindex, nofollow');
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: no-referrer');
header("Content-Security-Policy: default-src 'none'; style-src 'unsafe-inline'; img-src 'self'; form-action 'self'; frame-ancestors 'none'; base-uri 'none'");
define('SETUP_KEY', (string) (getenv('INTQU_SETUP_KEY') ?: ''));
const NOTICE_VERSION = 'intqu-interest-2026-09-v1';
const NEWSLETTER_TEXT = 'Ich möchte per E-Mail Neuigkeiten, Veranstaltungen und Weiterbildungsmöglichkeiten von IntQu.net erhalten. Ich kann meine Einwilligung jederzeit widerrufen.';
$roles = ['Beauty-Fachkraft','Studio / Salon','Trainer:in / Akademie','Expert:in','Marke','Hersteller','Distributor / Großhandel','Dienstleister','Eventveranstalter','Partner / Sponsor'];
$specialties = ['Kosmetik','Wimpern / Lashes','Nageldesign','Maniküre','Fußpflege / Pediküre','Friseur','Massage','Permanent Make-up','Enthaarung','Wellness','Fitness','Business / Mindset','Recht / Unternehmensberatung','Sonstiges'];
function e($s): string { return htmlspecialchars((string)$s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
function pageStart(string $title): void {
    if(defined('INTQU_NEXA_SHOWROOM') && INTQU_NEXA_SHOWROOM){
        $parts=explode('<!--NEXA_FORM-->',(string)$GLOBALS['nexaShowroomTemplate'],2);
        echo $parts[0].'<h2>'.e($title).'</h2>';return;
    }
    echo '<!doctype html><html lang="de"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>'.e($title).' – IntQu.net</title><style>
    *{box-sizing:border-box}body{margin:0;background:#f6f0ed;color:#332331;font:17px/1.6 system-ui,sans-serif}header,main,footer{max-width:920px;margin:auto;padding:24px}header{display:flex;align-items:center;justify-content:space-between;gap:16px;border-bottom:1px solid #d8c9d0}header strong{font-size:27px}header small{display:block}.site-home{color:inherit;text-decoration:none}.home-link{display:inline-block;padding:10px 14px;border:1px solid #c8aebd;border-radius:7px;background:#fff7fa;color:#66324f;font-weight:650;text-decoration:none;white-space:nowrap}a{color:#66324f}h1{font-size:clamp(29px,5vw,46px);line-height:1.15}h2,legend{font-size:23px;font-weight:650}fieldset,.card{border:1px solid #d8c9d0;border-radius:16px;padding:22px;margin:20px 0;background:#fff}legend{padding:0 8px}label{display:block;margin:15px 0 5px}input:not([type=checkbox]),textarea,select{font:inherit;width:100%;padding:11px;border:1px solid #92838b;border-radius:7px;background:white}input[type=checkbox]{width:20px;height:20px;vertical-align:middle;margin-right:10px}textarea{min-height:105px}.choices{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:4px 16px}.choices label{margin:6px 0}button,.button{display:inline-block;font:inherit;font-weight:650;background:#66324f;color:#fff;border:0;border-radius:8px;padding:13px 22px;cursor:pointer;text-decoration:none}button:focus-visible,a:focus-visible,input:focus-visible,textarea:focus-visible,select:focus-visible{outline:3px solid #267bb0;outline-offset:3px}.note{color:#67515f;font-size:15px}.error{padding:16px;background:#ffe5e5;border:2px solid #a02d2d;border-radius:8px}.ok{padding:16px;background:#e7f3e9;border:2px solid #357349;border-radius:8px}.gallery img{max-width:180px;max-height:180px;margin:8px;border-radius:8px}nav{display:flex;gap:15px;flex-wrap:wrap}.trap{position:absolute;left:-10000px}dl{overflow-wrap:anywhere}dt{font-weight:bold}dd{margin:0 0 10px;white-space:pre-wrap}summary{cursor:pointer;font-weight:600}footer{font-size:14px}pre{white-space:pre-wrap;font:inherit}
    /* Registration layout: headings stay inside their cards. */
    body{font-size:16px;line-height:1.6}
    main{padding-top:32px;padding-bottom:40px}
    fieldset{min-inline-size:0;padding:28px;margin:24px 0;border-radius:16px}
    .section-title{display:flex;align-items:center;gap:12px;margin:0 0 22px;font-size:22px;line-height:1.35;letter-spacing:-.02em}
    .section-number{display:inline-flex;align-items:center;justify-content:center;flex:0 0 36px;height:36px;border-radius:50%;background:#f4eaf0;color:#66324f;font-size:14px;letter-spacing:0}
    fieldset>p{margin:0 0 20px;color:#67515f}
    fieldset>h2:not(.section-title){margin:28px 0 14px;font-size:18px}
    fieldset>label{margin:20px 0 7px;font-weight:550}
    .choices{grid-template-columns:repeat(2,minmax(0,1fr));gap:10px 16px;margin:0 0 24px}
    label.check-label{display:flex;align-items:flex-start;gap:10px;font-weight:400;line-height:1.5}
    .choices label{margin:0;padding:12px;border:1px solid #e6dce2;border-radius:8px;background:#fcfafb;overflow-wrap:anywhere}
    input[type=checkbox]{flex:0 0 20px;margin:2px 0 0;accent-color:#66324f}
    input:not([type=checkbox]),textarea,select{min-width:0;max-width:100%;color:#332331}
    input[type=file]{font-size:14px;padding:12px;background:#fcfafb}
    input[type=file]::file-selector-button{border:0;border-radius:5px;padding:9px 12px;margin-right:10px;background:#f0e3eb;color:#4d263d;font:inherit;cursor:pointer}
    textarea{resize:vertical}
    pre{overflow-wrap:anywhere}
    .intro-copy{max-width:680px;color:#67515f}
    @media(max-width:600px){header,main,footer{padding-left:18px;padding-right:18px}fieldset{padding:20px 16px;margin:18px 0}.section-title{font-size:20px;gap:10px}.choices{grid-template-columns:1fr;gap:8px}form>button[type=submit]{width:100%}h1{font-size:32px}}
</style></head><body><header><a class="site-home" href="/"><strong>IntQu.net</strong><small>International Quality Network</small></a><a class="home-link" href="/">← Zur Homepage</a></header><main><h1>'.e($title).'</h1>';
}
function pageEnd(): void {
    if(defined('INTQU_NEXA_SHOWROOM') && INTQU_NEXA_SHOWROOM){
        $parts=explode('<!--NEXA_FORM-->',(string)$GLOBALS['nexaShowroomTemplate'],2);
        echo $parts[1]??'';intquFlushLanguage();return;
    }
    echo '</main><footer><a href="/">Zur Homepage</a> · <a href="mailto:info@intqu.net">info@intqu.net</a><br>© 2026 IntQu.net – International Quality Network. Alle Rechte vorbehalten.</footer></body></html>'; intquFlushLanguage(); }
function stopPage(string $message, int $status = 503): void { http_response_code($status); pageStart('Einrichtung noch nicht abgeschlossen'); echo '<p>'.e($message).'</p>'; pageEnd(); exit; }
function scalarPost(string $key, int $limit = 300): string {
    $v = $_POST[$key] ?? ''; if (!is_string($v) || strlen($v) > $limit) throw new RuntimeException('Bitte prüfe das Feld „'.$key.'“ und seine Länge.');
    return trim($v);
}
function picked(string $key, array $allowed): array {
    $v = $_POST[$key] ?? []; if (!is_array($v) || count($v) > count($allowed)) throw new RuntimeException('Bitte prüfe deine Auswahl.');
    foreach ($v as $item) if (!is_string($item) || !in_array($item,$allowed,true)) throw new RuntimeException('Ungültige Auswahl.');
    return array_values(array_unique($v));
}
function csrfField(): void { echo '<input type="hidden" name="csrf" value="'.e($_SESSION['csrf']).'">'; }
function csrfCheck(): void { if (!hash_equals($_SESSION['csrf'],scalarPost('csrf',100))) throw new RuntimeException('Die Sitzung ist abgelaufen. Bitte lade die Seite neu.'); }
function setting(PDO $db,string $key,string $fallback=''): string { $q=$db->prepare('SELECT value FROM settings WHERE name=?');$q->execute([$key]);$v=$q->fetchColumn();return $v===false?$fallback:(string)$v; }
function setSetting(PDO $db,string $key,string $value): void { $q=$db->prepare('INSERT OR REPLACE INTO settings(name,value) VALUES(?,?)');$q->execute([$key,$value]); }
function cleanMailHeader(string $value): string { return trim(str_replace(["\r", "\n"], ' ', $value)); }
function notifyApplication(PDO $db, array $p, int $id, array $savedFiles, string $created): bool {
    try {
        $to = 'info@intqu.net';
        $email = cleanMailHeader((string)($p['email'] ?? ''));
        $anlass = (string)($p['anlass'] ?? 'Neue Anfrage');
        $topic = preg_replace('/^IntQu\.net\s*[–-]\s*/u', '', $anlass);
        $subject = 'IntQu.net '.(($topic !== null && $topic !== '') ? $topic : $anlass);
        $body = "Neue Anfrage über www.intqu.net\n\n"
            ."ID: {$id}\n"
            ."Datum (UTC): {$created}\n\n"
            ."Name: ".($p['name'] ?? '')."\n"
            ."E-Mail: ".($p['email'] ?? '')."\n";
        foreach (['company'=>'Unternehmen / Studio','country'=>'Land','city'=>'Stadt','language'=>'Sprache','phone'=>'Telefon','anlass'=>'Anlass','description'=>'Tätigkeit und Angebot','experience'=>'Berufserfahrung','qualifications'=>'Qualifikationen','links'=>'Website / Social Media','goals'=>'Ziele im Netzwerk','public_interest'=>'Wunsch nach öffentlichem Profil','nachricht'=>'Nachricht'] as $key=>$label) {
            if (array_key_exists($key, $p) && $p[$key] !== '') $body .= $label.': '.(is_array($p[$key]) ? implode(', ', $p[$key]) : (string)$p[$key])."\n";
        }
        foreach (['roles'=>'Rollen','specialties'=>'Fachbereiche','interesse'=>'Interesse'] as $key=>$label) {
            if (!empty($p[$key])) $body .= $label.': '.implode(', ', (array)$p[$key])."\n";
        }
        $body .= "\nGespeicherte Fotos: ".count($savedFiles)."\n\n"
            ."Die vollständigen Angaben und Fotos liegen in der passwortgeschützten Verwaltung.\n";
        if (!function_exists('mail') || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            setSetting($db, 'last_notification', gmdate('c').' · Anfrage #'.$id.' · nicht vorbereitet');
            error_log('[IntQu] Interne Benachrichtigung konnte nicht vorbereitet werden. Anfrage-ID: '.$id);
            return false;
        }
        $headers = "From: IntQu.net <{$to}>\r\n"
            ."Reply-To: {$email}\r\n"
            ."MIME-Version: 1.0\r\n"
            ."Content-Type: text/plain; charset=UTF-8\r\n";
        $sent = @mail($to, '=?UTF-8?B?'.base64_encode($subject).'?=', $body, $headers);
        setSetting($db, 'last_notification', gmdate('c').' · Anfrage #'.$id.' · '.($sent?'Übergabe angenommen':'Übergabe abgelehnt'));
        if (!$sent) error_log('[IntQu] Interne Benachrichtigung konnte nicht versendet werden. Anfrage-ID: '.$id);
        return $sent;
    } catch (Throwable $ex) {
        error_log('[IntQu] Fehler bei interner Benachrichtigung. Anfrage-ID: '.$id);
        return false;
    }
}
$isLocal = in_array($_SERVER['SERVER_NAME'] ?? '', ['localhost','127.0.0.1'],true);
$https = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
if (!$https && !$isLocal) stopPage('Bitte öffne diese Seite mit https://.',400);
if (version_compare(PHP_VERSION,'8.2','<') || !class_exists('PDO') || !in_array('sqlite',PDO::getAvailableDrivers(),true)) stopPage('Für dieses Paket werden PHP 8.2 und PDO SQLite benötigt.');
session_name('INTQU_REG');
session_set_cookie_params(['httponly'=>true,'secure'=>$https,'samesite'=>'Strict','path'=>'/']);
ini_set('session.use_strict_mode','1');session_start();
if (empty($_SESSION['csrf'])) $_SESSION['csrf']=bin2hex(random_bytes(24));
$admin = isset($_GET['admin']); $setup = isset($_GET['setup']); $error='';
// Storage is only permitted outside the current document root; no webroot fallback.
$root = realpath($_SERVER['DOCUMENT_ROOT'] ?? '');
if (!$root || $root === DIRECTORY_SEPARATOR) stopPage('Der geschützte Speicherort muss für dieses Hosting gesondert eingerichtet werden.');
$folderName = '.intqu-private-'.substr(hash('sha256',__FILE__),0,16);
$store = dirname($root).DIRECTORY_SEPARATOR.$folderName;
$creating = !is_dir($store);
if ($creating && strlen(SETUP_KEY) < 32) {
    stopPage('Das Formular ist noch nicht eingerichtet. Für die einmalige Einrichtung wird der geschützte Einrichtungsschlüssel benötigt.');
}
if ($creating && (!$setup || ($_SERVER['REQUEST_METHOD']??'GET')!=='POST')) {
    pageStart('IntQu.net einrichten');echo '<p>Die Anmeldung ist noch geschlossen. Zur Einrichtung wird der Schlüssel aus der beiliegenden Anleitung benötigt.</p><form method="post" action="?setup=1">';csrfField();echo '<label>Einrichtungsschlüssel<input type="password" name="setup_key" required autocomplete="off"></label><button>Geschützten Speicher prüfen</button></form>';pageEnd();exit;
}
if ($creating) {
    try { csrfCheck(); if (!hash_equals(SETUP_KEY,scalarPost('setup_key',100))) throw new RuntimeException('Der Einrichtungsschlüssel stimmt nicht.'); }
    catch (Throwable $ex) {stopPage($ex->getMessage(),403);}
    umask(0077);if (!@mkdir($store,0700)) stopPage('Der Server erlaubt hier keinen geschützten Ordner außerhalb der Homepage. Es wurde keine Anmeldung geöffnet. Bitte dieses Ergebnis an CLEOs Chat senden.');
}
$resolved = realpath($store);
if (!$resolved || is_link($store) || $resolved===$root || str_starts_with($resolved,$root.DIRECTORY_SEPARATOR)) stopPage('Der Speicherort erfüllt die Sicherheitsprüfung nicht. Die Anmeldung bleibt geschlossen.');
if (!is_writable($resolved)) stopPage('Der geschützte Speicherordner ist nicht beschreibbar.');
try {
    umask(0077);$db = new PDO('sqlite:'.$resolved.'/intqu.sqlite');$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);$db->exec('PRAGMA busy_timeout=5000');$db->exec('PRAGMA foreign_keys=ON');
    $db->exec('CREATE TABLE IF NOT EXISTS settings(name TEXT PRIMARY KEY,value TEXT NOT NULL);
    CREATE TABLE IF NOT EXISTS applications(id INTEGER PRIMARY KEY AUTOINCREMENT,created TEXT NOT NULL,payload TEXT NOT NULL,newsletter TEXT NOT NULL,consent_at TEXT,consent_text TEXT,privacy_text TEXT NOT NULL,status TEXT NOT NULL DEFAULT "neu",published INTEGER NOT NULL DEFAULT 0);
    CREATE TABLE IF NOT EXISTS photos(id INTEGER PRIMARY KEY AUTOINCREMENT,application_id INTEGER NOT NULL REFERENCES applications(id) ON DELETE CASCADE,filename TEXT NOT NULL);
    CREATE TABLE IF NOT EXISTS attempts(bucket TEXT PRIMARY KEY,count INTEGER NOT NULL,until INTEGER NOT NULL);');
    $applicationColumns=$db->query('PRAGMA table_info(applications)')->fetchAll(PDO::FETCH_COLUMN,1);
    if(!in_array('published',$applicationColumns,true))$db->exec('ALTER TABLE applications ADD COLUMN published INTEGER NOT NULL DEFAULT 0');
} catch(Throwable $ex) {stopPage('Die Datenbank konnte nicht geöffnet werden. Die Anmeldung bleibt geschlossen.');}
function rateCheck(PDO $db,string $purpose,int $max,int $window): void {
    $key=hash_hmac('sha256',$purpose.'|'.($_SERVER['REMOTE_ADDR']??'unknown'),SETUP_KEY);$now=time();
    $db->exec('DELETE FROM attempts WHERE until < '.(int)$now);
    $q=$db->prepare('INSERT INTO attempts(bucket,count,until) VALUES(?,1,?) ON CONFLICT(bucket) DO UPDATE SET count=count+1');$q->execute([$key,$now+$window]);
    $q=$db->prepare('SELECT count FROM attempts WHERE bucket=?');$q->execute([$key]);if ((int)$q->fetchColumn()>$max) throw new RuntimeException('Zu viele Versuche. Bitte später erneut versuchen.');
}
if (setting($db,'admin_hash')==='') {
    if (($_SERVER['REQUEST_METHOD']??'GET')==='POST' && isset($_POST['password'])) {
        try {csrfCheck();rateCheck($db,'setup',10,900);if (!hash_equals(SETUP_KEY,scalarPost('setup_key',100))) throw new RuntimeException('Der Einrichtungsschlüssel stimmt nicht.');$pw=scalarPost('password',200);if(strlen($pw)<14)throw new RuntimeException('Bitte mindestens 14 Zeichen für das Passwort verwenden.');
            $db->exec('BEGIN IMMEDIATE');if(setting($db,'admin_hash')!=='')throw new RuntimeException('Die Einrichtung ist bereits abgeschlossen.');setSetting($db,'admin_hash',password_hash($pw,PASSWORD_DEFAULT));$db->exec('COMMIT');session_regenerate_id(true);$_SESSION['admin_until']=time()+1800;header('Location: ?admin=1');exit;
        }catch(Throwable $ex){if($db->inTransaction())$db->rollBack();$error=$ex instanceof RuntimeException && !($ex instanceof PDOException)?$ex->getMessage():'Einrichtung fehlgeschlagen.';}
    }
    pageStart('Verwaltungszugang einrichten');echo '<p>SQLite wurde im geschützten Ordner außerhalb des aktuellen Website-Verzeichnisses angelegt. Die öffentliche Anmeldung bleibt zunächst geschlossen.</p>';
    if($error)echo '<p class="error">'.e($error).'</p>';echo '<form method="post" action="?setup=1">';csrfField();echo '<label>Einrichtungsschlüssel<input type="password" name="setup_key" required autocomplete="off"></label><label>Neues Verwaltungspasswort (mindestens 14 Zeichen)<input type="password" name="password" minlength="14" maxlength="200" required autocomplete="new-password"></label><button>Zugang anlegen</button></form>';pageEnd();exit;
}
function publicProfileRow(PDO $db,int $id): ?array {
    $q=$db->prepare('SELECT * FROM applications WHERE id=? AND published=1');$q->execute([$id]);$row=$q->fetch(PDO::FETCH_ASSOC);
    return $row?:null;
}
function publicProfilePhoto(PDO $db,string $resolved,int $photoId): void {
    $q=$db->prepare('SELECT p.filename FROM photos p JOIN applications a ON a.id=p.application_id WHERE p.id=? AND a.published=1');$q->execute([$photoId]);$file=$q->fetchColumn();
    if(!$file||!preg_match('/^[a-f0-9]{48}\.jpg$/D',(string)$file)||!is_file($resolved.'/'.$file)){http_response_code(404);exit;}
    header('Content-Type: image/jpeg');header('Cache-Control: public, max-age=3600');readfile($resolved.'/'.$file);exit;
}
function publicProfilePhotoId(PDO $db,int $applicationId): int {
    $q=$db->prepare('SELECT id FROM photos WHERE application_id=? ORDER BY id LIMIT 1');$q->execute([$applicationId]);return (int)($q->fetchColumn()?:0);
}
function publicProfileLinks(string $value): string {
    $html='';
    foreach(preg_split('/\R+/',trim($value)) as $link){$link=trim($link);if($link===''||!filter_var($link,FILTER_VALIDATE_URL))continue;$scheme=strtolower((string)parse_url($link,PHP_URL_SCHEME));if(!in_array($scheme,['http','https'],true))continue;$html.='<li><a rel="noopener" target="_blank" href="'.e($link).'">'.e($link).'</a></li>';}
    return $html;
}
function downloadPrivateBackup(string $store): never {
    if (!class_exists('ZipArchive')) throw new RuntimeException('Der Server unterstützt den geschützten Daten-Download derzeit nicht. Die Anfragen bleiben weiterhin in der Verwaltung erhalten.');
    $temporary = tempnam(sys_get_temp_dir(), 'intqu-backup-');
    if ($temporary === false) throw new RuntimeException('Die Sicherungsdatei konnte nicht vorbereitet werden.');
    $zipFile = $temporary.'.zip';
    @unlink($temporary);
    $zip = new ZipArchive();
    if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) throw new RuntimeException('Die Sicherungsdatei konnte nicht erstellt werden.');
    $database = $store.'/intqu.sqlite';
    if (!is_file($database) || !$zip->addFile($database, 'intqu.sqlite')) { $zip->close(); @unlink($zipFile); throw new RuntimeException('Die Anfragen konnten nicht zur Sicherung hinzugefügt werden.'); }
    $zip->addFromString('BITTE_SICHER_AUFBEWAHREN.txt', "IntQu.net – vertrauliche Datensicherung\n\nEnthält die Anmeldung-Datenbank und alle hochgeladenen Fotos.\nNicht öffentlich weitergeben.\nErstellt: ".gmdate('c')."\n");
    foreach (glob($store.'/*.jpg') ?: [] as $photo) if (is_file($photo)) $zip->addFile($photo, 'fotos/'.basename($photo));
    $zip->close();
    if (!is_file($zipFile)) throw new RuntimeException('Die Sicherungsdatei konnte nicht abgeschlossen werden.');
    register_shutdown_function(static function() use ($zipFile): void { @unlink($zipFile); });
    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="intqu-vertrauliche-daten-'.gmdate('Y-m-d-His').'.zip"');
    header('Content-Length: '.(string)filesize($zipFile));
    header('X-Content-Type-Options: nosniff');
    readfile($zipFile);
    exit;
}
if($publicProfiles){
    if(isset($_GET['photo']))publicProfilePhoto($db,$resolved,(int)$_GET['photo']);
    $profileId=(int)($_GET['profile']??0);$row=$profileId?publicProfileRow($db,$profileId):null;
    if($profileId&&!$row){http_response_code(404);pageStart('Profil nicht gefunden');echo '<p class="error">Dieses Profil ist nicht verfügbar.</p>';pageEnd();exit;}
    pageStart('Mitglieder & Partner');
    echo '<style>.public-intro{max-width:700px}.profile-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,300px));justify-content:start;gap:20px}.profile-card{max-width:300px;border:1px solid #d8c9d0;border-radius:16px;overflow:hidden;background:#fff;display:flex;flex-direction:column}.profile-photo{display:block;width:100%;aspect-ratio:4/3;object-fit:cover;background:#f0e4ea}.profile-card .profile-photo{height:220px;aspect-ratio:auto}.profile-placeholder{display:flex;align-items:center;justify-content:center;color:#66324f;font-size:15px}.profile-card-body{padding:20px}.profile-kind{margin:0 0 6px;color:#8b526d;font-size:13px;font-weight:700;letter-spacing:.08em;text-transform:uppercase}.profile-card h2,.profile-detail h2{margin:0 0 8px;font-size:25px;line-height:1.2}.profile-meta{margin:0 0 14px;color:#67515f}.profile-text{white-space:pre-wrap}.profile-tags{display:flex;flex-wrap:wrap;gap:7px;margin:14px 0}.profile-tags span{padding:5px 9px;border-radius:999px;background:#f4e8ed;color:#66324f;font-size:13px}.profile-detail{border:1px solid #d8c9d0;border-radius:16px;padding:24px;background:#fff}.profile-detail>.profile-photo{max-height:520px;object-fit:contain;border-radius:10px}.profile-gallery{display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:12px;margin:20px 0}.profile-gallery img{display:block;width:100%;aspect-ratio:1;object-fit:cover;border-radius:10px;background:#f0e4ea}.profile-detail h3{margin:26px 0 8px;color:#66324f}.profile-detail ul{padding-left:22px}.profile-detail .back{margin-top:22px}@media(max-width:600px){.profile-grid{grid-template-columns:1fr}.profile-card{max-width:none}.profile-detail{padding:18px}}</style>';
    echo '<nav><a href="/">Zur Homepage</a><a href="?profiles=1">Alle Mitglieder &amp; Partner</a><a href="?join=mitglied">Mitglied werden</a><a href="?join=partner">Partner werden</a></nav>';
    if($row){
        $p=json_decode((string)$row['payload'],true)?:[];$name=(string)($p['name']??'Profil');$roles=array_values(array_filter(array_map('strval',(array)($p['roles']??[]))));$specialties=array_values(array_filter(array_map('strval',(array)($p['specialties']??[]))));$kind=str_contains((string)($p['anlass']??''),'Partner')?'Partner':'Mitglied';$location=implode(', ',array_filter([(string)($p['city']??''),(string)($p['country']??'')]));$photoId=publicProfilePhotoId($db,(int)$row['id']);
        echo '<p class="profile-kind">'.e($kind).'</p><div class="profile-detail">';if($photoId)echo '<img class="profile-photo" src="?profiles=1&amp;photo='.$photoId.'" alt="Profilfoto von '.e($name).'">';else echo '<div class="profile-photo profile-placeholder">Profilfoto folgt</div>';echo '<h2>'.e($name).'</h2>';if(($p['company']??'')!=='')echo '<p class="profile-meta">'.e($p['company']).($location?' · '.e($location):'').'</p>';elseif($location)echo '<p class="profile-meta">'.e($location).'</p>';if($roles||$specialties){echo '<div class="profile-tags">';foreach(array_merge($roles,$specialties) as $tag)echo '<span>'.e($tag).'</span>';echo '</div>';}if(($p['description']??'')!=='')echo '<h3>Tätigkeit und Angebot</h3><p class="profile-text">'.e($p['description']).'</p>';if(($p['experience']??'')!=='')echo '<h3>Berufserfahrung</h3><p class="profile-text">'.e($p['experience']).'</p>';if(($p['qualifications']??'')!=='')echo '<h3>Ausbildungen und Qualifikationen</h3><p class="profile-text">'.e($p['qualifications']).'</p>';if(($p['links']??'')!==''){ $links=publicProfileLinks((string)$p['links']);if($links)echo '<h3>Website und Social Media</h3><ul>'.$links.'</ul>';}$q=$db->prepare('SELECT id FROM photos WHERE application_id=? ORDER BY id');$q->execute([(int)$row['id']]);$photos=$q->fetchAll(PDO::FETCH_COLUMN);if(count($photos)>1){echo '<h3>Bilder</h3><div class="profile-gallery">';foreach($photos as $photo)echo '<img src="?profiles=1&amp;photo='.(int)$photo.'" alt="Foto von '.e($name).'">';echo '</div>';}echo '<a class="button back" href="?profiles=1">← Zurück zu allen Profilen</a></div>';
    }else{
        echo '<p class="public-intro">Hier stellen sich freigegebene Mitglieder und Partner von IntQu.net vor. Profile und Fotos werden erst nach ausdrücklicher Zustimmung veröffentlicht.</p>';
        $rows=$db->query('SELECT * FROM applications WHERE published=1 ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC);
        if(!$rows)echo '<p class="card">Noch sind keine öffentlichen Profile freigeschaltet. Wir bauen diesen Bereich Schritt für Schritt auf.</p>';else{echo '<div class="profile-grid">';foreach($rows as $item){$p=json_decode((string)$item['payload'],true)?:[];$name=(string)($p['name']??'Profil');$kind=str_contains((string)($p['anlass']??''),'Partner')?'Partner':'Mitglied';$location=implode(', ',array_filter([(string)($p['city']??''),(string)($p['country']??'')]));$photoId=publicProfilePhotoId($db,(int)$item['id']);echo '<article class="profile-card">';if($photoId)echo '<img class="profile-photo" src="?profiles=1&amp;photo='.$photoId.'" alt="Profilfoto von '.e($name).'">';else echo '<div class="profile-photo profile-placeholder">Profilfoto folgt</div>';echo '<div class="profile-card-body"><p class="profile-kind">'.e($kind).'</p><h2>'.e($name).'</h2>';if(($p['company']??'')!==''||$location)echo '<p class="profile-meta">'.e((string)($p['company']??'')).(($p['company']??'')!==''&&$location?' · ':'').e($location).'</p>';if(!empty($p['specialties']))echo '<p>'.e(implode(', ',(array)$p['specialties'])).'</p>';if(($p['description']??'')!=='')echo '<p class="profile-text">'.e((string)$p['description']).'</p>';echo '<a class="button" href="?profiles=1&amp;profile='.(int)$item['id'].'">Profil ansehen ↗</a></div></article>';}$q=null;echo '</div>';}
    }
    pageEnd();exit;
}
$logged = ($_SESSION['admin_until']??0)>time();
if ($admin) {
    if(($_SERVER['REQUEST_METHOD']??'GET')==='POST') {
        try {csrfCheck();$action=scalarPost('action',30);
            if($action==='login'){rateCheck($db,'login',10,900);if(!password_verify(scalarPost('password',200),setting($db,'admin_hash')))throw new RuntimeException('Das Passwort stimmt nicht.');session_regenerate_id(true);$_SESSION['admin_until']=time()+1800;header('Location: ?admin=1');exit;}
            if(!$logged)throw new RuntimeException('Bitte erneut anmelden.');
            if($action==='logout'){$_SESSION=[];session_destroy();header('Location: ?admin=1');exit;}
            if($action==='settings'){$privacy=scalarPost('privacy',20000);$notice=scalarPost('notice',500);$active=isset($_POST['active']);if($active&&(strlen($privacy)<200 || $notice===''))throw new RuntimeException('Vor der Freigabe bitte vollständige Datenschutzhinweise und einen Hinweis zum Ablauf eintragen.');setSetting($db,'privacy',$privacy);setSetting($db,'notice',$notice);setSetting($db,'active',$active?'1':'0');header('Location: ?admin=1&saved=1');exit;}
            if($action==='status'){$status=scalarPost('status',40);if(!in_array($status,['neu','in Bearbeitung','kontaktiert','abgeschlossen'],true))throw new RuntimeException('Ungültiger Status.');$q=$db->prepare('UPDATE applications SET status=? WHERE id=?');$q->execute([$status,(int)scalarPost('id',20)]);header('Location: ?admin=1');exit;}
            if($action==='visibility'){$id=(int)scalarPost('id',20);$published=isset($_POST['published'])?'1':'0';$q=$db->prepare('UPDATE applications SET published=? WHERE id=?');$q->execute([$published,$id]);header('Location: ?admin=1');exit;}
            if($action==='private_backup'){downloadPrivateBackup($resolved);}
            if($action==='delete'){if(!isset($_POST['confirm_delete']))throw new RuntimeException('Bitte Löschung ausdrücklich bestätigen.');$id=(int)scalarPost('id',20);$q=$db->prepare('SELECT filename FROM photos WHERE application_id=?');$q->execute([$id]);$files=$q->fetchAll(PDO::FETCH_COLUMN);$q=$db->prepare('DELETE FROM applications WHERE id=?');$q->execute([$id]);foreach($files as $f)if(preg_match('/^[a-f0-9]{48}\.jpg$/D',$f))@unlink($resolved.'/'.$f);header('Location: ?admin=1');exit;}
            if($action==='export'){header('Content-Type: text/csv; charset=UTF-8');header('Content-Disposition: attachment; filename="intqu-anmeldungen.csv"');$out=fopen('php://output','w');fwrite($out,"\xEF\xBB\xBF");fputcsv($out,['ID','Datum UTC','Name','E-Mail','Rollen','Fachbereiche','Land','Stadt','Newsletterstatus','Status','Öffentlich','Anlass','Interesse','Nachricht'],';', '"','');foreach($db->query('SELECT * FROM applications ORDER BY id DESC') as $row){$p=json_decode($row['payload'],true);$cells=[$row['id'],$row['created'],$p['name'],$p['email'],implode(', ',$p['roles']??[]),implode(', ',$p['specialties']??[]),$p['country']??'',$p['city']??'',$row['newsletter'],$row['status'],$row['published']?'ja':'nein',$p['anlass']??'',implode(', ',$p['interesse']??[]),$p['nachricht']??''];$cells=array_map(fn($v)=>preg_match('/^[\s]*[=+@\-]/u',(string)$v)?"'".$v:$v,$cells);fputcsv($out,$cells,';','"','');}fclose($out);exit;}
        }catch(Throwable $ex){$error=$ex instanceof RuntimeException && !($ex instanceof PDOException)?$ex->getMessage():'Die Aktion konnte nicht abgeschlossen werden.';}
    }
    if(!$logged){pageStart('Verwaltung');if($error)echo '<p class="error">'.e($error).'</p>';echo '<form method="post" action="?admin=1">';csrfField();echo '<input type="hidden" name="action" value="login"><label>Passwort<input type="password" name="password" autocomplete="current-password" required></label><button>Anmelden</button></form>';pageEnd();exit;}
    $_SESSION['admin_until']=time()+1800;
    if(isset($_GET['photo'])){$q=$db->prepare('SELECT filename FROM photos WHERE id=?');$q->execute([(int)$_GET['photo']]);$f=$q->fetchColumn();if(!$f||!preg_match('/^[a-f0-9]{48}\.jpg$/D',$f)||!is_file($resolved.'/'.$f)){http_response_code(404);exit;}header('Content-Type: image/jpeg');readfile($resolved.'/'.$f);exit;}
    pageStart('Anmeldungen verwalten');if($error)echo '<p class="error">'.e($error).'</p>';if(isset($_GET['saved']))echo '<p class="ok">Einstellungen gespeichert.</p>';
    echo '<nav><a href="?preview=1">Formular-Vorschau</a><a href="?profiles=1">Mitglieder &amp; Partner ansehen ↗</a></nav><p>Die Daten sind nur in dieser passwortgeschützten Verwaltung sichtbar. Nach erfolgreicher Speicherung wird eine interne Benachrichtigung an info@intqu.net versucht; die Anfrage bleibt auch bei einem Mailfehler hier erhalten. Newsletter-Wünsche sind unbestätigt.</p>';if(($lastNotification=setting($db,'last_notification'))!=='')echo '<p class="note">Letzte Mail-Übergabe: '.e($lastNotification).'</p>';
    echo '<details class="card"><summary>Einstellungen und Freigabe</summary><form method="post" action="?admin=1">';csrfField();echo '<input type="hidden" name="action" value="settings"><label>Vollständige Datenschutzhinweise für dieses Formular<textarea name="privacy" maxlength="20000" rows="12">'.e(setting($db,'privacy')).'</textarea></label><p class="note">Für die tatsächliche Betreiberin und Verarbeitung ausarbeiten: Kontaktdaten, Zwecke, Rechtsgrundlagen, Hosting, Fotos, Empfänger, Löschfristen, Rechte und Newsletter. Keine Musterdaten veröffentlichen.</p><label>Was passiert nach der Anmeldung?<textarea name="notice" maxlength="500">'.e(setting($db,'notice','Wir sehen uns deine Angaben an und melden uns persönlich zu den nächsten Schritten. Deine Anfrage ist unverbindlich. Dein Profil und deine Fotos werden nicht automatisch veröffentlicht.')).'</textarea></label><label class="check-label"><input type="checkbox" name="active" '.(setting($db,'active')==='1'?'checked':'').'>Formular öffentlich freigeben (erst nach Test und Prüfung der Hinweise)</label><button>Einstellungen speichern</button></form></details>';
    echo '<form method="post" action="?admin=1">';csrfField();echo '<button name="action" value="export">Anmeldungen als CSV herunterladen</button> <button name="action" value="private_backup">Anfragen und Fotos sichern</button> <button name="action" value="logout">Abmelden</button></form><p class="note">Die Datensicherung enthält vertrauliche Angaben und Fotos. Bitte nur auf einem geschützten eigenen Gerät speichern.</p>';
    $total=(int)$db->query('SELECT count(*) FROM applications')->fetchColumn();echo '<p>'.e($total).' Anmeldungen · Anzeige der neuesten 100</p>';
    foreach($db->query('SELECT * FROM applications ORDER BY id DESC LIMIT 100') as $row){$p=json_decode($row['payload'],true);echo '<details class="card"><summary>#'.e($row['id']).' · '.e($p['name']).' · '.e($row['status']).($row['published']?' · öffentlich':'').'</summary><dl>';foreach($p as $key=>$v)echo '<dt>'.e(['anlass'=>'Anlass','interesse'=>'Interesse','nachricht'=>'Nachricht','name'=>'Name','email'=>'E-Mail','public_interest'=>'Wunsch nach öffentlichem Profil'][$key]??$key).'</dt><dd>'.e(is_array($v)?implode(', ',$v):$v).'</dd>';echo '<dt>Datum (UTC)</dt><dd>'.e($row['created']).'</dd><dt>Newsletter</dt><dd>'.e($row['newsletter']).'</dd></dl><div class="gallery">';$q=$db->prepare('SELECT id FROM photos WHERE application_id=?');$q->execute([$row['id']]);foreach($q as $photo)echo '<a href="?admin=1&amp;photo='.(int)$photo['id'].'"><img alt="Eingereichtes Profil- oder Arbeitsfoto" src="?admin=1&amp;photo='.(int)$photo['id'].'"></a>';echo '</div><form method="post" action="?admin=1">';csrfField();echo '<input type="hidden" name="id" value="'.(int)$row['id'].'"><label>Bearbeitungsstatus<select name="status">';foreach(['neu','in Bearbeitung','kontaktiert','abgeschlossen'] as $s)echo '<option '.($s===$row['status']?'selected':'').'>'.e($s).'</option>';echo '</select></label><button name="action" value="status">Status speichern</button></form><form method="post" action="?admin=1">';csrfField();echo '<input type="hidden" name="id" value="'.(int)$row['id'].'"><label class="check-label"><input type="checkbox" name="published" '.($row['published']?'checked':'').'>Öffentliches Profil freigeben (nur nach ausdrücklicher Zustimmung)</label><button name="action" value="visibility">Freigabe speichern</button></form><form method="post" action="?admin=1">';csrfField();echo '<input type="hidden" name="id" value="'.(int)$row['id'].'"><label class="check-label"><input type="checkbox" name="confirm_delete">Diese Anmeldung samt Fotos endgültig löschen</label><button name="action" value="delete">Anmeldung löschen</button></form></details>';}
    pageEnd();exit;
}
$preview=$logged && isset($_GET['preview']);
$eventInterest=($_GET['event']??'')==='beauty-revolution-austria';
$nexaInterest=(!$eventInterest && ($_GET['interest']??'')==='nexa-uv');
$join=($_GET['join']??'')==='partner'?'partner':'mitglied';
$shortInterest=$nexaInterest||$eventInterest;
$shortName=$eventInterest?'Beauty Revolution Austria':'NEXA UV';
$shortBack=defined('INTQU_NEXA_SHOWROOM')?'#top':($eventInterest?'./#events':'showroom/nexa-uv-system/');
$showroomOptions=$eventInterest?['Interesse an der Meisterschaft','Bitte Informationen und Kriterien zuschicken']:['Vorführung','Schulung','Produktinformationen'];
if(isset($_GET['success']) && (int)($_SESSION['receipt_until']??0)>=time()){if(!empty($_SESSION['receipt_nexa'])||!empty($_SESSION['receipt_event'])){pageStart(!empty($_SESSION['receipt_event'])?'Danke für dein Interesse an Beauty Revolution Austria':'Danke für dein Interesse an NEXA UV');echo '<p class="ok">Deine Anfrage wurde gespeichert.</p><p>Wir melden uns persönlich per E-Mail bei dir. Deine Anfrage ist unverbindlich.</p><p><a href="'.(defined('INTQU_NEXA_SHOWROOM')?'#top':(!empty($_SESSION['receipt_event'])?'./#events':'showroom/nexa-uv-system/')).'">Zurück zur Übersicht</a></p>';pageEnd();exit;}pageStart(!empty($_SESSION['receipt_event'])?'Dein Eventinteresse ist gespeichert':(!empty($_SESSION['receipt_nexa'])?'Deine NEXA-Anfrage ist gespeichert':'Deine Anfrage ist gespeichert'));echo '<p class="ok">Danke! Deine Angaben und die hochgeladenen Fotos wurden gespeichert.</p><p>'.e(setting($db,'notice')).'</p><p>Es wurde kein öffentliches Profil und kein persönliches Benutzerkonto angelegt. Falls du den Newsletter gewählt hast, ist dein Wunsch vorgemerkt. Eine Bestätigung folgt gesondert.</p>';pageEnd();exit;}
if(setting($db,'active')!=='1'&&!$preview){pageStart('Die Anmeldung wird vorbereitet');echo '<p>Das Profilformular ist noch nicht geöffnet. Bei Interesse schreibe bitte an <a href="mailto:info@intqu.net">info@intqu.net</a>.</p>';pageEnd();exit;}

if(($_SERVER['REQUEST_METHOD']??'GET')==='POST'){
    $savedFiles=[];
    try{csrfCheck();rateCheck($db,'application',8,3600);if(scalarPost('contact_fax',100)!=='')throw new RuntimeException('Die Anfrage konnte nicht angenommen werden.');
        if(time()-(int)($_SESSION['form_started']??time())<3)throw new RuntimeException('Bitte prüfe deine Angaben und sende erneut.');
        if($shortInterest){
            $p=['name'=>scalarPost('name',120),'email'=>scalarPost('email',254),'anlass'=>$eventInterest?'Beauty Revolution Austria – unverbindliches Interesse':'NEXA UV – Showroom-Anfrage','interesse'=>picked('showroom_interests',$showroomOptions),'nachricht'=>scalarPost('message',2000)];
            if($p['name']===''||!filter_var($p['email'],FILTER_VALIDATE_EMAIL)||$p['interesse']===[])throw new RuntimeException('Bitte deinen Namen, eine gültige E-Mail-Adresse und mindestens ein Interesse angeben.');
        }else{
        $p=[];foreach(['name'=>120,'email'=>254,'company'=>160,'country'=>100,'city'=>100,'language'=>100,'phone'=>60,'links'=>800,'experience'=>500,'qualifications'=>2000,'description'=>3000,'goals'=>3000] as $k=>$n)$p[$k]=scalarPost($k,$n);
        $p['formularsprache']=intquIsRo()?'ro':'de';$p['anlass']=$eventInterest?'Beauty Revolution Austria – unverbindliches Interesse':($nexaInterest?'NEXA UV – Vorführung / Informationen':($join==='partner'?'IntQu.net – Partneranfrage':'IntQu.net – Mitgliedsanfrage'));$p['public_interest']=isset($_POST['public_interest'])?'ja':'nein';
        $p['roles']=picked('roles',$roles);$p['specialties']=picked('specialties',$specialties);
        if($p['name']===''||!filter_var($p['email'],FILTER_VALIDATE_EMAIL)||$p['country']===''||$p['roles']===[]||$p['specialties']===[]||$p['goals']==='')throw new RuntimeException('Bitte Name, gültige E-Mail, Land, Rolle, Fachbereich und Ziele ausfüllen.');
        }
        if(!isset($_POST['privacy_read']))throw new RuntimeException('Bitte lies die Datenschutzhinweise und bestätige die Kenntnisnahme.');
        $uploads=$shortInterest?null:($_FILES['photos']??null);$count=0;
        if($uploads){if(!is_array($uploads['error']))throw new RuntimeException('Ungültige Fotoübertragung.');foreach($uploads['error'] as $err)if($err!==UPLOAD_ERR_NO_FILE)$count++;if($count>5)throw new RuntimeException('Bitte höchstens fünf Fotos auswählen.');if($count&&!isset($_POST['photo_rights']))throw new RuntimeException('Bitte bestätige, dass du die Fotos für diese Anfrage verwenden darfst.');
            if($count&&(!extension_loaded('gd')||!extension_loaded('fileinfo')))throw new RuntimeException('Fotoverarbeitung ist derzeit nicht verfügbar. Bitte ohne Fotos senden.');
            foreach($uploads['error'] as $i=>$err){if($err===UPLOAD_ERR_NO_FILE)continue;if($err!==UPLOAD_ERR_OK)throw new RuntimeException('Ein Foto konnte nicht hochgeladen werden. Bitte erneut auswählen.');$tmp=$uploads['tmp_name'][$i];if(!is_uploaded_file($tmp)||$uploads['size'][$i]>5*1024*1024)throw new RuntimeException('Jedes Foto darf höchstens 5 MB groß sein.');$mime=(new finfo(FILEINFO_MIME_TYPE))->file($tmp);if(!in_array($mime,['image/jpeg','image/png','image/webp'],true))throw new RuntimeException('Bitte JPG, PNG oder WebP verwenden.');$size=@getimagesize($tmp);if(!$size||$size[0]*$size[1]>16000000)throw new RuntimeException('Das Foto ist zu groß. Bitte auf maximal 16 Megapixel verkleinern.');$img=@imagecreatefromstring(file_get_contents($tmp));if(!$img)throw new RuntimeException('Das Foto konnte nicht gelesen werden.');$scale=min(1,1800/max($size[0],$size[1]));$w=max(1,(int)($size[0]*$scale));$h=max(1,(int)($size[1]*$scale));$dest=imagecreatetruecolor($w,$h);imagefill($dest,0,0,imagecolorallocate($dest,255,255,255));imagecopyresampled($dest,$img,0,0,0,0,$w,$h,$size[0],$size[1]);$file=bin2hex(random_bytes(24)).'.jpg';$savedFiles[]=$file;$ok=imagejpeg($dest,$resolved.'/'.$file,85);imagedestroy($img);imagedestroy($dest);if(!$ok)throw new RuntimeException('Das Foto konnte nicht gespeichert werden.');}
        }
        $db->beginTransaction();$now=gmdate('c');$news=!$shortInterest && isset($_POST['newsletter']);$q=$db->prepare('INSERT INTO applications(created,payload,newsletter,consent_at,consent_text,privacy_text) VALUES(?,?,?,?,?,?)');$q->execute([$now,json_encode($p,JSON_UNESCAPED_UNICODE|JSON_THROW_ON_ERROR),$news?'angefragt – unbestätigt':'nein',$news?$now:null,$news?(intquIsRo()?html_entity_decode(intquTranslateText(NEWSLETTER_TEXT),ENT_QUOTES|ENT_HTML5,'UTF-8'):NEWSLETTER_TEXT):null,NOTICE_VERSION."\n".setting($db,'privacy')]);$id=(int)$db->lastInsertId();$q=$db->prepare('INSERT INTO photos(application_id,filename) VALUES(?,?)');foreach($savedFiles as $file)$q->execute([$id,$file]);$db->commit();notifyApplication($db,$p,$id,$savedFiles,$now);$_SESSION['receipt_until']=time()+900;$_SESSION['receipt_event']=$eventInterest;$_SESSION['receipt_nexa']=$nexaInterest;$_SESSION['csrf']=bin2hex(random_bytes(24));header('Location: ?success=1'.(intquIsRo()?'&lang=ro':'').(defined('INTQU_NEXA_SHOWROOM')?'#anfragen':''));exit;
    }catch(Throwable $ex){if($db->inTransaction())$db->rollBack();foreach($savedFiles as $file)@unlink($resolved.'/'.$file);$error=$ex instanceof RuntimeException&&!($ex instanceof PDOException)?$ex->getMessage():'Die Anfrage konnte nicht gespeichert werden. Bitte versuche es erneut.';}
}
$_SESSION['form_started']=$_SESSION['form_started']??time();
function field(string $name,string $label,string $type='text',bool $required=false,int $max=300):void{$v=$_POST[$name]??'';if(!is_string($v))$v='';echo '<label for="'.e($name).'">'.e($label).($required?' *':'').'</label>';if($type==='textarea')echo '<textarea id="'.e($name).'" name="'.e($name).'" maxlength="'.$max.'" '.($required?'required':'').'>'.e($v).'</textarea>';else echo '<input id="'.e($name).'" name="'.e($name).'" type="'.e($type).'" maxlength="'.$max.'" value="'.e($v).'" '.($required?'required':'').'>';}

if($shortInterest){
    pageStart('Dein Interesse an '.$shortName);
    if($eventInterest)echo '<p class="intro-copy">Beauty Revolution Austria startet am <strong>2. November</strong>. Ab <strong>10. Oktober</strong> findest du alle Informationen und Kriterien hier auf der Plattform.</p><p>Du interessierst dich für die Meisterschaft oder möchtest zuerst Informationen erhalten? Hinterlasse uns eine kurze Anfrage. Wir melden uns persönlich per E-Mail.</p><p class="note">Das ist eine unverbindliche Interessensmeldung, noch keine Anmeldung zur Meisterschaft.</p>';
    else echo '<p class="intro-copy">Du möchtest NEXA UV näher kennenlernen? Sag uns, was dich interessiert. Wir melden uns persönlich per E-Mail bei dir.</p>';
    if($preview)echo '<p class="ok">Interne Vorschau. Testanfragen werden gespeichert.</p>';
    if($error)echo '<p class="error" role="alert">'.e($error).'</p>';
    echo '<form method="post" action="?'.($eventInterest?'event=beauty-revolution-austria':'interest=nexa-uv').($preview?'&amp;preview=1':'').(defined('INTQU_NEXA_SHOWROOM')?'#anfragen':'').'"><fieldset aria-labelledby="showroom-title"><h2 class="section-title" id="showroom-title">Deine Anfrage</h2>';
    csrfField();
    field('name','Dein Name','text',true,120);
    field('email','Deine E-Mail-Adresse','email',true,254);
    echo '<h3 id="interest-label">Was interessiert dich? *</h3><p class="note" id="interest-help">Bitte mindestens eine Option auswählen. Mehrfachauswahl möglich.</p><div class="choices" role="group" aria-labelledby="interest-label" aria-describedby="interest-help">';
    foreach($showroomOptions as $option){$checked=is_array($_POST['showroom_interests']??null)&&in_array($option,$_POST['showroom_interests'],true);echo '<label class="check-label"><input type="checkbox" name="showroom_interests[]" value="'.e($option).'" '.($checked?'checked':'').'>'.e($option).'</label>';}
    echo '</div>';
    field('message','Deine Nachricht (optional)','textarea',false,2000);
    echo '<details><summary>Datenschutzhinweise lesen</summary><pre>'.e(setting($db,'privacy')).'</pre></details><label class="check-label"><input type="checkbox" name="privacy_read" required '.(isset($_POST['privacy_read'])?'checked':'').'>Ich habe die Datenschutzhinweise gelesen. *</label><p class="note">* Pflichtfelder · Unverbindliche Anfrage</p><div class="trap" aria-hidden="true"><label>Fax<input name="contact_fax" tabindex="-1" autocomplete="off"></label></div><button type="submit">Interesse senden</button></fieldset></form><p><a href="'.e($shortBack).'">Zurück zur Übersicht</a></p>';
    if($eventInterest)echo '<p>Du möchtest dich im IntQu.net-Netzwerk engagieren? <a href="?join=mitglied">Mitglied werden</a> · <a href="?join=partner">Partner werden</a></p>';
    pageEnd();exit;
}

pageStart($eventInterest?'Dein Interesse an Beauty Revolution Austria':($nexaInterest?'Deine Anfrage zu NEXA UV':($join==='partner'?'Partner bei IntQu.net werden':'Mitglied bei IntQu.net werden')));
if($nexaInterest)echo '<p class="ok">Du interessierst dich für NEXA UV. Schreibe unten bei deinen Zielen, ob du eine Vorführung, eine Schulung oder Produktinformationen suchst. Wir melden uns persönlich bei dir.</p>';
if($eventInterest)echo '<p class="ok">Du meldest dein Interesse an Beauty Revolution Austria. Beschreibe unten bei deinen Zielen, wie du dabei sein möchtest. Das ist noch keine verbindliche Teilnahmebuchung.</p>';
if($join==='partner')echo '<p>Als Partner bringst du Fachwissen, Schulungen, Produkte oder Unterstützung ins Netzwerk ein – zum Beispiel als Expert:in, Trainer:in, Marke oder Sponsor. Erzähle uns unten, wie du mitwirken möchtest.</p>';
echo '<p class="intro-copy">Zeige uns, was du beruflich machst und welche Möglichkeiten du im Netzwerk suchst. Mit deinen Angaben können wir deine Anfrage persönlich bearbeiten.</p><p class="note">Unverbindliche Profilanfrage · kein automatischer Vertragsabschluss · Veröffentlichung nur nach ausdrücklicher Freigabe</p>';
if($preview)echo '<p class="ok">Interne Vorschau: Die öffentliche Anmeldung ist möglicherweise noch geschlossen. Testanmeldungen werden gespeichert und können in der Verwaltung gelöscht werden.</p>';
if($error)echo '<p class="error" role="alert">'.e($error).' Bereits ausgewählte Fotos bitte erneut auswählen.</p>';
echo '<form method="post" enctype="multipart/form-data" action="'.('?'.http_build_query(array_filter(['preview'=>$preview?'1':null,'event'=>$eventInterest?'beauty-revolution-austria':null,'interest'=>$nexaInterest?'nexa-uv':null,'join'=>$join]))).'">';csrfField();

echo '<fieldset aria-labelledby="section-1"><h2 class="section-title" id="section-1"><span class="section-number" aria-hidden="true">01</span>Deine Kontaktdaten</h2>';field('name','Vor- und Nachname','text',true,120);field('email','E-Mail-Adresse','email',true,254);field('company','Studio, Unternehmen oder Akademie','text',false,160);field('country','Land','text',true,100);field('city','Stadt','text',false,100);field('language','Bevorzugte Sprache','text',false,100);field('phone','Telefon (optional)','tel',false,60);echo '</fieldset><fieldset aria-labelledby="section-2"><h2 class="section-title" id="section-2"><span class="section-number" aria-hidden="true">02</span>Deine Tätigkeit und Fachbereiche</h2><p>Mehrfachauswahl möglich. Bitte mindestens eine Rolle und einen Fachbereich wählen.</p><div class="choices">';
foreach($roles as $r){$checked=is_array($_POST['roles']??null)&&in_array($r,$_POST['roles'],true);echo '<label class="check-label"><input type="checkbox" name="roles[]" value="'.e($r).'" '.($checked?'checked':'').'>'.e($r).'</label>';}echo '</div><h2>Deine Fachbereiche</h2><div class="choices">';foreach($specialties as $r){$checked=is_array($_POST['specialties']??null)&&in_array($r,$_POST['specialties'],true);echo '<label class="check-label"><input type="checkbox" name="specialties[]" value="'.e($r).'" '.($checked?'checked':'').'>'.e($r).'</label>';}echo '</div>';field('description','Deine Tätigkeit und dein Angebot','textarea',false,3000);field('experience','Berufserfahrung','text',false,500);field('qualifications','Ausbildungen und Qualifikationen (optional)','textarea',false,2000);field('links','Website und Social-Media-Links (optional)','textarea',false,800);echo '</fieldset><fieldset aria-labelledby="section-3"><h2 class="section-title" id="section-3"><span class="section-number" aria-hidden="true">03</span>Deine Ziele im Netzwerk</h2><p>Welche Kontakte oder Möglichkeiten suchst du? Zum Beispiel Kooperationen, Weiterbildung oder Austausch mit Studios, Trainer:innen und Marken.</p>';field('goals','Deine Ziele und Wünsche','textarea',true,3000);echo '</fieldset><fieldset aria-labelledby="section-4"><h2 class="section-title" id="section-4"><span class="section-number" aria-hidden="true">04</span>Deine Bilder</h2><p>Ergänze freiwillig ein Porträt oder Bilder deiner Arbeit, deines Studios oder deiner Produkte. Die Bilder werden intern geprüft und nur nach ausdrücklicher Freigabe öffentlich gezeigt.</p><p class="note">Bis zu fünf Bilder · maximal 5 MB je Bild · JPG, PNG oder WebP</p><label for="photos">Fotos auswählen</label><input id="photos" type="file" name="photos[]" accept="image/jpeg,image/png,image/webp" multiple><label class="check-label"><input type="checkbox" name="photo_rights">Ich bin berechtigt, diese Bilder für meine Anfrage einzureichen. Erforderliche Zustimmungen abgebildeter Personen liegen vor.</label></fieldset>';
    echo '<fieldset aria-labelledby="section-5"><h2 class="section-title" id="section-5"><span class="section-number" aria-hidden="true">05</span>Datenschutz und Newsletter</h2><details><summary>Datenschutzhinweise lesen</summary><pre>'.e(setting($db,'privacy','Interne Vorschau: Datenschutzhinweise müssen vor der öffentlichen Freigabe ergänzt werden.')).'</pre></details><label class="check-label"><input type="checkbox" name="privacy_read" required>Ich habe die Datenschutzhinweise gelesen. *</label><label class="check-label"><input type="checkbox" name="public_interest">Ich möchte nach persönlicher Abstimmung ein öffentliches Profil mit meinen Angaben und Fotos erhalten.</label><label class="check-label"><input type="checkbox" name="newsletter">'.e(NEWSLETTER_TEXT).'</label><p class="note">Die Veröffentlichung erfolgt niemals automatisch. Newsletter freiwillig. Dein Wunsch wird zunächst unbestätigt gespeichert; dieses Formular startet keinen Versand.</p></fieldset><div class="trap" aria-hidden="true"><label>Fax<input name="contact_fax" tabindex="-1" autocomplete="off"></label></div><p>'.e(setting($db,'notice')).'</p><p class="note">* Pflichtfelder. Du kannst auch ohne Fotos anfragen.</p><button type="submit">Anfrage senden</button></form>';pageEnd();

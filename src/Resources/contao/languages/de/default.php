<?php

/** PSLZME cookiebar */

$GLOBALS['TL_LANG']['robindort_pslzme_links']['cookiebar_fh'] = '<h4 class="pslzme-heading">Sehr geehrte/r BesucherIn,</h4>';
$GLOBALS['TL_LANG']['robindort_pslzme_links']['cookiebar_sh'] = '<h4 class="pslzme-heading">Sie sind über <span id="pslzme-cookiebar-first-contact"></span> einem persönlichen pslz<b>me</b> Einladungslink von <span id="pslzme-cookiebar-link-creator"></span> gefolgt.</h4></p>
<p>Hierdurch sind wir in der Lage, Sie auf unserer Webseite DSGVO-konform persönlich anzusprechen und Ihnen unsere Webseite mit persönlich für Sie zugeschnittenen Inhalten zu präsentieren, sofern Sie uns dies gestatten.</p>
<p>Um dies zu tun, geben Sie bitte hier die ersten drei Buchstaben Ihres Nachnamens ein und bestätigen Sie dann zusätzlich mit einem Klick auf den <b>Ja-Button</b>, dass wir Sie persönlich auf unserer Webseite empfangen und Ihnen individuelle Inhalte und Angebote ausliefern dürfen. Oder lehnen Sie die Personalisierung mit Klick auf <strong>Nein</strong> ab. Sofern Sie Nein klicken, werden wir Sie auf die unpersonalisierte Version unserer Webseite weiterleiten.
</p>';

$GLOBALS['TL_LANG']['robindort_pslzme_links']['cookiebar_nvft'] = '<strong>Geben Sie hier nun die ersten drei Buchstaben Ihres Nachnamens ein:</strong>';
$GLOBALS['TL_LANG']['robindort_pslzme_links']['cookiebar_nvst'] = 'Restliche Versuche: <span id="remaining-attempts">3</span>';
$GLOBALS['TL_LANG']['robindort_pslzme_links']['cookiebar_nvtt'] = 'Bestätigen Sie nachfolgend dann mit einem Klick auf <strong>Ja</strong>, dass wir Ihre Daten entschlüsseln und zur persönlichen Ansprache und personalisierten Inhalten auf unserer Webseite verwenden dürfen.';

$GLOBALS['TL_LANG']['robindort_pslzme_links']['cookiebar_footer_more_info'] = 'Weiterführende Informationen zu pslz<b>me</b>';
$GLOBALS['TL_LANG']['robindort_pslzme_links']['cookiebar_footer_text'] = '<p>Bei pslz<b>me</b> (ausgesprochen: personalize <b>me</b>) handelt es sich um ein von uns entwickeltes, DSGVO-konformes und absolut sicheres Personalisierungs-Framework, das schon jetzt als bahnbrechende Entwicklung im Programmatic Web bezeichnet werden darf und auf sichere und datensparsame Weise, erstmals Personalisierung, Individualisierung und persönliche Ansprache auch im Web ermöglicht.</p>
<p>Unser System ist dabei so aufgebaut, dass alle Informationen unter Einsatz höchster Sicherheitsmaßnahmen auf unterschiedlichen Sicherheitsebenen in einen einfachen Link gepackt werden. So sicher, dass unser System selbst Ihre Daten nicht kennt und ebenso wir diese nicht tracken können. Es findet auch zu keinem Zeitpunkt eine unverschlüsselte Datenübertragung und -speicherung statt. Wir arbeiten hier ausschließlich mit personengebundenen Daten, die Sie freiwillig veröffentlicht haben. Es findet weder ein Tracking auf Basis Ihrer Daten, noch ein Profiling statt. Und pslz<b>me</b> entschlüsselt und verarbeitet Ihre personengebundenen Daten erst und ausschließlich dann, wenn Sie uns dies ausdrücklich erlauben.</p>';

$GLOBALS['TL_LANG']['robindort_pslzme_links']['imprint'] = 'Impressum';
$GLOBALS['TL_LANG']['robindort_pslzme_links']['privacy'] = 'Datenschutz';
$GLOBALS['TL_LANG']['robindort_pslzme_links']['yes'] = 'Ja';
$GLOBALS['TL_LANG']['robindort_pslzme_links']['no'] = 'Nein';


/** Custom elements */

$GLOBALS['TL_LANG']['CTE']['pslzme_text'] = ['Pslzme Text', 'Personalisierbares Text element'];
$GLOBALS['TL_LANG']['CTE']['pslzme_3D_content'] = ['Pslzme 3D content', 'Personalisierbares 3D Content Element'];


/** Backend module */

$GLOBALS['TL_LANG']['MOD']['pslzme_configuration'] = 'Konfiguration';
$GLOBALS['TL_LANG']['pslzme_configuration']['main_heading'] = 'pslz<span>me</span> Konfiguration';
$GLOBALS['TL_LANG']['pslzme_configuration']['first_config_container_h2'] = '1: Datenbank Konfiguration';
$GLOBALS['TL_LANG']['pslzme_configuration']['pslzme_explanation_part_one'] = 'Zur erfolgreichen Nutzung von pslz<strong>me</strong> ist eine Datenbankanbindung notwendig.';
$GLOBALS['TL_LANG']['pslzme_configuration']['pslzme_explanation_part_two'] = 'Um Ihnen die Konfiguration so einfach wie möglich zu gestalten, finden Sie im weiteren Abschnitt eine detaillierte Beschreibung
                    der benötigten Schritte zur Erstellung und Konfiguration der Datenbank.';
$GLOBALS['TL_LANG']['pslzme_configuration']['config_step_one'] = 'Schritt 1:</span> Erstellung der Datenbank';
$GLOBALS['TL_LANG']['pslzme_configuration']['pslzme_explanation_part_three'] = 'Zur Erstellung einer Datenbank loggen Sie sich bitte in Ihrem gewählten Serverhosting-Tool ein und navigieren dort zum
                        bereitgestellten Abschnitt <span>&lt;Datenbanken&gt;</span>. Anschließend wählen Sie die Option <span>
                        &lt;Neue Datenbank erstellen&gt;</span> und geben dann Ihre gewünschten Konfigurationdaten für Datenbankname,
                        Username und Passwort an.';
$GLOBALS['TL_LANG']['pslzme_configuration']['pslzme_explanation_part_four'] = 'Sollten Sie noch keinen Datenbank-User erstellt haben, so muss dies im Idealfall vor der
                        Erstellung der Datenbank getan werden. Dieser kann jedoch auch nachträglich erstellt und der Datenbank zugewiesen werden.
                        Zur Erstellung des Users, navigieren sie zum Abschnitt <span>&lt;Datenbank-Nutzer erstellen&gt;</span>
                        und weissen Sie dann die gewünschten Konfigurationdaten wie Username und Passwort zu. Nach beidiger Erstellung
                        muss zuletzt - wenn nicht bereits getan - der erstellte User noch der Datenbank zugewiesen werden.';
$GLOBALS['TL_LANG']['pslzme_configuration']['config_step_two'] = '<span>Schritt 2:</span> Datenbank an plsz<strong>me</strong> plugin anbinden';
$GLOBALS['TL_LANG']['pslzme_configuration']['pslzme_explanation_part_five'] = 'Als nächstes tragen Sie bitte die Verbindungsdaten der soeben erstellten Datenbank in die nachstehenden Felder ein. Nach
                        Bestätigung des Speichern buttons, werden die benötigten Tabellen von pslz<strong>me</strong> automatisiert initiiert.';

$GLOBALS['TL_LANG']['pslzme_configuration']['db_name'] = "Datenbankname:";
$GLOBALS['TL_LANG']['pslzme_configuration']['current_db'] = "Aktuelle Datenbank:";
$GLOBALS['TL_LANG']['pslzme_configuration']['no_db'] = "Keine Datenbank konfiguriert";
$GLOBALS['TL_LANG']['pslzme_configuration']['db_user'] = "Datenbank-User:";
$GLOBALS['TL_LANG']['pslzme_configuration']['current_db_user'] = 'Aktueller Datenbank-User:';
$GLOBALS['TL_LANG']['pslzme_configuration']['no_db_user'] = 'Kein Datenbank-User konfiguriert';
$GLOBALS['TL_LANG']['pslzme_configuration']['db_pw'] = 'Datenbank Passwort:';
$GLOBALS['TL_LANG']['pslzme_configuration']['second_config_container_h2'] = '2: Interne Seiten Konfiguration';
$GLOBALS['TL_LANG']['pslzme_configuration']['save'] = "Speichern";



?>
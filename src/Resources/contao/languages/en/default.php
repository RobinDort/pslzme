<?php

/** PSLZME cookiebar */

$GLOBALS['TL_LANG']['robindort_pslzme_links']['cookiebar_fh'] = '<h4 class="pslzme-heading">Dear visitor,</h4>';
$GLOBALS['TL_LANG']['robindort_pslzme_links']['cookiebar_sh'] = '<h4 class="pslzme-heading">You have followed a personal pslz<b>me</b> invitation link from <span id="pslzme-cookiebar-link-creator"></span> via <span id="pslzme-cookiebar-first-contact"></span></h4></p>
<p>This enables us to address you personally and GDPR-compliant on our website and to present our website to you with content tailored to you personally, provided you allow us to do so.</p>
<p>To do this, please enter the first three letters of your surname here and then click on the <b>Yes</b> button to confirm that we may receive you personally on our website and deliver personalized content and offers to you. Or click <strong>No</strong> to reject personalization. If you click No, we will redirect you to the non-personalized version of our website.</p>';

$GLOBALS['TL_LANG']['robindort_pslzme_links']['cookiebar_nvft'] = '<strong>Enter the first three letters of your surname here:</strong>';
$GLOBALS['TL_LANG']['robindort_pslzme_links']['cookiebar_nvst'] = 'Remaining attempts: <span id="remaining-attempts">3</span>';
$GLOBALS['TL_LANG']['robindort_pslzme_links']['cookiebar_nvtt'] = 'Click <strong>Yes</strong> to confirm that we may decrypt your data and use it to address you personally and personalize content on our website.';

$GLOBALS['TL_LANG']['robindort_pslzme_links']['cookiebar_footer_more_info'] = 'Further information on pslz<b>me</b>';
$GLOBALS['TL_LANG']['robindort_pslzme_links']['cookiebar_footer_text'] = '<p>pslz<b>me</b> (pronounced: personalize <b>me</b>) is a GDPR-compliant and absolutely secure personalization framework developed by us, which can already be described as a groundbreaking development in the programmatic web and enables personalization, individualization and a personal approach on the web for the first time in a secure and data-saving manner.</p>
<p>Our system is structured in such a way that all information is packed into a simple link using the highest security measures at different security levels. So secure that our system itself does not know your data and we cannot track it either. At no time does unencrypted data transmission or storage take place. We also work exclusively with personal data that you have published voluntarily. There is neither tracking based on your data nor profiling. And pslz<b>me</b> only decrypts and processes your personal data if you expressly allow us to do so.</p>';

$GLOBALS['TL_LANG']['robindort_pslzme_links']['imprint'] = 'Imprint';
$GLOBALS['TL_LANG']['robindort_pslzme_links']['privacy'] = 'Privacy statement';
$GLOBALS['TL_LANG']['robindort_pslzme_links']['yes'] = 'Yes';
$GLOBALS['TL_LANG']['robindort_pslzme_links']['no'] = 'No';

/** Custom elements */

$GLOBALS['TL_LANG']['CTE']['pslzme_text'] = ['Pslzme Text', 'Personalizable text element'];
$GLOBALS['TL_LANG']['CTE']['pslzme_3D_content'] = ['Pslzme 3D content', 'Personalizable 3D content element'];

/** Backend module */

$GLOBALS['TL_LANG']['MOD']['pslzme_configuration'] = 'Configuration';
$GLOBALS['TL_LANG']['pslzme_configuration']['main_heading'] = 'pslz<span>me</span> configuration';
$GLOBALS['TL_LANG']['pslzme_configuration']['first_config_container_h2'] = '1: Database configuration';
$GLOBALS['TL_LANG']['pslzme_configuration']['pslzme_explanation_part_one'] = 'To successfully use pslz<strong>me</strong> a database connection is required.';
$GLOBALS['TL_LANG']['pslzme_configuration']['pslzme_explanation_part_two'] = 'To make the configuration as easy as possible for you, you will find a detailed description of the steps required to create and configure the database in the following section.';
$GLOBALS['TL_LANG']['pslzme_configuration']['config_step_one'] = 'Step 1:</span> Creation of the database';
$GLOBALS['TL_LANG']['pslzme_configuration']['pslzme_explanation_part_three'] = 'To create a database, please log in to your chosen server hosting tool and navigate to the <span>&lt;Databases&gt;</span> section provided. Then select the <span>&lt;create new database&gt;</span> option and enter your desired configuration data for the database name, username and password.';
$GLOBALS['TL_LANG']['pslzme_configuration']['pslzme_explanation_part_four'] = 'If you have not yet created a database user, this should ideally be done before the database is created. However, this can also be created later and assigned to the database. To create the user, navigate to the <span>&lt;create database&gt;</span> user section and then enter the required configuration data such as user name and password. Once both have been created, the created user must finally be assigned to the database if this has not already been done.';
$GLOBALS['TL_LANG']['pslzme_configuration']['config_step_two'] = '<span>Step 2:</span> Connect database to plsz<strong>me</strong> plugin';
$GLOBALS['TL_LANG']['pslzme_configuration']['pslzme_explanation_part_five'] = 'Next, please enter the connection data for the database you have just created in the fields below. After confirming the Save button, the required tables are automatically initiated by pslz<strong>me</strong>.';
$GLOBALS['TL_LANG']['pslzme_configuration']['db_name'] = "Database name:";
$GLOBALS['TL_LANG']['pslzme_configuration']['current_db'] = "Current database:";
$GLOBALS['TL_LANG']['pslzme_configuration']['no_db'] = "No database configured";
$GLOBALS['TL_LANG']['pslzme_configuration']['db_user'] = "Database user:";
$GLOBALS['TL_LANG']['pslzme_configuration']['current_db_user'] = 'Current database user:';
$GLOBALS['TL_LANG']['pslzme_configuration']['no_db_user'] = 'No database user configured';
$GLOBALS['TL_LANG']['pslzme_configuration']['db_pw'] = 'Database password:';
$GLOBALS['TL_LANG']['pslzme_configuration']['second_config_container_h2'] = '2: Internal page configuration';
$GLOBALS['TL_LANG']['pslzme_configuration']['save'] = "Save";




?>
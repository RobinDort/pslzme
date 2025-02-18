<?php

/**
 * Configuration for pslzme_text element
 */

$GLOBALS['TL_DCA']['tl_content']['palettes']['pslzme_text'] = '{type_legend},type,headline;{text_legend},personalizedText,unpersonalizedText;{expert_legend:hide},cssID';


$GLOBALS['TL_DCA']['tl_content']['fields']['personalizedTextGroup'] = [
    'label' => array('Personalized Text/HTML/Code'),
    'inputType' => 'group',
];

$GLOBALS['TL_DCA']['tl_content']['fields']['personalizedText'] = [
    'label'     => ['Personalized Text', 'Enter personalized text'],
    'exclude'   => true,
    'inputType' => 'textarea',
    'eval'      => ['rte' => 'tinyMCE', 'helpwizard' => true, 'mandatory' => false],
    'sql' => "TEXT NULL"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['unpersonalizedTextGroup'] = [
    'label' => array('Unpersonalized Text/HTML/Code'),
    'inputType' => 'group',
];

$GLOBALS['TL_DCA']['tl_content']['fields']['unpersonalizedText'] = [
    'label'     => ['Unpersonalized Text', 'Enter unpersonalized text'],
    'exclude'   => true,
    'inputType' => 'textarea',
    'eval'      => ['rte' => 'tinyMCE', 'helpwizard' => true, 'mandatory' => true],
    'sql' => "TEXT NULL"
];



/**
 * Configuration for pslzme_3D_content element
 */

$GLOBALS['TL_DCA']['tl_content']['palettes']['pslzme_3D_content'] = '
    {type_legend},type,headline;
    {3D Image},addImage;
    {3D PlayGround},pageLink,html;
    {expert_legend:hide},cssID';

$GLOBALS['TL_DCA']['tl_content']['fields']['addImage'] = [
    'inputType' => 'standardField',
];


$GLOBALS['TL_DCA']['tl_content']['fields']['pageLink'] = [
    'label' => array('Link address'),
    'inputType' => 'pageTree',
    'eval'      => ['mandatory' => false, 'fieldType' => 'radio', 'tl_class' => 'clr'],
    'sql'       => "int(10) unsigned NOT NULL default 0"
];

?>
<?php

/**
 * Configuration for pslzme_text element
 */

$GLOBALS['TL_DCA']['tl_content']['palettes']['pslzme_text'] = '{type_legend},type,headline;{text_legend},personalizedText,unpersonalizedText;{expert_legend:hide},showUnpersonalizedText,cssID';


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

$GLOBALS['TL_DCA']['tl_content']['fields']['showUnpersonalizedText'] = [
    'label'     => ["Show Unpersonalized Text", 'Choose selection'],
    'exclude'   => true,
    'inputType' => 'radio',
    'options'   => ['1' => 'Yes', '0' => 'No'],
    'default'   => '1',
    'eval'      => ['mandatory' => true, 'tl_class' => 'w50'],
    'sql'       => "char(1) NOT NULL default '1'"
];



/**
 * Configuration for pslzme_3D_content element
 */

$GLOBALS['TL_DCA']['tl_content']['palettes']['pslzme_3D_content'] = '
    {type_legend},type,headline;
    {3D Image},singleSRC,alt,size,imagemargin,imageUrl,fullsize,caption,floating;
    {3D PlayGround},pageLink,html;
    {expert_legend:hide},cssID';

$GLOBALS['TL_DCA']['tl_content']['fields']['pageLink'] = [
    'label' => array('Link address'),
    'inputType' => 'pageTree',
    'eval'      => ['mandatory' => false, 'fieldType' => 'radio', 'tl_class' => 'clr'],
    'sql'       => "int(10) unsigned NOT NULL default 0"
];

?>
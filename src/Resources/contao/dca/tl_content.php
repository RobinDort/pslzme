<?php
use Contao\System;

/**
 * Configuration for pslzme_text element
 */

$GLOBALS['TL_DCA']['tl_content']['palettes']['pslzme_text'] = '{type_legend},type,headline;{text_legend};personalizedTextGroup,personalizedText;unpersonalizedTextGroup,unpersonalizedText,showUnpersonalizedText;{expert_legend:hide},cssID';


$GLOBALS['TL_DCA']['tl_content']['fields']['personalizedTextGroup'] = [
    'inputType' => 'group',
];

$GLOBALS['TL_DCA']['tl_content']['fields']['personalizedText'] = [
    'exclude'   => true,
    'inputType' => 'textarea',
    'eval'      => ['rte' => 'tinyMCE', 'helpwizard' => true, 'mandatory' => false],
    'sql' => "TEXT NULL"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['unpersonalizedTextGroup'] = [
    'inputType' => 'group',
];

$GLOBALS['TL_DCA']['tl_content']['fields']['unpersonalizedText'] = [
    'exclude'   => true,
    'inputType' => 'textarea',
    'eval'      => ['rte' => 'tinyMCE', 'helpwizard' => true, 'mandatory' => true],
    'sql' => "TEXT NULL"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['showUnpersonalizedText'] = [
    'exclude'   => true,
    'inputType' => 'radio',
    'options'   => ['1', '0'],
    'reference' => [
        '1' => $GLOBALS['TL_LANG']['pslzme_configuration']['yes'],
        '0' => $GLOBALS['TL_LANG']['pslzme_configuration']['no'],
    ],
    'default'   => '1',
    'eval'      => ['mandatory' => true, 'tl_class' => 'w50'],
    'sql'       => "char(1) NOT NULL default '1'"
];



/**
 * Configuration for pslzme_content element
 */

$GLOBALS['TL_DCA']['tl_content']['palettes']['pslzme_content'] = 
 '{type_legend},type,headline;{content_type_legend},selectedContent;{expert_legend:hide},cssID;';

$GLOBALS['TL_DCA']['tl_content']['palettes']['__selector__'][] = 'selectedContent';

$GLOBALS['TL_DCA']['tl_content']['subpalettes']['selectedContent_image-content'] =
    '{personalized_image_content_legend:hide},personalizedImage,alt,size,imageUrl,caption;
     {unpersonalized_image_content_legend},unpersonalizedImage,upAlt,upSize,upImageUrl,upCaption';


$GLOBALS['TL_DCA']['tl_content']['subpalettes']['selectedContent_video-content'] =
    '{personalized_video_content_legend:hide},personalizedVideo,playerSize,playerOptions,playerCaption,playerPreload;
     {unpersonalized_video_content_legend:hide},unpersonalizedVideo, upPlayerSize, upPlayerOptions, upPlayerCaption, upPlayerPreload;';


$GLOBALS['TL_DCA']['tl_content']['fields']['selectedContent'] = [
    'inputType' => 'radio',
    'options'   => ['image-content' => 'Image', 'video-content' => 'Video'],
    'default'   => 'image-content',
    'eval'      => ['mandatory' => true, 'submitOnChange' => true, 'tl_class' => 'clr'],
    'sql'       => "varchar(32) default NULL"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['personalizedImage'] = [
    'inputType' => 'fileTree',
    'eval'      => [
        'mandatory' => false, 
        'filesOnly' => true, 
        'fieldType' => 'radio', 
        'extensions' => 'jpg,jpeg,png,gif,webp', 
        'tl_class' => 'clr',
    ],
    'sql'       => "binary(16) NULL"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['unpersonalizedImage'] = [
    'inputType' => 'fileTree',
    'eval'      => [
        'mandatory' => true, 
        'filesOnly' => true, 
        'fieldType' => 'radio',
        'extensions' => 'jpg,jpeg,png,gif,webp', 
        'tl_class' => 'clr',
    ],
    'sql'       => "binary(16) NULL"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['upSize'] = [
    'inputType' => 'imageSize',
    'options_callback' => function () {
        return System::getContainer()->get('contao.image.sizes')->getAllOptions();
    },
    'eval'      => array('rgxp'=>'digit', 'includeBlankOption'=>true, 'tl_class'=>'w50'),
    'sql'       => "varchar(128) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['upAlt'] = [
    'inputType' => 'text',
    'eval'      => ['maxlength' => 255, 'tl_class' => 'w50'],
    'sql'       => "varchar(255) NULL"
];


$GLOBALS['TL_DCA']['tl_content']['fields']['upImageUrl'] = [
    'inputType' => 'pageTree',
    'eval'      => [
        'fieldType' => 'radio',
        'tl_class' => 'w50',
    ],
    'sql'       => "text NULL"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['upCaption'] = [
    'inputType' => 'text',
    'eval'      => ['maxlength' => 255, 'tl_class' => 'clr'],
    'sql'       => "varchar(255) NOT NULL default ''"
];



$GLOBALS['TL_DCA']['tl_content']['fields']['personalizedVideo'] = [
    'inputType' => 'fileTree',
    'eval'      => [
        'mandatory' => false, 
        'filesOnly' => true, 
        'fieldType' => 'radio', 
        'extensions' => 'mp4,webm',
        'tl_class' => 'clr',
    ],
    'sql'       => "binary(16) NULL"
];


$GLOBALS['TL_DCA']['tl_content']['fields']['unpersonalizedVideo'] = [
    'inputType' => 'fileTree',
    'eval'      => [
        'mandatory' => true, 
        'filesOnly' => true, 
        'fieldType' => 'radio', 
        'extensions' => 'mp4,webm', 
        'tl_class' => 'clr',
    ],
    'sql'       => "binary(16) NULL"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['upPlayerSize'] = [
    'exclude'       => true,
    'inputType'     => 'text',
    'eval'          => array('multiple'=>true, 'size'=>2, 'rgxp'=>'natural', 'nospace'=>true, 'tl_class'=>'w50'),
    'sql'           => "varchar(64) COLLATE ascii_bin NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['upPlayerOptions'] = [
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'options'                 => array('player_autoplay', 'player_nocontrols', 'player_loop', 'player_playsinline', 'player_muted'),
    'reference'               => &$GLOBALS['TL_LANG']['tl_content'],
    'eval'                    => array('multiple'=>true, 'tl_class'=>'clr'),
    'sql'                     => "text NULL"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['upPlayerCaption'] = [
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('tl_class'=>'w50'),
    'sql'                     => "varchar(255) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['upPlayerPreload'] = [
    'exclude'                 => true,
    'inputType'               => 'select',
    'options'                 => array('auto', 'metadata', 'none'),
    'reference'               => &$GLOBALS['TL_LANG']['tl_content']['player_preload'],
    'eval'                    => array('includeBlankOption' => true, 'nospace'=>true, 'tl_class'=>'w50'),
    'sql'                     => "varchar(8) COLLATE ascii_bin NOT NULL default ''"
];



/**
 * Configuration for pslzme_image element
 */

$GLOBALS['TL_DCA']['tl_content']['palettes']['pslzme_image'] = '{type_legend},type;{text_legend};personalizedTextGroup,personalizedText;unpersonalizedTextGroup,unpersonalizedText;firstImageGroup,firstImage,firstImageSize;secondImageGroup,secondImage,secondImageSize;{expert_legend:hide},cssID';


$GLOBALS['TL_DCA']['tl_content']['fields']['firstImageGroup'] = [
    'inputType' => 'group',
];


$GLOBALS['TL_DCA']['tl_content']['fields']['firstImage'] = [
    'inputType' => 'fileTree',
    'eval' => [
        'filesOnly' => true,
        'fieldType' => 'radio',
        'extensions' => 'jpg,jpeg,png,webp',
        'mandatory' => true,
    ],
    'sql'       => "binary(16) NULL"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['firstImageSize'] = [
    'inputType' => 'imageSize',
    'eval' => [
        'mandatory' => true,
        'rgxp' => 'digit',
        'includeBlankOption' => true,
    ],
    'options_callback' => function () {
        return System::getContainer()->get('contao.image.sizes')->getAllOptions();
    },
    'sql'       => "binary(16) NULL"
];


$GLOBALS['TL_DCA']['tl_content']['fields']['secondImageGroup'] = [
    'inputType' => 'group',
];

$GLOBALS['TL_DCA']['tl_content']['fields']['secondImage'] = [
    'inputType' => 'fileTree',
    'eval' => [
        'filesOnly' => true,
        'fieldType' => 'radio',
        'extensions' => 'jpg,jpeg,png,webp',
        'mandatory' => true,
    ],
    'sql'       => "binary(16) NULL"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['secondImageSize'] = [
    'inputType' => 'imageSize',
    'eval' => [
        'mandatory' => true,
        'rgxp' => 'digit',
        'includeBlankOption' => true,
    ],
    'options_callback' => function () {
        return System::getContainer()->get('contao.image.sizes')->getAllOptions();
    },
    'sql'       => "binary(16) NULL"
];


?>
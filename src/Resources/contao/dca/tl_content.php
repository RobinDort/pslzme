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

$GLOBALS['TL_DCA']['tl_content']['palettes']['pslzme_image'] = '{type_legend},type;{text_legend};
personalizedTextGroup,personalizedText;
unpersonalizedTextGroup,unpersonalizedText;
contentSpaceGroup,contentSpaceTop,contentSpaceRight,contentSpaceBottom,contentSpaceLeft,contentSpaceUnit;
firstImageGroup,firstImage,firstImageSize,firstImageAlt,firstImageTitle;
secondImageGroup,secondImage,secondImageSize,secondImageLink,secondImageAlt,secondImageTitle;
{expert_legend:hide},cssID';


$GLOBALS['TL_DCA']['tl_content']['fields']['contentSpaceGroup'] = [
    'inputType' => 'group',
];

$GLOBALS['TL_DCA']['tl_content']['fields']['contentSpaceTop'] = [
    'inputType' => 'text',
    'eval' => [
        'maxlength' => 64,
        'tl_class' => 'w25',
    ],
    'sql' => "varchar(64) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['contentSpaceRight'] = [
    'inputType' => 'text',
    'eval' => [
        'maxlength' => 64,
        'tl_class' => 'w25',
    ],
    'sql' => "varchar(64) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['contentSpaceBottom'] = [
    'inputType' => 'text',
    'eval' => [
        'maxlength' => 64,
        'tl_class' => 'w25',
    ],
    'sql' => "varchar(64) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['contentSpaceLeft'] = [
    'inputType' => 'text',
    'eval' => [
        'maxlength' => 64,
        'tl_class' => 'w25',
    ],
    'sql' => "varchar(64) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['contentSpaceUnit'] = [
    'inputType' => 'select',
    'options' => ['px', 'em', 'rem', '%', 'vh', 'vw'],
    'default' => 'px',
    'eval' => [
        'maxlength' => 4,
        'tl_class' => 'w25',
    ],
    'sql' => "varchar(4) NOT NULL default 'px'",
];


$GLOBALS['TL_DCA']['tl_content']['fields']['firstImageGroup'] = [
    'inputType' => 'group',
    'eval' => [
        'tl_class' => 'clr',
    ],
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
        'includeBlankOption' => true,
    ],
    'options_callback' => function () {
        return System::getContainer()->get('contao.image.sizes')->getAllOptions();
    },
    'sql'       => "varchar(64) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['firstImageAlt'] = [
    'inputType' => 'group',
    'inputType' => 'text',
    'eval' => [
        'mandatory' => false,
        'maxlength' => 255,
        'tl_class' => 'w50'
    ],
    'sql' => "varchar(255) NOT NULL default ''",
];


$GLOBALS['TL_DCA']['tl_content']['fields']['firstImageTitle'] = [
    'inputType' => 'text',
    'eval' => [
        'mandatory' => false,
        'maxlength' => 255,
        'tl_class' => 'w50'
    ],
    'sql' => "varchar(255) NOT NULL default ''",
];


$GLOBALS['TL_DCA']['tl_content']['fields']['secondImageGroup'] = [
    'inputType' => 'group',
    'eval' => [
        'tl_class' => 'clr',
    ]
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
        'includeBlankOption' => true,
    ],
    'options_callback' => function () {
        return System::getContainer()->get('contao.image.sizes')->getAllOptions();
    },
    'sql'       => "varchar(64) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['secondImageLink'] = [
    'inputType' => 'pageTree',
    'eval' => [
        'mandatory' => false,
        'fieldType' => 'radio',
        'extensions' => '',
    ],
    'sql' => "blob NULL",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['secondImageAlt'] = [
    'inputType' => 'text',
    'eval' => [
        'mandatory' => false,
        'maxlength' => 255
    ],
    'sql' => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['secondImageTitle'] = [
    'inputType' => 'text',
    'eval' => [
        'mandatory' => false,
        'maxlength' => 255
    ],
    'sql' => "varchar(255) NOT NULL default ''",
];



/**
 * Configuration for pslzme_marquee element
 */
$GLOBALS['TL_DCA']['tl_content']['palettes']['pslzme_marquee'] = '{type_legend},type,headline;{text_legend};personalizedMarqueeTextGroup,personalizedMarqueeText;unpersonalizedMarqueeTextGroup,unpersonalizedMarqueeText;{expert_legend:hide},cssID';

$GLOBALS['TL_DCA']['tl_content']['fields']['personalizedMarqueeTextGroup'] = [
    'inputType' => 'group',
];

$GLOBALS['TL_DCA']['tl_content']['fields']['personalizedMarqueeText'] = [
    'exclude'   => true,
    'inputType' => 'textarea',
    'eval'      => ['rte' => 'tinyMCE', 'helpwizard' => true, 'mandatory' => false],
    'sql' => "TEXT NULL"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['unpersonalizedMarqueeTextGroup'] = [
    'inputType' => 'group',
];

$GLOBALS['TL_DCA']['tl_content']['fields']['unpersonalizedMarqueeText'] = [
    'exclude'   => true,
    'inputType' => 'textarea',
    'eval'      => ['rte' => 'tinyMCE', 'helpwizard' => true, 'mandatory' => true],
    'sql' => "TEXT NULL"
];


/**
 * Configuration for pslzme_3d_text element
 */

$GLOBALS['TL_DCA']['tl_content']['palettes']['pslzme_3d_text'] = '{type_legend},type,{text_legend};personalized3DTextGroup,personalized3DText;unpersonalized3DTextGroup,unpersonalized3DText;text3DColorOptionsGroup,text3DSceneBackgroundColor,text3DHighlightColorOne,text3DHighlightColorTwo,text3DHighlightColorThree;text3DCameraOptionsGroup,text3DCameraPosX,text3DCameraPosY,text3DCameraPosZ,text3DCameraTargetPosX,text3DCameraTargetPosY,text3DCameraTargetPosZ;text3DFurtherOptionsGroup,text3DFogEnabled,text3DFogColor,text3DTextMirrored,text3DTextDraggable,text3DMovingLightEnabled,text3DTextRotation,text3DTextRotationDirection;{expert_legend:hide},cssID';

$GLOBALS['TL_DCA']['tl_content']['palettes']['__selector__'][] = 'text3DFogEnabled';
$GLOBALS['TL_DCA']['tl_content']['palettes']['__selector__'][] = 'text3DTextRotation';

$GLOBALS['TL_DCA']['tl_content']['subpalettes']['text3DFogEnabled'] = 'text3DFogColor';
$GLOBALS['TL_DCA']['tl_content']['subpalettes']['text3DTextRotation'] = 'text3DTextRotationDirection';

$GLOBALS['TL_DCA']['tl_content']['fields']['personalized3DTextGroup'] = [
    'inputType' => 'group',
];


$GLOBALS['TL_DCA']['tl_content']['fields']['personalized3DText'] = [
    'exclude'   => true,
    'inputType' => 'textarea',
    'eval'      => ['rte' => 'tinyMCE', 'helpwizard' => true, 'mandatory' => false],
    'sql' => "TEXT NULL"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['unpersonalized3DTextGroup'] = [
    'inputType' => 'group',
];

$GLOBALS['TL_DCA']['tl_content']['fields']['unpersonalized3DText'] = [
    'exclude'   => true,
    'inputType' => 'textarea',
    'eval'      => ['rte' => 'tinyMCE', 'helpwizard' => true, 'mandatory' => true],
    'sql' => "TEXT NULL"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['text3DColorOptionsGroup'] = [
    'inputType' => 'group',
];

$GLOBALS['TL_DCA']['tl_content']['fields']['text3DSceneBackgroundColor'] = [
    'inputType' => 'text',
    'eval' => ['colorPicker' => true, 'mandatory' => false],
    'sql' => "varchar(20) NULL default '#222222'",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['text3DHighlightColorOne'] = [
    'inputType' => 'text',
    'eval' => ['colorPicker' => true, 'mandatory' => false],
    'sql' => "varchar(20) NULL default '#a4dd46'",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['text3DHighlightColorTwo'] = [
    'inputType' => 'text',
    'eval' => ['colorPicker' => true, 'mandatory' => false],
    'sql' => "varchar(20) NULL default '#0000ff'",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['text3DHighlightColorThree'] = [
    'inputType' => 'text',
    'eval' => ['colorPicker' => true, 'mandatory' => false],
    'sql' => "varchar(20) NULL default '#ff0000'",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['text3DCameraOptionsGroup'] = [
    'inputType' => 'group',
];

$GLOBALS['TL_DCA']['tl_content']['fields']['text3DCameraPosX'] = [
    'inputType' => 'text',
    'eval' => ['rgxp' => 'digit', 'minval' => 0, 'maxval' => 1000, 'tl_class' => 'w33', 'mandatory' => false],
    'default' => '0',
    'sql' => "varchar(4) NULL default '0'",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['text3DCameraPosY'] = [
    'inputType' => 'text',
    'eval' => ['rgxp' => 'digit', 'minval' => 0, 'maxval' => 1000, 'tl_class' => 'w33', 'mandatory' => false],
    'default' => '150',
    'sql' => "varchar(4) NULL default '150'",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['text3DCameraPosZ'] = [
    'inputType' => 'text',
    'eval' => ['rgxp' => 'digit', 'minval' => 0, 'maxval' => 1000, 'tl_class' => 'w33', 'mandatory' => false],
    'default' => '700',
    'sql' => "varchar(4) NULL default '700'",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['text3DCameraTargetPosX'] = [
    'inputType' => 'text',
    'eval' => ['rgxp' => 'digit', 'minval' => 0, 'maxval' => 500, 'tl_class' => 'w33', 'mandatory' => false],
    'default' => '0',
    'sql' => "varchar(3) NULL default '0'",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['text3DCameraTargetPosY'] = [
    'inputType' => 'text',
    'eval' => ['rgxp' => 'digit', 'minval' => 0, 'maxval' => 500, 'tl_class' => 'w33', 'mandatory' => false],
    'default' => '115',
    'sql' => "varchar(3) NULL default '115'",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['text3DCameraTargetPosZ'] = [
    'inputType' => 'text',
    'eval' => ['rgxp' => 'digit', 'minval' => 0, 'maxval' => 500, 'tl_class' => 'w33', 'mandatory' => false],
    'default' => '0',
    'sql' => "varchar(3) NULL default '0'",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['text3DFurtherOptionsGroup'] = [
    'inputType' => 'group',
];

$GLOBALS['TL_DCA']['tl_content']['fields']['text3DFogEnabled'] = [
    'inputType' => 'checkbox',
    'eval' => ['isBoolean' => true, 'mandatory' => false, 'submitOnChange' => true],
    'default' => true,
    'sql' => "char(1) NOT NULL default '1'"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['text3DFogColor'] = [
    'inputType' => 'text',
    'eval' => ['colorPicker' => true, 'mandatory' => false],
    'sql' => "varchar(20) NULL default '#222222'",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['text3DTextMirrored'] = [
    'inputType' => 'checkbox',
    'eval' => ['isBoolean' => true, 'mandatory' => false],
    'default' => false,
    'sql' => "char(1) NOT NULL default '0'"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['text3DTextDraggable'] = [
    'inputType' => 'checkbox',
    'eval' => ['isBoolean' => true, 'mandatory' => false],
    'default' => true,
    'sql' => "char(1) NOT NULL default '1'"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['text3DMovingLightEnabled'] = [
    'inputType' => 'checkbox',
    'eval' => ['isBoolean' => true, 'mandatory' => false],
    'default' => true,
    'sql' => "char(1) NOT NULL default '1'"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['text3DTextRotation'] = [
    'inputType' => 'checkbox',
    'eval' => ['isBoolean' => true, 'mandatory' => false, 'submitOnChange' => true],
    'default' => true,
    'sql' => "char(1) NOT NULL default '1'"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['text3DTextRotationDirection'] = [
    'inputType' => 'select',
    'eval' => ['mandatory' => true],
    'options' => ['Left', 'Right'],
    'reference' => &$GLOBALS['TL_LANG']['tl_content']['text3DTextRotationDirection'],
    'default' => 'Left',
    'sql' => "char(6) NOT NULL default 'Left'"
];
?>
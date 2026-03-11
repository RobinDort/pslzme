<?php
namespace RobinDort\PslzmeLinks\Elements;

use Contao\ContentElement;

/**
 * custom contao element that represents the main pslzme 3d text element that is used to show personalized messages.
 */
class Pslzme3DTextElement extends ContentElement {

    protected $strTemplate = 'ce_pslzme_3d_text';

    protected function compile() {

        $this->Template->usedText = $GLOBALS['decryptedVars']['varsSet'] === true && !empty($this->personalized3DText) ? $this->personalized3DText : $this->unpersonalized3DText;
        $this->Template->text3DSceneBackgroundColor = $this->text3DSceneBackgroundColor;
        $this->Template->text3DHighlightColorOne = $this->text3DHighlightColorOne;
        $this->Template->text3DHighlightColorTwo = $this->text3DHighlightColorTwo;
        $this->Template->text3DHighlightColorThree = $this->text3DHighlightColorThree;
        $this->Template->text3DCameraPosX = $this->text3DCameraPosX;
        $this->Template->text3DCameraPosY = $this->text3DCameraPosY;
        $this->Template->text3DCameraPosZ = $this->text3DCameraPosZ;
        $this->Template->text3DCameraTargetPosX = $this->text3DCameraTargetPosX;
        $this->Template->text3DCameraTargetPosY = $this->text3DCameraTargetPosY;
        $this->Template->text3DCameraTargetPosZ = $this->text3DCameraTargetPosZ;
        $this->Template->text3DFogEnabled = $this->text3DFogEnabled;
        $this->Template->text3DFogColor = $this->text3DFogColor;
        $this->Template->text3DTextMirrored = $this->text3DTextMirrored;
        $this->Template->text3DTextDraggable = $this->text3DTextDraggable;
        $this->Template->text3DMovingLightEnabled = $this->text3DMovingLightEnabled;
        $this->Template->text3DTextRotation = $this->text3DTextRotation;
        $this->Template->text3DTextRotationDirection = $this->text3DTextRotationDirection;

        error_log('text3DTextRotation: ' . $this->text3DTextRotation);
        error_log('text3DMovingLightEnabled: ' . $this->text3DMovingLightEnabled);
        error_log('text3DTextRotationDirection: ' . $this->text3DTextRotationDirection);

    }

}


?>
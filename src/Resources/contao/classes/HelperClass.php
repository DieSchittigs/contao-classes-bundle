<?php

namespace DieSchittigs\ContaoClassesBundle;

use DieSchittigs\ContaoClassesBundle\ClassesModel;
use Contao\Frontend;
use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\ContentElement;
use Contao\ContentModel;

class HelperClass extends Frontend
{
    public function addClassesToPage($objPage, $objLayout, $objPageRegular)
    {
        if (!is_array($arrCustom = unserialize($objPage->customClass))) return;

        foreach ($arrCustom as $classID) {

            $objClass = ClassesModel::findBy(['id=?', 'showOnPage=?'], [$classID, 1]);
            $objPage->cssClass .= ' ' . $objClass->cssClass;
        }
        $objPage->cssClass = trim($objPage->cssClass);
    }

    public function addClassesToArticle($objRow)
    {

        $arrCss = unserialize($objRow->cssID);

        if (!is_array($arrCustom = unserialize($objRow->customClass))) return;

        foreach ($arrCustom as $classID) {
            $objClass = ClassesModel::findBy(['id=?', 'showOnArticle=?'], [$classID, 1]);
            $arrCss[1] .= ' ' . $objClass->cssClass;
        }

        //$arrCss[1] .= ' ' . implode(' ', $arrCustom);
        $objRow->cssID = serialize([$arrCss[0], trim($arrCss[1])]);
    }

    //public function addClassesToElement($objRow, $strBuffer, $objElement)
    public function addClassesToElement(ContentModel $contentModel, string $buffer, $element)
    {
        $cssId = (is_array(unserialize($contentModel->cssID))) ? unserialize($contentModel->cssID)[1] : '';
        $classes = 'content-' . $contentModel->type . ((empty($cssId)) ? '' : ' ' . $cssId);

        if (!is_array($arrCustom = unserialize($contentModel->customClass))) return $buffer;

        $arrCss = [];
        foreach ($arrCustom as $classID) {
            $objClass = ClassesModel::findBy(['id=?', 'showOnElement=?'], [$classID, 1]);
            $arrCss[] = ' ' . $objClass->cssClass;
        }
        if (is_array($arrCss)) {
            $classes .= implode(' ', $arrCss);
        }


        $rgxp = "/class\=\"[\w\s-]*content\-[\w\s-]*\"/m";
        $replace = 'class="' . $classes . '"';
        // replace string buffer

        $buffer = preg_replace($rgxp, $replace, $buffer, 1);
        return $buffer;
    }
}

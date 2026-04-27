<?php

namespace Derralf\ElementalMover;

use SilverStripe\Core\Extension;
use DNADesign\Elemental\Models\ElementalArea;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;

use SilverStripe\ORM\ArrayList;
use SilverStripe\View\ArrayData;


class ElementalMoverExtension extends Extension
{

    public function updateCMSFields(FieldList $fields)
    {
        $availableParents = $this->getElementalAreaDropdownMap();
        if($availableParents) {
            $ParentIdDropdown = DropdownField::create('TempParentID', _t(self::class.'.AreaDropdownLabel', 'Move to'), $availableParents, $this->getOwner()->ParentID);
            $fields->addFieldToTab('Root.Move', $ParentIdDropdown);
        }

        return $fields;
    }


    public function getElementalAreaDropdownMap() {
        $available_areas = ElementalArea::get();
        if($available_areas->exists()) {
            $area_list = ArrayList::create();
            foreach($available_areas as $area) {
                $ownerPage = $area->getOwnerPage();
                if ($ownerPage) {
                    $area_list->push(ArrayData::create([
                        "AreaID" => $area->ID,
                        "PageMenuTitle" => $ownerPage->MenuTitle,
                        "PageLink" => $ownerPage->Link(),
                        "PageSort" => $ownerPage->Sort,
                        "PageParentSort" => $ownerPage->Parent()->Sort,
                        "DropdownTitle" => $area->getOwnerPage()->MenuTitle . ' (' . $area->getOwnerPage()->Link() . ')'
                    ]));
                }
            }

            $area_list = $area_list->sort([
                'PageParentSort' => 'ASC',
                'PageSort'       => 'ASC',
                'PageLink'       => 'ASC'
            ]);
            return $area_list->map("AreaID", "DropdownTitle");
        }
    }

    public function onBeforeWrite()
    {
        parent::onBeforeWrite();
        if($this->getOwner()->TempParentID && ($this->getOwner()->TempParentID != $this->getOwner()->ParentID)) {
            $this->getOwner()->ParentID = $this->getOwner()->TempParentID;

        }
    }

}

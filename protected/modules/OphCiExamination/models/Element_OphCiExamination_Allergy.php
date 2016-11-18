<?php
/**
 * OpenEyes.
 *
 * (C) Moorfields Eye Hospital NHS Foundation Trust, 2008-2011
 * (C) OpenEyes Foundation, 2011-2013
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @link http://www.openeyes.org.uk
 *
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (c) 2008-2011, Moorfields Eye Hospital NHS Foundation Trust
 * @copyright Copyright (c) 2011-2013, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/gpl-3.0.html The GNU General Public License V3.0
 */

namespace OEModule\OphCiExamination\models;

class Element_OphCiExamination_Allergy extends \BaseEventTypeElement
{
    // Custom attribute to determine the allergy validation
    public $allergy_group;

    public function getCurrentDataWithQuery(){
        
        $condition = 'paa.patient_id = :id';
        
        $params[':id'] = $this->event->episode->patient->id;
        
        $result = \Yii::app()->db->createCommand()
            ->select('*')
            ->from('et_ophciexamination_allergy_version av')
            ->join('patient_allergy_assignment paa','paa.last_modified_date = av.version_date')
            ->join('allergy a','a.id = paa.allergy_id')
            ->where($condition,$params)
            ->queryAll();
        return $result;
    }

    public function getAllVersionDataWithQuery(){
        $condition = 'av.event_id = :id 
                      and paa.patient_id = :paid';
                      
        $params[':id'] = $this->event->id;      
        $params[':paid'] = $this->event->episode->patient->id;    
        $result = \Yii::app()->db->createCommand()
            ->select('*')
            ->from('et_ophciexamination_allergy_version av')
            ->join('patient_allergy_assignment paa','paa.last_modified_date = av.version_date')
            ->join('allergy a','a.id = paa.allergy_id')
            ->where($condition,$params)
            ->order('av.last_modified_date DESC')
            ->queryAll();
        return $result;
    }

    public function getVersionDataWithQuery($event_id=null){
        $condition = 'av.event_id = :id 
                      and paa.patient_id = :paid
                      and av.version_id = :version_id';
        $params[':paid'] = $this->event->episode->patient->id;    
        if($event_id != null){
            $params[':id'] = $event_id;
        } else {
            $params[':id'] = $this->event->id;
        }
        $params[':version_id'] = $this->getVersionID();

        $result = \Yii::app()->db->createCommand()
            ->select('av.*,a.id as allergy_id, a.name as allergy_name, paa.id as assigment_id, paa.comments')
            ->from('et_ophciexamination_allergy_version av')
            ->join('patient_allergy_assignment paa','paa.last_modified_date = av.version_date')
            ->join('allergy a','a.id = paa.allergy_id')
            ->where($condition,$params)
            ->queryAll();

        return $result;
    }

    public function tableName()
    {
        return 'et_ophciexamination_allergy';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('event_id', 'safe'),
            array('allergy_group', 'validateAllergy'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'event' => array(self::BELONGS_TO, 'Event', 'event_id'),
            'user' => array(self::BELONGS_TO, 'User', 'created_user_id'),
            'usermodified' => array(self::BELONGS_TO, 'User', 'last_modified_user_id'),
        );
    }

    /**
     * To validate the allergy elements
     * @param $attribute
     * @param $param
     */
    public function validateAllergy($attribute, $param)
    {
        if ( $this->event->episode->patient->allergyAssignments &&
            !\Yii::app()->request->getParam('no_allergies') &&
            !\Yii::app()->request->getParam('selected_allergies') &&
            !\Yii::app()->request->getParam('deleted_allergies')
        )
        {
            return;
        }
        if (!\Yii::app()->request->getParam('no_allergies') && !\Yii::app()->request->getParam('selected_allergies'))
        {
            $this->addError($attribute, 'Please select an allergy or confirm patient has no allergies');
        }
    }

}

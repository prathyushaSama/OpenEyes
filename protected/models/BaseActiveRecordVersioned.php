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
class BaseActiveRecordVersioned extends BaseActiveRecord
{
    private $enable_version = true;
    private $fetch_from_version = false;
    private $version_id = null;

    public function getFromVersion(){
        return $this->fetch_from_version;
    }

    public function setVersionID($versionID){
        $this -> version_id = $versionID;
    }
    
    /**
     * Get the versionID for this element.
     *
     * @return ElementType
     */
    public function getVersionID(){
        return $this -> version_id;
    }

    /* Disable archiving on save() */
    
    public function noVersion()
    {
        $this->enable_version = false;
        return $this;
    }

    /* Re-enable archiving on save() */
    
    public function withVersion()
    {
        $this->enable_version = true;

        return $this;
    }

    /* Fetch from version */

    public function fromVersion()
    {
        $this->fetch_from_version = true;

        return $this;
    }

    /* Disable fetch from version */

    public function notFromVersion()
    {
        $this->fetch_from_version = false;

        return $this;
    }

    public function getTableSchema()
    {
        if ($this->fetch_from_version) {
            return $this->getDbConnection()->getSchema()->getTable($this->tableName().'_version');
        }

        return parent::getTableSchema();
    }

    public function getEventDataFromElement()
    {
        $condition = 'id = :id';
        $params = array(':id' => $this->id);
        return $this->model()->findAll(array(
            'condition' => $condition,
            'params' => $params
        ));
    }

    public function getPreviousModificationsHeader($event_id = null)
    {
        $condition = 'v.event_id = :id';
        $params[':id'] = $event_id;

        return Yii::app()->db->createCommand()
            ->select('u.first_name, u.last_name, TIME(v.last_modified_date) as last_modified_date, v.version_id')
            ->from($this->tableName().'_version v')
            ->join('user u', 'u.id=v.last_modified_user_id')
            ->where($condition,$params)
            ->order('v.last_modified_date DESC')->queryAll();
    }

    /* Return all previous modifier users by versions ordered by most recent */
    public function getPreviousUsersByVersions()
    {
        $condition = 'v.id = :id';
        $params[':id'] = $this->id;

        if ($this->version_id) {
            $condition .= ' and v.version_id = :version_id';
            $params[':version_id'] = $this->version_id;
        }

        return Yii::app()->db->createCommand()
            ->select('u.first_name, u.last_name, v.last_modified_date')
            ->from($this->tableName().'_version v')
            ->join('user u', 'u.id=v.last_modified_user_id')
            ->where($condition,$params)
            ->order('v.version_id DESC')->queryAll();
    }

    public function getVersionTableSchema()
    {
        return Yii::app()->db->getSchema()->getTable($this->tableName().'_version');
    }

    public function getCommandBuilder()
    {
        return new OECommandBuilder($this->getDbConnection()->getSchema());
    }

    public function updateByPk($pk, $attributes, $condition = '', $params = array())
    {
        $transaction = $this->dbConnection->beginInternalTransaction();
        try {
            $this->versionToTable($this->commandBuilder->createPkCriteria($this->tableName(), $pk, $condition, $params));
            $result = parent::updateByPk($pk, $attributes, $condition, $params);
            $transaction->commit();

            return $result;
        } catch (Exception $e) {
            $transaction->rollback();
            throw $e;
        }
    }

    public function updateAll($attributes, $condition = '', $params = array())
    {
        $transaction = $this->dbConnection->beginInternalTransaction();
        try {
            $this->versionToTable($this->commandBuilder->createCriteria($condition, $params));
            $result = parent::updateAll($attributes, $condition, $params);
            $transaction->commit();

            return $result;
        } catch (Exception $e) {
            $transaction->rollback();
            throw $e;
        }
    }

    public function deleteByPk($pk, $condition = '', $params = array())
    {
        $transaction = $this->dbConnection->beginInternalTransaction();
        try {
            $this->versionToTable($this->commandBuilder->createPkCriteria($this->tableName(), $pk, $condition, $params));
            $result = parent::deleteByPk($pk, $condition, $params);
            $transaction->commit();

            return $result;
        } catch (Exception $e) {
            $transaction->rollback();
            throw $e;
        }
    }

    public function deleteAll($condition = '', $params = array())
    {
        $transaction = $this->dbConnection->beginInternalTransaction();
        try {
            $this->versionToTable($this->commandBuilder->createCriteria($condition, $params));
            $result = parent::deleteAll($condition, $params);
            $transaction->commit();

            return $result;
        } catch (Exception $e) {
            $transaction->rollback();
            throw $e;
        }
    }

    public function deleteAllByAttributes($attributes, $condition = '', $params = array())
    {
        $transaction = $this->dbConnection->beginInternalTransaction();
        try {
            $this->versionToTable($this->commandBuilder->createColumnCriteria($this->tableName(), $attributes, $condition, $params));
            $result = parent::deleteAllByAttributes($attributes, $condition, $params);
            $transaction->commit();

            return $result;
        } catch (Exception $e) {
            $transaction->rollback();
            throw $e;
        }
    }

    public function save($runValidation = true, $attributes = null, $allow_overriding = false)
    {
        if ($this->version_id) {
            throw new Exception('save() should not be called on versiond model instances.');
        }

        return parent::save($runValidation, $attributes, $allow_overriding);
    }

    public function resetScope($resetDefault = true)
    {
        $this->enable_version = true;
        $this->fetch_from_version = false;

        return parent::resetScope($resetDefault);
    }

    protected function versionToTable(CDbCriteria $criteria)
    {
        if ($this->enable_version) {
            $this->getCommandBuilder()->createInsertFromTableCommand(
                $this->getVersionTableSchema(), $this->getTableSchema(), $criteria
            )->execute();
        }
    }
    
    public function getVersion($versionID=null)
    {
        $this->version_id = $versionID == null ? $this->version_id : $versionID;
        $condition = 'id = :id';
        $params = array(':id' => $this->id);
        $condition .= ' and version_id = :version_id';
        $params[':version_id'] = $this->version_id;

        $version = $this->model()->fromVersion()->find(array(
            'condition' => $condition,
            'params' => $params,
            'order' => 'version_id desc',
        ));
        
        $version -> setAttribute('version_id', $this->version_id );
        return $version;
    }

    public function getLastVersion()
    {
        $condition = 'id = :id';
        $params = array(':id' => $this->id);

        $version = $this->model()->fromVersion()->find(array(
            'condition' => $condition,
            'params' => $params,
            'order' => 'version_id desc',
            'limit' => '1',
        ));

        return $version;        
    }

    /* Return all previous versions ordered by most recent */
    public function getPreviousVersions()
    {
        $condition = 'id = :id';
        $params = array(':id' => $this->id);
        

        if ($this->version_id) {
            $condition .= ' and version_id < :version_id';
            $params[':version_id'] = $this->version_id;
        }
       
        $versions = $this->model()->fromVersion()->findAll(array(
            'condition' => $condition,
            'params' => $params,
            'order' => 'version_id desc',
        ));
        
        return $versions;
    }

    public function getPreviousVersion()
    {
        $condition = 'id = :id';
        $params = array(':id' => $this->id);
        $condition .= ' and version_id < :version_id';
        $params[':version_id'] = $this->version_id;

        $version = $this->model()->fromVersion()->find(array(
            'condition' => $condition,
            'params' => $params,
            'order' => 'version_id desc',
            'limit' => '1',
        ));
        
        //$version -> version_id = $this->version_id;
        return $version;
    }
    
    private function addStyleToModifiedValue($value)
    {
        return sprintf("|span class=[highlighted_red]|%s|span|", $value);
    }    

    public function versionsDiff($version1,$version2)
    {
        if($version2==null){ return array(); }
        $diff = array();
        $diffCount = 0;
        
        foreach($version1->getAttributes() as $key => $oneAttrib){
            if( in_array($key,array('last_modified_date')) )
            { 
                continue; 
            }
            
            $prevAttrib = $version2->getAttributes()[$key];
            
            if( $oneAttrib != $prevAttrib )
            {
                $diffCount++;
                if($prevAttrib!='' && $oneAttrib=='')
                {
                    $oneAttrib = '*DELETED*';
                }
                $version1->setAttribute($key,$this->addStyleToModifiedValue($oneAttrib));
            }
        }
        return $diffCount == 0 ? false : $version1;
    }    
 
    public function hasDiffVersions($version1,$version2){
        if($version2==null){ return array(); }
        
        foreach($version1->getAttributes() as $key => $oneAttrib){
            if( in_array($key,array('last_modified_date')) )
            { 
                continue; 
            }
            
            $prevAttrib = $version2->getAttributes()[$key];
            
            if( $oneAttrib != $prevAttrib )
            {
                return true;
            }
        }
        return false;
    }
}

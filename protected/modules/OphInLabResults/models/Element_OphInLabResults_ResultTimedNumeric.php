<?php

/**
 * Class Element_OphInLabResults_ResultTimedNumeric
 */
class Element_OphInLabResults_ResultTimedNumeric extends BaseLabResultElement
{

    protected $htmlOptions = array(
        'time' => array('type' => 'time'),
        'result' => array('type' => 'number'),
    );

    /**
     * @return string
     */
    public function tableName()
    {
        return 'et_ophinlabresults_result_timed_numeric';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('time, result', 'required'),
            array('result', 'numerical'),
            array('time', 'type', 'type' => 'time', 'timeFormat'=>'hh:mm'),
            array('event_id, time, result, comment', 'safe'),
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
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
        );
    }

    /**
     * @inheritdoc
     */
    public function afterFind()
    {
        parent::afterFind();
        //We aren't really interested in the microseconds and it breaks the validation on edit
        $this->time = date_create_from_format('H:i:s', $this->time)->format('H:i');
    }

}
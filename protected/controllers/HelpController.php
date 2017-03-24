<?php

class HelpController extends BaseController
{

    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('view'),
                'users' => array('@'),
            ),
        );
    }

    public function onBeforeSave()
    {

    }

    public function actionView($id)
    {
    	$this->render('view',
    		array(
    			'topic_id' => $id
    		)
    	);
    }
}
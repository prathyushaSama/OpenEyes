<?php
/**
 * OpenEyes
 *
 * (C) Moorfields Eye Hospital NHS Foundation Trust, 2008-2011
 * (C) OpenEyes Foundation, 2011-2012
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package OpenEyes
 * @link http://www.openeyes.org.uk
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (c) 2008-2011, Moorfields Eye Hospital NHS Foundation Trust
 * @copyright Copyright (c) 2011-2012, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/gpl-3.0.html The GNU General Public License V3.0
 */

Yii::import('application.controllers.*');

class PatientController extends BaseController
{
	public $layout = '//layouts/column2';
	public $patient;
	public $service;
	public $firm;
	public $editing;
	public $event;
	public $event_type;
	public $title;

	public function filters()
	{
		return array('accessControl');
	}

	public function accessRules()
	{
		return array(
			array('allow',
				'users'=>array('@')
			),
			// non-logged in can't view anything
			array('deny',
				'users'=>array('?')
			),
		);
	}

	protected function beforeAction($action)
	{
		parent::storeData();

		// Sample code to be used when RBAC is fully implemented.
//		if (!Yii::app()->user->checkAccess('admin')) {
//			throw new CHttpException(403, 'You are not authorised to perform this action.');
//		}

		$this->firm = Firm::model()->findByPk($this->selectedFirmId);

		if (!isset($this->firm)) {
			// No firm selected, reject
			throw new CHttpException(403, 'You are not authorised to view this page without selecting a firm.');
		}

		$this->service = new ClinicalService;

		return parent::beforeAction($action);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->patient = $this->loadModel($id);

		$tabId = !empty($_GET['tabId']) ? $_GET['tabId'] : 0;
		$eventId = !empty($_GET['eventId']) ? $_GET['eventId'] : 0;

		$episodes = $this->patient->episodes;

		$this->layout = '//layouts/patientMode/main';

		$this->logActivity('viewed patient');

		$episodes_open = 0;
		$episodes_closed = 0;

		foreach ($episodes as $episode) {
			if ($episode->end_date === null) {
				$episodes_open++;
			} else {
				$episodes_closed++;
			}
		}

		$this->render('view', array(
			'tab' => $tabId, 'event' => $eventId, 'episodes' => $episodes, 'episodes_open' => $episodes_open, 'episodes_closed' => $episodes_closed
		));
	}

	/**
	 * Redirect to correct patient view by hospital number
	 * @param string $hos_num
	 * @throws CHttpException
	 */
	public function actionViewhosnum($hos_num) {
		$hos_num = (int) $hos_num;
		if(!$hos_num) {
			throw new CHttpException(400, 'Invalid hospital number');
		}
		$patient = Patient::model()->find('hos_num=:hos_num', array(':hos_num' => $hos_num));
		if($patient) {
			$this->redirect('/patient/view/'.$patient->id);
		} else {
			throw new CHttpException(404, 'Hospital number not found');
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider = new CActiveDataProvider('Patient');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	/**
	 * Display a form to use for searching models
	 */
	public function actionSearch()
	{
		if (isset($_POST['Patient'])) {
			$this->forward('results');
		} else {
			$model = new Patient;
			$this->render('search', array(
				'model' => $model,
			));
		}
	}

	/**
	 * Display results based on a search submission
	 */
	public function actionResults($page=false)
	{
		if (!empty($_POST)) {

			foreach ($_POST['Patient'] as $key => $value) {
				$_POST['Patient'][$key] = trim($value);
			}

			if ((!@$_POST['Patient']['hos_num'] || preg_match('/[^\d]/', $_POST['Patient']['hos_num'])) && (!@$_POST['Patient']['first_name'] || !@$_POST['Patient']['last_name'])) {
				setcookie('patient-search-minimum-criteria','1',0,'/');
				$this->redirect('/patient/results/error');
			}

			if (@$_POST['Patient']['hos_num']) {
				$get_hos_num = str_pad($_POST['Patient']['hos_num'], 7, '0', STR_PAD_LEFT);
				$_GET = array(
					'hos_num' => $get_hos_num,
					'nhs_num' => '',
					'gender' => '',
					'sort_by' => 0,
					'sort_dir' => 0,
					'page_num' => 1,
					'first_name' => '',
					'last_name' => ''
				);

				$this->patientSearch();

				Yii::app()->end();
			} else {
				$get_hos_num = '000000';
			}

			$get_first_name = (@$_POST['Patient']['first_name'] ? $_POST['Patient']['first_name'] : '0');
			$get_last_name = (@$_POST['Patient']['last_name'] ? $_POST['Patient']['last_name'] : '0');
			// Get rid of any dashes from nhs_num as PAS doesn't store them
			$get_nhs_num = (@$_POST['Patient']['nhs_num'] ? preg_replace('/-/', '', $_POST['Patient']['nhs_num']) : '0');
			$get_gender = (@$_POST['Patient']['gender'] ? $_POST['Patient']['gender'] : '0');
			$get_dob_day = (@$_POST['dob_day'] ? $_POST['dob_day'] : '0');
			$get_dob_month = (@$_POST['dob_month'] ? $_POST['dob_month'] : '0');
			$get_dob_year = (@$_POST['dob_year'] ? $_POST['dob_year'] : '0');

			setcookie('patient-search-minimum-criteria','1',0,'/');
			$this->redirect("/patient/results/$get_first_name/$get_last_name/$get_nhs_num/$get_gender/0/0/1");
		}

		if (@$_GET['hos_num'] == '0' && (@$_GET['first_name'] == '0' || @$_GET['last_name'] == '0')) {
			$this->redirect('/patient/results/error');
		}

		$this->patientSearch();
	}

	function patientSearch() {
		
		switch ($_GET['sort_by']) {
			case 0:
				$sort_by = 'hos_num*1';
				break;
			case 1:
				$sort_by = 'title';
				break;
			case 2:
				$sort_by = 'first_name';
				break;
			case 3:
				$sort_by = 'last_name';
				break;
			case 4:
				$sort_by = 'dob';
				break;
			case 5:
				$sort_by = 'gender';
				break;
			case 6:
				$sort_by = 'nhs_num*1';
				break;
		}

		$sort_dir = ($_GET['sort_dir'] == 0 ? 'asc' : 'desc');
		
		$model = new Patient();
		$model->attributes = $this->collateGetData();
		$pageSize = 20;
		$dataProvider = $model->search(array(
			'currentPage' => (integer)@$_GET['page_num'],
			'pageSize' => $pageSize,
			'sortBy' => $sort_by,
			'sortDir'=> $sort_dir,
		));
		$nr = $model->search_nr();

		if($nr == 0) {
			$this->redirect('/patient/no-results');
		} else if($nr == 1) {
			foreach ($dataProvider->getData() as $item) {
				$this->redirect('/patient/view/'.$item->id);
			}
		} else {
			$pages = ceil($nr/$pageSize);
			$this->render('results', array(
				'dataProvider' => $dataProvider,
				'pages' => $pages,
				'items_per_page' => $pageSize,
				'total_items' => $nr,
				'first_name' => $_GET['first_name'],
				'last_name' => $_GET['last_name'],
				'nhs_num' => $_GET['nhs_num'],
				'gender' => $_GET['gender'],
				'pagen' => (integer)$_GET['page_num'],
				'sort_by' => (integer)$_GET['sort_by'],
				'sort_dir' => (integer)$_GET['sort_dir']
			));
		}
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model = new Patient('search');
		$model->unsetAttributes();	// clear any default values
		if (isset($_GET['Patient']))
			$model->attributes = $_GET['Patient'];

		$this->render('admin', array(
			'model' => $model,
		));
	}

	public function actionSummary()
	{
		$patient = $this->loadModel($_GET['id']);

		$criteria = new CDbCriteria;
		$criteria->compare('patient_id', $patient->id);
		$criteria->order = 'start_date DESC';

		$dataProvider = new CActiveDataProvider('Episode', array(
			'criteria'=>$criteria));

		$this->renderPartial('_summary',
			array('model'=>$patient, 'address'=>$patient->address, 'episodes'=>$dataProvider));
	}

	public function actionContacts()
	{
		$patient = $this->loadModel($_GET['id']);
		$this->renderPartial('_contacts', array('model'=>$patient));
	}

	public function actionCorrespondence()
	{
		$patient = $this->loadModel($_GET['id']);
		$this->renderPartial('_correspondence', array('model'=>$patient));
	}

	public function actionEpisodes()
	{
		$this->layout = '//layouts/patientMode/main';
		$this->service = new ClinicalService;
		$this->patient = $this->loadModel($_GET['id']);

		$episodes = $this->patient->episodes;

		$site = Site::model()->findByPk(Yii::app()->request->cookies['site_id']->value);

		$this->title = 'Episode summary';

		$this->render('events_and_episodes', array(
			'title' => empty($episodes) ? '' : 'Episode summary',
			'episodes' => $episodes,
			'eventTypes' => EventType::model()->getEventTypeModules(),
			'site' => $site,
			'current_episode' => empty($episodes) ? false : $episodes[0]
		));
	}

	public function actionEpisode($id)
	{
		$this->layout = '//layouts/patientMode/main';
		$this->service = new ClinicalService;

		if (!$episode = Episode::model()->findByPk($id)) {
			throw new SystemException('Episode not found: '.$id);
		}

		$this->patient = $episode->patient;

		$episodes = $this->patient->episodes;

		$site = Site::model()->findByPk(Yii::app()->request->cookies['site_id']->value);

		$this->title = 'Episode summary';

		$this->render('events_and_episodes', array(
			'title' => empty($episodes) ? '' : 'Episode summary',
			'episodes' => $episodes,
			'eventTypes' => EventType::model()->getEventTypeModules(),
			'site' => $site,
			'current_episode' => $episode
		));
	}

	public function actionEvent($id) {
		$this->layout = '//layouts/patientMode/main';
		$this->service = new ClinicalService;

		$this->event = Event::model()->findByPk($id);
		$this->event_type = EventType::model()->findByPk($this->event->event_type_id);
		$this->patient = $this->event->episode->patient;
		$episodes = $this->patient->episodes;

		$elements = $this->service->getDefaultElements('view', $this->event);

		$event_template_name = $this->getTemplateName('view', $this->event->event_type_id);

		$this->logActivity('viewed event');

		$site = Site::model()->findByPk(Yii::app()->request->cookies['site_id']->value);

		if(isset($this->event->element_operation->booking->session->date)){
			$this->title = $this->event_type->name .": ".$this->event->element_operation->booking->session->NHSDate('date'). ", ". $this->patient->first_name. " ". $this->patient->last_name;
		}else{
			$this->title = $this->event_type->name .": ". $this->patient->first_name. " ". $this->patient->last_name;
		}
		
		$this->render('events_and_episodes', array(
			'episodes' => $episodes,
			'elements' => $elements,
			'event_template_name' => $event_template_name,
			'eventTypes' => EventType::model()->getEventTypeModules(),
			'site' => $site,
			'current_episode' => $this->event->episode
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model = Patient::model()->findByPk((int) $id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'patient-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	protected function getEventTypeGrouping()
	{
		return array(
			'Examination' => array('visual fields', 'examination', 'question', 'outcome'),
			'Treatments' => array('oct', 'laser', 'operation'),
			'Correspondence' => array('letterin', 'letterout'),
			'Consent Forms' => array(''),
		);
	}

	/**
	 * Perform a search on a model and return the results
	 * (separate function for unit testing)
	 *
	 * @param array $data		form data of search terms
	 * @return dataProvider
	 */
	public function getSearch($data)
	{
		$model = new Patient;
		$model->attributes = $data;
		return $model->search();
	}

	/**
	 * Returns the $_REQUIEST['Patient'] values plus the dob day, month and year appended together.
	 *
	 * @return array
	 */
	public function collatePostData()
	{
		$data = $_POST['Patient'];

		if (isset($_POST['dob_day']) && isset($_POST['dob_month']) && isset($_POST['dob_year']) && $_POST['dob_day'] && $_POST['dob_month'] && $_POST['dob_year']) {
			$data['dob'] = $_POST['dob_year'] . '-' . $_POST['dob_month'] . '-' . $_POST['dob_day'];
		}

		return $data;
	}

	public function collateGetData()
	{
		$data = $_GET;

		if (isset($_GET['dob_day']) && isset($_GET['dob_month']) && isset($_GET['dob_year']) && $_GET['dob_day'] && $_GET['dob_month'] && $_GET['dob_year']) {
			$data['dob'] = $_GET['dob_year'] . '-' . $_GET['dob_month'] . '-' . $_GET['dob_day'];
		}

		foreach ($data as $key => $value) {
			if ($value == '0') {
				$data[$key] = '';
			}
		}

		return $data;
	}

	public function getTemplateName($action, $eventTypeId)
	{
		$template = 'eventTypeTemplates' . DIRECTORY_SEPARATOR . $action . DIRECTORY_SEPARATOR . $eventTypeId;

		if (!file_exists(Yii::app()->basePath . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'clinical' . DIRECTORY_SEPARATOR . $template . '.php')) {
			$template = $action;
		}

		return $template;
	}

	public function actionSetEpisodeStatus($id) {
		$episode = Episode::model()->findByPk($id);

		if (!isset($episode)) {
			throw new CHttpException(403, 'Invalid episode id.');
		}

		$episode->episode_status_id = $_POST['episode_status_id'];
		$episode->save();
	}

	/**
	 * Get all the elements for a the current module's event type
	 *
	 * @param $event_type_id
	 * @return array
	 */
	public function getDefaultElements($action, $event_type_id=false, $event=false) {
		$etc = new BaseEventTypeController(1);
		$etc->event = $event;
		return $etc->getDefaultElements($action, $event_type_id);
	}

	/**
	 * Get the optional elements for the current module's event type
	 * This will be overriden by the module
	 *
	 * @param $event_type_id
	 * @return array
	 */
	public function getOptionalElements($action, $event=false) {
		return array();
	}
}

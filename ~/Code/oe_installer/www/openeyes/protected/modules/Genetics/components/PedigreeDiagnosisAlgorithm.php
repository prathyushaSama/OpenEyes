<?php
/**
 * OpenEyes
 *
 * (C) Moorfields Eye Hospital NHS Foundation Trust, 2008-2011
 * (C) OpenEyes Foundation, 2011-2013
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package OpenEyes
 * @link http://www.openeyes.org.uk
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (c) 2008-2011, Moorfields Eye Hospital NHS Foundation Trust
 * @copyright Copyright (c) 2011-2013, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/gpl-3.0.html The GNU General Public License V3.0
 */

/**
 * Class PedigreeDiagnosisAlgorithm
 */
class PedigreeDiagnosisAlgorithm
{

	public function calculatePedigreeDiagnosisByPatient(Patient $patient)
	{
		if ($pedigree = $this->findPedigreeByPatient($patient)) {
			return $this->mostCommonDiagnosis($pedigree->$members);
		}
	}

	private function findPedigreeByPatient(Patient $patient)
	{
		if($patient_pedigree = PatientPedigree::model()->find('patient_id=?',array($patient->id))) {
			$pedigree = $patient_pedigree->pedigree;
			return $pedigree;
		}
		return false;
	}
	
	private function mostCommonDiagnosis($pedigree_members)
	{
		$diagnoses_count = $this->countDiagnoses($pedigree_members);
		$most_common = array_keys($diagnoses_count, max($diagnoses_count)); //maybe equal first
		return $most_common[0]; //slice off top result if joint first
	}

	private function countDiagnoses($pedigree_members)
	{
		$table_results = array();
		foreach ($pedigree_members as $member){
			$member_diagnoses = $member->patient->systemicDiagnoses;
			foreach($member_diagnoses as $diagnosis){
				$diagnosis_disorder_id = $diagnosis->disorder_id;
				if(array_key_exists($diagnosis_disorder_id, $table_results)) {
					$table_results[$diagnosis_disorder_id]  += 1;
				}
				else {
					$table_results[$diagnosis_disorder_id] = 1;
				}
			}
		}
		return $table_results;
	}
}
<?php

namespace App\Controller\Helpers;

class CheckHelper
{
	public function validatePassword(string $password)
	{
		if (!isset($password)) {
			$errors = 'Champs obligatoir';
		} elseif (preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/", $password) == 0) {
			$errors = 'Au moins 8 caractaire, 1 Maj, 1 min et 1 chiffre';
		} else {
			$errors = false;
		}
		return $errors;
	}

	public function validate(\stdClass $content, string $var)
	{
		if (isset($content->$var) && !empty(trim($content->$var))) {
			return true;
		}
		return false;
	}

	public function validateBoolean(\stdClass $content, string $var)
	{
		if (isset($content->$var)) {
			if (is_bool($content->$var)) {
				return true;
			}
		}
		return false;
	}

	public function validateDate($var)
	{
		try {
			$date = new \DateTime($var);
			$year = $date->format('Y');
			$month = $date->format('n');
			$day = $date->format('d');

			// verifie si la date est valide				
			if (checkdate($month, $day, $year)) {
				return true;
			}
		} catch (\Throwable $th) {
			return false;
		}
		return false;
	}

	public function validateDateIntervale($var, $min)
	{
		try {
			if ($this->validateDate($var)) {
				$date = new \DateTime($var);
				$dateMin = new \DateTime($min);
				if ($date < $dateMin) {
					return true;
				}
			}
		} catch (\Throwable $th) {
			return false;
		}
		return false;
	}

	public function validateOrm($validator, $errors = null)
	{
		$context = [];
		if ($validator->count() > 0) {
			foreach ($validator->getIterator() as $val) {
				$context[] = [
					'path' => $val->getPropertyPath(),
					'message' => $val->getMessage()
				];
			}
			if ($errors) {
				return array_merge($errors, $context);
			}
			return $context;
		}

		if ($errors) {
			return $errors;
		}

		return false;
	}
}

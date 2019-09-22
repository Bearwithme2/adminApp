<?php declare(strict_types=1);

namespace App\Services;

class JsonConverter
{

	public function convertRequestToArray($data): array
	{
		$e = explode('&', $data);
		$a = [];
		foreach ($e as $item) {
			$b = explode('=', $item);
			if (array_key_exists(1, $b)) {
				$a[$b[0]] = $b[1];
			}
		}

		return $a;
	}

}
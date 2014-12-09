<?php
namespace CIC\Cicbase\Domain\Repository;

class EmailTemplateRepository extends AbstractRepository {

	/**
	 * @param array $keys
	 */
	public function filterOutExistingTemplateKeys(array &$keys) {
		$allQR = $this->findAll();
		$existingKeys = $this->rowsFromQueryResult($allQR, NULL, 'template_key');
		foreach ($existingKeys as $existingKey) {
			$parts = explode('.', $existingKey);
			$ext = $parts[0];
			$templateKey = $parts[1];
			if (isset($keys[$ext])) {
				$k = array_search($templateKey, $keys[$ext]);
				if ($k !== FALSE) {
					unset($keys[$ext][$k]);
				}
			}
		}
	}

	/**
	 * @param string $key
	 * @return object
	 */
	public function findOneByTemplateKey($key) {
		return $this->query(function ($q) use ($key) {
			$q->equals('templateKey', $key);
			$q->equals('isDraft', FALSE);
		})->getFirst();
	}
}
?>
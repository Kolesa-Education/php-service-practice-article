<?php

namespace App\Model\Validators;

class AdvertValidator implements ValidatorInterface
{
    private const NOT_EMPTY_FIELDS = ['title', 'description'];
    private const MIN_TITLE_LENGTH = 10;
    private const MAX_TITLE_LENGTH = 80;
    private const MIN_PRICE = 0;
    private const MAX_PRICE = 100000;

    public function validate(array $data): array
    {
        $errors = $this->validateNotEmpty($data);

        if (!empty($errors)) {
            return $errors;
        }

        return array_merge(
            $this->validateLength($data),
            $this->validatePrice($data)
        );
    }

    private function validateNotEmpty(array $data): array
    {
        $errors = [];

        foreach (self::NOT_EMPTY_FIELDS as $fieldName) {
            $value = $data[$fieldName] ?? null;

            if (empty($value)) {
                $errors[$fieldName] = 'Поле "' . $fieldName . '" не должно быть пустым';
            }
        }

        return $errors;
    }

    private function validateLength(array $data): array
    {
        $titleLength = mb_strlen($data['title']);

        if ($titleLength < self::MIN_TITLE_LENGTH) {
            return [
                'title' => 'Заголовок не может быть меньше ' . self::MIN_TITLE_LENGTH . ' символов'
            ];
        }

        if ($titleLength > self::MAX_TITLE_LENGTH) {
            return [
                'title' => 'Заголовок не может быть больше ' . self::MAX_TITLE_LENGTH . ' символов'
            ];
        }

        return [];
    }

    private function validatePrice(array $data): array
    {
        $price = $data['price'] ?? 0;

        if ($price < self::MIN_PRICE) {
            return [
                'price' => 'Цена не может быть меньше ' . self::MIN_PRICE,
            ];
        }

        if ($price > self::MAX_PRICE) {
            return [
                'price' => 'Цена не может быть больше ' . self::MAX_PRICE,
            ];
        }

        return [];
    }
}

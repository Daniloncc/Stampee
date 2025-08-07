<?php

namespace App\Providers;

class Validator
{

    private $errors = array();
    private $key;
    private $value;
    private $name;

    public function field($key, $value, $name = null)
    {
        $this->key = $key;
        $this->value = $value;
        if ($name == null) {
            $this->name = ucfirst($key);
        } else {
            $this->name = ucfirst($name);
        }
        return $this;
    }

    public function required()
    {
        if (empty($this->value)) {
            $this->errors[$this->key] = "$this->name est necessaire!";
        }
        return $this;
    }

    public function onlyLetters()
    {
        if (!preg_match('/^[a-zA-ZÀ-ÿ\s\-]+$/u', $this->value)) {
            $this->errors[$this->key] = "$this->name doit contenir uniquement des lettres.";
        }
        return $this;
    }

    public function max($length)
    {
        if (strlen($this->value) > $length) {
            $this->errors[$this->key] = "$this->name accepte un max de $length caractères";
        }
        return $this;
    }

    public function min($length)
    {
        if (strlen($this->value) < $length) {
            $this->errors[$this->key] = "$this->name accepte un min de $length caractères";
        }
        return $this;
    }

    public function number()
    {
        if (!empty($this->value) && !is_numeric($this->value)) {
            $this->errors[$this->key] = "$this->name accepte juste des chiffres!";
        }
        return $this;
    }

    public function email()
    {
        if (!empty($this->value) && !filter_var($this->value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$this->key] = "Le format $this->name est invalide.";
        }
        return $this;
    }

    public function unique($model)
    {
        $model = 'App\\Models\\' . $model;
        $model = new $model;
        $unique = $model->unique($this->key, $this->value);
        if ($unique) {
            $this->errors[$this->key] = "$this->name must be unique.";
        }
        return $this;
    }

    public function onlyLettersAndNumbers()
    {
        if (!preg_match('/^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z0-9]{3,8}$/', $this->value)) {
            $this->errors[$this->key] = "$this->name doit contenir entre 3 et 8 caractères, avec au moins une lettre et un chiffre, sans caractères spéciaux.";
        }
        return $this;
    }

    public function isSuccess()
    {
        if (empty($this->errors)) return true;
    }

    public function getErrors()
    {
        if (!$this->isSuccess()) return $this->errors;
    }
}

<?php
namespace App\Utils;

class FormValidator {

    private $value;
    private $error;

    public function value($value): self {
        $this->value = $value;
        return $this;
    }

    public function name($name): self {
        $this->name = $name;
        return $this;
    }

    public function required(): bool {
        /**
         * Si c'est vide tu me retourne une erreur
         * Si il y a des espaces tu retire les espace
         */
        if(empty(trim($this->value))) {
            $this->error[$this->name] = "Champs obligatoire.";
        }
        return true;
    }

    public function isEmail(): self {
        /**
         * Vérifie si c'est un e-mail : bernard@durand.com
         */
        if(!filter_var($this->value, FILTER_VALIDATE_EMAIL)) {
            $this->error[$this->name] = "E-mail invalide";
        }
        return $this;
    }

    public function isInt(): self {
        /**
         * Si la valeur c'est bien un nombre entier
         */
        if(!filter_var($this->value, FILTER_VALIDATE_INT)) {
            return false;
        }
        return $this;
    }
    /**
     * Je vérifie si la taille de la chaine de caractère et les unicodes envoyer par l'utilisateur
     * est supérieur à la taille par défaut
     * J'affiche une erreur
     */
    public function maxLength($length): self {
        if(mb_strlen($this->value) > $length) {
            $this->error[$this->name] = $this->name . " est trop grand : max " . $length . " caractères"; 
        }
        return $this;
    }

    /**
     * Je vérifie si la taille de la chaine de caractère et les unicodes envoyer par l'utilisateur 
     * est inférieur à la taille par défaut
     * J'affiche une erreur
     */
    public function minLength($length): self {
        if(mb_strlen($this->value) < $length) {
            $this->error[$this->name] = $this->name . " est trop petit : min " . $length . " caractères"; 
        }
        return $this;
    }

    /**
     * Je vérifie si la valeur du champs entrer par l'utilisateur est bien un entier sinon renvoie erreur
     * Je vérifie si la valeur  du champs entrer par l'utilisateur est inférieur à la valeur mise par défaut
     * Sinon erreur
     */
    public function min($val): self {
        if(!$this->isInt()) {
            $this->error[$this->name] = "Il faut mettre un nombre";
        } else {
            if($this->value < $val) {
                $this->error[$this->name] = 'La valeur minimum doit être ' . $val;
            }
        }
        return $this;
    }

    /**
     * Je vérifie si la valeur du champs entrer par l'utilisateur est bien un entier sinon renvoie erreur
     * Je vérifie si la valeur  du champs entrer par l'utilisateur est supérieur à la valeur mise par défaut
     * Sinon erreur
     */
    public function max($val): self {
        if(!$this->isInt()) {
            $this->error[$this->name] = "Il faut mettre un nombre";
        } else {
            if($this->value > $val) {
                $this->error[$this->name] = "La valeur maximum doit être " . $val;
            }
        }
        return $this;
    }

    /**
     * Elle prend en paramètre la valeur à vérifier
     * Ensuite on vérifie si la valeur du champs entrer par l'utilisateur est différent de la valeur entrée dans le second champs
     * On affiche erreur si different
     */
    public function equal($value): self {
        if($this->value !== $value) {
            $this->error[$this->name] = $this->value . " est différent de " . $value;
        }
        return $this;
    }
    

    public function getError() {
        /**
         * Je check si le tableau n'est pas vide tu retourne les erreur
         * Sinon tu retourne que tout va bien
         */
        if(!empty($this->error)) {
            return $this->error;
        }
        return true;
    }
}
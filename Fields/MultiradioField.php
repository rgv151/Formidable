<?php

namespace Gregwar\DSD\Fields;

/**
 * Radios
 *
 * @author Grégoire Passault <g.passault@gmail.com>
 */
class MultiradioField extends Field
{
    /**
     * Nom de la source
     */
    private $source;

    /**
     * Radios
     */
    private $radios = array();

    /**
     * Labels des radios
     */
    private $labels = array();

    /**
     * Sauve du push
     */
    private $pushSave = array();

    public function check()
    {
        if (!$this->optional && !$this->value)
            return 'Vous devez cochez une des cases pour '.$this->printName();
    }

    public function push($var, $value)
    {
        switch ($var) {
        case 'type':
            break;
        case 'source':
            $this->source = $value;
            break;
        default:
            $this->pushSave[$var] = $value;
            parent::push($var, $value);
            break;
        }
    }

    public function getSource()
    {
        return $this->source;
    }

    public function source($datas)
    {
        foreach ($datas as $key => $label) {
            $this->radios[] = $radio = new RadioField;
            $radio->push('name', $this->getName());
            $radio->setValue($key);

            foreach ($this->pushSave as $var => $val) {
                $radio->push($var, $val);
            }
            $this->labels[$key] = $label;
        }
    }

    public function setValue($value)
    {
        $set = false;

        foreach ($this->radios as $radio) {
            if ($radio->getValue() == $value) {
                $radio->setChecked(true);
                $set = true;
            } else {
                $radio->setChecked(false);
            }
        }

        parent::setValue($set ? $value : null);
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getHTML()
    {
        $html = '';

        if ($this->radios) {
            foreach ($this->radios as $radio) {
                $html.= '<div class="'.$this->getAttribute('class').'">';
                $html.= '<label>';
                $html.= $radio->getHTML();
                $html.= $this->labels[$radio->getValue()];
                $html.= '</label>';
                $html.= '</div>';
            }
        }

        return $html;
    }
}

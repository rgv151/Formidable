<?php

use Gregwar\Formidable\FormContext;

/**
 * Tests du context de formulaires Formidable
 *
 * @author Grégoire Passault <g.passault@gmail.com>
 */
class FormContextTests extends \PHPUnit_Framework_TestCase
{
    /**
     * Test de création de formulaire à l'aide du context
     */
    public function testContextCreation()
    {
        $context = new FormContext;
        $form = $context->getForm(__DIR__.'/files/context/form.html');

        $html = "$form";
        $this->assertContains('test', $html);
        $this->assertEquals('Hello', $form->test);
    }

    /**
     * Test d'enregistrement d'un type personnalisé
     */
    public function testContextCustomType()
    {
        $context = new FormContext;
        $context->registerType('testing', '\Gregwar\Formidable\Fields\TextField');

        $form = $context->getForm(__DIR__.'/files/context/testing.html');
        $html = "$form";
        $this->assertContains('text', $html);
        $this->assertEquals('Hello', $form->test);
    }
}

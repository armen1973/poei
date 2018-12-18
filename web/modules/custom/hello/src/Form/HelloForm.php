<?php

namespace Drupal\hello\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\CssCommand;
use Drupal\Core\Ajax\HtmlCommand;

class HelloForm extends FormBase {

    /**
     *{@inheritdoc}
     */
    public function getFormId()
    {
        return 'Hello_Form';
    }

    /**
     *{@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        if(isset($form_state->getRebuildInfo()['messageresult'])) {
        $messageresult = $form_state->getRebuildInfo()['messageresult'];

            $form['messageresult'] = [
                '#markup' =>$this->t('Resultat Calcul : %messageresult',
                    ['%messageresult' => $messageresult]),
            ];
        }



        $form['valeur1'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('First value '),
            '#required' => "TRUE",
            '#ajax' => array(
            'callback' => array($this, 'validateTextAjax'),
            'event' => 'change',
            ),
            '#suffix' => '<span id="text-message-valeur1"></span>',
        );
        $form['active'] = array(
            '#type' => 'radios',
            '#title' => $this
                ->t('Operation'),
            '#default_value' => 0,
            '#options' => array(
                '+' => $this
                    ->t('Ajouter'),
                '-' => $this
                    ->t('Soustract'),
                '*' => $this
                    ->t('Multiply'),
                '/' => $this
                    ->t('Divide'),
            ),
        );

        $form['valeur2'] = array(
            '#type' => 'textfield',
            '#title' => $this
                ->t('Second value '),
            '#required' => "TRUE",
            '#ajax' => array(
                'callback' => array($this, 'validateTextAjax'),
                'event' => 'change',
            ),
            '#suffix' => '<span id="text-message-valeur"></span>',
        );

        $form['submit'] = array(
            '#type' => 'submit',
            '#value' => $this
                ->t('Calculate'),
        );

        return $form;
    }

    /**
     *{@inheritdoc}
     */

    public function validateForm(array &$form, FormStateInterface $form_state)
    {

        $value_1 = $form_state->getValue('valeur1');
        if(!is_numeric($value_1)) {
            $form_state->setErrorByName('valeur1', $this->t('Value 1 must be numeric!'));
        }
        $value_2 = $form_state->getValue('valeur2');

        if(!is_numeric($value_2)) {
            $form_state->setErrorByName('valeur2', $this->t('value must be different 0!'));
        }

        if(isset($form['messageresult'])) {
            unset($form['messageresult']);
        }
    }

    public function ValidateTextAjax(array &$form, FormStateInterface $form_state) {
        $response = new AjaxResponse();

        $field = $form_state->getTriggeringElement()['#name'];

        $value_1_ajax = $form_state->getValue('valeur1');
        if(!is_numeric($value_1_ajax)) {

            $css = ['border' => '2px solid red', 'color' => 'red'];
            $message = 'Value 1 must be numeric!' . $form_state->getValue('valeur1');

        } else {
            $css = ['border' => '2px solid green', 'color' => 'green', 'background' => 'rgba(25, 188, 0,0.2)'];
            $message = 'Ok' . $form_state->getValue('valeur1');
        }

        if(!is_numeric($value_1))

        $response->addCommand(new CssCommand('#edit-valeur1', $css));
        $response->addCommand(new HtmlCommand('#text-message-' . $field, $message)) ;

        return $response;
    }

    public function submitForm(array &$form, FormStateInterface $form_state)
    {


        $active = $form_state->getValue('active');
        $valeur1 = $form_state->getValue('valeur1');
        $valeur2 = $form_state->getValue('valeur2');

        if( $active == '+') {
            $result = $valeur1 + $valeur2;
        } elseif ($active == '-') {
            $result = $valeur1 - $valeur2;
        } elseif ($active == '*') {
            $result = $valeur1 * $valeur2;
        } elseif($active == '/') {
            $result = $valeur1 / $valeur2;
        }

        //drupal_set_message('coucou' . $result);

        $create_statesoumission = \Drupal::state()->set('Hello', REQUEST_TIME );

        $form_state->setRebuild()->addRebuildInfo('messageresult', $result);

    }
}

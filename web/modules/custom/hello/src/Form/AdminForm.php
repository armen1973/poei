<?php

namespace Drupal\hello\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\CssCommand;
use Drupal\Core\Ajax\HtmlCommand;

class AdminForm extends ConfigFormBase {

    /**
     *{@inheritdoc}
     */
    public function getFormId()
    {
        return 'Admin_Form';
    }

    protected function getEditableConfigNames()
    {
        return ['hello.settings'];
    }

    /**
     *{@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $form['example_select'] = [
            '#type' => 'select',
            '#title' => $this
                ->t('Select element'),
            '#default_value' => $this->config('hello.settings')->get('purge_days_number'),
            '#options' => [
                '0' => $this->t('0'),
                '1' => $this->t('1 Days'),
                '2' => $this->t('2 Days'),
                '7' => $this->t('7 Days'),
                '14' => $this->t('14 Days'),
                '30' => $this->t('30 Days'),
            ],
        ];

        return parent:: buildForm($form, $form_state);

        return $form;

    }

    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $value = $this->config('hello.settings')->set('purge_days_number', $form_state->getValue('example_select'))->save();

        return parent::submitForm($form, $form_state);
    }
}

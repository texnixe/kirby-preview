<?php
class PreviewField extends BaseField {

  static public $fieldname = 'preview';
  static public $assets = array(
    'js' => array(
      'script.js'
    )
  );

  public function __construct() {
    $this->type = 'preview';
    //$this->label = l::get('fields.map.label', 'Add Location');
    $this->options = array();
    //$this->placeholder = $this->options['placeholder'];

  }
  public function input() {

    $select = new Brick('select');
    $select->addClass('selectbox selectbox-preview');
    $select->attr(array(
      'name'         => $this->name(),
      'id'           => $this->id(),
      'required'     => $this->required(),
      'autocomplete' => $this->autocomplete(),
      'autofocus'    => $this->autofocus(),
      'readonly'     => $this->readonly(),
      'disabled'     => $this->disabled(),
      //'placeholder'  => $this->i18n($this->placeholder()),
    ));

    $default = $this->default();

    if(!$this->required()) {
      $select->append($this->option('', '', $this->value() == ''));
    }

    if($this->readonly()) {
      $select->attr('tabindex', '-1');
    }

    foreach($this->options() as $value => $text) {
      $select->append($this->option($value, $text, $this->value() == $value));
    }

    $inner = new Brick('div');
    $inner->addClass('selectbox-wrapper');
    $inner->append($select);

    $wrapper = new Brick('div');
    $wrapper->addClass('input input-with-selectbox');
    $wrapper->append($inner);
    $wrapper->attr('data-field', 'preview');

    if($this->readonly()) {
      $wrapper->addClass('input-is-readonly');
    } else {
      $wrapper->attr('data-focus', 'true');
    }

    return $wrapper;

  }


  public function options() {
    return FieldOptions::build($this);
  }

  public function option($value, $text, $selected = false) {
    return new Brick('option', $this->i18n($text), array(
      'value'    => $value,
      'selected' => $selected
    ));
  }

  public function result() {
    return null;
  }



  public function routes() {
    return array(
      array(
        'pattern' => 'previewer',
        'method' => 'POST',
        'action'  => function() {

          // get post data
          $data = kirby()->request()->data();
          $html = '';

          // find the page
          $page = panel()->site()->page($data['page']);

          // get the format extension for dedicated template
          $format = c::get('preview.output.format')? '.' . c::get('preview.output.format'): '';

          $file = kirby()->roots()->templates() . DS . $page->template() . $format . '.php';

          if(file_exists($file)) {
            $templateFile = $file;
          } else {
            $templateFile = $page->templatefile();
          }
          // create a new preview instance
          $preview = new Preview(kirby());

          // render content
  				$html .= $preview->render($templateFile, array(), $page);

  				return json_encode(array(
            'html' => $html,
          ));
  			}
      )
    );
  }

}

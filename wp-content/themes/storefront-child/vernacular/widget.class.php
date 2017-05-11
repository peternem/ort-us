<?php
class VernacularWidget extends WP_Widget {
  public $id, $title;
  public $height = 400;
  public $width = 300;
  public $description = '-';

  public $form_instance;

  public function setup(){
    $widget_ops = array( 'classname' => $this->id, 'description' => $this->description );
    $control_ops = array( 'width' => $this->width, 'height' => $this->height, 'id_base' => $this->id );
    $this->WP_Widget( $this->id, $this->title, $widget_ops, $control_ops );
  }

  public function render_template($args, $instance, $template){
    extract($args);
    extract($instance);

    require(get_stylesheet_directory()."/widgets/$template");
  }

  public function update( $data, $instance ){
    foreach($data as $key => $value){
      $instance[$key] = $data[$key];
    }

    return $instance;
  }

  public function setup_form($instance){
    $this->form_instance = wp_parse_args( (array) $instance, $defaults );
  }

  private function option($value, $label, $selected_value){
    $selected = false;

    if(is_array($selected_value)){
      if(in_array($value, $selected_value)){
        $selected = true;
      }
    } else {
      if($selected_value == $value){
        $selected = true;
      }
    }
  ?>
    <option value="<?= $value; ?>" <?= $selected ? ' selected' : ''; ?>>
      <?= $label; ?>
    </option>
 <?php }

  private function value($value, $default){
    if($value == ''){
      return $default;
    } else {
      return $value;
    }
  }

  private function label($id, $title){ ?>
    <label for="<?= $this->get_field_id( $id ); ?>"><?= $title ?></label>
 <?php }

  private function field_meta($id, $class = '', $style = ''){ ?>
    id="<?= $this->get_field_id( $id ); ?>" name="<?= $this->get_field_name( $id ); ?>" class="<?= $class; ?>" style="<?= $style; ?>"
<?php }

  public function textfield($id, $title, $default = ''){ ?>
    <p>
      <?= $this->label($id, $title); ?>
      <input <?= $this->field_meta($id, 'widefat'); ?> value="<?= $this->value($this->form_instance[$id], $default); ?>" type="text"/>
    </p>
<?php }

  public function textarea($id, $title, $default = ''){ ?>
    <p>
      <?= $this->label($id, $title); ?>
      <textarea <?= $this->field_meta($id, 'widefat', 'height:5em;'); ?>><?= $this->value($this->form_instance[$id], $default); ?></textarea>
    </p>
<?php }

  public function dropdown($id, $title, $options){ ?>
    <p>
      <?= $this->label($id, $title); ?><br>
      <select <?= $this->field_meta($id); ?>>
        <? foreach ($options as $value => $label): ?>
          <? $this->option($value, $label, $this->form_instance[$id]); ?>
        <? endforeach; ?>
      </select>
    </p>
<?php }

  public function category($id = "category", $title = "Category"){ ?>
    <p>
      <?= $this->label($id, $title); ?><br>
      <?php wp_dropdown_categories(array(
        'id' => $this->get_field_id($id),
        'name' => $this->get_field_name( $id ),
        'selected' => $this->form_instance[$id],
        'hide_empty' => false,
        'show_count' => true,
        'hierarchical' => true,
        'show_option_all' => 'All Categories'
      )); ?>
    </p>
<?php }

  public function tag($id = "tag", $title = "Tag"){ ?>
    <p>
      <?= $this->label($id, $title); ?><br>
      <select <?= $this->field_meta($id, $style = 'max-width: 98%;'); ?>>
        <option value="">&mdash;</option>
        <?php $tags = get_tags(); ?>
        <?php foreach ($tags as $tag): ?>
        <?php $this->option($tag->slug, $tag->name, $this->form_instance[$id]); ?>
        <?php endforeach; ?>
      </select>
    </p>
  <?php }

  public function tags($id = "tags", $title = "Tags"){ ?>
    <p>
      <?= $this->label($id, $title); ?><br>
      <select id="<?= $this->get_field_id( $id ); ?>" name="<?= $this->get_field_name( $id ); ?>[]" style="max-width: 98%;" multiple>
        <?php $tags = get_tags(); ?>
        <?php foreach ($tags as $tag): ?>
            <?php $this->option($tag->slug, $tag->name, $this->form_instance[$id]); ?>
        <?php endforeach; ?>
      </select>
    </p>
  <?php }
}

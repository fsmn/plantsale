# Coding Standards
The styles for this site are based on [Drupal's coding standards](https://www.drupal.org/docs/develop/standards/coding-standards)

## Quotes
Single quotes should be used to define text strings in PHP. Concatentations should be done using "." such as `base_url('/order/view/. $order_id);` instead of `base_url("order/view/$order_id");` 

Double quotes should be used for any html tag attributes such as class="button edit dialog" and in all Javascript such as `jQuery(document).on("click",".edit.dialog",function(e){...`

Double quotes may be used in complex query strings, however, whenever possible use the [CodeIgniter query builder system](https://codeigniter.com/userguide3/database/queries.html) and try to use PHP to manipulate data to achieve the same results before relying on a free-form query that bypasses the CodeIgniter query builder. 

## Arrays
While using `array()` is the most backward-compatible solution, for this project, we use the PHP7.4 `[]` preferred array definition. Arrays should be multi-line unless there is only one key/value pair. The last value in an array should always be followed by a comma. So an array that would appear like this in code 
<pre>$buttons[] = array('title' => 'My Title', 'href' => base_url('order/view' . $order_id), 'class' => array('button','edit','dialog'));</pre>

Should instead look like this:
<pre>$buttons[] = [
  'title' => 'My Title', 
  'href' => base_url('order/view' . $order_id), 
  'class' => [
    'button',
    'edit',
    'dialog',
    ]
  ,];</pre>
  
## Control Structures
See the [Drupal coding standards section on control structures](https://www.drupal.org/docs/develop/standards/coding-standards#controlstruct)

Note the [different rules for control statements inside of views](https://www.drupal.org/docs/develop/standards/coding-standards#s-alternate-control-statement-syntax-for-templates).

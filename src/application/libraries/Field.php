<?

class Field
{

    function __construct ()
    {
        $CI = & get_instance();
        $CI->load->model("field_model", "field");
    }

    public function get ($field, $table)
    {
        $result = $this->field->get($field_name, $table);
        return $result;
    }
}
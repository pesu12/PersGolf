<?php

namespace Anax\HTMLForm;

/**
 * A utility class to easy creating and handling of forms
 *
 * @package CForm
 */
class CFormElement implements \ArrayAccess
{

    /**
     * Properties
     */
    public $attributes;
    public $characterEncoding;



    /**
     * Constructor creating a form element.
     *
     * @param string $name       of the element.
     * @param array  $attributes to set to the element. Default is an empty array.
     */
    public function __construct($name, $attributes = [])
    {
        $this->attributes = $attributes;
        $this['name'] = $name;
        //$this['key'] = $name;
        //$this['name'] = isset($this['name']) ? $this['name'] : $name;

        // Use character encoding from lydia if available, else use UTF-8 OBSOLETE, remove this.
        if (is_callable('CLydia::Instance()')) {
            $this->characterEncoding = CLydia::Instance()->config['character_encoding'];
        } else {
            $this->characterEncoding = 'UTF-8';
        }
    }



    /**
     * Implementing ArrayAccess for this->attributes
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->attributes[] = $value;
        } else {
            $this->attributes[$offset] = $value;
        }
    }



    /**
     * Implementing ArrayAccess for this->attributes
     */
    public function offsetExists($offset)
    {
        return isset($this->attributes[$offset]);
    }



    /**
     * Implementing ArrayAccess for this->attributes
     */
    public function offsetUnset($offset)
    {
        unset($this->attributes[$offset]);
    }



    /**
     * Implementing ArrayAccess for this->attributes
     */
    public function offsetGet($offset)
    {
        return isset($this->attributes[$offset]) ? $this->attributes[$offset] : null;
    }



    /**
     * Create a formelement from an array, factory returns the correct
     * instance.
     *
     * @param string $name       name of the element.
     * @param array  $attributes to use when creating the element.
     *
     * @return the instance of the form element.
     */
    public static function create($name, $attributes)
    {

        // Not supported is type=image, <button>, list, output, select-optgroup
        $types = [

            // Standard HTML 4.01
            'text'              => '\Anax\HTMLForm\CFormElementText',
            'file'              => '\Anax\HTMLForm\CFormElementFile',
            'password'          => '\Anax\HTMLForm\CFormElementPassword',
            'hidden'            => '\Anax\HTMLForm\CFormElementHidden',
            'textarea'          => '\Anax\HTMLForm\CFormElementTextarea',
            'radio'             => '\Anax\HTMLForm\CFormElementRadio',
            'checkbox'          => '\Anax\HTMLForm\CFormElementCheckbox',
            'select'            => '\Anax\HTMLForm\CFormElementSelect',
            'select-multiple'   => '\Anax\HTMLForm\CFormElementSelectMultiple',
            'submit'            => '\Anax\HTMLForm\CFormElementSubmit',
            'reset'             => '\Anax\HTMLForm\CFormElementReset',
            'button'            => '\Anax\HTMLForm\CFormElementButton',

            // HTML5
            'color'             => '\Anax\HTMLForm\CFormElementColor',
            'date'              => '\Anax\HTMLForm\CFormElementDate',
            'number'            => '\Anax\HTMLForm\CFormElementNumber',
            'range'             => '\Anax\HTMLForm\CFormElementRange',
            'tel'               => '\Anax\HTMLForm\CFormElementTel',
            'email'             => '\Anax\HTMLForm\CFormElementEmail',
            'url'               => '\Anax\HTMLForm\CFormElementUrl',
            'search'            => '\Anax\HTMLForm\CFormElementSearch',
            'file-multiple'     => '\Anax\HTMLForm\CFormElementFileMultiple',
            'datetime'          => '\Anax\HTMLForm\CFormElementDatetime',
            'datetime-local'    => '\Anax\HTMLForm\CFormElementDatetimeLocal',
            'month'             => '\Anax\HTMLForm\CFormElementMonth',
            'time'              => '\Anax\HTMLForm\CFormElementTime',
            'week'              => '\Anax\HTMLForm\CFormElementWeek',

            // Custom
            'search-widget'     => '\Anax\HTMLForm\CFormElementSearchWidget',
            'checkbox-multiple' => '\Anax\HTMLForm\CFormElementCheckboxMultiple',
            // Address
        ];

        // $attributes['type'] must contain a valid type creating an object to succeed.
        $type = isset($attributes['type']) ? $attributes['type'] : null;

        if ($type && isset($types[$type])) {
            return new $types[$type]($name, $attributes);
        } else {
            throw new \Exception("Form element does not exists and can not be created: $name - $type");
        }
    }



    /**
     * Get id of an element.
     *
     * @return HTML code for the element.
     */
    public function getElementId()
    {
        return ($this['id'] = isset($this['id']) ? $this['id'] : 'form-element-' . $this['name']);
    }



    /**
     * Get alll validation messages.
     *
     * @return HTML code for the element.
     */
    public function getValidationMessages()
    {
        $messages = null;
        if (isset($this['validation-messages'])) {

            $message = null;
            foreach ($this['validation-messages'] as $val) {
                $message .= "<li>{$val}</li>\n";
            }
            $messages = "<ul class='validation-message'>\n{$message}</ul>\n";
        }
        return $messages;
    }



    /**
     * Get details for a HTML element, prepare for creating HTML code for it.
     *
     * @return HTML code for the element.
     */
    public function getHTMLDetails()
    {
        // Add disabled to be able to disable a form element
        // Add maxlength
        $id =  $this->GetElementId();

        $class = isset($this['class'])
            ? "{$this['class']}"
            : null;

        $validates = (isset($this['validation-pass']) && $this['validation-pass'] === false)
            ? ' validation-failed'
            : null;

        $class = (isset($class) || isset($validates))
            ? " class='{$class}{$validates}'"
            : null;

        $name = " name='{$this['name']}'";

        $label = isset($this['label'])
            ? ($this['label'] . (isset($this['required']) && $this['required']
                ? "<span class='form-element-required'>*</span>"
                : null))
            : null;

        $autofocus = isset($this['autofocus']) && $this['autofocus']
            ? " autofocus='autofocus'"
            : null;

        $required = isset($this['required']) && $this['required']
            ? " required='required'"
            : null;

        $readonly = isset($this['readonly']) && $this['readonly']
            ? " readonly='readonly'"
            : null;

        $placeholder = isset($this['placeholder']) && $this['placeholder']
            ? " placeholder='{$this['placeholder']}'"
            : null;

        $multiple = isset($this['multiple']) && $this['multiple']
            ? " multiple"
            : null;

        $max = isset($this['max'])
            ? " max='{$this['max']}'"
            : null;

        $min = isset($this['min'])
            ? " min='{$this['min']}'"
            : null;

        $low = isset($this['low'])
            ? " low='{$this['low']}'"
            : null;

        $high = isset($this['high'])
            ? " high='{$this['high']}'"
            : null;

        $optimum = isset($this['optimum'])
            ? " optimum='{$this['optimum']}'"
            : null;

        $step = isset($this['step'])
            ? " step='{$this['step']}'"
            : null;

        $size = isset($this['size'])
            ? " size='{$this['size']}'"
            : null;

        $text = isset($this['text'])
            ? htmlentities($this['text'], ENT_QUOTES, $this->characterEncoding)
            : null;

        $checked = isset($this['checked']) && $this['checked']
            ? " checked='checked'"
            : null;

        $type = isset($this['type'])
            ? " type='{$this['type']}'"
            : null;

        $title = isset($this['title'])
            ? " title='{$this['title']}'"
            : null;

        $pattern = isset($this['pattern'])
            ? " pattern='{$this['pattern']}'"
            : null;

        $description = isset($this['description'])
            ? $this['description']
            : null;

        $onlyValue = isset($this['value'])
            ? htmlentities($this['value'], ENT_QUOTES, $this->characterEncoding)
            : null;

        $value = isset($this['value'])
            ? " value='{$onlyValue}'"
            : null;

        $messages = $this->getValidationMessages();

        return [
            'id'            => $id,
            'class'         => $class,
            'name'          => $name,
            'label'         => $label,
            'autofocus'     => $autofocus,
            'required'      => $required,
            'readonly'      => $readonly,
            'placeholder'   => $placeholder,
            'multiple'      => $multiple,
            'min'           => $min,
            'max'           => $max,
            'low'           => $low,
            'high'          => $high,
            'step'          => $step,
            'optimum'       => $optimum,
            'size'          => $size,
            'text'          => $text,
            'checked'       => $checked,
            'type'          => $type,
            'title'         => $title,
            'pattern'       => $pattern,
            'description'   => $description,
            'onlyValue'     => $onlyValue,
            'value'         => $value,
            'messages'      => $messages,
        ];
    }



    /**
     * Get HTML code for a element.
     *
     * @return HTML code for the element.
     */
    public function getHTML()
    {
        $details = $this->getHTMLDetails();
        extract($details);

        // Create HTML for the element
        if (in_array($this['type'], ['submit', 'reset', 'button'])) {

            // type=submit || reset || button
            return <<<EOD
<span>
<input id='$id'{$type}{$class}{$name}{$value}{$autofocus}{$readonly}{$title} />
</span>
EOD;

        } elseif ($this['type'] == 'search-widget') {

            // custom search-widget with type=search and type=submit
            $label = isset($this['label']) ? " value='{$this['label']}'" : null;
            $classSubmit = isset($this['class-submit']) ? " class='{$this['class-submit']}'" : null;

            return <<<EOD
<p>
<input id='$id' type='search'{$class}{$name}{$value}{$autofocus}{$required}{$readonly}{$placeholder}/>
<input id='do-{$id}' type='submit'{$classSubmit}{$label}{$readonly}{$title}/>
</p>
<p class='cf-desc'>{$description}</p>
EOD;

        } elseif ($this['type'] == 'textarea') {

            // textarea
            return <<<EOD
<p>
<label for='$id'>$label</label><br/>
<textarea id='$id'{$class}{$name}{$autofocus}{$required}{$readonly}{$placeholder}{$title}>{$onlyValue}</textarea>
</p>
<p class='cf-desc'>{$description}</p>
EOD;

        } elseif ($this['type'] == 'hidden') {

            // type=hidden
            return "<input id='$id'{$type}{$class}{$name}{$value} />\n";

        } elseif ($this['type'] == 'checkbox') {

            // checkbox
            return <<<EOD
<p>
<input id='$id'{$type}{$class}{$name}{$value}{$autofocus}{$required}{$readonly}{$checked}{$title} />
<label for='$id'>$label</label>
{$messages}
</p>
<p class='cf-desc'>{$description}</p>
EOD;

        } elseif ($this['type'] == 'radio') {

            // radio
            $ret = null;
            foreach ($this['values'] as $val) {
                $id .= $val;
                $item = $onlyValue  = htmlentities($val, ENT_QUOTES, $this->characterEncoding);
                $value = " value='{$onlyValue}'";
                $checked = isset($this['checked']) && $val === $this['checked']
                    ? " checked='checked'"
                    : null;
                $ret .= <<<EOD
<p>
<input id='$id'{$type}{$class}{$name}{$value}{$autofocus}{$readonly}{$checked}{$title} />
<label for='$id'>$item</label>
{$messages}
</p>
EOD;
            }
            return <<<EOD
<div>
<p class='cf-label'>{$label}</p>
{$ret}
<p class='cf-desc'>{$description}</p>
</div>
EOD;

        } elseif ($this['type'] == 'checkbox-multiple') {

            // custom for checkbox-multiple
            $type = "type='checkbox'";
            $name = " name='{$this['name']}[]'";
            $ret = null;

            foreach ($this['values'] as $val) {
                $id .= $val;
                $item = $onlyValue  = htmlentities($val, ENT_QUOTES, $this->characterEncoding);
                $value = " value='{$onlyValue}'";
                $checked = is_array($this['checked']) && in_array($val, $this['checked'])
                    ? " checked='checked'"
                    : null;
                $ret .= <<<EOD
<p>
<input id='$id'{$type}{$class}{$name}{$value}{$autofocus}{$readonly}{$checked}{$title} />
<label for='$id'>$item</label>
{$messages}
</p>
EOD;
            }
            return <<<EOD
<div>
<p>{$label}</p>
{$ret}
<p class='cf-desc'>{$description}</p>
</div>
EOD;

        } elseif ($this['type'] == 'file-multiple') {

            // file-multiple
            // @codingStandardsIgnoreStart
            return <<<EOD
<p>
<label for='$id'>$label</label>
<br/>
<input id='$id' type='file' multiple{$class}{$name}{$value}{$autofocus}{$required}{$readonly}{$placeholder}{$title}{$multiple}{$pattern}{$max}{$min}{$step}/>
{$messages}
</p>
<p class='cf-desc'>{$description}</p>
EOD;
            // @codingStandardsIgnoreEnd

        } else {

            // Everything else
            // @codingStandardsIgnoreStart
            return <<<EOD
<p>
<label for='$id'>$label</label>
<br/>
<input id='$id'{$type}{$class}{$name}{$value}{$autofocus}{$required}{$readonly}{$placeholder}{$title}{$multiple}{$pattern}{$max}{$min}{$step}/>
{$messages}
</p>
<p class='cf-desc'>{$description}</p>
EOD;
            // @codingStandardsIgnoreEnd

        }
    }



    /**
     * Validate the form element value according a ruleset.
     *
     * @param array      $rules validation rules.
     * @param CForm|null $form  the parent form.
     *
     * @return boolean true if all rules pass, else false.
     */
    public function validate($rules, $form = null)
    {
        $regExpEmailAddress = '/\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b/i';
        $tests = [
            'fail' => [
                'message' => 'Will always fail.',
                'test' => 'return false;'
            ],

            'pass' => [
                'message' => 'Will always pass.',
                'test' => 'return true;'
            ],

            'not_empty' => [
                'message' => 'Can not be empty.',
                'test' => 'return $value != "";'
            ],

            'not_equal' => [
                'message' => 'Value not valid.',
                'test' => 'return $value != $arg;'
            ],

            'numeric' => [
                'message' => 'Must be numeric.',
                'test' => 'return is_numeric($value);'
            ],

            'email_adress' => [
                'message' => 'Must be an email adress.',
                'test' => function ($value) {
                    return preg_match('/\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b/i', $value) === 1;
                }
            ],

            'match' => [
                'message' => 'The field does not match.',
                'test' => 'return $value == $form[$arg]["value"] ;'
            ],

            'must_accept' => [
                'message' => 'You must accept this.',
                'test' => 'return $checked;'
            ],

            'custom_test' => true,
        ];

        // max tecken, min tecken, datum, tid, datetime, mysql datetime

        $pass = true;
        $messages = array();
        $value = $this['value'];
        $checked = $this['checked'];

        foreach ($rules as $key => $val) {

            $rule = is_numeric($key) ? $val : $key;
            if (!isset($tests[$rule])) {
                throw new \Exception("Validation of form element failed, no such validation rule exists: $rule");
            }
            $arg = is_numeric($key) ? null : $val;

            $test = ($rule == 'custom_test') ? $arg : $tests[$rule];
            $status = null;
            if (is_callable($test['test'])) {
                $status = $test['test']($value);
            } else {
                $status = eval($test['test']);
            }

            if ($status === false) {
                $messages[] = $test['message'];
                $pass = false;
            }
        }

        if (!empty($messages)) {
            $this['validation-messages'] = $messages;
        }
        return $pass;
    }



    /**
     * Use the element name as label if label is not set.
     *
     * @param string $append a colon as default to the end of the label.
     *
     * @return void
     */
    public function useNameAsDefaultLabel($append = ':')
    {
        if (!isset($this['label'])) {
            $this['label'] = ucfirst(strtolower(str_replace(array('-','_'), ' ', $this['name']))).$append;
        }
    }



    /**
     * Use the element name as value if value is not set.
     *
     * @return void
     */
    public function useNameAsDefaultValue()
    {
        if (!isset($this['value'])) {
            $this['value'] = ucfirst(strtolower(str_replace(array('-','_'), ' ', $this['name'])));
        }
    }



    /**
     * Get the value of the form element.
     *
     * @return mixed the value of the form element.
     */
    public function getValue()
    {
        return $this['value'];
    }



    /**
     * Get the value of the form element, if value is empty return null.
     *
     * @return mixed the value of the form element. Null if the value is empty.
     */
    public function getValueNullIfEmpty()
    {
        return empty($this['value']) ? null : $this['value'];
    }
}


<link rel="stylesheet" type="text/css" href="bootstrap.min.css">
<div class="container">
	<select class='form-control' type='multiple'>
		<option>hh</option>
		<option>hng</option>
	</select>
<?php  
	
class Form
{
	public $action ="";
	public $method="POST";
	public $form_class ="form-group";
	public $input_type = 'text';
	public $input_class = 'form-control';
	public $group_class ='form-group';
	public $form_name;
	function __construct($form_name)
	{
		$this->form_name = $form_name;
	}
	public function openTag($tag, $attrs)
	{
		$Tag ='<'.$tag;
		
		$Tag .=$this->setAttr($attrs);
		$Tag .= '>';
		return $Tag;
	}
	public function closeTag($tag= null)
	{
		$Tag = null;
		if($tag != null)
		{
			$Tag .= '</'.$tag;
		}
		$Tag .= '>';
		return $Tag;
	}
	function inputTag($name,$type='text', $value='')
	{
		$attrs =['type'=>$type, 'id'=>$name, 'name'=>$name, 'value'=>$value, 'class'=>$this->input_class, 'placeholder'=>$name];
		
		$Tag = $this->openTag($this->dis_type,['class'=>$this->group_class]);
		if ($type != 'submit' && $this->group_class == 'form-group' ) {
			$Tag .= $this->openTag('label',['for'=>$name]);
			$Tag .= $name;
			$Tag .= $this->closeTag('label');
		}
		
		$Tag .= $this->openTag('input',$attrs);
		if ($this->group_class == 'input-group') {
			$Tag .= $this->group_btn($name);
		}
		$Tag .= $this->closeTag($this->dis_type);
		return $Tag;
	}
	function SelectField($name, $value='')
	{
		$attrs =['name'=>$name, 'class'=>$this->input_class];
		
		$Tag = $this->openTag('p',['class'=>'form-group']);
		
		$Tag .= $this->openTag('label',['for'=>$name]);
		$Tag .= $name;
		$Tag .= $this->closeTag('label');

		$Tag .= $this->openTag('select',$attrs);
		foreach ($value['SelectField'] as $key => $option) {
			$option =explode('/', $option);
			$selected = isset($option[1])? 'true':'false';
			$Tag .= $this->openTag(
				'option',
				[
					'value'=>$option[0],
					'selected'=> $selected,
			]
			);
			$Tag .= $option[0];
			$Tag .= $this->closeTag('option');
		}
		$Tag .= $this->closeTag('select');
		$Tag .= $this->closeTag('p');
		return $Tag;
	}

	function GroupedField($name, $value='')
	{
		return $this->inputTag($name,'text', $value);
	}
	public function group_btn($name)
	{
		$Tag=null ;
		$Tag .= $this->openTag('span',['class'=>'input-group-btn']);
		$Tag .= $this->openTag('button',['class'=>'btn btn-default']);
		$Tag .= $name;
		$Tag .= $this->closeTag('button');
		$Tag .= $this->closeTag('span');
		return $Tag;
	}
	public function TextField($name, $value='')
	{
		$Tag=null ;
		$attrs =['id'=>$name, 'name'=>$name, 'value'=>$value, 'class'=>$this->input_class, 'placeholder'=>$name];
		$Tag .= $this->openTag($this->dis_type,['class'=>'form-group']);
		$Tag .= $this->openTag('label',['for'=>$name]);
		$Tag .= $name;
		$Tag .= $this->closeTag('label');
		$Tag .= $this->openTag('textarea',$attrs);
		$Tag .= $value;
		$Tag .= $this->closeTag('textarea');
		$Tag .= $this->closeTag($this->dis_type);
		return $Tag;
	}
	public function StringField($name, $value=null)
	{
		
		return $this->inputTag($name,'text', $value);
	}
	public function CheckboxField($name, $value=null)
	{
		$this->input_class ='checkbox';
		return $this->inputTag($name,'checkbox','');
	}
	public function PasswordField($name, $value=null)
	{
		
		return $this->inputTag($name,'password', $value);
	}
	public function SubmitButton($name, $value=null)
	{
		$ns = explode('/', $name);
		$name = $ns[0];
		$icon_name = isset($ns[1])? $ns[1] :null;
		$btn = $this->openTag('p',['class'=>'form-group']);
		
		$btn .= $this->openTag('button',['type'=>'submit','class'=>'btn btn-primary']);
		$btn .= $this->btnIcon($icon_name).' ';
		$btn .= $name;
		$btn .= $this->closeTag('button');
		$btn .=$this->closeTag('p');
		return $btn;
	}
	public function btnIcon($icon_name)
	{
		$Tag = $this->openTag('i', ['class'=>'glyphicon glyphicon-'.$icon_name]);
		$Tag .=$this->closeTag('i');
		return$Tag;
	}
	public function SubmitField($name, $value=null)
	{
		$this->input_class ='btn btn-primary';
		return $this->inputTag($name,'submit',$name);
	}
	function setAttr(array $array)
	{
		$attrs =' ';
		foreach ($array as $attrName => $value) {

			$attrs .= $attrName.'="'.$value.'" ';
		}
		return $attrs;
	}
	public function render(array $fields)
	{
		$attrs =['action'=>$this->action, 'method'=>$this->method, 'class'=>$this->form_class];
		$form = $this->openTag('form', $attrs);
		$form .= $this->openTag('legend',[]);
		$form .= $this->form_name;
		$form .= $this->closeTag('legend');
		$value= null;
		foreach ($fields as $name => $func) {
			if (is_array($func)) {
				$value = isset($func[1])? $func[1]:$func;
				$func =isset($func[0])?$func[0]: array_keys($func)[0];
			}

			$form .= $this->{$func}($name, $value);
		}
		$form .= $this->closeTag('form');
		return print_r($form);
	}
}
$form = new Form('Login');
$form->dis_type = 'p';
$form->group_class = 'form-group';
		$fields = array(
			 'username'=>['StringField','tinashe banguwangu'],
			 'address'=>['TextField','9550 new stands mabvuku harare'],
			 'login/log-in' => 'SubmitButton', 
			 'password'=>['SelectField'=>array('rcgby','wangu/wangu')],
			);
		$form->render($fields);
		
?>
</div>
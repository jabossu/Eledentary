<?php

/**
*	Classe pour generer des formulaires HTML facilemnt
**/

class form // ( $cible, $style, $titre='informations' )
{
	//	internal variables
	private $_output ;
	private $_styleform ;
	private $_stylelabel ;
	private $_styleinput ;

	// ===================================================
	// Accesseurs
	// ===================================================
	public function debug()
	// Renvoie le code HTML genere plutot que de l'afficher.
	// Remplace la fonction output
	{
		$this->append("</form></div></div>\n") ;
		echo '<pre>' . htmlspecialchars($this->_output) . '</pre>' ;
	}
	
	public function output()
	// Conclut la generation du code et l'affiche.
	{
		$this->append("</form></div></div>\n") ;
		echo $this->_output ;
	}
	
	public function s_form()		{ return $this->_styleform ; }	
	public function s_label()		{ return $this->_stylelabel ; }	
	public function s_input()		{ return $this->_styleinput ; }	
	
	public function cut($slot)
	// What the hell is that sh** ?
	{
		if ( preg_match('#col-(sm|md|xs)-[0-9]{2}#', $this->_styleinput) )
		{
			$col = array('col-sm-2', 'col-sm-10') ;
		}
		else
		{
			$col = array('none', 'none') ;
		}
		return $col[$slot-1] ;
	}
	
	// ===================================================
	// Setters
	// ===================================================
	
	public function append( $string, $newline=true, $tab=0 )
	// Ajoutte le code passe en parametre au code source du tableau
	{
		$this->_output .= ($newline) ? "\n" : '' ;
		# saute une ligne dans le code source de la page avant l'ajout
		
		$n = 0 ;	while ($n < (int) $tab)
		{	$this->_output .= "\t" ; $n += 1 ;	}
		
		$this->_output .= $string ;
	}
    
	public function add($string)
	/**
	*	Ajoute une ligne au formulaire
	*	Fonction faite pour etre utilisee par les autres fonctions pour generer le code
	**/
	{
		$this->append('<div class="form-group">', $newline=true, $tab=1);
		$this->append($string, $newline=true, $tab=0);
		$this->append('</div>', $newline=true, $tab=1);
	}
	
	public function label($id, $text='Label')
	//	Genere le label d'un input
	{
		$r  = "\t\t" ;
		$r .= '<label for="'. $id .'" class="'. $this->s_label() .'">' ;
		$r .= $text ;
		$r .= '</label>' ;
		return($r) ;
	}
	
	public function legend($text)
	//	Genere la legende d'une section du formulaire
	{
		$this->append('<legend>' . $text . '</legend>', true, 2);
	}
	
	public function texte($text='input', $label=null)
	{	
		$r = "";	
		if ( isset($label) )
		{
			$r  .= $this->label( '', $label ) ;
		}
		
		$tabs = "\t\t" ;
			
		$r .= $tabs . '<p class="form-control-static">' . $text . '</p>' ;
		
		$this->add($r) ;
	}
	
	public function input($id, $label='Input field', $type='text', $value='', $placeholder=null, $prefixe=null, $suffixe=null)
	{
		$fake = "" ; $r = "";
		$fake = ($type == "fake") ? 'disabled' : '' ;
		if ( !in_array( $type, array('text', 'password', 'email', 'search', 'url', 'number', 'search', 'tel', 'color', 'date' ) ) )
		{
			$type = 'text' ;
		}
		$placeholder = ( !isset($placeholder) ) ? $type : $placeholder ;
		
		if ( isset($label) )
		{
			$r  .= $this->label( $id, $label ) ;
		}
		$r .= "\n\t\t" . '<div class="' . $this->cut(2) . '">' . "\n";
		if ( isset($prefixe) or isset($sufixe) )
		{
			$tabs = "\t\t\t" ;
			$r .= "\n\t\t" . '<div class="' . $this->s_input() . '">' . "\n";
		} 
		else
		{
			$tabs = "\t\t" ;
		}
		
		
		if (isset($prefixe))
		{	$r .= $tabs . '<span class="input-group-addon">' . $prefixe . "</span>\n" ;	}
		
		$r .= $tabs . '<input type="'.$type.'" ' . $fake . ' class="form-control" id="' . $id . '" name="' . $id . '" value="'.$value.'"placeholder="' . $placeholder . '">' ;
		
		if (isset($sufixe))
		{	$r .= $tabs . '<span class="input-group-addon">' . $sufixe . "</span>\n" ;	}
		
		if ( isset($prefixe) or isset($sufixe) )
		{
			$r .= "\n\t\t" . '</div>';
		} 
		$r .= "\n\t\t" . '</div>';
		$this->add($r) ;
	}
	public function number($id, $label='Number field', $value=1, $prefixe=null, $suffixe=null)
	{
		if ( isset($label) )
		{
			$r  .= $this->label( $id, $label ) ;
		}
		$r .= "\n\t\t" . '<div class="' . $this->cut(2) . '">' . "\n";
		if ( isset($prefixe) or isset($sufixe) )
		{
			$tabs = "\t\t\t" ;
			$r .= "\n\t\t" . '<div class="' . $this->s_input() . '">' . "\n";
		} 
		else
		{
			$tabs = "\t\t" ;
		}
		
		
		if (isset($prefixe))
		{	$r .= $tabs . '<span class="input-group-addon">' . $prefixe . "</span>\n" ;	}
		
		$r .= $tabs . '<input type="number" class="form-control" id="' . $id . '" name="' . $id . '" value="'.$value.'">' ;
		
		if (isset($sufixe))
		{	$r .= $tabs . '<span class="input-group-addon">' . $sufixe . "</span>\n" ;	}
		
		if ( isset($prefixe) or isset($sufixe) )
		{
			$r .= "\n\t\t" . '</div>';
		} 
		$r .= "\n\t\t" . '</div>';
		$this->add($r) ;
	}
	
	public function fake($id, $label='Fake field', $placeholder='input', $prefixe=null, $suffixe=null)
	{
		echo ' This syntaxt is obselete' ;
	}
	public function password($id, $label='Password', $prefixe=null, $suffixe=null)
	{
		echo 'this syntax is obselete' ;
	}
	
	
	public function textarea($id, $label='textearea', $value='', $placeholder='Type some text', $rows=3 )
	{
		$rows = (is_int($rows)) ? $rows : 3 ;
		if ( isset($label) )
		{
			$r  = $this->label( $id, $label ) ;
		}
		else
		{
			$r = '' ;
		}		
		$r .= "\n\t\t" . '<div class="'.$this->cut(2).'">' ;
		$r .= "\n\t\t" . '<textarea class="form-control" rows="'. $rows .'" id="' . $id . '" name="' . $id . '" placeholder="'.$placeholder.'">'.$value.'</textarea>' ;
		$r .= "\n\t\t" . '</div>' ;
		
		$this->add($r) ;
	}
	
	
	public function liste($id, $label='Liste', array $choices, $selected=null )
	{
		$r = "";
		if ( isset($label) )
		{
			$r  = $this->label( $id, $label ) ;
		}
		$r .= "\n\t\t".'<div class="' . $this->cut(2) .'">' ;
		$r .= "\n\t\t\t" . '<select class="form-control" name="' . $id . '"> ' ;
		foreach ($choices as $k => $v)
		{
			$sel = ($selected == $k) ? ' selected="selected" ' : '' ;
			$r .= "\n\t\t\t\t" . '<option value="' . $k . '"' . $sel . '>' . $v . '</option>' ;
		}
		$r .= "\n\t\t\t" . '</select> ' ;
		$r .= "\n\t\t</div>" ;
		$this->add($r);
	}
	
	
	
	public function checkbox($id, $legend='CheckBoxes', array $choices, $checked=null)
	{
		$align = ($this->cut(1) != 'none') ? ' text-right ' : '' ;
	
		$r  = "\t\t<fieldset>" ;
		$r .= "\n\t\t<div class='".$this->cut(1) . $align ."'><label>$legend</label></div>" ;
		$r .= "\n\t\t<div class='".$this->cut(2)."'>";
		foreach ($choices as $key => $value)
		{
			$chk = ( preg_match('#'.$key.'#', $checked) ) ? ' checked ' : '' ;
			$r .= "\n\t\t".'<div class="checkbox">';
			$r .= "\n\t\t\t<label>";
			$r .= "\n\t\t\t" . '<input type="checkbox" name="' . $id . '[]" value="' . $key . '"'.$chk.' />' ;
			$r .= "\n\t\t\t" . $value ;
			$r .= "\n\t\t\t</label>";
			$r .= "\n\t\t".'</div>';
		}
		$r .= "\n\t\t</div>" ;
		$r .= "\n\t\t</fieldset>" ;
		$this->add($r) ;
	}
	
	
	public function radiolist($id, $legend='RadioList', array $choices, $checked=null)
	{
		$align = ($this->cut(1) != 'none') ? ' text-right ' : '' ;
	
		$r  = "\t\t<fieldset>" ;
		$r .= "\n\t\t<div class='".$this->cut(1) . $align ."'><label>$legend</label></div>" ;
		$r .= "\n\t\t<div class='".$this->cut(2)."'>";
		foreach ($choices as $key => $value)
		{
			$chk = ( preg_match('#'.$key.'#', $checked) ) ? ' checked ' : '' ;
			$r .= "\n\t\t".'<div class="radio">';
			$r .= "\n\t\t\t<label>";
			$r .= "\n\t\t\t" . '<input type="radio" name="' . $id . '" value="' . $key . '"'.$chk.' />' ;
			$r .= "\n\t\t\t" . $value ;
			$r .= "\n\t\t\t</label>";
			$r .= "\n\t\t".'</div>';
		}
		$r .= "\n\t\t</div>" ;
		$r .= "\n\t\t</fieldset>" ;
		$this->add($r) ;
	}

	
	public function submit($text='Send', $type='primary', $size=0)
	{
		if ( !in_array( $type, array('default', 'primary', 'warning', 'info', 'danger', 'link' ) ) )
		{
			$type = 'default' ;
		}
		$text = ( isset($text) ) ? $text : 'Send' ;
		
		switch ($size)
		{
			case 1:
				$type .= ' btn-lg';
				break;
				
			case 2:
				$type .= ' btn-sm';
				break;
				
			case 3:
				$type .= ' btn-xs';
				break;
				
			case 4:
				$type .= ' btn-block';
				break;
		}
		if ( !preg_match('#inline#', $this->_styleform) )
		{	$this->append('<div class="text-center">', true, 1) ;		}
		$this->append('<button type="submit" class="btn btn-' . $type . '">' . $text . '</button>', true, 2) ;
		if ( !preg_match('#inline#', $this->_styleform) )
		{	$this->append('</div>', true, 1) ;	}
	}
	
	/**/
	
	// ===================================================style="margin: 0px ; padding: 10px 40px 10px 40px ;"
	//	Constructor
	// ===================================================	
	function __construct( $style='classic', $titre='informations', $cible=null )
	{
		$cible = ( isset($cible) == null ) ? $GLOBALS['_SERVER']['REQUEST_URI'] : $cible ;
		switch ($style)
		{
			case 'horizontal':
				$this->_styleform = 'well form-horizontal' ;
				$this->_stylelabel = 'col-sm-2 control-label' ;
				$this->_styleinput = 'col-sm-10 input-group' ;
				break;
			
			case 'inline':
				$this->_styleform = 'form-inline' ;
				$this->_stylelabel = 'control-label' ;
				$this->_styleinput = 'input-group' ;
				break;
			
			case 'welled':
				$this->_styleform = 'well form-classic' ;
				$this->_stylelabel = 'control-label' ;
				$this->_styleinput = 'input-group' ;
				break;
			
			case 'classic':
			default:
				$this->_styleform = 'form-classic' ;
				$this->_stylelabel = 'control-label' ;
				$this->_styleinput = 'input-group' ;
				break;
		}
		$this->append('<div class="row"><div class="col-sm-10 col-sm-push-1"><form action="'. $cible .'" method="post"  class="'. $this->s_form() .'">');		
	}

}


<?php

class PhpliveController extends Controller
{
        public $layout = '//layouts/withoutSidebar';
    
	public function actionIndex()
	{
            $code = '';
            
            
            if( false !==(  $code = filter_input(INPUT_GET, 'code', FILTER_VALIDATE_INT) ) )
            {
                $livecode = Livecode::model()->findByPk($code);
                if( $livecode !== null ) $code = $livecode->code;
            }
            
            $this->vars = array
            (
                    'title'         => 'קוד php online', 
                    'keywords'      => 'php, online, live, try, קוד, אונליין, שרת', 
                    'page_author'   => 'phpguide.co.il', 
                    'description'   => "אפשרות לכתוב ולנסות קוד php און-ליין בלי שרת או איחסון", 
            );
            
            $this->addscripts('ui', 'phplive');
            $this->render('index', array('code' => $code));
	}
        
        
        public function actionStorecode()
        {
            if( !isset($_POST['code']) || trim($_POST['code']) === '' ) return;
            
            $code = trim($_POST['code']);
            $checksum = md5($code);
            
            if( null === ($stored = Livecode::model()->findByAttributes(array('checksum' => $checksum))))
            {
                $stored = new Livecode();
                $stored->code = $code;
                $stored->checksum = $checksum;
                $stored->save();
            }
            echo $stored->id;
    
        }

}
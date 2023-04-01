<?php

class Application
{
    private $renderEngine;
    private $viewsPath;
    public function __construct()
    {
        $this->renderEngine = ".php";
        $this->viewsPath = "Views/";
    }
    public function setRenderEngine($extension)
    {
        $this->renderEngine = $extension;
    }
    public function setPath($type,$path)
    {
        if($type == "views")
        {
            $this->viewsPath = $path;
        }
    }
    public function renderView($view_name, $variables)
    {
        if(file_exists($this->viewsPath.$view_name.$this->renderEngine))
        {
            $file_content = file_get_contents($this->viewsPath.$view_name.$this->renderEngine);
            $config = new \Controllers\Config();
            $enviroment_variables = $config->get()[0]["enviroment_variables"];
            if(sizeof($enviroment_variables) > 0)
            {
                foreach ($enviroment_variables as $key => $value)
                {
                    $file_content = str_replace("{%$key%}",$value,$file_content);
                }
            }
            if(sizeof($variables) > 0)
            {
                foreach ($variables as $key => $value)
                {
                    $file_content = str_replace("{%$key%}",$value,$file_content);
                }
            }
            eval("?>$file_content");
        }else {$this->sendHttpError("500");}
    }
    public function getView($view_name)
    {
        if($_GET['view'] == $view_name)
        {
            return true;
        }
        return false;
    }
    public function sendHttpError($error)
    {
        if($error == "404")
        {
            http_response_code(404);
            echo "
                <script language='javascript'>
                    Append all elements in <div id='body'>
                    var body = document.getElementById('body');
                    body.innerHTML ='';
                </script>
            ";
            $this->renderView("404",[]);
            die();
        }
        if($error == "500")
        {
            http_response_code(500);
            echo "
                <script language='javascript'>
                    Append all elements in <div id='body'>
                    var body = document.getElementById('body');
                    body.innerHTML ='';
                </script>
            ";
            $this->renderView("500",[]);
            die();
        }
    }
}
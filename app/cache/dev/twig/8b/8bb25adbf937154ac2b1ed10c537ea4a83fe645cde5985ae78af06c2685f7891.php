<?php

/* TestCompanyBundle:OpnngHrs:registration.html.twig */
class __TwigTemplate_21477e8588083094ef19107fd213d14e54890b405f8fab9fbc9245514ac08da4 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_84c3c06ff02c0639a5ac8020855ef6fa6ede1f009f33f6977ec96354efe9fb17 = $this->env->getExtension("native_profiler");
        $__internal_84c3c06ff02c0639a5ac8020855ef6fa6ede1f009f33f6977ec96354efe9fb17->enter($__internal_84c3c06ff02c0639a5ac8020855ef6fa6ede1f009f33f6977ec96354efe9fb17_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "TestCompanyBundle:OpnngHrs:registration.html.twig"));

        // line 1
        echo "
<div>
    ";
        // line 3
        echo         $this->env->getExtension('form')->renderer->renderBlock((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), 'form');
        echo "
</div>";
        
        $__internal_84c3c06ff02c0639a5ac8020855ef6fa6ede1f009f33f6977ec96354efe9fb17->leave($__internal_84c3c06ff02c0639a5ac8020855ef6fa6ede1f009f33f6977ec96354efe9fb17_prof);

    }

    public function getTemplateName()
    {
        return "TestCompanyBundle:OpnngHrs:registration.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  26 => 3,  22 => 1,);
    }
}
/* */
/* <div>*/
/*     {{ form(form) }}*/
/* </div>*/

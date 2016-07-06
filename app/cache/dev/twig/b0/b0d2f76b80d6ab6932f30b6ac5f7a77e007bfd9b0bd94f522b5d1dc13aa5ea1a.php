<?php

/* TestCompanyBundle:Company:registration.html.twig */
class __TwigTemplate_1b0b637656c3a13d368558fb16a5480e0344a6686e96c660a1b705a06be0c01b extends Twig_Template
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
        $__internal_621ab4c2f1d188f72e5d9869fde9ed08bbf527ba423128589626af6eb58ab5eb = $this->env->getExtension("native_profiler");
        $__internal_621ab4c2f1d188f72e5d9869fde9ed08bbf527ba423128589626af6eb58ab5eb->enter($__internal_621ab4c2f1d188f72e5d9869fde9ed08bbf527ba423128589626af6eb58ab5eb_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "TestCompanyBundle:Company:registration.html.twig"));

        // line 1
        echo "
<div>
    ";
        // line 3
        echo         $this->env->getExtension('form')->renderer->renderBlock((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), 'form');
        echo "
</div>";
        
        $__internal_621ab4c2f1d188f72e5d9869fde9ed08bbf527ba423128589626af6eb58ab5eb->leave($__internal_621ab4c2f1d188f72e5d9869fde9ed08bbf527ba423128589626af6eb58ab5eb_prof);

    }

    public function getTemplateName()
    {
        return "TestCompanyBundle:Company:registration.html.twig";
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

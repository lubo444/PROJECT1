<?php

/* TestCompanyBundle:Office:registration.html.twig */
class __TwigTemplate_8d43241ab41723e49bbe4b8e5bf70fb83a01335715b508012d645df77a3bb65d extends Twig_Template
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
        $__internal_e228b3ee8cbf17872065e75e61e8f553f8c295de42c81b18c75441917fbddc29 = $this->env->getExtension("native_profiler");
        $__internal_e228b3ee8cbf17872065e75e61e8f553f8c295de42c81b18c75441917fbddc29->enter($__internal_e228b3ee8cbf17872065e75e61e8f553f8c295de42c81b18c75441917fbddc29_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "TestCompanyBundle:Office:registration.html.twig"));

        // line 1
        echo "
<div>
    ";
        // line 3
        echo         $this->env->getExtension('form')->renderer->renderBlock((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), 'form_start');
        echo "
    ";
        // line 4
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "address", array()), 'label');
        echo "
    ";
        // line 5
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "address", array()), 'widget');
        echo "
    ";
        // line 6
        echo         $this->env->getExtension('form')->renderer->renderBlock((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), 'form_end');
        echo "
</div>";
        
        $__internal_e228b3ee8cbf17872065e75e61e8f553f8c295de42c81b18c75441917fbddc29->leave($__internal_e228b3ee8cbf17872065e75e61e8f553f8c295de42c81b18c75441917fbddc29_prof);

    }

    public function getTemplateName()
    {
        return "TestCompanyBundle:Office:registration.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  38 => 6,  34 => 5,  30 => 4,  26 => 3,  22 => 1,);
    }
}
/* */
/* <div>*/
/*     {{ form_start(form) }}*/
/*     {{ form_label(form.address) }}*/
/*     {{ form_widget(form.address) }}*/
/*     {{ form_end(form) }}*/
/* </div>*/

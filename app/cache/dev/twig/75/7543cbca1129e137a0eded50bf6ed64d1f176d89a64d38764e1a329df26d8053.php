<?php

/* TestCompanyBundle:Form:registration.html.twig */
class __TwigTemplate_7d7397263fbb4040a66c3c179d1e6195999c1e8f78df355e78a877d7cc12f791 extends Twig_Template
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
        $__internal_7c56616821c20986496068a170f54e0d9c452cf5edef86f9a11aacd20a73af97 = $this->env->getExtension("native_profiler");
        $__internal_7c56616821c20986496068a170f54e0d9c452cf5edef86f9a11aacd20a73af97->enter($__internal_7c56616821c20986496068a170f54e0d9c452cf5edef86f9a11aacd20a73af97_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "TestCompanyBundle:Form:registration.html.twig"));

        // line 1
        echo "<div>
    ";
        // line 2
        echo         $this->env->getExtension('form')->renderer->renderBlock((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), 'form');
        echo "
</div>";
        
        $__internal_7c56616821c20986496068a170f54e0d9c452cf5edef86f9a11aacd20a73af97->leave($__internal_7c56616821c20986496068a170f54e0d9c452cf5edef86f9a11aacd20a73af97_prof);

    }

    public function getTemplateName()
    {
        return "TestCompanyBundle:Form:registration.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  25 => 2,  22 => 1,);
    }
}
/* <div>*/
/*     {{ form(form) }}*/
/* </div>*/

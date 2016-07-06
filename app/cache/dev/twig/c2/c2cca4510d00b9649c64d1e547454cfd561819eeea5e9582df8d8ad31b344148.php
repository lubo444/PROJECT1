<?php

/* TestCompanyBundle:Office:list.html.twig */
class __TwigTemplate_334f3b1903d913ab0371b755671645ddf611cc537809f8ad2ea9acbfa4b7c476 extends Twig_Template
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
        $__internal_e5b3a5c78d1c750880e556fd3e4fb6d02b66e9e07a8652b8e1710d3613f12fad = $this->env->getExtension("native_profiler");
        $__internal_e5b3a5c78d1c750880e556fd3e4fb6d02b66e9e07a8652b8e1710d3613f12fad->enter($__internal_e5b3a5c78d1c750880e556fd3e4fb6d02b66e9e07a8652b8e1710d3613f12fad_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "TestCompanyBundle:Office:list.html.twig"));

        // line 1
        echo "<div>
    <a href=\"";
        // line 2
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getUrl("test_office_create", array("companyId" => (isset($context["companyId"]) ? $context["companyId"] : $this->getContext($context, "companyId")))), "html", null, true);
        echo "\">register new office</a>
</div>

<div>
---------------------------
</div>

";
        // line 9
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["offices"]) ? $context["offices"] : $this->getContext($context, "offices")));
        foreach ($context['_seq'] as $context["_key"] => $context["office"]) {
            // line 10
            echo "    <div>
        <a href='";
            // line 11
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getUrl("test_office_opnng_hrs", array("officeId" => $this->getAttribute($context["office"], "idOffice", array()))), "html", null, true);
            echo "'>";
            echo twig_escape_filter($this->env, $this->getAttribute($context["office"], "address", array()), "html", null, true);
            echo "</a>
        <a href='";
            // line 12
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getUrl("test_office_delete", array("officeId" => $this->getAttribute($context["office"], "idOffice", array()))), "html", null, true);
            echo "'>delete</a>
    </div>
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['office'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 15
        echo "
";
        
        $__internal_e5b3a5c78d1c750880e556fd3e4fb6d02b66e9e07a8652b8e1710d3613f12fad->leave($__internal_e5b3a5c78d1c750880e556fd3e4fb6d02b66e9e07a8652b8e1710d3613f12fad_prof);

    }

    public function getTemplateName()
    {
        return "TestCompanyBundle:Office:list.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  57 => 15,  48 => 12,  42 => 11,  39 => 10,  35 => 9,  25 => 2,  22 => 1,);
    }
}
/* <div>*/
/*     <a href="{{ url('test_office_create', { 'companyId':companyId }) }}">register new office</a>*/
/* </div>*/
/* */
/* <div>*/
/* ---------------------------*/
/* </div>*/
/* */
/* {% for office in offices %}*/
/*     <div>*/
/*         <a href='{{ url('test_office_opnng_hrs', { 'officeId': office.idOffice }) }}'>{{ office.address }}</a>*/
/*         <a href='{{ url('test_office_delete', { 'officeId': office.idOffice }) }}'>delete</a>*/
/*     </div>*/
/* {% endfor %}*/
/* */
/* */

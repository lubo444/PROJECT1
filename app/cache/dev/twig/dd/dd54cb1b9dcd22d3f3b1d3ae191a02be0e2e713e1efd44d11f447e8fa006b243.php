<?php

/* TestCompanyBundle:Homepage:list.html.twig */
class __TwigTemplate_0648db505508bc1872890a46eba9d00483d1ad82e4aec9f8fd040b0762766f18 extends Twig_Template
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
        $__internal_23239b21c2cdd1144ce082c37c7d323fd55f25792093787fb7309162cc0a1ace = $this->env->getExtension("native_profiler");
        $__internal_23239b21c2cdd1144ce082c37c7d323fd55f25792093787fb7309162cc0a1ace->enter($__internal_23239b21c2cdd1144ce082c37c7d323fd55f25792093787fb7309162cc0a1ace_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "TestCompanyBundle:Homepage:list.html.twig"));

        // line 1
        echo "<div>
    <a href=\"";
        // line 2
        echo $this->env->getExtension('routing')->getUrl("test_company_create");
        echo "\">register new company</a>
</div>

<div>
    ---------------------------
</div>

";
        // line 9
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["companies"]) ? $context["companies"] : $this->getContext($context, "companies")));
        foreach ($context['_seq'] as $context["_key"] => $context["company"]) {
            // line 10
            echo "    <div>
        <h2>
            <a href='";
            // line 12
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getUrl("test_company_list", array("companyId" => $this->getAttribute($context["company"], "idCompany", array()))), "html", null, true);
            echo "'>";
            echo twig_escape_filter($this->env, $this->getAttribute($context["company"], "title", array()), "html", null, true);
            echo "</a>
            <a href='";
            // line 13
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getUrl("test_company_delete", array("companyId" => $this->getAttribute($context["company"], "idCompany", array()))), "html", null, true);
            echo "'>remove</a>
        </h2>
    </div>
    ";
            // line 16
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute($context["company"], "offices", array()));
            foreach ($context['_seq'] as $context["_key"] => $context["office"]) {
                // line 17
                echo "        <div>
            ";
                // line 18
                echo twig_escape_filter($this->env, $this->getAttribute($context["office"], "address", array()), "html", null, true);
                echo "
        </div>
        ";
                // line 20
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable($this->getAttribute($context["office"], "openingHours", array()));
                foreach ($context['_seq'] as $context["_key"] => $context["hours"]) {
                    // line 21
                    echo "            <div>
                ";
                    // line 22
                    $context["lunch"] = "";
                    // line 23
                    echo "                ";
                    if (($this->getAttribute($context["hours"], "lunchStartAt", array()) != "")) {
                        // line 24
                        echo "                    ";
                        $context["lunch"] = ((($this->getAttribute($context["hours"], "lunchStartAt", array()) . ", ") . $this->getAttribute($context["hours"], "lunchEndAt", array())) . " - ");
                        // line 25
                        echo "                ";
                    }
                    // line 26
                    echo "                ";
                    echo twig_escape_filter($this->env, $this->getAttribute($context["hours"], "startAt", array()), "html", null, true);
                    echo " - ";
                    echo twig_escape_filter($this->env, (isset($context["lunch"]) ? $context["lunch"] : $this->getContext($context, "lunch")), "html", null, true);
                    echo twig_escape_filter($this->env, $this->getAttribute($context["hours"], "endAt", array()), "html", null, true);
                    echo "
            </div>
        ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['hours'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 29
                echo "    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['office'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['company'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        
        $__internal_23239b21c2cdd1144ce082c37c7d323fd55f25792093787fb7309162cc0a1ace->leave($__internal_23239b21c2cdd1144ce082c37c7d323fd55f25792093787fb7309162cc0a1ace_prof);

    }

    public function getTemplateName()
    {
        return "TestCompanyBundle:Homepage:list.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  98 => 29,  85 => 26,  82 => 25,  79 => 24,  76 => 23,  74 => 22,  71 => 21,  67 => 20,  62 => 18,  59 => 17,  55 => 16,  49 => 13,  43 => 12,  39 => 10,  35 => 9,  25 => 2,  22 => 1,);
    }
}
/* <div>*/
/*     <a href="{{ url('test_company_create') }}">register new company</a>*/
/* </div>*/
/* */
/* <div>*/
/*     ---------------------------*/
/* </div>*/
/* */
/* {% for company in companies %}*/
/*     <div>*/
/*         <h2>*/
/*             <a href='{{ url('test_company_list', { 'companyId': company.idCompany }) }}'>{{ company.title }}</a>*/
/*             <a href='{{ url('test_company_delete', { 'companyId': company.idCompany }) }}'>remove</a>*/
/*         </h2>*/
/*     </div>*/
/*     {% for office in company.offices %}*/
/*         <div>*/
/*             {{ office.address }}*/
/*         </div>*/
/*         {% for hours in office.openingHours %}*/
/*             <div>*/
/*                 {% set lunch = '' %}*/
/*                 {% if hours.lunchStartAt != '' %}*/
/*                     {% set lunch = hours.lunchStartAt ~ ', ' ~  hours.lunchEndAt ~ ' - ' %}*/
/*                 {% endif %}*/
/*                 {{ hours.startAt }} - {{ lunch }}{{ hours.endAt }}*/
/*             </div>*/
/*         {% endfor %}*/
/*     {% endfor %}*/
/* {% endfor %}*/
/* */

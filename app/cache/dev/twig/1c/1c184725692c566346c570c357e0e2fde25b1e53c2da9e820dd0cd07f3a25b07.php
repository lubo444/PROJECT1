<?php

/* TestCompanyBundle:Office:detail.html.twig */
class __TwigTemplate_3aa57117c98e30fe8662a37b5a62feada0155de6ff451902e46c15d781bb773b extends Twig_Template
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
        $__internal_567f90ab6c4eeaca2529a5107ff1ceb999d3056067dca81fe10999523095259d = $this->env->getExtension("native_profiler");
        $__internal_567f90ab6c4eeaca2529a5107ff1ceb999d3056067dca81fe10999523095259d->enter($__internal_567f90ab6c4eeaca2529a5107ff1ceb999d3056067dca81fe10999523095259d_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "TestCompanyBundle:Office:detail.html.twig"));

        // line 1
        echo "

<div>";
        // line 3
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["office"]) ? $context["office"] : $this->getContext($context, "office")), "idCompany", array()), "title", array()), "html", null, true);
        echo "</div>

<div>";
        // line 5
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["office"]) ? $context["office"] : $this->getContext($context, "office")), "address", array()), "html", null, true);
        echo "</div>

<div>
---------------------------
</div>

<div>
    <a href=\"";
        // line 12
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getUrl("test_opnng_hours_create", array("officeId" => $this->getAttribute((isset($context["office"]) ? $context["office"] : $this->getContext($context, "office")), "idOffice", array()))), "html", null, true);
        echo "\">add new hours</a>
</div>

<div>
---------------------------
</div>

<div>
    <table>
    ";
        // line 21
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["days"]) ? $context["days"] : $this->getContext($context, "days")));
        foreach ($context['_seq'] as $context["_key"] => $context["day"]) {
            // line 22
            echo "        <tr>
            <td>";
            // line 23
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["daysInWeek"]) ? $context["daysInWeek"] : $this->getContext($context, "daysInWeek")), $this->getAttribute($context["day"], "dayInWeek", array()), array(), "array"), "html", null, true);
            echo "</td>
            <td>";
            // line 24
            echo twig_escape_filter($this->env, $this->getAttribute($context["day"], "startAt", array()), "html", null, true);
            if ((($this->getAttribute($context["day"], "lunchStartAt", array()) != "") && ($this->getAttribute($context["day"], "lunchEndAt", array()) != ""))) {
                echo " - ";
                echo twig_escape_filter($this->env, $this->getAttribute($context["day"], "lunchStartAt", array()), "html", null, true);
                echo ", ";
                echo twig_escape_filter($this->env, $this->getAttribute($context["day"], "lunchEndAt", array()), "html", null, true);
            }
            echo " - ";
            echo twig_escape_filter($this->env, $this->getAttribute($context["day"], "endAt", array()), "html", null, true);
            echo "</td>
            <td><a href='";
            // line 25
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getUrl("test_opnng_hours_edit", array("openingHoursId" => $this->getAttribute($context["day"], "idOpnngHrs", array()))), "html", null, true);
            echo "'>edit</a></td>
            <td><a href='";
            // line 26
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getUrl("test_opnng_hours_delete", array("openingHoursId" => $this->getAttribute($context["day"], "idOpnngHrs", array()))), "html", null, true);
            echo "'>delete</a></td>
        </tr>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['day'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 29
        echo "    </table>
</div>";
        
        $__internal_567f90ab6c4eeaca2529a5107ff1ceb999d3056067dca81fe10999523095259d->leave($__internal_567f90ab6c4eeaca2529a5107ff1ceb999d3056067dca81fe10999523095259d_prof);

    }

    public function getTemplateName()
    {
        return "TestCompanyBundle:Office:detail.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  89 => 29,  80 => 26,  76 => 25,  64 => 24,  60 => 23,  57 => 22,  53 => 21,  41 => 12,  31 => 5,  26 => 3,  22 => 1,);
    }
}
/* */
/* */
/* <div>{{ office.idCompany.title }}</div>*/
/* */
/* <div>{{ office.address }}</div>*/
/* */
/* <div>*/
/* ---------------------------*/
/* </div>*/
/* */
/* <div>*/
/*     <a href="{{ url('test_opnng_hours_create', { 'officeId':office.idOffice }) }}">add new hours</a>*/
/* </div>*/
/* */
/* <div>*/
/* ---------------------------*/
/* </div>*/
/* */
/* <div>*/
/*     <table>*/
/*     {% for day in days %}*/
/*         <tr>*/
/*             <td>{{ daysInWeek[day.dayInWeek] }}</td>*/
/*             <td>{{ day.startAt }}{% if day.lunchStartAt != '' and day.lunchEndAt != '' %} - {{ day.lunchStartAt }}, {{ day.lunchEndAt }}{% endif %} - {{ day.endAt }}</td>*/
/*             <td><a href='{{ url('test_opnng_hours_edit', { 'openingHoursId': day.idOpnngHrs }) }}'>edit</a></td>*/
/*             <td><a href='{{ url('test_opnng_hours_delete', { 'openingHoursId': day.idOpnngHrs }) }}'>delete</a></td>*/
/*         </tr>*/
/*     {% endfor %}*/
/*     </table>*/
/* </div>*/

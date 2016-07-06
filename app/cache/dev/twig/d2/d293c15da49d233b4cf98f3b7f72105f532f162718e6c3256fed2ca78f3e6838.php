<?php

/* TwigBundle:Exception:exception_full.html.twig */
class __TwigTemplate_60c51e2ef2f5f268e6dc4f8a288432a9264762d18353dc2c963820f07170f5d4 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("TwigBundle::layout.html.twig", "TwigBundle:Exception:exception_full.html.twig", 1);
        $this->blocks = array(
            'head' => array($this, 'block_head'),
            'title' => array($this, 'block_title'),
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "TwigBundle::layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_304175661d691e82b6cbca1b2d89786d163996f6d2d624365d46fc36431a0fa9 = $this->env->getExtension("native_profiler");
        $__internal_304175661d691e82b6cbca1b2d89786d163996f6d2d624365d46fc36431a0fa9->enter($__internal_304175661d691e82b6cbca1b2d89786d163996f6d2d624365d46fc36431a0fa9_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "TwigBundle:Exception:exception_full.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_304175661d691e82b6cbca1b2d89786d163996f6d2d624365d46fc36431a0fa9->leave($__internal_304175661d691e82b6cbca1b2d89786d163996f6d2d624365d46fc36431a0fa9_prof);

    }

    // line 3
    public function block_head($context, array $blocks = array())
    {
        $__internal_afa5aae629c619aa24b65b178c8d6054ab078e06724b0e40bbb6e5fd12791abb = $this->env->getExtension("native_profiler");
        $__internal_afa5aae629c619aa24b65b178c8d6054ab078e06724b0e40bbb6e5fd12791abb->enter($__internal_afa5aae629c619aa24b65b178c8d6054ab078e06724b0e40bbb6e5fd12791abb_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "head"));

        // line 4
        echo "    <link href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('request')->generateAbsoluteUrl($this->env->getExtension('asset')->getAssetUrl("bundles/framework/css/exception.css")), "html", null, true);
        echo "\" rel=\"stylesheet\" type=\"text/css\" media=\"all\" />
";
        
        $__internal_afa5aae629c619aa24b65b178c8d6054ab078e06724b0e40bbb6e5fd12791abb->leave($__internal_afa5aae629c619aa24b65b178c8d6054ab078e06724b0e40bbb6e5fd12791abb_prof);

    }

    // line 7
    public function block_title($context, array $blocks = array())
    {
        $__internal_ed47fbf062795871d99dc6dcde9b72c5db732da553abfcb21cef96e98f4ab305 = $this->env->getExtension("native_profiler");
        $__internal_ed47fbf062795871d99dc6dcde9b72c5db732da553abfcb21cef96e98f4ab305->enter($__internal_ed47fbf062795871d99dc6dcde9b72c5db732da553abfcb21cef96e98f4ab305_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        // line 8
        echo "    ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["exception"]) ? $context["exception"] : $this->getContext($context, "exception")), "message", array()), "html", null, true);
        echo " (";
        echo twig_escape_filter($this->env, (isset($context["status_code"]) ? $context["status_code"] : $this->getContext($context, "status_code")), "html", null, true);
        echo " ";
        echo twig_escape_filter($this->env, (isset($context["status_text"]) ? $context["status_text"] : $this->getContext($context, "status_text")), "html", null, true);
        echo ")
";
        
        $__internal_ed47fbf062795871d99dc6dcde9b72c5db732da553abfcb21cef96e98f4ab305->leave($__internal_ed47fbf062795871d99dc6dcde9b72c5db732da553abfcb21cef96e98f4ab305_prof);

    }

    // line 11
    public function block_body($context, array $blocks = array())
    {
        $__internal_80d36e7c2cf2b5b3b06330ee327bf0f63a770aa7fd268ffbe13fe8e94c6b24d9 = $this->env->getExtension("native_profiler");
        $__internal_80d36e7c2cf2b5b3b06330ee327bf0f63a770aa7fd268ffbe13fe8e94c6b24d9->enter($__internal_80d36e7c2cf2b5b3b06330ee327bf0f63a770aa7fd268ffbe13fe8e94c6b24d9_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 12
        echo "    ";
        $this->loadTemplate("TwigBundle:Exception:exception.html.twig", "TwigBundle:Exception:exception_full.html.twig", 12)->display($context);
        
        $__internal_80d36e7c2cf2b5b3b06330ee327bf0f63a770aa7fd268ffbe13fe8e94c6b24d9->leave($__internal_80d36e7c2cf2b5b3b06330ee327bf0f63a770aa7fd268ffbe13fe8e94c6b24d9_prof);

    }

    public function getTemplateName()
    {
        return "TwigBundle:Exception:exception_full.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  78 => 12,  72 => 11,  58 => 8,  52 => 7,  42 => 4,  36 => 3,  11 => 1,);
    }
}
/* {% extends 'TwigBundle::layout.html.twig' %}*/
/* */
/* {% block head %}*/
/*     <link href="{{ absolute_url(asset('bundles/framework/css/exception.css')) }}" rel="stylesheet" type="text/css" media="all" />*/
/* {% endblock %}*/
/* */
/* {% block title %}*/
/*     {{ exception.message }} ({{ status_code }} {{ status_text }})*/
/* {% endblock %}*/
/* */
/* {% block body %}*/
/*     {% include 'TwigBundle:Exception:exception.html.twig' %}*/
/* {% endblock %}*/
/* */
